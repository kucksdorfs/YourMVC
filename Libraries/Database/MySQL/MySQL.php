<?php
namespace YourMVC\Libraries\Database\MySQL
{

    require_once 'Libraries/Database/DatabaseReader.php';
    require_once 'Libraries/Interfaces/Database/Database.php';
    require_once 'Libraries/Database/MySQL/MySQLColumnMeta.php';
    require_once 'Libraries/Database/MySQL/MySQLTableMeta.php';
    
    use YourMVC\Libraries\Interfaces\Database\iDatabase;

    /**
     *
     * @author stephen
     */
    class MySQL implements iDatabase
    {

        private $host, $user, $password, $database;
        // Required
        private $port, $socket;
        // Optional
        public static function CreateNewDatabase($host, $user, $password, $database, $port = 3306, $socket = null)
        {
            $params = array();
            $params['HostName'] = $host;
            $params['User'] = $user;
            $params['Password'] = $password;
            $params['Database'] = $database;
            $params['Port'] = $port;
            $params['Socket'] = $socket;
            
            $database = new MySQL($params);
            return $database;
        }

        static function NewDatabase($parameters)
        {
            return new MySQL($parameters);
        }

        public static function CreateNewDatabaseWithAssocArray($params)
        {
            if (! isset($params)) {
                throw new \InvalidArgumentException("Could not load the following parameters:\n\thost\n\tuser\n\tpassword\n\tdatabase\nPlease make sure they are set.", 1000, null);
            }
            
            $database = new MySQL($params);
        }

        /**
         *
         * @deprecated - Use the static function CreateNewDatabaseWithAssocArray($params)
         * @param unknown $params            
         * @throws \Exception
         */
        public function __construct($params)
        {
            if (! isset($params))
                throw new \InvalidArgumentException("Could not load the following parameters:\n\thost\n\tuser\n\tpassword\n\tdatabase\nPlease make sure they are set.");
            $this->VerifyRequiredFields($params);
            $this->host = $params['HostName'];
            $this->user = $params['User'];
            $this->password = $params['Password'];
            $this->database = $params['Database'];
            $this->port = isset($params['Port']) ? intval($params['Port'], 10) : 3306;
            $this->socket = isset($params['Socket']) ? $params['Socket'] : null;
            $link = $this->Connect();
            if (! $link->ping())
                throw new \Exception("Unable to estabilsh a connection to the database");
            $this->Disconnect($link);
        }

        private function VerifyRequiredFields($params)
        {
            $error = "";
            if (! isset($params['HostName']) && strlen($params['HostName'] == 0))
                $error .= "\thost\n";
            if (! isset($params['User']) && strlen($params['User'] == 0))
                $error .= "\tuser\n";
            if (! isset($params['Password']) && strlen($params['Password'] == 0))
                $error .= "\tpassword\n";
            if (! isset($params['Database']) && strlen($params['Database'] == 0))
                $error .= "\tdatabase\n";
            if (strlen($error) > 0)
                throw new \Exception("Could not load the following parameters:\n" . $error . "Please make sure they are set.");
        }

        private function ConvertToReader($queryResult)
        {
            $results = array();
            while ($obj = $queryResult->fetch_assoc()) {
                $results[] = array_change_key_case($obj, CASE_UPPER);
            }
            $queryResult->free();
            
            return $results;
        }

        protected function Connect()
        {
            try {
                $link = \mysqli_connect($this->host, $this->user, $this->password, $this->database, $this->port, $this->socket);
            } catch (Exception $exc) {
                $i = 0;
                echo $exc->getMessage();
            }
            if (! $link->ping())
                throw new \Exception("Unable to estabilsh a connection to the database");
            return $link;
        }

        protected function Disconnect($link)
        {
            return $link->close();
        }

        public function ExecuteQuery($statement)
        {
            $link = $this->Connect();
            $result = $link->query($statement);
            if (! $result)
                throw new \Exception("The query was not executed successfully.");
            $this->Disconnect($link);
            return $this->ConvertToReader($result);
        }

        public function ExecuteReader($statement)
        {
            $reader = new DatabaseReader($this->ExecuteQuery($statement));
            
            return $reader;
        }

        public function ExecuteNonQuery($statement)
        {
            $link = $this->Connect();
            $result = $link->query($statement);
            if (! $result)
                throw new \Exception("The query was not executed successfully.");
            
            $this->Disconnect($link);
        }

        function GetDatabase()
        {
            return $this->database;
        }

        public function GetAllTables()
        {
            $statement = "Select table_name from information_schema.tables where table_schema = '$this->database';";
            $reader = $this->ExecuteReader($statement);
            $tables = array();
            while ($reader->Read()) {
                $tables[] = new MySQLTableMeta($this, $reader->GetStringValue("table_name"));
            }
            
            return $tables;
        }
    }
}