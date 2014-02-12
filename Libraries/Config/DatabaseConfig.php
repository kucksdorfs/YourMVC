<?php
namespace YourMVC\Configuration {

    use YourMVC\YourMySQL;
	class DatabaseConfiguration {
        public static function DatabaseDefault() {
            $config = array(
                'ClassName' => 'YourMVC\\Database\\MySQL',
                'HostName' => 'localhost',
                'Database' => 'mydb',
                'User' => 'mydb',
                'Password' => 'password');
            return $config;
        }
    }
}