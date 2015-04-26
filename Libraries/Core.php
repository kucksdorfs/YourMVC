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

use YourMVC\Libraries\YourReflection;

YourMVC\Libraries\Logging\Console::LoadLogging(YourMVC\Libraries\Config\LoggingConfig::WebDefault());

function CallController($routeInfo)
{
    $baseController = new YourMVC\Libraries\BaseController();
    $retValue = "";
    
    try {
        $className = "";
        if ($routeInfo != null) {
            $className = 'YourMVC\\Controllers\\' . ucfirst($routeInfo['Controller']) . 'Controller';
            
            $controller = YourReflection::CreateNewInstance($className);
            if ($controller == null) {
                $retValue = $baseController->Error404();
                return;
            }
            $action = ucfirst($routeInfo['Action']);
            $retValue = null;
            
            if (YourReflection::HasInstanceMethod($controller, strtoupper($routeInfo['Method']) . '_' . $action)) {
                YourReflection::InvokeInstanceMethod($controller, $routeInfo['Method'] . '_' . $action, $parameters, $retValue);
            } elseif (YourReflection::HasInstanceMethod($controller, $action)) {
                YourReflection::InvokeInstanceMethod($controller, $action, $parameters, $retValue);
            } else {
                $retValue = $baseController->Error404();
                return;
            }
        } else {
            $retValue = $baseController->Error404();
            return;
        }
    } catch (Exception $ex) {
        $retValue = $baseController->Error500();
    }
    
    if (is_string($retValue) && $retValue != "") {
        echo $retValue;
    }
}

if (php_sapi_name() !== 'cli') {
    $method = strtoupper($_SERVER['REQUEST_METHOD']);
    $namedParameters = $method == "GET" ? $_GET : $_POST;
    $routingInfo = YourMVC\Libraries\Routing::GetRoutingInfo($_SERVER['PATH_INFO'], $method, $namedParameters);
    // CallController($routingInfo);
}