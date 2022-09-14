<?php

$host = "127.0.0.1";

$port = 8080;
// No Timeout
set_time_limit(0);

$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

//$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");

if (!socket_bind($socket, $host, $port)) {
    die('Unable to bind socket: '. socket_strerror(socket_last_error()) . PHP_EOL);
}

$result = socket_listen($socket, 3) or die("Could not set up socket listener\n");

$spawn = socket_accept($socket) or die("Could not accept incoming connection\n");

$input = socket_read($spawn, 1024) or die("Could not read input\n");

// clean up input string
$input = trim($input);
echo "Client Message : ".$input;

// reverse client input and send back
$output = strrev($input) . "\n";

socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");
// close sockets

socket_close($spawn);
socket_close($socket);