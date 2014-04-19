<?php
namespace YourMVC\Libraries\Logging
{

    class Console
    {

        protected static $myLogging = null;

        public static function LoadLogging($configuration)
        {
            if (is_null($configuration)) {
                self::$myLogging = new Logging(null);
            } elseif (is_null($configuration['ClassName'])) {
                self::$myLogging = new Logging(null);
            } else {
                self::$myLogging = \YourMVC\Libraries\YourReflection::CreateNewInstance($configuration['ClassName'], $configuration);
            }
        }

        public static function WriteInformation($message)
        {
            self::$myLogging->WriteInformation($message);
        }

        public static function WriteWarning($message)
        {
            self::$myLogging->WriteWarning($message);
        }

        public static function WriteError($message)
        {
            self::$myLogging->WriteError($message);
        }
    }
}