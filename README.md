# FireTest - PHP Automated Testing

A Lightweight PHP Testing Framework

## Documentation

https://ua1.us/projects/firetest/

## Configure The Test Runner

FireTest can be configured so that it can be ran from either directly the command line or from your composer run-scripts.

**Running directly from the command line:**

    php vendor/ua1-labs/firetest/scripts/runner.php --dir=[directory] --ext=[fireExt]

The `runner.php` file is a script meant to bootstrap your test suite together to make it easier to configure your test runner. It accepts two parameters. `[directory]` is the directory you would like to scan to search for your test files. `[fileExt]` is the file extension FireTest should look for when it is scanning for tests.

Example:

    php vendor/ua1-labs/firetest/scripts/runner.php --dir=src --ext=.TestCase.php

In the example above, the test suite will search through your `src` directory for all files with the extension `.TestCase.php`.

**Running as a Composer Run-Script:**

To run FireTest as a composer test script all you need to do is configure the run-script to run the `runner.php` script and point it to the directory you want and the file extension you want it to find. You will find run-script configurations in your `composer.json` file located at the configuration `scripts`.

    "scripts": {
        "test": "php vendor/ua1-labs/firetest/scripts/runner.php --dir=/src --ext=.TestCase.php"
    }

Once you have it configured all you need to do is run the test script using Composer.

    composer test

## Creating Your First Test

To create your first test, you will need to start out by creating your test file. Your test file will consist of a class you create which will extend the class `UA1Labs\Fire\Test\TestCase`.

Example:

    use UA1Labs\Fire\Test\TestCase;

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

## Asserting

At some point, you will most likely want to assert something with your test method. Because you extended the `Fire\Test\TestCase` class, you have access to two methods called `UA1Labs\Fire\Test\TestCase::should($statement)` and `UA1Labs\Fire\Test\TestCase::assert($true)`. The `should` method provides you a way to tell us what your assert is going to do. Think of it like "this test should...". The `assert` method evaluates the `$true` parameter to determine a pass or fail. `$true` must evaluate to a `true` boolean value.

Example:

    $this->should('Should be set to true.')
    // do some scaffolding to setup your test
    $this->assert(true);

## FireTest Logging

You have the ability to log out information as your tests are running. `Fire\Test\Suite::log()` is a static method you can use to log out information as your test is running.
