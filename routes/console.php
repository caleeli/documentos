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

Artisan::command('schema:update', function () {
    App\Jobs\UpdateModels::dispatchNow('pgsql');
    App\Jobs\UpdateModels::dispatchNow('hr');
})->describe('Update the schema cache now.');

Artisan::command('documento {icono}', function ($icono) {
    $documento = App\Documentos::find(1);
    $documento->icono = $icono;
    $documento->save();
})->describe('Send a message to the clients');



Artisan::command('fastserver', function () {
    if (!extension_loaded('sockets')) {
        die('The sockets extension is not loaded.');
    }
// create unix udp socket
    $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
    if (!$socket)
        die('Unable to create AF_UNIX socket');

// same socket will be used in recv_from and send_to
    $server_side_sock = dirname(__FILE__) . "/server.sock";
    if (!socket_bind($socket, $server_side_sock))
        die("Unable to bind to $server_side_sock");

    while (1) { // server never exits
// receive query
        if (!socket_set_block($socket))
            die('Unable to set blocking mode for socket');
        $buf = '';
        $from = '';
        echo "Ready to receive...\n";
// will block to wait client query
        $bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);
        if ($bytes_received == -1)
            die('An error occured while receiving from the socket');
        echo "Received $buf from $from\n";

        $buf .= "->Response"; // process client query here
// send response
        if (!socket_set_nonblock($socket))
            die('Unable to set nonblocking mode for socket');
// client side socket filename is known from client request: $from
        $len = strlen($buf);
        $bytes_sent = socket_sendto($socket, $buf, $len, 0, $from);
        if ($bytes_sent == -1)
            die('An error occured while sending to the socket');
        else if ($bytes_sent != $len)
            die($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
        echo "Request processed\n";
    }
})->describe('Eval a code');

Artisan::command('fastclient', function () {
    $t0= microtime(true);
    if (!extension_loaded('sockets')) {
        die('The sockets extension is not loaded.');
    }
// create unix udp socket
    $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
    if (!$socket)
        die('Unable to create AF_UNIX socket');

// same socket will be later used in recv_from
// no binding is required if you wish only send and never receive
    $client_side_sock = dirname(__FILE__) . "/client.sock";
    if (!socket_bind($socket, $client_side_sock))
        die("Unable to bind to $client_side_sock");

// use socket to send data
    if (!socket_set_nonblock($socket))
        die('Unable to set nonblocking mode for socket');
// server side socket filename is known apriori
    $server_side_sock = dirname(__FILE__) . "/server.sock";
    $msg = "Message";
    $len = strlen($msg);
// at this point 'server' process must be running and bound to receive from serv.sock
    $bytes_sent = socket_sendto($socket, $msg, $len, 0, $server_side_sock);
    if ($bytes_sent == -1)
        die('An error occured while sending to the socket');
    else if ($bytes_sent != $len)
        die($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');

// use socket to receive data
    if (!socket_set_block($socket))
        die('Unable to set blocking mode for socket');
    $buf = '';
    $from = '';
// will block to wait server response
    $bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);
    if ($bytes_received == -1)
        die('An error occured while receiving from the socket');
    echo "Received $buf from $from\n";

// close socket and delete own .sock file
    socket_close($socket);
    unlink($client_side_sock);
    echo "Client exits\n";
    dump( microtime(true)-$t0);
})->describe('Eval a code');
