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

if (php_sapi_name() !== 'cli') {
    http_response_code(404);
    exit();
}

require_once __DIR__ . '/../vendor/autoload.php';

$dir = __DIR__ . '/../UA1Labs';
$suite = new UA1Labs\Fire\Test\Suite($dir, '.TestCase.php');
$suite->run();