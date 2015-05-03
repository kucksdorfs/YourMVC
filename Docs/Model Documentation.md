<h1 style="text-align:center">YourMVC</h1>
<h2 style="text-align:center">Documentation for Models</h2>
******
###Table of Content
* [Models](#TOC_Models)

<h4 id="TOC_Models">Models</h4>

YourMVC includes some built in model functionality. Each model class should go into it's own files (adhearing to PSR-4).

Each model should extend YourMVC\Libraries\BaseModel. Each model has access to a Console object (accessed via $this->CONSOLE). The console member calls the same Console object created in the Logging Documentation. For more information read the [Documentation for Logging](Logging%20Documentation.md)
Models also inherit a database object (accessed b $this->DataBase). This database member is created by invoking the database configuration located in YourMVC\Libraries\Config\DatabaseConfig::DatabaseDefault(). For more information read the [Documentation for Databases and MySQL](Database%20;and%20;MySQL%20Documentation.md)

******
<p class="footer" style="text-align:center">
Written on May 3, 2015 by Stephen
Version 0.4B
</p>
