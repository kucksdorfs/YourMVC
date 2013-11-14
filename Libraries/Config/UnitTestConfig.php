<?php

namespace YourMVC\Configuration {

	class UnitTestConfiguration {

		// have to use a function in order to call a function to set the property
		static function UnitTestDir() {
			$directory = getcwd() . DIRECTORY_SEPARATOR . "UnitTests";
			return $directory;
		}

		static function TestsEndWith() {
			return "Test";
		}

		static function GetUnitTestArgs() {
			return array("unitTestPath" => self::UnitTestDir(), "TestsEndWith" => self::TestsEndWith());
		}


	}
}