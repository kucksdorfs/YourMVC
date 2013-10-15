<?php
namespace MyMVC\UnitTest\Framework {
    use MyMVC\MyReflection;
    use MyMVC;
    require_once "UnitTest.php";
    require_once "Libraries/Reflection.php";

    class ReflectionTest extends \MyMVC\UnitTest\Framework\UnitTest {

        //Creating Objects Tests
        function CreateObjectTest(){
            $myClass = MyReflection::CreateNewInstance("MyMVC\UnitTest\Framework\MyTestClass");
            $this->AssertIsNotNull($myClass);
        }

        function CreateBadObjectTest(){
            $myClass = MyReflection::CreateNewInstance("ReallyBadClass");
            $this->AssertIsNull($myClass);
        }

        //Instance Methods Tests
        function ObjectHasMethodTest(){
            $myClass = MyReflection::CreateNewInstance("MyMVC\UnitTest\Framework\MyTestClass");
            $this->AssertTrue(MyReflection::HasInstanceMethod($myClass,"CalculateSum"));
        }

        function CallInstanceMethodTest(){
            $myClass = MyReflection::CreateNewInstance("MyMVC\UnitTest\Framework\MyTestClass");
            $myRetValue = null;
            $completed = MyReflection::InvokeInstanceMethod($myClass,"CalculateSum",array(2,2),$myRetValue);
            $this->AssertTrue($completed);
            $this->AssertAreEqual(4,$myRetValue);
        }

        function CallInstanceMethodWithNoParameters(){
            $myClass = MyReflection::CreateNewInstance("MyMVC\UnitTest\Framework\MyTestClass");
            $myRetValue = null;
            $completed = MyReflection::InvokeInstanceMethod($myClass,"CalculateTrue",null,$myRetValue);
            $this->AssertTrue($completed);
            $this->AssertIsNull($myRetValue);
        }

        function CallInstanceMethodWithBadParametersTest(){
            $myClass = MyReflection::CreateNewInstance("MyMVC\UnitTest\Framework\MyTestClass");
            $myRetValue = null;
            $completed = MyReflection::InvokeInstanceMethod($myClass,"CalculateSum",null,$myRetValue);
            $this->AssertTrue($completed);
        }

        function CallVoidMethodTest(){
            $myClass = MyReflection::CreateNewInstance("MyMVC\UnitTest\Framework\MyTestClass");
            $myRetValue = null;
            $completed = MyReflection::InvokeInstanceMethod($myClass,"MyVoidFunction",array(2,2),$myRetValue);
            $this->AssertTrue($completed);
        }

        function CallBadMethodTest(){
            $myClass = MyReflection::CreateNewInstance("MyMVC\UnitTest\Framework\MyTestClass");
            $myRetValue = null;
            $completed = MyReflection::InvokeInstanceMethod($myClass,"CalculateSume",array(2,2),$myRetValue);
            $this->AssertFalse($completed);
        }

        //Static Methods Tests
        function CallStaticMethodTest(){
            $myRetValue = null;
            $completed = MyReflection::InvokeStaticMethod("MyMVC\UnitTest\Framework\MyTestClass","CalculateProduct",array(3,3),$retValue);
            $this->AssertTrue($completed);
            $this->AssertAreEqual($retValue,9);
        }

        function CallStaticMethodWithNoParametersTest(){
            $myRetValue = null;
            $completed = MyReflection::InvokeStaticMethod("MyMVC\UnitTest\Framework\MyTestClass","CalculateFalse",null,$myRetValue);
            $this->AssertTrue($completed);
            $this->AssertFalse($myRetValue);
        }

        //Instance Variables Tests
        function HasInstanceVariablesTest(){
            $$this->AssertTrue(MyReflection::HasInstanceMember("MyMVC\UnitTest\Framework\MyTestClass","myString"));
            $this->AssertTrue(MyReflection::HasInstanceMember("MyMVC\UnitTest\Framework\MyTestClass","myInt"));
            $this->AssertTrue(MyReflection::HasInstanceMember("MyMVC\UnitTest\Framework\MyTestClass","myFloat"));
        }

