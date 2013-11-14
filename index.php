<?php
include_once "Libraries/Config/LoggingConfig.php";
include_once "Libraries/Logging.php";
//use YourMVC;
use YourMVC\Console;
use YourMVC\Configuration\LoggingConfiguration;
use YourMVC\Logging;

Console::LoadLogging(LoggingConfiguration::CLIDefault());
Console::WriteInformation("Hello world!");
Console::WriteError("There was an error.");
Console::WriteWarning("Warning");