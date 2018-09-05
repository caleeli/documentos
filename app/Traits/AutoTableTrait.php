<?php
namespace App\Traits;

use Carbon\Carbon;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Types\DateTimeType;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Description of AutoTable
 *
 */
trait AutoTableTrait
{

    use ValidatedModelTrait;

    protected $rules = [];
    private static $attIndexes = [];
    private static $attRelationships = [];
    private static $attRules = [];
    private static $attColumns = [];

    /**
     * Boot the AutoTableTrait.
     *
     */
    public static function bootAutoTableTrait()
    {
        self::loadAttIndexes();
    }

    /**
     * Get the array of fillable columns.
     *
     * @return array
     */
    public function getFillable()
    {
        $fillable = parent::getFillable();
        return array_merge($fillable, self::$attColumns[$this->getTable()]['fillable']);
    }

    /**
     * Get the array of casts of columns.
     *
     * @return array
     */
    public function getCasts()
    {
        $casts = parent::getCasts();
        return array_merge($casts, self::$attColumns[$this->getTable()]['casts']);
    }

    /**
     * Load the schema information.
     */
    private static function loadAttIndexes()
    {
        if (empty(self::$attIndexes)) {
            $conn = DB::connection()->getDoctrineConnection();
            $sm = $conn->getSchemaManager();
            self::readAttSchema($sm);
        }
    }

    /**
     * Read the schema information.
     *
     * @param AbstractSchemaManager $schema
     */
    private static function readAttSchema(AbstractSchemaManager $schema)
    {
        $tables = $schema->listTableNames();
        foreach ($tables as $table) {
            foreach ($schema->listTableIndexes($table) as $index) {
                self::readAttIndex($index, $table);
            }
        }
        foreach ($tables as $table) {
            foreach ($schema->listTableForeignKeys($table) as $fk) {
                self::registerAttFK($fk, $table);
            }
        }
        foreach ($tables as $table) {
            self::$attColumns[$table]['fillable'] = [];
            self::$attColumns[$table]['casts'] = [];
            foreach ($schema->listTableColumns($table) as $column) {
                self::readAttColumn($column, $table);
            }
        }
        self::findAttManytoManyRelationships();
    }

    /**
     * Read the columns from schema.
     *
     * @param Column $column
     * @param string $table
     */
    private static function readAttColumn(Column $column, $table)
    {
        $key = $column->getName();
        self::$attColumns[$table]['fillable'][] = $key;
        if ($column->getName() === 'created_at') {
            //dd($column->toArray(), get_class($column->getType()));
        }
        if ($column->getNotnull() && $column->getDefault() === null && !$column->getAutoincrement()) {
            self::$attRules[$table][$key][] = 'required';
        }
        if ($column->getType() === 'string') {
            self::$attRules[$table][$key][] = 'max:' . $column->getLength();
        }
        if ($column->getType() instanceof DateTimeType) {
            self::$attRules[$table][$key][] = 'date';
            self::$attColumns[$table]['casts'][$key] = 'datetime';
        }
    }

    /**
     * Load an index.
     *
     * @param Index $index
     * @param string $table
     */
    private static function readAttIndex(Index $index, $table)
    {
        $columns = $index->getColumns();
        sort($columns);
        $key = $table . '.' . json_encode($columns);
        self::$attIndexes[$key] = [
            'name' => $index->getName(),
            'multiplicity' => $index->isUnique() || $index->isPrimary() ? 1 : 'n',
            'isPrimary' => $index->isPrimary(),
        ];
    }

    /**
     * Get and index by table and columns.
     *
     * @param array $columns
     * @param string $table
     *
     * @return array
     */
    private static function getAttIndex(array $columns, $table)
    {
        self::loadAttIndexes();
        sort($columns);
        $jcolumns = json_encode($columns);
        $key = $table . '.' . $jcolumns;
        return isset(self::$attIndexes[$key]) ? self::$attIndexes[$key] : null;
    }

    /**
     * Register a foreign key.
     *
     * @param ForeignKeyConstraint $fk
     * @param string $table
     */
    private static function registerAttFK(ForeignKeyConstraint $fk, $table)
    {
        $foreignTable = $fk->getForeignTableName();
        //@todo change get_namespace(static::class) to a input parameter to set the Model package.
        $foreign = guess_model(get_namespace(static::class), $foreignTable);
        $local = guess_model(get_namespace(static::class), $table);

        $localColumns = $fk->getColumns();
        $foreignColumns = $fk->getForeignColumns();
        $foreignIndex = self::getAttIndex($foreignColumns, $foreignTable);
        $localIndex = self::getAttIndex($localColumns, $table);

        self::addAttRelationship(
            [
            'table' => $table,
            'class' => $local,
            'index' => $localIndex,
            'columns' => count($localColumns) === 1 ? $localColumns[0] : $localColumns,
            ], [
            'table' => $foreignTable,
            'class' => $foreign,
            'index' => $foreignIndex,
            'columns' => count($foreignColumns) === 1 ? $foreignColumns[0] : $foreignColumns,
            ]
        );
    }

