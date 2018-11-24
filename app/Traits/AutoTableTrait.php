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

    use ValidatedModelTrait;
    use AutoTableTraitBase;

    /**
     * Boot the AutoTableTrait.
     *
     */
    public static function bootAutoTableTrait()
    {
        $connection = static::getStaticConnectionName();
        if (!self::isAttConfigurationEmpty($connection)) {
            return;
        }
        $key = 'AutoTableTraitSchema.' . $connection;
        $ttl = 'AutoTableTraitSchemaTTL.' . $connection;
        if (!Cache::has($key)) {
            UpdateModels::dispatchNow($connection);
        } else {
            Cache::remember($ttl, 0.1, function () use ($connection) {
                UpdateModels::dispatch($connection);
                return 1;
            });
        }
        self::setAttConfiguration($connection, Cache::get($key, [
            'fields' => [],
            'relationships' => [],
        ]));
        static::observe(GenericObserver::class);
    }
}
