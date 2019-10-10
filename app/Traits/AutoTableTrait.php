<?php

namespace App\Traits;

use App\Jobs\UpdateModels;
use App\Observers\GenericObserver;
use Illuminate\Support\Facades\Cache;
use Nano\SchemaLive\AutoTableTrait as AutoTableTraitBase;

/**
 * Description of AutoTable
 *
 */
trait AutoTableTrait
{
    /**
     * Sync the original attributes with the current.
     *
     * @return $this
     */
    public function syncOriginal()
    {
        if (empty($this->attributes)) {
            $columns = $this->getConnection()->getDoctrineSchemaManager()->listTableColumns($this->getTable());
            $this->attributes = [];
            $reserved = [static::CREATED_AT, static::UPDATED_AT, 'user_add', 'user_mod', 'user_del'];
            method_exists($this, 'getDeletedAtColumn') ? $reserved[]=$this->getDeletedAtColumn() : false;
            foreach ($columns as $col) {
                $colName = $col->getName();
                if (!$col->getAutoincrement() && !in_array($colName, $reserved)) {
                    $this->attributes[$col->getName()] = $col->getDefault() ?? $this->getDefaultByType($col->getType()->getName());
                }
            }
        }
        return parent::syncOriginal();
    }

    private function getDefaultByType($type)
    {
        switch ($type) {
            case 'date': return date('Y-m-d');
            case 'datetime': return date('Y-m-d H:i:s');
            case 'string': return '';
            case 'text': return '';
            case 'integer': return 0;
            case 'float': return 0;
            default: return '';
        }
    }

//
//    use ValidatedModelTrait;
//    use AutoTableTraitBase;
//
//    /**
//     * Boot the AutoTableTrait.
//     *
//     */
//    public static function bootAutoTableTrait()
//    {
//        $connection = static::getStaticConnectionName();
//        if (!self::isAttConfigurationEmpty($connection)) {
//            return;
//        }
//        $key = 'AutoTableTraitSchema.' . $connection;
//        $ttl = 'AutoTableTraitSchemaTTL.' . $connection;
//        if (!Cache::has($key)) {
//            UpdateModels::dispatchNow($connection);
//        } else {
//            Cache::remember($ttl, 0.1, function () use ($connection) {
//                UpdateModels::dispatch($connection);
//                return 1;
//            });
//        }
//        self::setAttConfiguration($connection, Cache::get($key, [
//            'fields' => [],
//            'relationships' => [],
//        ]));
//        static::observe(GenericObserver::class);
//    }
}
