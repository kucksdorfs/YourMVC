<?php
//set_include_path(get_include_path() . ":..");
chdir("..");
header("Content-type: text/plain");

require_once 'Libraries' . DIRECTORY_SEPARATOR . 'Core.php';

// The configuration for the Unit Tests
//require_once 'Config' . DIRECTORY_SEPARATOR . 'UnitTestConfig.php';
//require_once 'UnitTestFramework.php';




\YourMVC\Testing\UnitTestFramework::Main(YourMVC\Testing\Config\UnitTestConfig::GetUnitTestArgs());

//\YourMVC\UnitTest\Framework\UnitTest::Main(YourMVC\Testing\Configuration\UnitTestConfiguration::GetUnitTestArgs());
