<?php

/**
 *    __  _____   ___   __          __
 *   / / / /   | <  /  / /   ____ _/ /_  _____
 *  / / / / /| | / /  / /   / __ `/ __ `/ ___/
 * / /_/ / ___ |/ /  / /___/ /_/ / /_/ (__  )
 * `____/_/  |_/_/  /_____/`__,_/_.___/____/
 *
 * @package FireStudio
 * @subpackage FireTest
 * @author UA1 Labs Developers https://ua1.us
 * @copyright Copyright (c) UA1 Labs
 */

namespace Fire\Test;

abstract class TestCase
{

    /**
     * The array of tests that have passed.
     * @var array
     */
    private $_passed;

    /**
     * The array of tests that have failed.
     * @var array
     */
    private $_failed;

    /**
     * When runninng tests, this variable will contain the
     * current test's should statement. The user will state
     * what their current test should do using the ::should()
     * method.
     * @var string
     */
    private $_should;

    /**
     * The Constructor
     * @return void
     */
    public function __construct()
    {
        $this->_resetResults();
    }

    /**
     * A method that is invoked when the when the testcase is first intialized.
     * @return void
     */
    public function setUp()
    {

    }

    /**
     * A method that is invoked before each test method is invoked.
     * @return void
     */
    public function beforeEach()
    {

    }

    /**
     * A method that is invoked after each test method is invoked.
     * @return void
     */
    public function afterEach()
    {

    }

    /**
     * A method that is invoked when the test case is finish running all test methods.
     * @return void
     */
    public function tearDown()
    {

    }

    /**
     * A method that returns all methods that should be invoked for testing.
     * @return array
     */
    public function getTestMethods()
    {
        return array_filter(array_map([$this, '_filterTestMethods'], get_class_methods($this)));
    }

    /**
     * Returns the results for the a test that just ran.
     * @return array
     */
    public function getResults()
    {
        $results = [
            'passed' => $this->_passed,
            'failed' => $this->_failed
        ];
        $this->_resetResults();
        return $results;
    }

    /**
     * Method used to set the current test's should statement.
     * @param  string $shouldStatement The statement you want to test against
     * @return \Fire\Test\TestCase
     */
    protected function should($statement)
    {
        $this->_should = $statement;
        return $this;
    }

    /**
     * Method used to determine if a test passes or failes.
     * @param  boolean $trueStatement The statement you want to test
     * @return Fire\Test\TestCase
     */
    protected function assert($true)
    {
        if ($true === true) {
            $this->_passed[] = $this->_should;
        } else {
            $this->_failed[] = $this->_should;
        }
        return $this;
    }

    /**
     * Resets results.
     * @return void
     */
    public function _resetResults()
    {
        $this->_should = '';
        $this->_passed = [];
        $this->_failed = [];
    }

    /**
     * Used to filter method names or the ::getTestMethods() method.
     * @param  string $methodName The method name
     * @return string|null
     */
    private function _filterTestMethods($methodName)
    {
        return (substr($methodName, 0, 4) === 'test') ? $methodName : null;
    }

}
