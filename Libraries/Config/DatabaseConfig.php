<?php
namespace YourMVC\Libraries\Config
{

    class DatabaseConfig
    {

        public static function DatabaseDefault()
        {
            $config = array(
                'ClassName' => 'YourMVC\\Libraries\\Database\\MySQL\\MySQL',
                'HostName' => 'localhost',
                'Database' => 'mydb',
                'User' => 'mydb',
                'Password' => 'password'
            );
            return $config;
        }
    }
}