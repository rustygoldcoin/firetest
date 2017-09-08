<?php

namespace firetest;

use firetest\FireTestException;
use firetest\testcase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class suite {

    /**
     * The directory that the test suite should scan for tests.
     * @var string
     */
    private $_dir;

    /**
     * The file extension the test suite should use to deferentiate tests.
     * @var string
     */
    private $_fileExt;

    /**
     * An array of classes identified to be ran with this suite.
     * @var array
     */
    private $_testClasses;

    /**
     * Total of all tests that passed for the suite.
     * @var integer
     */
    private $_totalPassCount;

    /**
     * Total of all tests that have failed for the suite.
     * @var integer
     */
    private $_totalFailCount;

    /**
     * An array of the tests that failed.
     * @var array
     */
    private $_allFailedTests;

    /**
     * The constructor
     * @param string $dir
     * @param string $fileExt
     */
    public function __construct($dir, $fileExt = '.test.php') {
        $this->_dir = $dir;
        $this->_fileExt = $fileExt;
        $this->_testClasses = [];
        $this->_totalPassCount = 0;
        $this->_totalFailCount = 0;
        $this->_allFailedTests = [];
        $this->_loadTestFiles();
    }

    /**
     * The run logic used to run the suite of testcases and tests.
     * @return void
     */
    public function run() {
        $this->log('Starting test suite located at "' . $this->_dir . '".');
        foreach($this->_testClasses as $testClass) {
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
                $this->_totalFailCount += $failedCount;
                if ($failedCount > 0) {
                    foreach ($fails as $failed) {
                        $this->_allFailedTests[] = $failed;
                        $this->log('[FAILED] ' . $failed);
                    }
                }
                $passes = $results['passed'];
                $passedCount = count($passes);
                $this->_totalPassCount += $passedCount;
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
        if ($this->_totalFailCount > 0) {
            $this->log('********************************************');
            $this->log('███████╗ █████╗ ██╗██╗     ███████╗██████╗');
            $this->log('██╔════╝██╔══██╗██║██║     ██╔════╝██╔══██╗');
            $this->log('█████╗  ███████║██║██║     █████╗  ██║  ██║');
            $this->log('██╔══╝  ██╔══██║██║██║     ██╔══╝  ██║  ██║');
            $this->log('██║     ██║  ██║██║███████╗███████╗██████╔╝');
            $this->log('╚═╝     ╚═╝  ╚═╝╚═╝╚══════╝╚══════╝╚═════╝');
            $i = 0;
            foreach ($this->_allFailedTests as $failedTest) {
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
        $this->log('[FINAL] (Passed: '. $this->_totalPassCount . ', Failed: ' . $this->_totalFailCount . ')');

        if ($this->_totalFailCount > 0) {
            exit(1);
        }

    }

    /**
     * Loads tests files from the directory and fileExt configurations.
     * @return void
     */
    private function _loadTestFiles() {
        $rDir = new RecursiveDirectoryIterator($this->_dir);
        $iDir = new RecursiveIteratorIterator($rDir);
        $iFiles = new RegexIterator($iDir, '/^.+\\' . $this->_fileExt . '$/', RegexIterator::GET_MATCH);
        foreach($iFiles as $file) {
            $require = $file[0];
            require_once $require;
            $className = str_replace($this->_fileExt, '', basename($require));
            if (!class_exists($className)) {
                throw new FireTestException('Test class "' . $className . '" cannot be found.');
            }
            $testInstance = new $className();
            if (!($testInstance instanceof testcase)) {
                throw new FireTestException('Test class "' . $className . '" must extend firetest\testcase.');
            }
            $this->_testClasses[] = new $className();
        }
    }

    /**
     * Logs out test that you pass into it.
     * @param  string $text
     * @return void
     */
    public static function log($text) {
        if (php_sapi_name() == "cli") {
            echo 'FireTest Log: ' . $text . "\n";
        } else {
            // Not in cli-mode
        }
    }

}
