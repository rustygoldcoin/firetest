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

    protected $_mockedMethods;

    protected $_mockedProperties;

    public function __construct($className)
    {
        $this->_mockedMethods = (object) [];
        $this->_mockedProperties = (object) [];
    }

    public function method($methodName)
    {
        if (!isset($this->_mockedMethods->{$methodName})) {
            $this->_mockedMethods->{$methodName} = [];
        }


    }

    public function property($propertyName)
    {

    }

}
