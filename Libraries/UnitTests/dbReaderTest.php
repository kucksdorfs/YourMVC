<?php

namespace YourMVC\UnitTest\Framework{

    require_once 'Database.php';
    use YourMVC\Database\DatabaseReader;

    class DatabaseReaderTest extends UnitTest{
        protected $aryOne = array (
                0 => array (
                        "varchar50col" => "really long string",
                        "id" => '0',
                        "date_entered" => '2014-02-09',
                        "time_entered" => '08:19:15',
                        "random_datetime" => '2014-02-09 08:55:07',
                        "random_float" => '3.14',
                        "boolField" => "0" 
                ),
                1 => array (
                        "varchar50col" => "second element",
                        "id" => '1',
                        "date_entered" => '2014-02-10',
                        "time_entered" => '08:56:00',
                        "random_datetime" => '2014-02-09 08:59:19',
                        "random_float" => '21389',
                        "boolField" => "1" 
                ),
                2 => array (
                        "varchar50col" => null,
                        "id" => '2',
                        "date_entered" => null,
                        "time_entered" => null,
                        "random_datetime" => '2014-02-10 08:55:07',
                        "random_float" => '0.00',
                        "boolField" => "1" 
                ),
                3 => array (
                        "varchar50col" => "really short string",
                        "id" => '3',
                        "date_entered" => '2014-02-09',
                        "time_entered" => '08:19:15',
                        "random_datetime" => null,
                        "random_float" => null,
                        "boolField" => null 
                ),
                4 => array (
                        "varchar50col" => "last element",
                        "id" => null,
                        "date_entered" => '2014-02-09',
                        "time_entered" => '08:19:15',
                        "random_datetime" => '2014-02-09 08:55:07',
                        "random_float" => '3.14',
                        "boolField" => "0" 
                ) 
        );
        private $reader = null;
        protected function MethodSetup(){
            $this->reader = new DatabaseReader($this->aryOne);
        }
        protected function MethodTearDown(){
            $this->reader = null;
        }
        private function VerifyArray($aryToValidate, $requiredElements){
            $hasValidElement = array ();
            for($i = 0; $i < count($requiredElements); ++$i) {
                $hasValidElement [] = false;
            }
            
            $i = 0;
            foreach ( $requiredElements as $key ) {
                if (in_array($key, array_keys($aryToValidate))) {
                    $hasValidElement [$i] = true;
                }
                ++$i;
            }
            
            for($i = 0; $i < count($hasValidElement); ++$i) {
                if (!$hasValidElement [$i]) {
                    return false;
                }
            }
            return true;
        }
        function VerifyStringFieldTest(){
            while ( $this->reader->Read() ) {
                $field = $this->reader->GetStringValue("varchar50col");
                if (!is_string($field) && !is_null($field))
                    $this->AssertFail("The VerifyStringFieldTest has failed. The value '$field' is not a string.");
            }
        }
        function VerifyIntFieldTest(){
            while ( $this->reader->Read() ) {
                $field = $this->reader->GetIntValue("id");
                if (!is_int($field))
                    $this->AssertFail("The VerifyIntFieldTest has failed. The value '$field' is not an int.");
            }
        }
        function VerifyDateFieldTest(){
            $validElements = array (
                    "day",
                    "month",
                    "year" 
            );
            while ( $this->reader->Read() ) {
                $field = $this->reader->GetDateValue("date_entered");
                if (is_null($field))
                    continue;
                if (count($field) < 3)
                    $this->AssertFail("The VerifyDateFieldTest has failed. The value '" . var_dump($field) . "' is not a date.");
                if (!$this->VerifyArray($field, $validElements))
                    $this->AssertFail("One of the elements is missing from the Date Field. " . var_dump($field));
            }
        }
        function VerifyTimeFieldTest(){
            $validElements = array (
                    "hour",
                    "minute" 
            ); // second is considered optional
            while ( $this->reader->Read() ) {
                $field = $this->reader->GetTimeValue("time_entered");
                if (is_null($field))
                    continue;
                if (count($field) < 2)
                    $this->AssertFail("The VerifyTimeFieldTest has failed. The value '" . var_dump($field) . "' is not a time.");
                if (!$this->VerifyArray($field, $validElements))
                    $this->AssertFail("One of the elements is missing from the Time Field. " . var_dump($field));
            }
        }
        function VerifyDateTimeFieldTest(){
            $validElements = array (
                    "day",
                    "month",
                    "year",
                    "hour",
                    "minute" 
            );
            while ( $this->reader->Read() ) {
                $field = $this->reader->GetDateTimeValue("random_datetime");
                if (is_null($field))
                    continue;
                if (count($field) < 5)
                    $this->AssertFail("The VerifyTimeFieldTest has failed. The value '$field' is not a date time.");
                if (!$this->VerifyArray($field, $validElements))
                    $this->AssertFail("One of the elements is missing from the Date Time Field. " . var_dump($field));
            }
        }
        function VerifyFloatFieldTest(){
            while ( $this->reader->Read() ) {
                $field = $this->reader->GetFloatValue("random_float");
                if (!is_float($field))
                    $this->AssertFail("The VerifyFloatFieldTest has failed. The value '$field' is not a float.");
            }
        }
        function VerifyBooleanFieldTest(){
            while ( $this->reader->Read() ) {
                $field = $this->reader->GetBooleanValue("boolField");
                if (!is_bool($field))
                    $this->AssertFail("The VerifyBooleanFieldTest has failed. The value '$field' is not a boolean.");
            }
        }
    }
}