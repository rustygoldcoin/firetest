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
use \UA1Labs\Fire\Test\TestCase;
use \RecursiveDirectoryIterator;
use \RecursiveIteratorIterator;
use \RegexIterator;

/**
 * This class is responsible for running a test suite given.
 */
class Suite
{

    /**
     * The directory that the test suite should scan for tests.
     *
     * @var string
     */
    private $dir;

    /**
     * The file extension the test suite should use to deferentiate tests.
     *
     * @var string
     */
    private $fileExt;

    /**
     * An array of classes identified to be ran with this suite.
     *
     * @var array<string>
     */
    private $testClasses;

    /**
     * Total of all tests that passed for the suite.
     *
     * @var integer
     */
    private $totalPassCount;

    /**
     * Total of all tests that have failed for the suite.
     *
     * @var integer
     */
    private $totalFailCount;

    /**
     * An array of the tests that failed.
     *
     * @var array<string>
     */
    private $allFailedTests;

    /**
     * The class constructor.
     *
     * @param string $dir The directory you would like to run this test suite for
     * @param string $fileExt The file extendion that will indicate FireTest cases
     */
    public function __construct($dir, $fileExt = '.TestCase.php')
    {
        if (!is_dir($dir)) {
            $error = 'The directory "' . $dir . '" could not be found.';
            throw new TestException($error);
        }
        $this->dir = $dir;
        $this->fileExt = $fileExt;
        $this->testClasses = [];
        $this->totalPassCount = 0;
        $this->totalFailCount = 0;
        $this->allFailedTests = [];

        $this->log('*************************************************************');
        $this->log('███████╗██╗██████╗ ███████╗████████╗███████╗███████╗████████╗');
        $this->log('██╔════╝██║██╔══██╗██╔════╝╚══██╔══╝██╔════╝██╔════╝╚══██╔══╝');
        $this->log('█████╗  ██║██████╔╝█████╗     ██║   █████╗  ███████╗   ██║   ');
        $this->log('██╔══╝  ██║██╔══██╗██╔══╝     ██║   ██╔══╝  ╚════██║   ██║   ');
        $this->log('██║     ██║██║  ██║███████╗   ██║   ███████╗███████║   ██║   ');
        $this->log('╚═╝     ╚═╝╚═╝  ╚═╝╚══════╝   ╚═╝   ╚══════╝╚══════╝   ╚═╝   ');
        $this->log('*************************************************************');
        $this->log('[STARTING] Test suite is located at "' . realpath($this->dir) . '"');
        $this->log('[STARTING] Finding all files with the extension "' . $this->fileExt . '"');
        $this->loadTestFiles();
    }

    /**
     * The run logic used to run the suite of test cases and tests.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->testClasses as $testClass) {
            $testClass->setUp();
            $testMethods = $testClass->getTestMethods();
            foreach ($testMethods as $testMethod) {
                $testClass->beforeEach();
                $testName = get_class($testClass) . '::' . $testMethod . '()';
                $this->log('[RUNNING] ' . $testName);
                $testClass->{$testMethod}();

                $results = $testClass->getResults();
                $fails = $results['failed'];
                $failedCount = count($fails);
                $this->totalFailCount += $failedCount;
                if ($failedCount > 0) {
                    foreach ($fails as $failed) {
                        $this->allFailedTests[] = $failed;
                        $this->log('[FAILED] ' . $failed);
                    }
                }
                $passes = $results['passed'];
                $passedCount = count($passes);
                $this->totalPassCount += $passedCount;
                if ($passedCount > 0) {
                    foreach ($passes as $passed) {
                        $this->log('[PASSED] ' . $passed);
                    }
                }
                $passFail = (count($fails) === 0) ? 'PASSED' : 'FAILED';

                $this->log('[RESULT] (Passed: '. $passedCount . ', Failed: ' . $failedCount . ')');
                $testClass->afterEach();
            }
            $testClass->tearDown();
        }
        if ($this->totalFailCount > 0) {
            $this->log('********************************************');
            $this->log('███████╗ █████╗ ██╗██╗     ███████╗██████╗');
            $this->log('██╔════╝██╔══██╗██║██║     ██╔════╝██╔══██╗');
            $this->log('█████╗  ███████║██║██║     █████╗  ██║  ██║');
            $this->log('██╔══╝  ██╔══██║██║██║     ██╔══╝  ██║  ██║');
            $this->log('██║     ██║  ██║██║███████╗███████╗██████╔╝');
            $this->log('╚═╝     ╚═╝  ╚═╝╚═╝╚══════╝╚══════╝╚═════╝');
            $i = 0;
            foreach ($this->allFailedTests as $failedTest) {
                $this->log('[#' . $i . '] ' . $failedTest);
                $i++;
            }
            $this->log('********************************************');
        } else {
            $this->log('***********************************************************');
            $this->log('███████╗██╗   ██╗ ██████╗ ██████╗███████╗███████╗███████╗');
            $this->log('██╔════╝██║   ██║██╔════╝██╔════╝██╔════╝██╔════╝██╔════╝');
            $this->log('███████╗██║   ██║██║     ██║     █████╗  ███████╗███████╗');
            $this->log('╚════██║██║   ██║██║     ██║     ██╔══╝  ╚════██║╚════██║');
            $this->log('███████║╚██████╔╝╚██████╗╚██████╗███████╗███████║███████║');
            $this->log('╚══════╝ ╚═════╝  ╚═════╝ ╚═════╝╚══════╝╚══════╝╚══════╝');
            $this->log('***********************************************************');
        }
        $this->log('[FINAL] (Passed: '. $this->totalPassCount . ', Failed: ' . $this->totalFailCount . ')');

        if ($this->totalFailCount > 0) {
            exit(1);
        }
    }

    /**
     * Loads tests files from the directory and fileExt configurations.
     *
     * @return void
     */
    private function loadTestFiles()
    {
        $rDir = new RecursiveDirectoryIterator($this->dir);
        $iDir = new RecursiveIteratorIterator($rDir);
        $iFiles = new RegexIterator($iDir, '/^.+\\' . $this->fileExt . '$/', RegexIterator::GET_MATCH);
        foreach($iFiles as $file) {
            $require = $file[0];
            $this->log('[LOADING] Test file "' . realpath($require) . '"');
            $declaredBefore = get_declared_classes();
            require_once $require;
            $declaredAfter = get_declared_classes();
            $loadedClasses = array_diff($declaredAfter, $declaredBefore);
            foreach($loadedClasses as $className) {
                if (is_subclass_of($className, 'UA1Labs\Fire\Test\TestCase')) {
                    if (!class_exists($className)) {
                        throw new TestException('Test class "' . $className . '" cannot be found.');
                    }
                    $testInstance = new $className();
                    if (!($testInstance instanceof TestCase)) {
                        throw new TestException('Test class "' . $className . '" must extend Fire\Test\TestCase.');
                    }
                    $this->log('[LOADING] Test class "' . $className . '"');
                    $this->testClasses[] = new $className();
                }
            }
        }
    }

    /**
     * Logs out test that you pass into it.
     *
     * @param  string $text The text you would like to log out.
     * @return void
     */
    public static function log($text)
    {
        if (php_sapi_name() === 'cli') {
            echo 'FireTest: ' . $text . "\n";
        } else {
            // Not in cli-mode
        }
    }

}
