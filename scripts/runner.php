<?php
require_once __DIR__ . '/../../../autoload.php';

$dir = isset($argv[1]) ? $argv[1] : false;
$fileExt = isset($argv[2]) ? $argv[2] : '.test.php';
if (!$dir) {
    $exceptionDesc = 'Please include a directory parameter. Ex: php vendor/ua1-labs/firetest/src/runner.php'
        . ' [test_directory] [test_file_ext]';
    throw new Fire\TestException($exceptionDesc);
}

$suite = new Fire\Test\Suite(__DIR__ . '/../../../../' . $dir, $fileExt);
$suite->run();
