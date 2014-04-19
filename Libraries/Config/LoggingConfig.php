<?php
namespace YourMVC\Libraries\Config
{

    class LoggingConfig
    {

        public static function CLIDefault()
        {
            $cliDefault = array(
                "ClassName" => "YourMVC\Libraries\Logging\ConsoleLogging",
                "SubLogging" => array(
                    "ClassName" => "YourMVC\Libraries\Logging\FileSystemLogging",
                    "Location" => "Log" . DIRECTORY_SEPARATOR . "Web",
                    "SubLogging" => array(
                        'ClassName' => 'YourMVC\Libraries\Logging\DatabaseLogging',
                        'Table' => 'Logging',
                        'Database' => array(
                            'ClassName' => 'YourMVC\Libraries\Database\MySQL\MySQL',
                            'HostName' => 'localhost',
                            'Database' => 'Logging',
                            'User' => 'Logging',
                            'Password' => 'logging'
                        )
                    )
                )
            );
            return $cliDefault;
        }

        public static function WebDefault()
        {
            $webDefault = array(
                "ClassName" => "YourMVC\Libraries\Logging\FileSystemLogging",
                "Location" => "Log" . DIRECTORY_SEPARATOR . "Web",
                "SubLogging" => array(
                    'ClassName' => 'YourMVC\Libraries\Logging\DatabaseLogging',
                    'Table' => 'Logging',
                    'Database' => array(
                        'ClassName' => 'YourMVC\Libraries\Database\MySQL\MySQL',
                        'HostName' => 'localhost',
                        'Database' => 'Logging',
                        'User' => 'Logging',
                        'Password' => 'logging'
                    )
                )
            );
            return $webDefault;
        }
    }
}