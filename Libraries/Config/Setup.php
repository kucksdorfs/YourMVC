<?php
// This section sets up the path to the "root" directory of the application.
$includePath = get_include_path();
$myDir = dirname($_SERVER['PHP_SELF']);
echo $myDir . "\n";
if(strtoupper(php_sapi_name()) == "CLI" && strpos($includePath, $myDir) == FALSE){
    set_include_path(get_include_path() . ":" . $myDir);
}