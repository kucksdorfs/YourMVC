<h1 style="text-align:center">YourMVC</h1>
<h2 style="text-align:center">Documentation for Databases and MySQL</h2>
******
###Table of Content
* [Database Configuration](#TOC_DBConfig)
    - [Database Reader](#TOC_DBReader)
- [Writing your own](#TOC_WritingYourOwn)
    - [Database Class](#TOC_DatabaseClass)
    - [TableMeta Class](#TOC_TableMetaClass)
    - [ColumnMeta Class](#TOC_ColumnMetaClass)

<h4 id="TOC_DBConfig">Database Configuration</h4>

To use MySQL, in DatabaseConfig.php, at a minimum the DatabaseDefault function should return a ClassName referring to the class of the database driver. Using MySQL, the ClassName is “YourMVC\Libraries\Database\MySQL” and the following are required values: the HostName, Database, User, and Password. Optionally a Port and Socket can also be set. The ClassName variable must contain the namespace of the class in it.

<h5 id="TOC_DBReader">Database Reader</h5>

The database reader class acts as a object that steps forward through rows of a data set. A reader can be created by calling a Database->ExecuteReader from a class that implements iDatabase. When using a DatabaseReader object, the Read function should be used to move to the next row. If the reader is new, the row is null, and trying to get a value will fail. The read function returns true if there is a row to read, otherwise it will return false.

The database reader class also has several Name/Value functions. These functions will return a column based on the type declared in a function (GetIntValue returns an int for example). The function takes either a string or an integer. If you use an integer, the columns has to be between 0 and the number of columns (three columns would be 0 and 2). If you use a string, then the value of the string should be the case insensitive column of the data you want.

The following functions are available and will return their data type or null:

- GetIntValue
- GetFloatValue
- GetStringValue
- GetBooleanValue

There are three other functions that return special data types. These are GetDateValue, GetTimeValue and GetDateTimeValue. These will return arrays with keys. The GetDateValue will have keys day, month, year. The GetTimeValue will have hour, minute, second, and fraction. And the GetDateTimeValue will have day, month, year, hour minute, second, and fraction. Any of those values can be missing and it will still be considered a valid object of each type (for example, the GetTimeValue may only have an hour, minute, and second, but not fraction, only the hour, minute, and second values will be returned).

<h4 id="TOC_WritingYourOwn">Writing your own</h4>

When writing your own Database driver, there are several classes that must be implemented. The required classes are a ColumnMeta class that extends YourMVC\Libraries\Interfaces\Database\ColumnMeta, a TableMeta class that extends YourMVC\Libraries\Interfaces\Database\TableMeta, and a Database class that implements YourMVC\Libraries\Interfaces\Database\iDatabase.

<h5 id="TOC_DatabaseClass">Database Class</h5>

The database class must implement the iDatabase interface. There are several functions that should be implemented when building your database class. The ExecuteQuery returns an array of arrays. The first array is which row was returned. The second array is the hash table of the columns that were returned from the query. The ExecuteQuery function must always return a table.

The second function that must be implemented is the ExecuteReader. This function returns a DatabaseReader. The database reader expects the results of ExecuteQuery It is recommended that you execute the ExecuteQuery function, passing in $statement, and send that to a new instance of YourMVC\Libraries\Database\DatabaseReader.

The third function is the ExecuteNonQuery. This should execute a non-value-returning sql query such as an insert, update, or delete.
The fourth function is GetDatabase, and it should return the name of the database being used by this object.

The final function is the GetAllTables function. This function should return an array of TableMeta objects. This list should be all the tables in the current database.

<h5 id="TOC_TableMetaClass">TableMeta Class</h5>

Your TableMeta class must extend the TableMeta class. There is one function that must be implemented when building your TableMeta class. The only required function is the GetAllColumns function. This function returns an array of ColumnMeta objects.

The second, and optional, function that can be implemented is the GetTableName function. By default, the table name is returned.

<h5 id="TOC_ColumnMetaClass">ColumnMeta Class</h5>

Your ColumnMeta class must extend the ColumnMeta class. There are several functions that must be implemented when building your ColumnMeta class. The GetType function gets the SQL data type of that column.

The second function that must be implemented is the IsRequired function. This function returns true if the columns requires a non-null value when inserting or updating values for this column.

The third function that must be implemented  is the IsUnique function. The function returns true if the column is marked unique, or marked as a primary key.

The fourth function that must be implemented is the IsPrimaryKey function. The function returns true if the column is a primary key for the table.

The fourth function that must be implemented is the GetDefaultValue function. This function returns the default value of the column. If the column does not have a default values, the return value is null.

The fifth function that must be implemented is the GetReferenceTable function. This function returns the table of the current column, the database of the foreign key column, the table of the foreign key column, and the name of the foreign column. If the column is not a foreign key the function should return null.

The sixth and final function that must be implemented is GetMyReferences. This function returns an array of objects that include the database, table and column names. This function should peek into the current column, and try to find any columns that reference the current column.

******
<p class="footer" style="text-align:center">
Written on February 12, 2014 by Stephen
Modified on April 27, 2015 by Stephen
Version 0.4A
</p>
