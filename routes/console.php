<?php

use App\Jobs\UpdateModels;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Redis;

/*
  |--------------------------------------------------------------------------
  | Console Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of your Closure based console
  | commands. Each Closure is bound to a command instance allowing a
  | simple approach to interacting with each command's IO methods.
  |
 */

Artisan::command('inspire',
    function () {
    $this->comment(Inspiring::quote());
    $a = new \App\Nombres;
    $a->padres;
})->describe('Display an inspiring quote');

Artisan::command('message {message}',
    function ($message) {
    broadcast(new \App\Events\ExampleEvent($message));
})->describe('Send a message to the clients');

Artisan::command('schema:update',
    function () {
    App\Jobs\UpdateModels::dispatchNow('pgsql');
    App\Jobs\UpdateModels::dispatchNow('hr');
})->describe('Update the schema cache now.');

Artisan::command('documento {icono}',
    function ($icono) {
    $documento = App\Documentos::find(1);
    $documento->icono = $icono;
    $documento->save();
})->describe('Send a message to the clients');

Artisan::command('migrate:update',
    function () {
    $current = exec('git rev-parse HEAD');
    $previous = file_exists('.previouscommit') ? file_get_contents('.previouscommit') : $current;
    $res = [];
    foreach (explode("\n", shell_exec('git diff --name-only ' . $previous)) as $path) {
        if (substr($path, 0, 20) !== 'database/migrations/') {
            continue;
        }
        $code = file_get_contents($path);
        if (preg_match('/class\s+(\w+)\s+/', $code, $match)) {
            require($path);
            $class = $match[1];
            $migration = new $class;
            $migration->down();
            $migration->up();
        }
    }
    UpdateModels::dispatchNow('hr');
    UpdateModels::dispatchNow('pgsql');
    file_put_contents('.previouscommit', $current);
})->describe('Actualiza las migrations que fueron modificadas');

Artisan::command('queue:clear',
    function () {
    Redis::connection()->del('queues:default');
})->describe('Limpia la lista de jobs en la cola (default) de redis');

Artisan::command('require-plugin {name}',
    function ($name) {
    exec('composer require ' . $name);
    exec('rm -Rf public/modules/' . $name);
    Artisan::call('vendor:publish', [
        '--tag' => $name
    ]);
});
