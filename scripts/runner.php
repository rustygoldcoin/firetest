<?php

/**
 *    __  _____   ___   __          __
 *   / / / /   | <  /  / /   ____ _/ /_  _____
 *  / / / / /| | / /  / /   / __ `/ __ `/ ___/
 * / /_/ / ___ |/ /  / /___/ /_/ / /_/ (__  )
 * `____/_/  |_/_/  /_____/`__,_/_.___/____/
 *
 * @package FireTest
 * @author UA1 Labs Developers https://ua1.us
 * @copyright Copyright (c) UA1 Labs
 */

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    $baseDir = __DIR__ . '/../';
} else {
    require_once __DIR__ . '/../../../autoload.php';
    $baseDir = __DIR__ . '/../../../../';
}

$options = getopt('', ['dir:', 'ext:']);
$dir = isset($options['dir']) ? $options['dir'] : '';
$fileExt = isset($options['ext']) ? $options['ext'] : '.test.php';

$dir = $baseDir . $dir;
$suite = new Fire\Test\Suite($dir, $fileExt);
$suite->run();
