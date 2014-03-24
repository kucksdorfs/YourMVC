<?php
// Make sure Console logging is available everywhere
namespace YourMVC{

    include_once 'Libraries/Config/LoggingConfig.php';
    include_once 'Libraries/Reflection.php';
    use YourMVC\Configuration\LoggingConfiguration;

    interface iLogging{

        function WriteInformation($message);

        function WriteWarning($message);

        function WriteError($message);
    }

    class Console{

        protected static $myLogging = null;

        public static function LoadLogging($configuration){
            if(is_null($configuration)){
                self::$myLogging = new Logging(null);
            }
            elseif(is_null($configuration['ClassName'])){
                self::$myLogging = new Logging(null);
            }
            else{
                self::$myLogging = YourReflection::CreateNewInstance($configuration['ClassName'], $configuration);
            }
        }

        public static function WriteInformation($message){
            self::$myLogging->WriteInformation($message);
        }

        public static function WriteWarning($message){
            self::$myLogging->WriteWarning($message);
        }

        public static function WriteError($message){
            self::$myLogging->WriteError($message);
        }
    }

    /**
     * Base class for logging
     *
     * @author stephen
     *
     */
    class Logging implements iLogging{

        protected function GetDateTime($format = "Y-m-d H:i:s"){
            return date($format);
        }

        protected $subLogging = null;

        public function __($params){
            if(is_null($params)){
                $this->subLogging = null;
                return;
            }
            if (!isset($params['SubLogging'])){
                $this->subLogging = null;
                return;
            }
            $_params = $params['SubLogging'];
            if(is_null($_params)){
                $this->subLogging = null;
            }
            elseif(is_null($_params['ClassName'])){
                $this->subLogging = null;
            }
            else{
                $this->subLogging = YourReflection::CreateNewInstance($_params['ClassName'], $_params);
            }
        }

        public function WriteInformation($message){
            if(!is_null($this->subLogging))
                $this->subLogging->WriteInformation($message);
        }

        public function WriteWarning($message){
            if(!is_null($this->subLogging))
                $this->subLogging->WriteWarning($message);
        }

        public function WriteError($message){
            if(!is_null($this->subLogging))
                $this->subLogging->WriteError($message);
        }
    }

    class ConsoleLogging extends Logging{

        public function __construct($params){
            parent::__($params);
        }

        function WriteInformation($message){
            echo $this->GetDateTime() . " - INFORMATION - " . $message . "\n";
            parent::WriteInformation($message);
        }

        function WriteWarning($message){
            echo $this->GetDateTime() . " -   WARNING   - " . $message . "\n";
            parent::WriteWarning($message);
        }

        function WriteError($message){
            echo $this->GetDateTime() . " -    ERROR    - " . $message . "\n";
            parent::WriteError($message);
        }
    }

    class FileSystemLogging extends Logging{

        protected $location = null;

        protected $useIncludePath;

        public function __construct($params){
            parent::__($params);
            $this->location = $params["Location"];
            $this->useIncludePath = isset($params["UseIncludePath"]) ? $params["UseIncludePath"] : true;
        }

        function WriteInformation($message){
            $file = fopen($this->location . "Information.dat", "a+", $this->useIncludePath);
            if($file == false){
                $this->subLogging->WriteInformation($message);
                return;
            }
            fwrite($file, $this->GetDateTime() . " " . $message . "\n");
            fclose($file);
            parent::WriteInformation($message);
        }

        function WriteWarning($message){
            $file = fopen($this->location . "Warning.dat", "a+", $this->useIncludePath);
            if($file == false){
                $this->subLogging->WriteInformation($message);
                return;
            }
            fwrite($file, $this->GetDateTime() . " " . $message . "\n");
            fclose($file);
            parent::WriteWarning($message);
        }

        function WriteError($message){
            $file = fopen($this->location . "Error.dat", "a+", $this->useIncludePath);
            if($file == false){
                $this->subLogging->WriteInformation($message);
                return;
            }
            fwrite($file, $this->GetDateTime() . " " . $message . "\n");
            fclose($file);
            parent::WriteError($message);
        }
    }
    
    class DatabaseLogging extends Logging {
    	protected $databaseObject = null;
    	protected $insertStatement = "Insert into %s (LogType, LogText) values ('%s', '%s')";
    	protected $tableName = "";
    	
    	protected function WriteMessage($message, $type) {
    		if ($this->databaseObject == null) {
    			$retValue = null;
    			if ($this->subLogging != null)
    				YourReflection::InvokeInstanceMethod($this->subLogging, "Write" . $type, "Cannot write to a database.", $retValue);
    			return;
    		}
    		
    		try {
    			$this->databaseObject->ExecuteNonQuery(sprintf($this->insertStatement, $this->tableName, $type, $message));
    		}
    		Catch(Exception $ex) {
    			$retValue = null;
    			if ($this->subLogging != null)
    				YourReflection::InvokeInstanceMethod($this->subLogging, "Write" . $type, "Unable to log message to the database\r\n\t$message", $retValue);
    			return;
    		}
    	}
    	
    	
    	public function __construct($args) {
    		parent::__($args);
  			$this->databaseObject = YourReflection::CreateNewInstance($args["Database"]["ClassName"], $args["Database"]);
  			$this->tableName = $args["Table"];    		
    	}
    	
    	public function WriteInformation($message) {
    		parent::WriteInformation($message);
    		$this->WriteMessage($message, "Information");
    	}

    	public function WriteWarning($message) {
    		parent::WriteWarning($message);
    		$this->WriteMessage($message, "Warning");
    	}
    	
    	public function WriteError($message) {
    		parent::WriteError($message);
    		$this->WriteMessage($message, "Error");
    	}
    }
}