<?php
/**
 * These interfaces and abstract classes should be used when
 * implementing a new database engine.
 *
 * Licensed under The MIT License
 * @author stephen
 */
namespace YourMVC\Libraries\Interfaces\Database
{

    /**
     * This interface is to be used to make database specific ColumnMeta objects.
     *
     * @author stephen
     */
    interface iColumnMeta
    {

        /**
         * This function is to get the name of the current column.
         */
        function GetColumnName();

        /**
         * This function returns a string of the data type for the current column.
         *
         * @return string - The type of the column
         */
        function GetType();

        /**
         * This function returns true if the column requires a value when inserting
         * values into the table.
         *
         * @return boolean - True if the column is required, false otherwise.
         */
        function IsRequired();

        /**
         * This function returns true if the column is unique, false otherwise.
         *
         * @return boolean - True if the column requires a unique value, false otherwise.
         */
        function IsUnique();

        /**
         * This function returns a string that is the default value for the column.
         *
         * @return string - The default value of the column, null if one is not given.
         */
        function GetDefaultValue();

        /**
         * This function returns true if the column is a primary key, false otherwise.
         *
         * @return boolean - True if the column is a primary key, false otherwise.
         */
        function IsPrimaryKey();

        /**
         * If the column is a foreign key, return an associated array with this columns table,
         * the reference table database, the reference table, and the reference column.
         *
         * @return associated array - An associated array with the current column's table, the
         *         reference table's database, the reference table's table name, and the reference column.
         */
        function GetReferenceTable();

        /**
         * If the column is a foreign key to another table, this function will return an associated
         * array with the database, table, and column that uses this column as a foreign key.
         *
         * @return associated array - An associated with the reference database, reference table, and
         *         reference column.
         */
        function GetMyReferences();
    }

    /**
     * This abstract class should be used when creating a Column Meta for a specific
     * database.
     * 
     * @author stephen
     */
    abstract class ColumnMeta implements iColumnMeta
    {

        /**
         * $link - Object: The link to the database.
         * @tableName - String: The name of the table which this column belongs.
         * $column - String: The name of the column.
         */
        protected $link, $tableName, $column;

        /**
         * This constructor sets $link, $tableName and $column.
         * 
         * @param object $link            
         * @param string $tableName            
         * @param string $column            
         */
        public function __construct($link, $tableName, $column)
        {
            $this->link = $link;
            $this->tableName = $tableName;
            $this->column = $column;
        }

        /**
         * (non-PHPdoc)
         * 
         * @see \YourMVC\Libraries\Interfaces\Database\iColumnMeta::GetColumnName()
         */
        public function GetColumnName()
        {
            return $this->column;
        }

        /**
         * (non-PHPdoc)
         * 
         * @see \YourMVC\Libraries\Interfaces\Database\iColumnMeta::GetType()
         */
        public abstract function GetType();

        /**
         * (non-PHPdoc)
         * 
         * @see \YourMVC\Libraries\Interfaces\Database\iColumnMeta::IsRequired()
         */
        public abstract function IsRequired();

        /**
         * (non-PHPdoc)
         * 
         * @see \YourMVC\Libraries\Interfaces\Database\iColumnMeta::IsUnique()
         */
        public abstract function IsUnique();

        /**
         * (non-PHPdoc)
         * 
         * @see \YourMVC\Libraries\Interfaces\Database\iColumnMeta::GetDefaultValue()
         */
        public abstract function GetDefaultValue();

        /**
         * (non-PHPdoc)
         * 
         * @see \YourMVC\Libraries\Interfaces\Database\iColumnMeta::IsPrimaryKey()
         */
        public abstract function IsPrimaryKey();

        /**
         * (non-PHPdoc)
         * 
         * @see \YourMVC\Libraries\Interfaces\Database\iColumnMeta::GetReferenceTable()
         */
        public abstract function GetReferenceTable();

        /**
         * (non-PHPdoc)
         * 
         * @see \YourMVC\Libraries\Interfaces\Database\iColumnMeta::GetMyReferences()
         */
        public abstract function GetMyReferences();
    }
}