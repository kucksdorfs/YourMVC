<?php
namespace YourMVC\Libraries\Logging
{

    class ConsoleLogging extends Logging
    {

        public function __construct($params)
        {
            parent::__($params);
        }

        function WriteInformation($message)
        {
            echo $this->GetDateTime() . " - INFORMATION - " . $message . "\n";
            parent::WriteInformation($message);
        }

        function WriteWarning($message)
        {
            echo $this->GetDateTime() . " - WARNING - " . $message . "\n";
            parent::WriteWarning($message);
        }

        function WriteError($message)
        {
            echo $this->GetDateTime() . " - ERROR - " . $message . "\n";
            parent::WriteError($message);
        }
    }
}