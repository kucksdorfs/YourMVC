<?php
namespace YourMVC\Libraries\Logging
{

    class DatabaseLogging extends Logging
    {

        protected $databaseObject = null;

        protected $insertStatement = "Insert into %s (LogType, LogText) values ('%s', '%s')";

        protected $tableName = "";

        protected function WriteMessage($message, $type)
        {
            if ($this->databaseObject == null) {
                $retValue = null;
                if ($this->subLogging != null)
                    YourMVC\Libraries\YourReflection::InvokeInstanceMethod($this->subLogging, "Write" . $type, "Cannot write to a database.", $retValue);
                return;
            }
            
            try {
                $this->databaseObject->ExecuteNonQuery(sprintf($this->insertStatement, $this->tableName, $type, $message));
            } Catch (Exception $ex) {
                $retValue = null;
                if ($this->subLogging != null)
                    YourMVC\Libraries\YourReflection::InvokeInstanceMethod($this->subLogging, "Write" . $type, "Unable to log message to the database\r\n\t$message", $retValue);
                return;
            }
        }

        public function __construct($args)
        {
            parent::__($args);
            $this->databaseObject = \YourMVC\Libraries\YourReflection::CreateNewInstance($args["Database"]["ClassName"], $args["Database"]);
            $this->tableName = $args["Table"];
        }

        public function WriteInformation($message)
        {
            $this->WriteMessage($message, "Information");
            parent::WriteInformation($message);
        }

        public function WriteWarning($message)
        {
            $this->WriteMessage($message, "Warning");
            parent::WriteWarning($message);
        }

        public function WriteError($message)
        {
            $this->WriteMessage($message, "Error");
            parent::WriteError($message);
        }
    }
}