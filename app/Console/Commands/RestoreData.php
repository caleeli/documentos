<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class RestoreData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restore:data {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build a database data backup file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * Ex.:
     *  php artisan backup:data > data.bak
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('file');
        $f = fopen($file, 'r');
        Artisan::call('migrate:fresh');
        DB::beginTransaction();
        DB::select(DB::raw('SET session_replication_role=\'replica\''));
        while (($line = fgets($f)) !== false) {
            list($method, $params) = json_decode($line, true);
            call_user_func([$this, "fn$method"], ...$params);
        }
        fclose($f);
        DB::select(DB::raw('SET session_replication_role=\'origin\''));
        DB::rollBack();
    }

    /**
     * Restore a row
     *
     * @param string $table
     * @param array $row
     */
    private function fnSave($table, $row)
    {
        $table !== 'migrations' ? DB::table($table)->insert($row) : null;
    }

    private function fnDropAll()
    {
        DB::connection()->getSchemaBuilder()->dropAllTables();
        DB::connection()->getSchemaBuilder()->dropAllViews();
    }
}
