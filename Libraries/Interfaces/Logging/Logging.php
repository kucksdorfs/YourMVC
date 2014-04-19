<?php
namespace YourMVC\Libraries\Interfaces\Logging
{

    /**
     * Base class for logging
     *
     * @author stephen
     *        
     */
    class Logging implements iLogging
    {

        protected function GetDateTime($format = "Y-m-d H:i:s")
        {
            return date($format);
        }

        protected $subLogging = null;

        public function __($params)
        {
            if (is_null($params)) {
                $this->subLogging = null;
                return;
            }
            if (! isset($params['SubLogging'])) {
                $this->subLogging = null;
                return;
            }
            $_params = $params['SubLogging'];
            if (is_null($_params)) {
                $this->subLogging = null;
            } elseif (is_null($_params['ClassName'])) {
                $this->subLogging = null;
            } else {
                $this->subLogging = YourReflection::CreateNewInstance($_params['ClassName'], $_params);
            }
        }

        public function WriteInformation($message)
        {
            if (! is_null($this->subLogging))
                $this->subLogging->WriteInformation($message);
        }

        public function WriteWarning($message)
        {
            if (! is_null($this->subLogging))
                $this->subLogging->WriteWarning($message);
        }

        public function WriteError($message)
        {
            if (! is_null($this->subLogging))
                $this->subLogging->WriteError($message);
        }
    }

    interface iLogging
    {

        function WriteInformation($message);

        function WriteWarning($message);

        function WriteError($message);
    }
}