<?php
namespace MyMVC\UnitTest\Framework;
{
    require_once 'Libraries/UnitTestFramework.php';

    class UnitTestsTest extends \YourMVC\UnitTest\Framework\UnitTest {

        function AssertTrueTest(){
            $this->AssertTrue(true);
        }

        function AssertFalseTest(){
            $this->AssertFalse(false);
        }

        function AssertAreEqualTest(){
            $this->AssertAreEqual(true,true);
            $this->AssertAreEqual(false,false);
            $this->AssertAreEqual(4,4);
            $this->AssertAreEqual(4.0,4);
            $this->AssertAreEqual(1.1,1.1);
            $this->AssertAreEqual("Hello World","Hello World");
            $this->AssertAreEqual("Hello World",'Hello World');
        }

        function AssertAreIdenticalTest(){
            $this->AssertAreIdentical(true,true);
            $this->AssertAreIdentical(false,false);
            $this->AssertAreIdentical(4,4);
            $this->AssertAreIdentical(1.1,1.1);
            $this->AssertAreIdentical("Hello World","Hello World");
        }

        function AssertAreNotEqualTest(){
            $this->AssertAreNotEqual(true,false);
            $this->AssertAreNotEqual(4,5);
            $this->AssertAreNotEqual(1.1,2.1);
            $this->AssertAreNotEqual("Hello","World");
        }

        function AssertAreNotIdenticalTest(){
            $this->AssertAreNotIdentical(true,false);
            $this->AssertAreNotIdentical(4,5);
            $this->AssertAreNotIdentical(4,4.0);
            $this->AssertAreNotIdentical(1.1,2.1);
            $this->AssertAreNotIdentical("Hello","World");
        }

        function AssertAreEqualNotIdenticalTest(){
            $this->AssertAreNotIdentical(4,4.0);
        }

        function AssertIsNullTest(){
            $this->AssertIsNull(null);
        }

        function AssertIsNotNullTest(){
            $this->AssertIsNotNull(true);
            $this->AssertIsNotNull(false);
            $this->AssertIsNotNull(4);
            $this->AssertIsNotNull(4.0);
            $this->AssertIsNotNull("Hello World");
            $this->AssertIsNotNull(new MyCoolClass());
        }
    }

    class MyCoolClass {
        var $helloWorld = "Hello World";
    }
}