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

namespace Test\UA1Labs\Fire\Test;

use UA1Labs\Fire\Test\TestCase;

class TestCaseTestCase extends TestCase
{

    /**
     * The class we are testing
     *
     * @var UA1Labs\Fire\Test\TestCase
     */
    private $_testCase;

    public function beforeEach()
    {
        $this->_testCase = new TestCaseMock();
    }

    public function testConstructor()
    {
        $this->should('Return an instance object of the TestCase object without throwing an exception.');
        $this->assert($this->_testCase instanceof TestCase);
    }

}

/**
 * Mock class
 */
class TestCaseMock extends TestCase
{

}