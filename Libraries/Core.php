<?php

function __autoload($className)
{
    $myRequirePath = $className;
    $yourMVCPos = strpos(strtoupper($myRequirePath), 'YOURMVC');
    if ($yourMVCPos == 0) {
        $myRequirePath = substr($myRequirePath, strlen('YourMVC'));
    }
    $myRequirePath = str_replace("\\", DIRECTORY_SEPARATOR, $myRequirePath) . ".php";
    $includePaths = explode(":", get_include_path());
    
    $i = 0;
    while ($i < count($includePaths) && ! file_exists($includePaths[$i] . $myRequirePath)) {
        $i ++;
    }
    
    if ($i >= count($includePaths)) {
        return;
    }
    
    require_once $includePaths[$i] . $myRequirePath;
}

YourMVC\Libraries\Logging\Console::LoadLogging(YourMVC\Libraries\Config\LoggingConfig::WebDefault());

$routingInfo = null;
if (isset($_SERVER['PATH_INFO'])) {
    $method = strtoupper($_SERVER['REQUEST_METHOD']);
    $namedParameters = $method == "GET" ? $_GET : $_POST;
    $routingInfo = YourMVC\Libraries\Routing::GetRoutingInfo(strtoupper($_SERVER['PATH_INFO']), $method, $namedParameters);
}