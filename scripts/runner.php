<?php
require_once __DIR__ . '/../../../autoload.php';

$options = getopt('', ['dir:', 'ext:']);
$dir = isset($options['dir']) ? $options['dir'] : false;
$fileExt = isset($options['ext']) ? $options['ext'] : '.test.php';
if (!$dir) {
    $exceptionDesc = 'Please include a directory parameter. Ex: php vendor/ua1-labs/firetest/src/runner.php'
        . ' --dir=[test_directory] --ext[test_file_ext]';
    throw new Fire\TestException($exceptionDesc);
}

$dir = __DIR__ . '/../../../../' . $dir;
$suite = new Fire\Test\Suite($dir, $fileExt);
$suite->run();
