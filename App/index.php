<?php

spl_autoload_register(function ($class) {
    include $class . '.php';
});


// Make our items
$queue = new SplQueue();
$storage = new SplObjectStorage();
$producer = new MessageProducer($queue, $storage);
$reader = new MessageReader($queue, $storage);


// Create mock messages
$producer->makeMessage("Premier", "ENG", 1);
$producer->makeMessage("Deuxieme", "ENG", 1);
$producer->makeMessage("Troisieme, zut", "ENG", 1);

$reader->treatTopMessage();
$reader->treatTopMessage();
$reader->treatTopMessage();

// Check if all is empty after usage
echo var_dump($storage);
echo var_dump($queue);