    /**
     * Guess the name of a relationship.
     *
     * @param array $from
     * @param array $to
     *
     * @return string
     */
    private static function guessAttRelationName(array $from, array $to)
    {
        return lcfirst(Str::studly($from['index'] && $from['index']['name'] !== 'PRIMARY' ? $from['index']['name'] : $to['table']));
    }

    /**
     * Register a relationship.
     *
     * @param array $from
     * @param array $to
     *
     * @return void
     */
    private static function addAttRelationship(array $from, array $to)
    {
        $table = $from['table'];
        $key = self::guessAttRelationName($from, $to);
        if (isset(self::$attRelationships[$table][$key])) {
            return;
        }
        //n:m
        $isPrimary = $from['index'] ? $from['index']['isPrimary'] : false;
        $n = $from['index'] ? $from['index']['multiplicity'] : 'n';
        $m = $to['index'] ? $to['index']['multiplicity'] : 'n';

        $relationship = null;
        if ($isPrimary && $m == 1 && $to['table'] != $table) {
            $relationship = ['hasOne', [$to['class'], $to['columns'], $from['columns']]];
        }
        if (!$isPrimary && $m == 1) {
            $relationship = ['belongsTo', [$to['class'], $from['columns'], $to['columns'], $key]];
        }
        if ($m == 'n') {
            $relationship = ['hasMany', [$to['class'], $to['columns'], $from['columns']]];
        }
        if ($relationship) {
            $relationship[2] = [$from, $to];
            self::$attRelationships[$table][$key] = $relationship;
        }
        self::addAttRelationship($to, $from);
    }

    /**
     * Find many to many relationships.
     *
     */
    private static function findAttManytoManyRelationships()
    {
        foreach (self::$attRelationships as $relationships) {
            foreach ($relationships as $relationship) {
                if ($relationship[0] === 'hasMany') {
                    self::matchAttManytoManyRelationship($relationship);
                }
            }
        }
    }

    /**
     * Match to hasMany relationships and make a ManyToMany relationship.
     *
     * @param array $refRelationship
     */
    private static function matchAttManytoManyRelationship(array $refRelationship)
    {
        foreach (self::$attRelationships as $table => $relationships) {
            foreach ($relationships as $key => $relationship) {
                if ($relationship[0] === 'hasMany' && $relationship[2][1]['table'] === $refRelationship[2][1]['table'] && $relationship !== $refRelationship) {
                    $model1 = $refRelationship[2][0];
                    $model2 = $refRelationship[2][1];
                    $model2b = $relationship[2][0];
                    $model3 = $relationship[2][1];
                    $key = self::guessAttRelationName($model2b, $model3);
                    //belongsToMany($related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null, $parentKey = null, $relatedKey = null, $relation = null)
                    if (isset(self::$attRelationships[$table][$key])) {
                        $key .= '2';
                    }
                    self::$attRelationships[$table][$key] = [
                        'belongsToMany',
                        [$model3['class'], $model2['table'], $model1['columns'], $model3['columns'], $model2['columns'], $model2b['columns'], $key],
                        [$model1, $model2, $model2b, $model3]
                    ];
                }
            }
        }
    }

    /**
     * Get a relationship by table and name.
     *
     * @param string $table
     * @param string $name
     *
     * @return array
     */
    private function getDBRelationship($table, $name)
    {
        return isset(self::$attRelationships[$table][$name]) ? self::$attRelationships[$table][$name] : null;
    }

    /**
     * Get validation rules.
     *
     * @return array
     */
    protected function getRules()
    {
        return self::$attRules[$this->getTable()];
    }

    /**
     * Add relationships from DB.
     *
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        try {
            $relationship = $this->getDBRelationship($this->getTable(), $method);
            if ($relationship) {
                //dump(get_class($this), $relationship);
                $relationshipType = $relationship[0];
                $relationshipOptions = $relationship[1];
                return $this->$relationshipType(...$relationshipOptions);
            } else {
                return parent::__call($method, $parameters);
            }
        } catch (Exception $e) {
            //dump(get_class($this), self::$attRelationships[$this->getTable()]);
            throw $e;
        }
    }

    /**
     * Return a timestamp as DateTime object.
     *
     * @param mixed $value
     *
     * @return \Carbon\Carbon
     */
    protected function asDateTime($value)
    {
        try {
            //Carbon::W3C is the default format used by moment.js
            $date = Carbon::createFromFormat(Carbon::W3C, $value);
            if ($date->toW3cString() === $value) {
                return $date;
            }
        } catch (InvalidArgumentException $e) {
            
        }
        return parent::asDateTime($value);
    }
}
