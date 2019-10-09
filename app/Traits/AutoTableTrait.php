<?php
namespace App\Traits;

use App\Jobs\UpdateModels;
use App\Observers\GenericObserver;
use Illuminate\Support\Facades\Cache;
use Nano\SchemaLive\AutoTableTrait as AutoTableTraitBase;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Column;

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
            foreach($columns as $col) {
                if (!$col->getAutoincrement()) {
                    $this->attributes[$col->getName()] = $col->getDefault();
                }
            }
        }
        return parent::syncOriginal();
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
