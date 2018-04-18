# FireTest

A Lightweight PHP Testing Framework

### API Docs

[FireTest API](https://ua1.us/open-source/firetest/api/);

### Installation

Install via Composer

1. Add `ua1-labs\firetest:dev-master` to your `require-dev` configuration in your `composer.json` file.

        "require-dev": {
            "ua1-labs/firetest": "dev-master"
        }

2. Run `composer install`

### Configure The Test Runner

FireTest can be configured so that it can be ran from either directly the command line or from your composer run-scripts.

**Running directly from the command line:**

    php vendor/ua1-labs/firetest/scripts/runner.php --dir=[directory] --ext=[fireExt]

The `runner.php` file is a script meant to bootstrap your test suite together to make it easier to configure your test runner. It accepts two parameters. `[directory]` is the directory you would like to scan to search for your test files. `[fileExt]` is the file extension FireTest should look for when it is scanning for tests.

Example:

    php vendor/ua1-labs/firetest/scripts/runner.php --dir=src --ext=.test.php

In the example above, the test suite will search through your `src` directory for all files with the extension `.test.php`.

**Running as a Composer Run-Script:**

To run FireTest as a composer test script all you need to do is configure the run-script to run the `runner.php` script and point it to the directory you want and the file extension you want it to find. You will find run-script configurations in your `composer.json` file located at the configuration `scripts`.

    "scripts": {
        "test": "php vendor/ua1-labs/firetest/scripts/runner.php --dir=src --ext=.test.php"
    }

Once you have it configured all you need to do is run the test script using Composer.

    composer test

### Creating Your First Test

To create your first test, you will need to start out by creating your test file. Your test file will consist of a class you create which will extend the class `Fire\Test\TestCase`.

Example:

    use Fire\Test\TestCase;

    class MyTestCase extends TestCase
    {
        //my test suite logic
    }

Once you test suite is loaded and initialized, the FireTest will iterate through all your methods that begin with the name `test` and run each one.

Example:

    public function testMyMethod()
    {
        //my test logic
    }

### Asserting

At some point, you will most likely want to assert something with your test method. Because you extended the `Fire\Test\TestCase` class, you have access to two methods called `Fire\Test\TestCase::should($statement)` and `Fire\Test\TestCase::assert($true)`. The `should` method provides you a way to tell us what your assert is going to do. Think of it like "this test should...". The `assert` method evaluates the `$true` parameter to determine a pass or fail. `$true` must evaluate to a `true` boolean value.

Example:

    $this
        ->should('Should be set to true.')
        ->assert(true);

### TestCase API

When setting up a test case, you have several methods you can use to help you automate your tests.

    /**
     * A method that is invoked when the when the testcase is first intialized.
     * @return void
     */
    public function setUp()

    /**
     * A method that is invoked before each test method is invoked.
     * @return void
     */
    public function beforeEach()

    /**
     * A method that is invoked after each test method is invoked.
     * @return void
     */
    public function afterEach()

    /**
     * A
     * @return A method that is invoked when the test case is finish running all test methods.
     */
    public function tearDown()

    /**
     * Method used to set the current test's should statement.
     * @param  string $shouldStatement The statement you want to test against
     * @return \Fire\Test\TestCase
     */
    protected function should($statement)

    /**
     * Method used to determine if a test passes or failes.
     * @param  boolean $trueStatement The statement you want to test
     * @return Fire\Test\TestCase
     */
    protected function assert($true)

### FireTest Logging

You have the ability to log out information as your tests are running. `Fire\Test\Suite::log()` is a static method you can use to log out information as your test is running.
