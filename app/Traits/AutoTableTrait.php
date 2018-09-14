<?php
namespace App\Traits;

use App\Jobs\UpdateModels;
use App\Observers\GenericObserver;
use Illuminate\Support\Facades\Cache;

/**
 * Description of AutoTable
 *
 */
trait AutoTableTrait
{

    use ValidatedModelTrait;
    use \Nano\SchemaLive\AutoTableTrait;

    /**
     * Boot the AutoTableTrait.
     *
     */
    public static function bootAutoTableTrait()
    {
        if (!self::isAttConfigurationEmpty()) {
            return;
        }
        if (!Cache::has('AutoTableTraitSchema')) {
            UpdateModels::dispatchNow();
        } else {
            Cache::remember('AutoTableTraitSchemaTTL', 0.1, function () {
                UpdateModels::dispatch();
                return 1;
            });
        }
        self::setAttConfiguration(Cache::get('AutoTableTraitSchema', [
                'fields' => [],
                'relationships' => [],
        ]));
        static::observe(GenericObserver::class);
    }
}
