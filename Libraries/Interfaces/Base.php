<?php
namespace YourMVC\Libraries\Interfaces
{

    interface iBase
    {
    }

    class Base implements iBase
    {

        protected static $CONSOLE = null;

        protected static $DEBUG = false;

        private static function init()
        {
            self::$CONSOLE = new \YourMVC\Libraries\Logging\Console();
        }
    }
    $method = new \ReflectionMethod("YourMVC\Libraries\Interfaces\Base", "init");
    $method->setAccessible(true);
    $method->invoke(null);
    unset($method);
}