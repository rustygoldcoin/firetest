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

namespace Fire\Test;

use \ReflectionClass;

/**
 * This class is responsible for providing the ability to mock
 * dependencies within tests.
 */
class Mock
{

    private $_reflectionClass;

    private function __construct($className)
    {
        $this->_reflectionClass = new ReflectionClass($className);
    }

    public static function get($className)
    {
        return new Mock($className);
    }

    public function mockVariable()
    {

    }

    public function mockMethod()
    {

    }

}
