<?php

namespace YourMVC\Database{
    // Interfaces
    interface iDatabase{
        function ExecuteQuery($statement);
        function ExecuteReader($statement);
        function ExecuteNonQuery($statement);
        function GetAllTables();
        function GetDatabase();
    }
    interface iTableMeta{
        function GetTableName();
        function GetAllColumns();
    }
    interface iColumnMeta{
        function GetColumnName();
        function GetType();
        function IsRequired();
        function IsUnique();
        function GetDefaultValue();
        function IsPrimaryKey();
        
        // Foreign Key
        function GetReferenceTable();
        function GetMyReferences();
    }
    
    // Abstract Classes
    abstract class TableMeta implements iTableMeta{
        protected $link, $tableName;
        
        public function __construct($link, $tableName){
            $this->link = $link;
            $this->tableName = $tableName;
        }
        public function GetTableName(){
            return $this->tableName;
        }
        public abstract function GetAllColumns();
    }
    abstract class ColumnMeta implements iColumnMeta{
        protected $link, $tableName, $column;
        public function __construct($link, $tableName, $column){
            $this->link = $link;
            $this->tableName = $tableName;
            $this->column = $column;
        }
        
        public function GetColumnName() {
            return $this->column;
        }
        public abstract function GetType();
        public abstract function IsRequired();
        public abstract function IsUnique();
        public abstract function GetDefaultValue();
        public abstract function IsPrimaryKey();
        
        // Foreign Key
        public abstract function GetReferenceTable();
        public abstract function GetMyReferences();
    }
    final class DatabaseReader{
        protected $currentRow;
        protected $result;
        final public function __construct($queryResult){
            $result = array();
            for ($i = 0; $i < count($queryResult); ++$i) {
                $result [] = array_change_key_case($queryResult[$i], CASE_UPPER);
            }
            
            $this->result = $result;
            $currentRow = null;
        }
        final public function Read(){
            if (is_null($this->currentRow)) {
                $this->currentRow = 0;
            } else {
                $this->currentRow++;
            }
            return ($this->currentRow < count($this->result));
        }
        private function GetObjectFromValue($column){
            if (is_null($this->currentRow))
                throw new \Exception("Verify the read function is executed prior to attempting to get data from the DataReader.");
            $currentRow = $this->result [$this->currentRow];
            
            if (is_int($column)) {
                $column = strtoupper($this->GetColumnNameFromIndex($column, $currentRow));
            } else {
                $column = strtoupper($column);
                if (!array_key_exists($column, $currentRow)) {
                    throw new \Exception("The key $column does not exist in the query result.");
                }
            }
            
            return $currentRow [$column];
        }
        private function RemoveInvalidElements($aryObj, $validObjects){
            $retAry = array ();
            foreach ( $validObjects as $key ) {
                if (in_array($key, $aryObj)) {
                    if ($aryObj [$key] != false) {
                        $retAry [$key] = $aryObj [$key];
                    }
                }
            }
            
            return $retAry;
        }
        private function GetColumnNameFromIndex($index, $currentRow){
            $aryKeys = array_keys($currentRow);
            return $aryKeys [$index];
        }
        final public function GetIntValue($column){
            $objValue = $this->GetObjectFromValue($column);
            $retValue = intval($objValue);
            
            if (is_null($retValue))
                return null;
            elseif (!is_int($retValue) && $retValue != $objValue) {
                throw new \Exception("The value of the column $column is not an integer.");
            }
            return $retValue;
        }
        final public function GetFloatValue($column){
            $objValue = $this->GetObjectFromValue($column);
            $retValue = floatval($objValue);
            if (is_null($retValue))
                return null;
            elseif (!is_float($retValue) && $retValue != $objValue) {
                throw new \Exception("The value of the column $column is not a float.");
            }
            return $retValue;
        }
        final public function GetStringValue($column){
            $retValue = $this->GetObjectFromValue($column);
            if (is_null($retValue))
                return null;
            if (!is_string($retValue)) {
                throw new \Exception("The value of the column $column is not a string.");
            }
            return $retValue;
        }
        final public function GetBooleanValue($column){
            $objValue = $this->GetObjectFromValue($column);
            $retValue = boolval($objValue);
            if (is_null($retValue))
                return null;
            elseif (!is_bool($retValue))
                throw new \Exception("The value of the column $column is not a boolean.");
            return $retValue;
        }
        final public function GetDateValue($column){
            $retValue = $this->GetObjectFromValue($column);
            if (is_null($retValue))
                return null;
            
            $validElements = array (
                    "day",
                    "month",
                    "year" 
            );
            $retValue = $this->RemoveInvalidElements(date_parse($retValue), $validElements);
            if (count($retValue) == 0)
                throw new \Exception("The value of the column $column is not a valid Date.");
            
            return $retValue;
        }
        final public function GetTimeValue($column){
            $retValue = $this->GetObjectFromValue($column);
            if (is_null($retValue))
                return null;
            
            $validElements = array (
                    "hour",
                    "minute",
                    "second",
                    "fraction" 
            );
            $retValue = $this->RemoveInvalidElements(date_parse($retValue), $validElements);
            if (count($retValue) == 0)
                throw new \Exception("The value of the column $column is not a valid Time.");
            
            return $retValue;
        }
        final public function GetDateTimeValue($column){
            $retValue = $this->GetObjectFromValue($column);
            if (is_null($retValue))
                return null;
            
            $validElements = array (
                    "day",
                    "month",
                    "year",
                    "hour",
                    "minute",
                    "second",
                    "fraction" 
            );
            $retValue = $this->RemoveInvalidElements(date_parse($retValue), $validElements);
            if (count($retValue) == 0)
                throw new \Exception("The value of the column $column is not a valid Date/Time.");
            
            return $retValue;
        }
    }
}

