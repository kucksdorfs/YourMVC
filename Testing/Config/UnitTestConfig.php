<?php
namespace YourMVC\Testing\Config
{

    class UnitTestConfig
    {
        
        static function GetUnitTestArgs()
        {
            return array(
                "unitTestPath" => "Testing" . DIRECTORY_SEPARATOR . "UnitTests",
                "TestsEndWith" => "Test"
            );
        }
    }
}