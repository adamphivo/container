<?php

// Autoload classes from the App folder
spl_autoload_register(function ($class) {
    include 'App/'.$class.".php";
});

// Build the container
$container = new Container();

// Register MessageProducer And MessageReader into the container
$container->register('MessageReader', function($container) {
    return new MessageReader($container->queue, $container->storage);
});

$container->register('MessageProducer', function($container) {
    return new MessageProducer($container->queue, $container->storage);
});

$producer = $container->get('MessageProducer');
$reader = $container->get('MessageReader');

$producer->makeMessage("Premier", "ENG", 1);
$producer->makeMessage("Deuxieme", "ENG", 1);
$producer->makeMessage("Troisieme, zut", "ENG", 1);

$reader->treatTopMessage();
$reader->treatTopMessage();
$reader->treatTopMessage();

// Check if all is empty after usage
echo var_dump($container->storage);
echo var_dump($container->queue);