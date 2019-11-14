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

use \UA1Labs\Fire\TestException;
use \stdClass;
use \ReflectionClass;
use \ReflectionObject;

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
     * Returns an empty object of $className type you request.
     *
     * @param string $className The class you want to mock
     * @param array $methodOverrideValues An associative array of override methods mapped to value they should return
     * @throws \UA1Labs\Fire\TestException If the class doesn't exist
     * @throws \UA1Labs\Fire\TestException If an override method cannot be overridden
     * @return object
     */
    public function getMockObject($className, $methodOverrideValues = [])
    {
        if (!class_exists($className)) {
            throw new TestException('Unknown class "' . $className . '"');
        }

        $mockClassName = $this->registerMockClass($className, $methodOverrideValues);
        $mock = $this->createMockObject($mockClassName);
        $this->attachFireTestValuesToMockObject($mock, $methodOverrideValues);
        return $mock;
    }

    /**
     * Registers a mock class with the PHP runtime.
     *
     * @param string $className The class you would like to register a mock for
     * @param array $methodOverrideValues An associative array of override methods mapped to value they should return
     * @throws \UA1Labs\Fire\TestException If an override method cannot be overridden
     * @return string The className of the mocked class
     */
    private function registerMockClass($className, $methodOverrideValues)
    {
        // building override methods for mock class
        $refMock = new ReflectionClass($className);
        $methodOverrides = '';
        foreach ($methodOverrideValues as $method => $value) {
            if ($refMock->hasMethod($method)) {
                $refMethod = $refMock->getMethod($method);
                if (
                    $refMethod->isPublic()
                    && !$refMethod->isFinal()
                    && !$refMethod->isStatic()
                ) {
                    $static = $refMethod->isStatic() ? 'static ' : '';
                    $classFireTestVar = '$this->__firetest->' . $method;
                    $methodOverrides .= $static . 'public function ' . $method . '(){ return isset(' . $classFireTestVar . ') ? ' . $classFireTestVar . ' : null; } ';
                } else {
                    throw new TestException('When mocking "' . $className . '", we cannot override the method "'. $method . '".');
                }
            }
        }

        // building mock class by extending the requested $className
        $mockClassNamespace = 'FireTestMocks';
        $proposedClassName = str_replace(' ', '', ucwords(str_replace(['\\', '_'], ' ', $className)));
        $mockClassName = $this->getRandomizedClassName($mockClassNamespace, $proposedClassName);
        $finalClassName = '\\' . $mockClassNamespace . '\\' . $mockClassName;
        $mockClass = ''
            . 'namespace ' . $mockClassNamespace . '; '
            . 'class ' . $mockClassName . ' extends \\' . $className .' '
            . '{ ' . $methodOverrides . ' }';

        eval($mockClass);
        return $finalClassName;
    }

    /**
     * Creates a mock object from the classname
     *
     * @param string $className The name of the mocked class registered with self::registerMockClass()
     * @return object The mocked class
     */
    private function createMockObject($className)
    {
        $refMock = new ReflectionClass($className);
        $mock = $refMock->newInstanceWithoutConstructor();
        return $mock;
    }

    /**
     * Attaches __firetest object for mocked methods.
     *
     * @param object $mockObject The mocked object
     * @param array $methodOverrideValues An associative array of mapped method names with expected return values
     * @return void
     */
    private function attachFireTestValuesToMockObject(&$mockObject, $methodOverrideValues)
    {
        $mockObject->__firetest = (object) [];
        foreach ($methodOverrideValues as $method => $val) {
            $mockObject->__firetest->{$method} = $val;
        }
    }

    /**
     * Randomizes a clasname based on if it exists already.
     *
     * @param string $namespace
     * @param string $className
     * @return string
     */
    private function getRandomizedClassName($namespace, $className)
    {
        $proposedClassName = '\\' . $namespace . '\\' . $className;
        if (!class_exists($proposedClassName)) {
            return $className;
        }
        $className .= rand(100000, 999999);
        return $this->getRandomizedClassName($className, $className);
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
