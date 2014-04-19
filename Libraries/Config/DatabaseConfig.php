<?php
namespace YourMVC\Configuration
{

    class DatabaseConfiguration
    {

        public static function DatabaseDefault()
        {
            $config = array(
                'ClassName' => 'YourMVC\\Database\\MySQL\\MySQL',
                'HostName' => 'localhost',
                'Database' => 'mydb',
                'User' => 'mydb',
                'Password' => 'password'
            );
            return $config;
        }
    }
}