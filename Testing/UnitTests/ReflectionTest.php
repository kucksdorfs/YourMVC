<?php
namespace YourMVC\UnitTest\Framework
{

    use YourMVC\Libraries\YourReflection;

    class ReflectionTest extends \YourMVC\Testing\UnitTestFramework
    {
        
        // Creating Objects Tests
        function CreateObjectTest()
        {
            $myClass = YourReflection::CreateNewInstance("YourMVC\UnitTest\Framework\MyTestClass");
            $this->AssertIsNotNull($myClass);
        }

        function CreateBadObjectTest()
        {
            $myClass = YourReflection::CreateNewInstance("ReallyBadClass");
            $this->AssertIsNull($myClass);
        }
        
        // Instance Methods Tests
        function ObjectHasMethodTest()
        {
            $myClass = YourReflection::CreateNewInstance("YourMVC\UnitTest\Framework\MyTestClass");
            $this->AssertTrue(YourReflection::HasInstanceMethod($myClass, "CalculateSum"));
        }

        function CallInstanceMethodTest()
        {
            $myClass = YourReflection::CreateNewInstance("YourMVC\UnitTest\Framework\MyTestClass");
            $myRetValue = null;
            $completed = YourReflection::InvokeInstanceMethod($myClass, "CalculateSum", array(
                2,
                2
            ), $myRetValue);
            $this->AssertTrue($completed);
            $this->AssertAreEqual(4, $myRetValue);
        }

        function CallInstanceMethodWithNoParametersTest()
        {
            $myClass = YourReflection::CreateNewInstance("YourMVC\UnitTest\Framework\MyTestClass");
            $myRetValue = null;
            $completed = YourReflection::InvokeInstanceMethod($myClass, "CalculateTrue", null, $myRetValue);
            $this->AssertTrue($completed);
            $this->AssertTrue($myRetValue);
        }

        function CallInstanceMethodWithBadParametersTest()
        {
            $myClass = YourReflection::CreateNewInstance("YourMVC\UnitTest\Framework\MyTestClass");
            $myRetValue = null;
            $completed = YourReflection::InvokeInstanceMethod($myClass, "CalculateSum", null, $myRetValue);
            $this->AssertFalse($completed);
        }

        function CallVoidMethodTest()
        {
            $myClass = YourReflection::CreateNewInstance("YourMVC\UnitTest\Framework\MyTestClass");
            $myRetValue = null;
            $completed = YourReflection::InvokeInstanceMethod($myClass, "MyVoidFunction", null, $myRetValue);
            $this->AssertTrue($completed);
        }

        function CallBadMethodTest()
        {
            $myClass = YourReflection::CreateNewInstance("YourMVC\UnitTest\Framework\MyTestClass");
            $myRetValue = null;
            $completed = YourReflection::InvokeInstanceMethod($myClass, "CalculateSume", array(
                2,
                2
            ), $myRetValue);
            $this->AssertFalse($completed);
        }
        
        // Static Methods Tests
        function CallStaticMethodTest()
        {
            $myRetValue = null;
            $completed = YourReflection::InvokeStaticMethod("YourMVC\UnitTest\Framework\MyTestClass", "CalculateProduct", array(
                3,
                3
            ), $retValue);
            $this->AssertTrue($completed);
            $this->AssertAreEqual($retValue, 9);
        }

        function CallStaticMethodWithNoParametersTest()
        {
            $myRetValue = null;
            $completed = YourReflection::InvokeStaticMethod("YourMVC\UnitTest\Framework\MyTestClass", "CalculateFalse", null, $myRetValue);
            $this->AssertTrue($completed);
            $this->AssertFalse($myRetValue);
        }
        
        // Instance Variables Tests
        function HasInstanceVariablesTest()
        {
            $this->AssertTrue(YourReflection::HasInstanceMember("YourMVC\UnitTest\Framework\MyTestClass", "myString"));
            $this->AssertTrue(YourReflection::HasInstanceMember("YourMVC\UnitTest\Framework\MyTestClass", "myInt"));
            $this->AssertTrue(YourReflection::HasInstanceMember("YourMVC\UnitTest\Framework\MyTestClass", "myFloat"));
        }