        function GetInstanceVariablesTest(){
            $instance = MyReflection::CreateNewInstance("MyMVC\UnitTest\Framework\MyTestClass");
            $this->AssertAreEqual(MyReflection::GetInstanceMemberValue($instance,"myString"),"Hello World");
            $this->AssertAreEqual(MyReflection::GetInstanceMemberValue($instance,"myInt"),1);
            $this->AssertAreEqual(MyReflection::GetInstanceMemberValue($instance,"myFloat"),3.14);
        }

        function DoesNotHaveInstanceVariablesTest(){
            $this->AssertFalse(MyReflection::HasInstanceMember("MyMVC\UnitTest\Framework\MyTestClass","myBadVariable"));
        }

        function GetDoesNotHaveInstanceVariablesTest(){
            $iShouldFail = false;
            try{
                $this->AssertFalse(MyReflection::GetInstanceMemberValue("MyMVC\UnitTest\Framework\MyTestClass","myBadVariable"));
                $iShouldFail = true;
            }
            catch(\Exception $ex){
                // Just consume the exception
            }
            if($iShouldFail){
                throw $this->AssertFail();
            }
        }

        //Static Variables Tests
        function HasStaticVariableTest(){
            $this->AssertTrue(MyReflection::HasStaticMember("MyMVC\UnitTest\Framework\MyTestClass","myStaticString"));
            $this->AssertTrue(MyReflection::HasStaticMember("MyMVC\UnitTest\Framework\MyTestClass","myStaticInt"));
            $this->AssertTrue(MyReflection::HasStaticMember("MyMVC\UnitTest\Framework\MyTestClass","myStaticFloat"));
        }

        function DoesNotHaveStaticVariableTest(){
            $this->AssertFalse(MyReflection::HasStaticMember("MyMVC\UnitTest\Framework\MyTestClass","myBadStatic"));
        }

        function GetStaticVariableTest() {
            $this->AssertAreEqual(MyReflection::GetStaticMemberValue("MyMVC\UnitTest\Framework\MyTestClass","myStaticString"),"Hello World from a Static member");
            $this->AssertAreEqual(MyReflection::GetStaticMemberValue("MyMVC\UnitTest\Framework\MyTestClass","myStaticInt"),3);
            $this->AssertAreEqual(MyReflection::GetStaticMemberValue("MyMVC\UnitTest\Framework\MyTestClass","myStaticFloat"),2.78);
        }

        function GetDoesNotHaveStaticVariablesTest(){
            $iShouldFail = false;
            try{
                $this->AssertFalse(MyReflection::GetStaticMemberValue("MyMVC\UnitTest\Framework\MyTestClass","myBadVariable"));
                $iShouldFail = true;
            }
            catch(\Exception $ex){
                // Just consume the exception
            }
            if($iShouldFail){
                throw $this->AssertFail();
            }
        }
    }

    class MyTestClass {
        
        // Variables
        var $myString = "Hello World";
        var $myInt = 1;
        var $myFloat = 3.14;
        
        //Static Variables
        static $myStaticString = "Hello World from a Static member";
        static $myStaticInt = 3;
        static $myStaticFloat = 2.78;

        //Public method
        public function CalculateSum($a,$b){
            if(is_numeric($a) && is_numeric($b))
                return $a + $b;
        }

        //A function with no parameters
        public function CalculateTrue(){
            return true;
        }

        //A void function
        public function MyVoidFunction(){
            return;
        }

        //Static function
        public static function CalculateProduct($a,$b){
            if(is_numeric($a) && is_numeric($b))
                return $a * $b;
        }

        //A static function with no parameters
        public static function CalculateFalse(){
            return false;
        }
    }
}