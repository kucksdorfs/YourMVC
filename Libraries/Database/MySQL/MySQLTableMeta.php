<?php
namespace YourMVC\Libraries\Database\MySQL
{

    use YourMVC\Libraries\Interfaces\Database\TableMeta;

    class MySQLTableMeta extends TableMeta
    {

        public function __construct($link, $tableName)
        {
            parent::__construct($link, $tableName);
        }

        public function GetAllColumns()
        {
            $database = $this->link->GetDatabase();
            $statement = "select column_name from information_schema.columns where table_schema = '$database' and table_name = '$this->tableName';";
            $reader = $this->link->ExecuteReader($statement);
            $columns = array();
            while ($reader->Read()) {
                $columns[] = new MySQLColumnMeta($this->link, $this->tableName, $reader->GetStringValue("column_name"));
            }
            
            return $columns;
        }
    }
}