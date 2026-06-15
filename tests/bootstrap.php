<?php

$autoloaders = [
    __DIR__.'/../vendor/autoload.php',
    __DIR__.'/../../../../adminTest/vendor/autoload.php',
];

foreach ($autoloaders as $autoloader) {
    if (file_exists($autoloader)) {
        require_once $autoloader;
        require_once __DIR__.'/TestCase.php';

        return;
    }
}

throw new RuntimeException('Unable to locate Composer autoloader.');
