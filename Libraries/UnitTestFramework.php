<?php
namespace YourMVC\UnitTest\Framework;
{

    class UnitTest {

        // Class Level methods - Gets executed before the first test and after the last test
        protected function ClassSetup(){
        }

        protected function ClassTearDown(){
        }
        // Method level methods - Gets executed before and after each test method
        protected function MethodSetup(){
        }

        protected function MethodTearDown(){
        }

        protected final function AssertTrue($value,$failMessage = "The value is not true."){
            if($value == true)
                return;
            throw new \Exception($failMessage);
        }

        protected final function AssertFalse($value,$failMessage = "The value is not false."){
            if($value == false)
                return;
            throw new \Exception($failMessage);
        }

        protected final function AssertAreEqual($value1,$value2,$failMessage = "The two values are not equal."){
            if($value1 == $value2)
                return;
            throw new \Exception($failMessage);
        }

        protected final function AssertAreIdentical($value1,$value2,$failMessage = "The two values are not identical"){
            if($value1 === $value2)
                return;
            throw new \Exception($failMessage);
        }

        protected final function AssertAreNotEqual($value1,$value2,$failMessage = "The two values are equal."){
            if($value1 != $value2)
                return;
            throw new \Exception($failMessage);
        }

        protected final function AssertAreNotIdentical($value1,$value2,$failMessage = "The two values are not identical"){
            if($value1 !== $value2)
                return;
            throw new \Exception($failMessage);
        }

        protected final function AssertAreEqualNotIdentical($value1,$value2,$failMessage = "The two values either are not equals or are identical."){
            if($value1 == $value2 && $value1 !== $value2)
                return;
            throw new \Exception($failMessage);
        }

        protected final function AssertIsNull($value,$failMessage = "The object is not null."){
            if(is_null($value))
                return;
            throw new \Exception($failMessage);
        }

        protected final function AssertIsNotNull($value,$failMessage = "The object is null."){
            if(!is_null($value))
                return;
            throw new \Exception($failMessage);
        }

        protected final function AssertFail($failMessage = "The unit test has failed."){
            throw new \Exception($failMessage);
        }

        private static function GetUnitTestFromFolder($myDir){
            if(!is_dir($myDir))
                return null;
            $phpImports = array();
            $dir = new \DirectoryIterator($myDir);
            foreach($dir as $fileinfo){
                if($fileinfo->isDir() && !$fileinfo->isDot()){
                    $phpImports = array_merge($phpImports,self::GetUnitTestFromFolder($fileinfo->getPathname()));
                }
                elseif($fileinfo->isFile() && !$fileinfo->isDot()){
                    array_push($phpImports,$fileinfo->getPathname());
                }
            }
            return $phpImports;
        }

        public final static function Main($args){
            $unitTestPath = "";
            $testsEndsWith = "Test";
            $stop = false;
            if(is_null($args)){
                echo "Could not load the Unit Test parameters.";
                return;
            }
            if(!isset($args["unitTestPath"])){
                echo "Please make sure that a unit test directory is set in the Unit Test arguments.\n";
                $stop = true;
            }
            if(!isset($args["TestsEndWith"])){
                echo "The tests ends with parameter was not set, the default is \"Test\"";
            }
            else{
                $testsEndsWith = $args["TestsEndWith"];
            }
            if($stop){
                return;
            }
            $unitTestPath = $args["unitTestPath"];
            if(!is_dir($unitTestPath)){
                echo "Please verify the following directory exists: $unitTestPath.";
                return;
            }
            $listOfFiles = self::GetUnitTestFromFolder($unitTestPath);
            if(is_null($listOfFiles)){
                echo "There are no unit tests in $unitTestPath.";
                return;
            }
            $classesBeforeInclude = get_declared_classes();
            for($i = 0;$i < count($listOfFiles);$i++)
                include $listOfFiles[$i];
            $classesAfterInclude = get_declared_classes();
            $testClasses = array();
            // is_subclass_of
            for($i = 0;$i < count($classesAfterInclude);$i++){
                if(!in_array($classesAfterInclude[$i],$classesBeforeInclude) && is_subclass_of($classesAfterInclude[$i],"\YourMVC\UnitTest\Framework\UnitTest")){
                    array_push($testClasses,$classesAfterInclude[$i]);
                }
            }
            for($i = 0;$i < count($testClasses);$i++){
                // Get Class Data
                $class = new \ReflectionClass($testClasses[$i]);
                $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
                try{
                    // Create instance of the test class and call its setup
                    $testInstance = $class->newInstance();
                    $testInstance->ClassSetup();
                }
                catch(Exception $ex){
                    // skip the tests if the class setup fails
                    continue;
                }
                for($j = 0;$j < count($methods);$j++){
                    // The filter doesn't let us exclude and include (public but not static),
                    // so make sure to test the method isn't static and that it ends with
                    // some expected value (testsEndsWith).
                    if(substr_compare($methods[$j]->name,$testsEndsWith,strlen($methods[$j]->name) - strlen($testsEndsWith)) == 0 && !$methods[$j]->isStatic()){
                        $unitTestFailed = true;
                        echo "Testing " . $testClasses[$i] . "->" . $methods[$j]->name . "()\n";
                        try {
                            $testInstance->MethodSetup();
                            $methods[$j]->invoke($testInstance);
                            $unitTestFailed = false;
                            echo "Method " . $methods[$j]->name . " has completed successfully.\n";
                        }
                        catch(\Exception $ex){
                            echo "The unit test failed. ";
                            echo $ex->getMessage() . "\n";
                        }
                        try{
                            $testInstance->MethodTearDown();
                        }
                        catch(Exception $e){
                            if ($unitTestFailed) {
                                echo "The unit did not fail, but the method tear down failed for method " . $methods[$j]->name . " in the class " . $testClasses[$i] . ".\n" . $e->getMessage() . "\n";
                            }
                        }
                    }
                }
                try{
                    // Call the class instances tear down method
                    $testInstance->ClassTearDown();
                }
                catch(Exception $ex){
                    echo "The unit tests did not fail, but the class tear down failed.";
                }
                // Delete the instance
                unset($testInstance);
            }
        }
    }
}
$unitTestPath = getcwd() . DIRECTORY_SEPARATOR . "UnitTests";
$args = array("unitTestPath"=>$unitTestPath,"TestsEndWith"=>"Test");
\YourMVC\UnitTest\Framework\UnitTest::Main($args);
