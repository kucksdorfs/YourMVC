<?php
namespace YourMVC\Libraries\Logging
{

    class FileSystemLogging extends Logging
    {

        protected $location = null;

        protected $useIncludePath;

        public function __construct($params)
        {
            parent::__($params);
            $this->location = $params["Location"];
            $this->useIncludePath = isset($params["UseIncludePath"]) ? $params["UseIncludePath"] : true;
        }

        function WriteInformation($message)
        {
            $file = fopen($this->location . "Information.dat", "a+", $this->useIncludePath);
            if ($file == false) {
                $this->subLogging->WriteInformation($message);
                return;
            }
            fwrite($file, $this->GetDateTime() . " " . $message . "\n");
            fclose($file);
            parent::WriteInformation($message);
        }

        function WriteWarning($message)
        {
            $file = fopen($this->location . "Warning.dat", "a+", $this->useIncludePath);
            if ($file == false) {
                $this->subLogging->WriteInformation($message);
                return;
            }
            fwrite($file, $this->GetDateTime() . " " . $message . "\n");
            fclose($file);
            parent::WriteWarning($message);
        }

        function WriteError($message)
        {
            $file = fopen($this->location . "Error.dat", "a+", $this->useIncludePath);
            if ($file == false) {
                $this->subLogging->WriteInformation($message);
                return;
            }
            fwrite($file, $this->GetDateTime() . " " . $message . "\n");
            fclose($file);
            parent::WriteError($message);
        }
    }
}