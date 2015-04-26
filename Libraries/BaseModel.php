<?php
namespace YourMVC\Libraries
{

    use YourMVC\Libraries\YourReflection as YourReflection;

    class BaseModel extends \YourMVC\Libraries\Interfaces\Base
    {

        protected static $DataBase = null;

        private static function init()
        {
            $Config = Config\DatabaseConfig::DatabaseDefault();
            $retValue = null;
            YourReflection::InvokeStaticMethod($Config['ClassName'], 'NewDatabase', $Config, $retValue);
            self::$DataBase = $retValue;
        }
    }
    
    $method = new \ReflectionMethod("YourMVC\Libraries\BaseModel", "init");
    $method->setAccessible(true);
    $method->invoke(null);
    unset($method);
}