<h1 style="text-align:center">YourMVC</h1>
<h2 style="text-align:center">Documentation for Logging</h2>
******
###Table of Content
* [Logging Configuration](#TOC_LoggingConfig)
    - [Default Configuration](#TOC_DefaultConfig)
        - [Logging Class](#TOC_LoggingClass)
        - [File Sytem Logging](#TOC_FileSystemLogging)
        - [Database Logging](#TOC_DatabaseLogging)
- [Writing your own](#TOC_WritingYourOwn)
    - [Calling the Console Function](#TOC_CallingConsoleFn)

<h4 id="TOC_LoggingConfig">Logging Configuration</h4>

There are two configuration settings for Logging, the first is the CLI configuration, the second is the Web configuration. Each relies on the same structure. At a minimum, each section must contain a ClassName. A second optional configuration can be set called SubLogging. The ClassName variable must contain the namespace the class is in.

<h5 id="TOC_LoggingConfig">Default Configuration</h5>

There are three default classes for logging. They are described below.

<h6 id="TOC_LoggingClass">Logging Class</h6>

The default CLI writes all messages just like performing an echo would. With the message passed to it, the type of message is written as well as the current date and time in the Y-m-d H:i:s format. Because this is just echoing the messages, it is not recommended that this is not used during web output.

<h6 id="TOC_FileSystemLogging">File Sytem Logging</h6>

This is the default logging for web logging and the default sub logging for CLI logging. In this logging class, the informational, warnings, and errors are all written to their own file. A directory must be defined for where the three files should be created (if they are not already) and written to (called Location). An optional parameter may be defined to use the include path when writing the log files (called UseIncludePath). The folder must already exist and must be writable by the user running the php script (in a web environment this is typically www-data).

<h6 id="TOC_DatabaseLogging">Database Logging</h6>

Messages can now be logged to a SQL based database. The only officially supported database is MySQL. The script to create the table and views for logging is located in /YourMVC/Docs/ and is called Logging to MySQL. The table definition is spelled out below.

Along with the ClassName and SubLogging, there is a third and fourth configuration parameter called “Database” and “Table”. The “Table” parameter is the name of the table where the logs are to be stored. The “Database” parameter uses the same parameters as the YourDatabase interface uses. For more information about that see the Database documentation (Database and MySQL Documentation.md).

<h4 id="TOC_WritingYourOwn">Writing your own</h4>

When writing your own logging class, it must extend the Logging class. There are three methods that must be written, they are WriteInformation, WriteError, and WriteWarning. Each gets passed a single string variable that should be the message to be logged. At the end of each of these methods, the parent function should be called (parent::WriteInformation if you are in the WriteInformation method). The parent takes care of calling any sub logging class. At the beginning or the end of the constructor, the parent constructor should be called, passing in the single variable as it is, the parent takes care of stripping out and parent logging information.

<h5 id="TOC_CallingConsoleFn">Calling the Console Function</h5>

Before calling any of the write functions, Console::LoadLogging should be called. An array should be passed in defining any parameters needed for that class. At a minimum, a variable called ClassName should be defined. Optionally, an element that should be null or an array should be an array. Any other parameters will depend on the class being created. There are three functions that can be called, WriteInformation, WriteWarning, and WriteError. Each should be passed a string that is the message to be written to the log.

******

<p class="footer" style="text-align:center">
Written on November 9, 2013 by Stephen<br/>
Modified on April 27, 2015 by Stephen<br/>
Version 0.4A
</p>