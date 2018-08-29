<?php
namespace App;

use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;
use Doctrine\DBAL\Schema\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Description of Nombres
 *
 */
class Nombres extends Model
{

    use AutoTableTrait;

    protected $table = 'nombres';

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $conn = DB::connection()->getDoctrineConnection();
        $sm = $conn->getSchemaManager();
        dd($this->readSchema($sm));
        Schema::table($this->table, function(\Illuminate\Database\Schema\Blueprint $table) {
            dd($table->getColumns());
        });
    }

    private static $attIndexes = [];

    private function readSchema(\Doctrine\DBAL\Schema\AbstractSchemaManager $schema)
    {
        foreach ($schema->listTableIndexes($this->table) as $index) {
            static::readIndex($index);
        }
        foreach ($schema->listTableForeignKeys($this->table) as $fk) {
            static::registerFK($fk);
        }
    }

    private static function readIndex(\Doctrine\DBAL\Schema\Index $index)
    {
        $columns = $index->getColumns();
        sort($columns);
        static::$attIndexes[json_encode($columns)] = [
            'name' => $index->getName(),
            'multiplicity' => $index->isUnique() || $index->isPrimary() ? 1 : 'n',
        ];
    }
    
    public static function getDBIndex(array $columns)
    {
        sort($columns);
        $jcolumns = json_encode($columns);
        return isset($this->attIndexes[$jcolumns]) ? $this->attIndexes[$jcolumns]->getName() : null;
    }

    private static function registerFK(\Doctrine\DBAL\Schema\ForeignKeyConstraint $fk)
    {
        $table = $fk->getForeignTableName();
        $foreign = get_namespace($this) . '\\' . Str::studly($table);
        $foreignIndex = $foreign::getDBIndex($fk->getForeignColumns());
        $localIndex = static::getDBIndex($fk->getColumns());
        
        dd([
            $name, $table, $columns, get_namespace($this) . '\\' . Str::studly($table),
            $fk->getOptions(),
        ]);
    }

    public function padres()
    {
        return $this->hasMany(Nombres::class);
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
        $relationship = $this->getDBRelationship($method);
        if ($relationship) {
            return $relationship;
        } else {
            return parent::__call($method, $parameters);
        }
    }
}
