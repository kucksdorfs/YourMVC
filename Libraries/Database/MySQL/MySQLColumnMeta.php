<?php
namespace YourMVC\Libraries\Database\MySQL
{    
    use YourMVC\Libraries\Interfaces\Database\ColumnMeta;

    class MySQLColumnMeta extends ColumnMeta
    {

        public function __construct($link, $tableName, $column)
        {
            parent::__construct($link, $tableName, $column);
        }

        public function GetType()
        {
            return $this->ExecuteNonForeignKeyStatement("data_type");
        }

        public function IsRequired()
        {
            $isNullable = strtoupper($this->ExecuteNonForeignKeyStatement("is_nullable"));
            
            return ($isNullable == "NO");
        }

        public function IsUnique()
        {
            $isUnique = strtoupper($this->ExecuteNonForeignKeyStatement("column_key"));
            return ($isUnique == "PRI" || $isUnique == "UNI");
        }

        public function IsPrimaryKey()
        {
            $isUnique = strtoupper($this->ExecuteNonForeignKeyStatement("column_key"));
            return $isUnique == "PRI";
        }

        public function GetDefaultValue()
        {
            $defaultValue = $this->ExecuteNonForeignKeyStatement("column_default");
            
            return $defaultValue;
        }

        public function GetReferenceTable()
        {
            $database = $this->link->GetDatabase();
            $statement = "select TABLE_NAME, referenced_table_schema, referenced_table_name, referenced_column_name from information_schema.KEY_COLUMN_USAGE where TABLE_SCHEMA = '$database' AND TABLE_NAME = '$this->tableName' AND COLUMN_NAME = '$this->column' AND REFERENCED_TABLE_NAME is not null;";
            $reader = $this->link->ExecuteReader($statement);
            
            if (! $reader->Read())
                return null;
            return array(
                "My_Table" => $reader->GetStringValue("table_name"),
                "Referenced_Database" => $reader->GetStringValue("referenced_table_schema"),
                "Referenced_Table_Name" => $reader->GetStringValue("referenced_table_name"),
                "Referenced_Column_Name" => $reader->GetStringValue("referenced_column_name")
            );
        }

        public function GetMyReferences()
        {
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

        private function ExecuteNonForeignKeyStatement($column)
        {
            $database = $this->link->GetDatabase();
            $statement = "select $column from information_schema.columns where table_schema = '$database' AND table_name = '$this->tableName' AND column_name = '$this->column';";
            $reader = $this->link->ExecuteReader($statement);
            
            if (! $reader->Read())
                return null;
            return $reader->GetStringValue($column);
        }
    }
}