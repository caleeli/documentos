<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Nano\SchemaLive\Builder;

class UpdateModels implements ShouldQueue
{

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * Connection name.
     *
     * @var string $connectionName
     */
    public $connectionName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($connectionName)
    {
        $this->connectionName = $connectionName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $manager = DB::connection($this->connectionName)
            ->getDoctrineConnection()
            ->getSchemaManager();
        $builder = new Builder($manager, 'App');
        Cache::forever('AutoTableTraitSchema.' . $this->connectionName, $builder->getConfiguration());
    }
}
