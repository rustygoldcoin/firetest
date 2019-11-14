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

use \UA1Labs\Fire\Test\TestCase;
use \UA1Labs\Fire\TestException;

class TestCaseTestCase extends TestCase
{

    /**
     * The class we are testing
     *
     * @var UA1Labs\Fire\Test\TestCase
     */
    private $testCase;

    public function beforeEach()
    {
        $this->testCase = new TestCaseMock();
    }

    public function testConstructor()
    {
        $this->should('Return an instance object of the TestCase object without throwing an exception.');
        $this->assert($this->testCase instanceof TestCase);
    }

    public function testGetMock()
    {
        $this->should('Throw an exception if the class we are trying to mock does not exists');
        try {
            $mock = $this->testCase->getMockObject('Mock');
            $this->assert(false);
        } catch (TestException $e) {
            $this->assert(true);
        }

        $this->should('Return an empty object of the type we requested.');
        $mock = $this->testCase->getMockObject(TestCaseMock::class);
        var_dump($mock);
        exit();
    }

}

/**
 * Mock class
 */
class TestCaseMock extends TestCase
{

}
