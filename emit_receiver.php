<?php
require_once __DIR__ . '/emitter/vendor/autoload.php'; // Autoload files using Composer autoload

use SocketIO\Emitter;
use SocketIO\Binary;

$emitter = new Emitter(NULL, array('host' => '127.0.0.1', 'port' => '6379'));
$emitter->of('/development')->in('sample')->emit('broadcast_general_command', array("broadcast_hash" => "something"));