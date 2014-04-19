<?php
namespace YourMVC\Libraries\Interfaces\Database
{

    /**
     * This interface is to be used to make database specific TableMeta objects.
     *
     * @author stephen
     */
    interface iTableMeta
    {
    
        /**
         * This function is to get the name of the current table.
         *
         * @return string - The name of the table.
         */
        function GetTableName();
    
        /**
         * This function is to be used to get all the tables as an array of ColumnMeta objects.
         *
         * @return array of iColumnMeta - The database specific iColumnMeta object. Ex: MySQLColumnMeta which extends
         *         ColumnMeta.
        */
        function GetAllColumns();
    }
    
    /**
     * This abstract class should be used when creating a Table Meta for a specific
     * database.
     * @author stephen
     */
    abstract class TableMeta implements iTableMeta
    {
        /**
         * $link - Object: The link to the database
         * @tableName - String: The name of the table
         */
        protected $link, $tableName;
    
        /**
         * This constructor sets the $link and the $tableName objects.
         * @param object $link
         * @param string $tableName
         */
        public function __construct($link, $tableName)
        {
            $this->link = $link;
            $this->tableName = $tableName;
        }
    
        /**
         * (non-PHPdoc)
         * @see \YourMVC\Libraries\Interfaces\Database\iTableMeta::GetTableName()
         */
        public function GetTableName()
        {
            return $this->tableName;
        }
    
        /**
         * (non-PHPdoc)
         * @see \YourMVC\Libraries\Interfaces\Database\iTableMeta::GetAllColumns()
         */
        public abstract function GetAllColumns();
    }
    
}