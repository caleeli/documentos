<?php
namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    private static function loadAttIndexes()
    {
        if (empty(self::$attIndexes)) {
            $conn = DB::connection()->getDoctrineConnection();
            $sm = $conn->getSchemaManager();
            self::readAttSchema($sm);
        }
    }

    private static function readAttSchema(\Doctrine\DBAL\Schema\AbstractSchemaManager $schema)
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
            foreach ($schema->listTableColumns($table) as $column) {
                self::readAttColumn($column, $table);
            }
        }
        self::solveAttManytoManyRelationships();
    }

    private static function readAttColumn(\Doctrine\DBAL\Schema\Column $column, $table)
    {
        $key = $column->getName();
        self::$attRules[$table][$key] = [];
        if ($column->getName()==='created_at') {
            //dd($column->toArray(), get_class($column->getType()));
        }
        if ($column->getNotnull() && $column->getDefault() === null && !$column->getAutoincrement()) {
            self::$attRules[$table][$key][] = 'required';
        }
        if ($column->getType() === 'string') {
            self::$attRules[$table][$key][] = 'max:' . $column->getLength();
        }
        if ($column->getType() instanceof \Doctrine\DBAL\Types\DateTimeType) {
            self::$attRules[$table][$key][] = 'date';
        }
    }

    private static function readAttIndex(\Doctrine\DBAL\Schema\Index $index, $table)
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

    private static function getAttIndex(array $columns, $table)
    {
        self::loadAttIndexes();
        sort($columns);
        $jcolumns = json_encode($columns);
        $key = $table . '.' . $jcolumns;
        return isset(self::$attIndexes[$key]) ? self::$attIndexes[$key] : null;
    }

    private static function registerAttFK(\Doctrine\DBAL\Schema\ForeignKeyConstraint $fk, $table)
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

    private static function guessAttRelationName($from, $to)
    {
        return lcfirst(Str::studly($from['index'] && $from['index']['name'] !== 'PRIMARY' ? $from['index']['name'] : $to['table']));
    }

    private static function addAttRelationship($from, $to)
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

    private static function solveAttManytoManyRelationships()
    {
        foreach (self::$attRelationships as $relationships) {
            foreach ($relationships as $relationship) {
                if ($relationship[0] === 'hasMany') {
                    self::findAttManytoManyRelationship($relationship);
                }
            }
        }
    }

    private static function findAttManytoManyRelationship($refRelationship)
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

    private function getDBRelationship($table, $name)
    {
        self::loadAttIndexes();
        //dump(self::$attRelationships);
        return isset(self::$attRelationships[$table][$name]) ? self::$attRelationships[$table][$name] : null;
    }

    protected function getRules()
    {
        self::loadAttIndexes();
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
        } catch (\Exception $e) {
            //dump(get_class($this), self::$attRelationships[$this->getTable()]);
            throw $e;
        }
    }
}
