<?php

namespace YourMVC\Configuration {

	class LoggingConfiguration {
		public static function CLIDefault() {
			/*$cliDefault = array (
					"ClassName" => "YourMVC\\ConsoleLogging",
					"SubLogging" => array (
							"ClassName" => "YourMVC\\FileSystemLogging",
							"Location" => "Tmp" . DIRECTORY_SEPARATOR . "CLI",
							"SubLogging" => null
					)
			);*/
			$cliDefault = array(
				'ClassName' => 'YourMVC\\DatabaseLogging',
				'Database' => array(
						'ClassName' => 'YourMVC\\Database\\MySQL\\MySQL',
		                'HostName' => 'localhost',
		                'Database' => 'mydb',
		                'User' => 'mydbLogging',
		                'Password' => 'password'						
				),
				'Table' => 'Logging',
				"SubLogging" => array (
							"ClassName" => "YourMVC\\FileSystemLogging",
							"Location" => "Tmp" . DIRECTORY_SEPARATOR . "CLI",
							"SubLogging" => null
					)
			);
			return $cliDefault;
		}
		public static function WebDefault() {
			$webDefault = array (
					"ClassName" => "FileSystem",
					"Location" => "Tmp" . DIRECTORY_SEPARATOR . "Web"
			);
			return $webDefault;
		}
	}
}