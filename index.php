<?php
include_once "Libraries/Config/LoggingConfig.php";
include_once "Libraries/Config/DatabaseConfig.php";
include_once "Libraries/Logging.php";
include_once "Libraries/Database.php";

use YourMVC\Configuration\LoggingConfiguration;
use YourMVC\Configuration\DatabaseConfiguration;
use YourMVC\Console;
use YourMVC\Logging;
use YourMVC\Database;
use YourMVC\Database\MySQL;

Console::LoadLogging(LoggingConfiguration::CLIDefault());
$defaultDatabase = DatabaseConfiguration::DatabaseDefault();
$database = null;
if ($defaultDatabase ["ClassName"] == 'YourMVC\\Database\\MySQL') {
    $database = new YourMVC\Database\MySQL\MySQL($defaultDatabase);
} else {
    throw new Exception("Could not load the database.\n" . var_dump($defaultDatabase));
}

$tables = $database->GetAllTables();
for($k = 0; $k < count($tables); ++$k) {
    $columns = $tables [$k]->GetAllColumns();
    $tableName = $tables [$k]->GetTableName();
    Console::WriteInformation("Information for table: $tableName");
    for($i = 0; $i < count($columns); ++$i) {
        Console::WriteInformation("Column: " . $columns [$i]->GetColumnName());
        
        if ($columns [$i]->IsPrimaryKey())
            Console::WriteInformation("The column is a primary key.");
        elseif ($columns [$i]->IsUnique())
            Console::WriteInformation("The column is unique");
        
        Console::WriteInformation("The column's type is " . $columns [$i]->GetType());
        
        if ($columns [$i]->IsRequired())
            Console::WriteInformation("The column is required");
        
        $defaultValue = $columns [$i]->GetDefaultValue();
        if (!is_null($defaultValue))
            Console::WriteInformation("The default value is $defaultValue");
        
        $foreignKey = $columns [$i]->GetReferenceTable();
        if (!is_null($foreignKey)) {
            Console::WriteInformation("This column is a foreign key, it contains the following data.");
            Console::WriteInformation("My Table = " . $foreignKey ["My_Table"]);
            Console::WriteInformation("Referenced Table Database = " . $foreignKey ["Referenced_Database"]);
            Console::WriteInformation("Referenced Table Name = " . $foreignKey ["Referenced_Table_Name"]);
            Console::WriteInformation("Referenced Column Name = " . $foreignKey ["Referenced_Column_Name"]);
        }
        
        $referenceKeys = $columns [$i]->GetMyReferences();
        Console::WriteInformation("The columns is referenced in " . count($referenceKeys) . " tables.");
        for($j = 0; $j < count($referenceKeys); ++$j) {
            Console::WriteInformation("Table database = " . $referenceKeys [$j] ["Database"]);
            Console::WriteInformation("Table Name = " . $referenceKeys [$j] ["Table_Name"]);
            Console::WriteInformation("Column Name = " . $referenceKeys [$j] ["Column_Name"]);
        }
    }
}
$statement = "select * from YourGroups;";
$YourGroupsRdr = $database->ExecuteReader($statement);
$YourGroupsQry = $database->ExecuteQuery($statement);
$statement = "Insert into YourGroups (GroupName, DateEntered) values ('TestInsert', Now());";
$database->ExecuteNonQuery($statement);
$database->ExecuteNonQuery("Delete from YourGroups where GroupName = 'TestInsert'");

$statement = "select * from YourUsers;";
$YourUsersRdr = $database->ExecuteReader($statement);
$YourUsersQry = $database->ExecuteQuery($statement);