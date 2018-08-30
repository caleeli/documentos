<?php

use Illuminate\Foundation\Inspiring;

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

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
    $a = new \App\Nombres;
    $a->padres;
})->describe('Display an inspiring quote');

Artisan::command('message {message}', function ($message) {
    broadcast(new \App\Events\ExampleEvent($message));
})->describe('Send a message to the clients');