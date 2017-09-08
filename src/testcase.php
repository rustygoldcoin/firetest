<?php

namespace firetest;

abstract class testcase {

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
     * The Constructor
     * @return void
     */
    public function __construct() {
        $this->_resetResults();
    }

    /**
     * A method that is invoked when the when the testcase is first intialized.
     * @return void
     */
    public function setUp() {}

    /**
     * A method that is invoked before each test method is invoked.
     * @return void
     */
    public function beforeEach() {}

    /**
     * A method that is invoked after each test method is invoked.
     * @return void
     */
    public function afterEach() {}

    /**
     * A
     * @return A method that is invoked when the test case is finish running all test methods.
     */
    public function tearDown() {}

    /**
     * A method that returns all methods that should be invoked for testing.
     * @return array
     */
    public function getTestMethods() {
        return array_filter(array_map([$this, '_filterTestMethods'], get_class_methods($this)));
    }

    /**
     * Returns the results for the a test that just ran.
     * @return array
     */
    public function getResults() {
        $results = [
            'passed' => $this->_passed,
            'failed' => $this->_failed
        ];
        $this->_resetResults();
        return $results;
    }

    /**
     * Method used to determine if a test passes or failes.
     * @param  boolean $trueStatement The statement you want to test
     * @param  string $shouldStatement The description of the assert
     * @return void
     */
    protected function assert($trueStatement, $shouldStatement) {
        if ($trueStatement === true) {
            $this->_passed[] = $shouldStatement;
        } else {
            $this->_failed[] = $shouldStatement;
        }
    }

    /**
     * Resets results.
     * @return void
     */
    public function _resetResults() {
        $this->_passed = [];
        $this->_failed = [];
    }

    /**
     * Used to filter method names or the ::getTestMethods() method.
     * @param  string $methodName The method name
     * @return string|null
     */
    private function _filterTestMethods($methodName) {
        return (substr($methodName, 0, 4) === 'test') ? $methodName : null;
    }

}