        function GetInstanceVariablesTest()
        {
            $instance = YourReflection::CreateNewInstance("YourMVC\UnitTest\Framework\MyTestClass");
            $this->AssertAreEqual(YourReflection::GetInstanceMemberValue($instance, "myString"), "Hello World");
            $this->AssertAreEqual(YourReflection::GetInstanceMemberValue($instance, "myInt"), 1);
            $this->AssertAreEqual(YourReflection::GetInstanceMemberValue($instance, "myFloat"), 3.14);
        }

        function DoesNotHaveInstanceVariablesTest()
        {
            $this->AssertFalse(YourReflection::HasInstanceMember("YourMVC\UnitTest\Framework\MyTestClass", "myBadVariable"));
        }

        function GetDoesNotHaveInstanceVariablesTest()
        {
            $iShouldFail = false;
            try {
                $this->AssertFalse(YourReflection::GetInstanceMemberValue("YourMVC\UnitTest\Framework\MyTestClass", "myBadVariable"));
                $iShouldFail = true;
            } catch (\Exception $ex) {
                // Just consume the exception
            }
            if ($iShouldFail) {
                throw $this->AssertFail();
            }
        }
        
        // Static Variables Tests
        function HasStaticVariableTest()
        {
            $this->AssertTrue(YourReflection::HasStaticMember("YourMVC\UnitTest\Framework\MyTestClass", "myStaticString"));
            $this->AssertTrue(YourReflection::HasStaticMember("YourMVC\UnitTest\Framework\MyTestClass", "myStaticInt"));
            $this->AssertTrue(YourReflection::HasStaticMember("YourMVC\UnitTest\Framework\MyTestClass", "myStaticFloat"));
        }

        function DoesNotHaveStaticVariableTest()
        {
            $this->AssertFalse(YourReflection::HasStaticMember("YourMVC\UnitTest\Framework\MyTestClass", "myBadStatic"));
        }

        function GetStaticVariableTest()
        {
            $this->AssertAreEqual(YourReflection::GetStaticMemberValue("YourMVC\UnitTest\Framework\MyTestClass", "myStaticString"), "Hello World from a Static member");
            $this->AssertAreEqual(YourReflection::GetStaticMemberValue("YourMVC\UnitTest\Framework\MyTestClass", "myStaticInt"), 3);
            $this->AssertAreEqual(YourReflection::GetStaticMemberValue("YourMVC\UnitTest\Framework\MyTestClass", "myStaticFloat"), 2.78);
        }

        function GetDoesNotHaveStaticVariablesTest()
        {
            $iShouldFail = false;
            try {
                $this->AssertFalse(YourReflection::GetStaticMemberValue("YourMVC\UnitTest\Framework\MyTestClass", "myBadVariable"));
                $iShouldFail = true;
            } catch (\Exception $ex) {
                // Just consume the exception
            }
            if ($iShouldFail) {
                throw $this->AssertFail();
            }
        }
    }

    class MyTestClass
    {
        // Variables
        var $myString = "Hello World";

        var $myInt = 1;

        var $myFloat = 3.14;
        
        // Static Variables
        static $myStaticString = "Hello World from a Static member";

        static $myStaticInt = 3;

        static $myStaticFloat = 2.78;
        
        // Public method
        public function CalculateSum($a, $b)
        {
            if (is_numeric($a) && is_numeric($b))
                return $a + $b;
        }
        
        // A function with no parameters
        public function CalculateTrue()
        {
            return true;
        }
        
        // A void function
        public function MyVoidFunction()
        {
            return;
        }
        
        // Static function
        public static function CalculateProduct($a, $b)
        {
            if (is_numeric($a) && is_numeric($b))
                return $a * $b;
        }
        
        // A static function with no parameters
        public static function CalculateFalse()
        {
            return false;
        }
    }
}