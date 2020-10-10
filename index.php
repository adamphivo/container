<?php

// Autoload classes from the App folder
spl_autoload_register(function ($class) {
    include 'App/'.$class.".php";
});

