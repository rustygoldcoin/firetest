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
use UA1Labs\Fire\Test\Suite;

class SuiteTestCase extends TestCase
{

    /**
     * The class we are testing
     *
     * @var UA1Labs\Fire\Test\Suite
     */
    private $_suite;

    public function beforeEach()
    {
        $this->_suite = new SuiteMock(__DIR__ . '/.', '.TestCase.php');
    }

    public function testConstructor()
    {
        $this->should('Return an instance object of the Suite object without throwing an exception.');
        $this->assert($this->_suite instanceof Suite);
    }

}

/**
 * Mocking classes
 */
class SuiteMock extends Suite
{
    /**
     * The logs being output
     *
     * @var string
     */
    public static $logs;

    public function __construct($dir, $fireExt)
    {
        parent::__construct($dir, $fireExt);
        self::$logs = '';
    }

    public static function log($text)
    {
        self::$logs .= $text;
    }
}