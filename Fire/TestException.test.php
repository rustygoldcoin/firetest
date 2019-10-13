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

namespace Fire;

use Fire\Test\TestCase;
use Fire\Test\Mock;

class TestExceptionTest extends TestCase
{
    public function testIFail() {
        $this->should('Fail when assert is returned false');
        $this->assert(false);

        $mock = Mock::get('\Fire\TestExceptionTest');
        $mock
            ->method('MyMethod')
            ->calledWith()
            ->willReturn();

        $mock
            ->property('_member')
            ->withValue();
        var_dump($mock);
        exit();
    }
}