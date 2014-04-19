<?php
namespace YourMVC\Libraries\Interfaces\Database
{
    require_once 'TableMeta.php';
    require_once 'ColumnMeta.php';

    /**
     * This interface is used implement core database functionality.
     *
     * @author stephen
     */
    interface iDatabase
    {

        /**
         * This function is to be used to execute a select statement and to get
         * an associated array back from the select.
         *
         * @param string $statement
         *            - The select statement to be executed
         * @return Associated Array - The associated array of a select statement.
         */
        function ExecuteQuery($statement);

        /**
         * This function is to be used to execute a select statement to get a
         * YourMVC/Libraries/DatabaseReader object.
         *
         * @param string $statement
         *            - The select statement to be executed.
         * @return YourMVC/Libraries/DatabaseReader - The reader for the select
         *         select statement.
         */
        function ExecuteReader($statement);

        /**
         * This funcion is to be used to execute a non-select statement such as an update
         * or a delete.
         *
         *
         * @param string $statement
         *            - The statement to be executed.
         * @return boolean - True if the statement was executed successfully, false otherwise.
         */
        function ExecuteNonQuery($statement);

        /**
         * This function is to be used to get all the tables as an array of TableMeta objects.
         *
         * @return array of iTableMeta - The database specific iTableMeta object. Ex: MySQLTableMeta which implements
         *         iTableMeta.
         */
        function GetAllTables();

        /**
         * This function is to be used to get the name of the database.
         *
         * @return string - The name of the database.
         */
        function GetDatabase();
    }
}