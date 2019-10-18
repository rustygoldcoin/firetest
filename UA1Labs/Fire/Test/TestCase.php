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

namespace UA1Labs\Fire\Test;

/**
 * This is an abstract class used to create test cases from.
 */
abstract class TestCase
{

    /**
     * The array of tests that have passed.
     *
     * @var array
     */
    private $passed;

    /**
     * The array of tests that have failed.
     *
     * @var array
     */
    private $failed;

    /**
     * When runninng tests, this variable will contain the
     * current test's should statement. The user will state
     * what their current test should do using the ::should()
     * method.
     *
     * @var string
     */
    private $should;

    /**
     * The class constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->resetResults();
    }

    /**
     * A method that is invoked when the when the testcase is first intialized.
     *
     * @return void
     */
    public function setUp()
    {

    }

    /**
     * A method that is invoked before each test method is invoked.
     *
     * @return void
     */
    public function beforeEach()
    {

    }

    /**
     * A method that is invoked after each test method is invoked.
     *
     * @return void
     */
    public function afterEach()
    {

    }

    /**
     * A method that is invoked when the test case is finish running all test methods.
     *
     * @return void
     */
    public function tearDown()
    {

    }

    /**
     * A method that returns all methods that should be invoked for testing.
     *
     * @return array
     */
    public function getTestMethods()
    {
        return array_filter(array_map([$this, 'filterTestMethods'], get_class_methods($this)));
    }

    /**
     * Returns the results for the a test that just ran.
     *
     * @return array
     */
    public function getResults()
    {
        $results = [
            'passed' => $this->passed,
            'failed' => $this->failed
        ];
        $this->resetResults();
        return $results;
    }

    /**
     * Method used to set the current test's should statement.
     *
     * @param string $statement The statement you want to test against
     * @return UA1Labs\Fire\Test\TestCase
     */
    protected function should($statement)
    {
        $this->should = $statement;
        return $this;
    }

    /**
     * Method used to determine if a test passes or failes.
     *
     * @param boolean $true The statement you want to test
     * @return UA1Labs\Fire\Test\TestCase
     */
    protected function assert($true)
    {
        if ($true === true) {
            $this->passed[] = $this->should;
        } else {
            $this->failed[] = $this->should;
        }
        return $this;
    }

    /**
     * Resets results.
     *
     * @return void
     */
    public function resetResults()
    {
        $this->should = '';
        $this->passed = [];
        $this->failed = [];
    }

    /**
     * Used to filter method names or the ::getTestMethods() method.
     *
     * @param  string $methodName The method name
     * @return string|null
     */
    private function filterTestMethods($methodName)
    {
        return (substr($methodName, 0, 4) === 'test') ? $methodName : null;
    }

}
