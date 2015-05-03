<h1 style="text-align:center">YourMVC</h1>
<h2 style="text-align:center">Documentation for Unit Tests Framework</h2>
******
###Table of Content
* [Unit Test Configuration](#TOC_UnitTestsConfig)
    * [Unit Test Path](#TOC_UnitTestPath)
    * [Tests End With](#TOC_UnitTestEndsWith)
* [Writing Unit Tests](#TOC_WritingUnitTests)
    * [Classes for Unit Tests](#TOC_ClassesForUnitTests)
    * [Setup and Tear-down Methods](#TOC_SetupAndTearDown)
    * [The Unit Tests](#TOC_TheUnitTests)
    * [Assertions](#TOC_UnitTestsAssertions)


<h4 id="TOC_UnitTestsConfig">Unit Test Configuration</h4>

The unit tests are originally designed to run from the PHP command line interface. To run the unit tests run the following command in a terminal window:

	php /path/to/framework/YourMVC/Libraries/UnitTestFramework.php

By default the tests are stored in the folder YourMVC/Libraries/UnitTests/*. The framework does automatically assume that tests can be stored in sub directories. There are two parameters that can be configured when creating and using unit tests.

<h5 id="TOC_UnitTestPath">Unit Test Path</h5>

The unit test path is the first variable that can be changed. By default it is the current working directory and the sub directory UnitTests. It is recommended (but not required) that all unit tests stay within the scope of the framework. This requires a value, otherwise the unit tests will not run.

<h5 id="TOC_UnitTestEndsWith">Tests End With</h5>

When developing unit tests, each test method must end with this series of characters. By default this is Test. It is required that this has a value, otherwise unit tests will not be run.

<h4 id="TOC_WritingUnitTests">Writing Unit Tests</h4>

Unit tests should be written for all projects. Your MVC includes the ability to create unit tests. By default, any php files that are in YourMVC/Libraries/UnitTests/ are included.

<h5 id="TOC_ClassesForUnitTests">Classes for Unit Tests</h5>

Each unit test function must be contained within classes that extend the \YourMVC\UnitTest\Framework\UnitTest class. By default, each method that ends with Test is a method that will be ran.

There are four supporter methods that get called at the initialization and destruction of each class and method.

<h5 id="TOC_SetupAndTearDown">Setup and Tear-down Methods</h5>

At the initialization of a unit test class a method called ClassSetup() is called. Likewise at the destruction of a class a method called ClassTearDown() is called.

Before each unit test method is called a method called MethodSetup() is called. After the unit test method finishes (either passing or failing) a method called MethodTearDown() is called.

These methods should be used whenever objects need to be present for each method.

<h5 id="TOC_TheUnitTests">The Unit Tests</h5>

Each unit test method must end in Test by default. See the section about configuration to change this setting. If a unit test fails, it will stop at the line it failed at, and move onto the next method after calling the necessary tear down and setup methods.

<h5 id="TOC_UnitTestsAssertions">Assertions</h5>

There are ten types of assertions. They are the following:

* AssertTrue($value) – The value must be true.
* AssertFalse($value) – The value must be false.
* AssertAreEqual($value1, $value2) – The two values must be equal. 4 \== 4 and 4 \== 4.0.
* AssertAreIdentical($value1, $value2) – The two values must be identical. 4 =\== 4 but 4 !== 4.0.
* AssertAreNotEqual($value1, $value2) – The two values are not equal. 4 != 5
* AssertAreNotIdentical($value1, $value2) – The two values are not identical 4 !\== 4.0.
* AssertAreEqualNotIdentical($value1, $value2) - The two values are equal but not identical. 4 \== 4.0 but 4 !\== 4.0
* AssertIsNull($value) - The value must be null.
* AssertIsNotNull($value1) – The value must not be null.
* AssertFail() - The test fails automatically.

Each unit assert can be called by $this->Assert. Each unit test has another parameter that can describe why the test failed. Each unit test additional parameter has a default value, but you are encouraged to make each unique per test to avoid confusion.

******
<p class="footer" style="text-align:center">
Written on June 2, 2014 by Stephen
Modified on April 28, 2015 by Stephen
Version 0.4A
</p>
