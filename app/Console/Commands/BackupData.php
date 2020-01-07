<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BackupData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:data';

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
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        foreach ($tables as $table) {
            foreach (DB::table($table)->get() as $row) {
                $command = [
                    'save',
                    [
                        $table,
                        $row
                    ]
                ];
                $line = json_encode($command) . "\n";
                echo $line;
            }
        }
    }
}
