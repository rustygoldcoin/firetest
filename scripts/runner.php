<?php
require_once __DIR__ . '/../../../autoload.php';

$dir = isset($argv[1]) ? $argv[1] : false;
$fileExt = isset($argv[2]) ? $argv[2] : '.test.php';
if (!$dir) {
    throw new firetest\FireTestException('Please include a directory parameter. Ex: php vendor/jlj-labs/firetest/src/runner.php [test_directory] [test_file_ext]');
}

$suite = new firetest\suite(__DIR__ . '/../../../../' . $dir, $fileExt);
$suite->run();