namespace YourMVC\Database\MySQL{

    use YourMVC\Database\iDatabase;
    use YourMVC\Database\TableMeta;
    use YourMVC\Database\DatabaseReader;
    use YourMVC\Database\ColumnMeta;
    // MySQL instances
    class MySQL implements iDatabase{
        private $host, $user, $password, $database; // Required
        private $port, $socket; // Optional
        public function __construct($params){
            if (!isset($params))
                throw new \Exception("Could not load the following parameters:\n\thost\n\tuser\n\tpassword\n\tdatabase\nPlease make sure they are set.");
            $this->VerifyRequiredFields($params);
            $this->host = $params ['HostName'];
            $this->user = $params ['User'];
            $this->password = $params ['Password'];
            $this->database = $params ['Database'];
            $this->port = isset($params ['Port']) ? intval($params ['Port'], 10) : 3306;
            $this->socket = isset($params ['Socket']) ? $params['Socket'] : null;
            $link = $this->Connect();
            if (!$link->ping())
                throw new \Exception("Unable to estabilsh a connection to the database");
            $this->Disconnect($link);
        }
        private function VerifyRequiredFields($params){
            $error = "";
            if (!isset($params ['HostName']) && strlen($params ['HostName'] == 0))
                $error .= "\thost\n";
            if (!isset($params ['User']) && strlen($params ['User'] == 0))
                $error .= "\tuser\n";
            if (!isset($params ['Password']) && strlen($params ['Password'] == 0))
                $error .= "\tpassword\n";
            if (!isset($params ['Database']) && strlen($params ['Database'] == 0))
                $error .= "\tdatabase\n";
            if (strlen($error) > 0)
                throw new \Exception("Could not load the following parameters:\n" . $error . "Please make sure they are set.");
        }
        private function ConvertToReader($queryResult){
            $results = array ();
            while ( $obj = $queryResult->fetch_assoc() ) {
                $results [] = array_change_key_case($obj, CASE_UPPER);
            }
            $queryResult->free();
            
            return $results;
        }
        protected function Connect(){
        	try {
	            $link = \mysqli_connect(
	            		$this->host,
	            		$this->user,
	            		$this->password,
	            		$this->database,
	            		$this->port,
	            		$this->socket);
        	}
        	catch (Exception $exc) {
        		$i = 0;
        	}
            if (!$link->ping())
                throw new \Exception("Unable to estabilsh a connection to the database");
            return $link;
        }
        protected function Disconnect($link){
            return $link->close();
        }
        public function ExecuteQuery($statement){
            $link = $this->Connect();
            $result = $link->query($statement);
            if (!$result)
                throw new \Exception("The query was not executed successfully.");
            $this->Disconnect($link);
            return $this->ConvertToReader($result);
        }
        public function ExecuteReader($statement){
            $reader = new DatabaseReader($this->ExecuteQuery($statement));

            return $reader;
        }
        public function ExecuteNonQuery($statement){
            $link = $this->Connect();
            $result = $link->query($statement);
            if (!$result)
                throw new \Exception("The query was not executed successfully.");
            
            $this->Disconnect($link);
        }
        function GetDatabase(){
            return $this->database;
        }
        public function GetAllTables(){
            $statement = "Select table_name from information_schema.tables where table_schema = '$this->database';";
            $reader = $this->ExecuteReader($statement);
            $tables = array ();
            while ( $reader->Read() ) {
                $tables [] = new MySQLTableMeta($this, $reader->GetStringValue("table_name"));
            }
            
            return $tables;
        }
    }
    class MySQLTableMeta extends TableMeta{
        public function __construct($link, $tableName){
            parent::__construct($link, $tableName);
        }
        public function GetAllColumns(){
            $database = $this->link->GetDatabase();
            $statement = "select column_name from information_schema.columns where table_schema = '$database' and table_name = '$this->tableName';";
            $reader = $this->link->ExecuteReader($statement);
            $columns = array ();
            while ( $reader->Read() ) {
                $columns [] = new MySQLColumnMeta($this->link, $this->tableName, $reader->GetStringValue("column_name"));
            }
            
            return $columns;
        }
    }
    class MySQLColumnMeta extends ColumnMeta{
        public function __construct($link, $tableName, $column){
            parent::__construct($link, $tableName, $column);
        }
        public function GetType(){
            return $this->ExecuteNonForeignKeyStatement("data_type");
        }
        public function IsRequired(){
            $isNullable = strtoupper($this->ExecuteNonForeignKeyStatement("is_nullable"));
            
            return ($isNullable == "NO");
        }
        public function IsUnique(){
            $isUnique = strtoupper($this->ExecuteNonForeignKeyStatement("column_key"));
            return ($isUnique == "PRI" || $isUnique == "UNI");
        }
        public function IsPrimaryKey(){
            $isUnique = strtoupper($this->ExecuteNonForeignKeyStatement("column_key"));
            return $isUnique == "PRI";
        }
        public function GetDefaultValue(){
            $defaultValue = $this->ExecuteNonForeignKeyStatement("column_default");
            
            return $defaultValue;
        }
        public function GetReferenceTable(){
            $database = $this->link->GetDatabase();
            $statement = "select TABLE_NAME, referenced_table_schema, referenced_table_name, referenced_column_name from information_schema.KEY_COLUMN_USAGE where TABLE_SCHEMA = '$database' AND TABLE_NAME = '$this->tableName' AND COLUMN_NAME = '$this->column' AND REFERENCED_TABLE_NAME is not null;";
            $reader = $this->link->ExecuteReader($statement);
            
            if (!$reader->Read())
                return null;
            return array (
                    "My_Table" => $reader->GetStringValue("table_name"),
                    "Referenced_Database" => $reader->GetStringValue("referenced_table_schema"),
                    "Referenced_Table_Name" => $reader->GetStringValue("referenced_table_name"),
                    "Referenced_Column_Name" => $reader->GetStringValue("referenced_column_name") 
            );
        }
        public function GetMyReferences(){
            $database = $this->link->GetDatabase();
            $statement = "select TABLE_SCHEMA, TABLE_NAME, column_name from information_schema.KEY_COLUMN_USAGE where TABLE_SCHEMA = '$database' AND referenced_table_name = '$this->tableName' AND referenced_column_name = '$this->column' AND REFERENCED_TABLE_NAME is not null;";
            $reader = $this->link->ExecuteReader($statement);
            
            $retAry = array();
            while ($reader->Read()) {
                $retAry[] = array(
                        "Database" => $reader->GetStringValue("table_schema"),
                        "Table_Name" => $reader->GetStringValue("table_name"),
                        "Column_Name" => $reader->GetStringValue("column_name")
                );
            }
            return $retAry;
        }
        private function ExecuteNonForeignKeyStatement($column){
            $database = $this->link->GetDatabase();
            $statement = "select $column from information_schema.columns where table_schema = '$database' AND table_name = '$this->tableName' AND column_name = '$this->column';";
            $reader = $this->link->ExecuteReader($statement);
            
            if (!$reader->Read())
                return null;
            return $reader->GetStringValue($column);
        }
    }
}