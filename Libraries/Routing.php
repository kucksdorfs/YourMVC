<?php
namespace YourMVC\Libraries
{

    class Routing
    {

        private static $defaultValues =  array(
            "Controller" => "HOME",
            "Action" => "INDEX"
        );

        private static $hasController = false, $hasAction = false;

        private static function GetController($explodedURL)
        {
            if (count($explodedURL) > 0) {
                self::$hasController = true;
                return $explodedURL[0];
            }
            self::$hasController = false;
            return self::$defaultValues["Controller"];
        }

        private static function GetAction($explodedURL)
        {
        	if (self::$hasController && count($explodedURL) > 1)
        	{
        	    self::$hasAction = true;
        	    return $explodedURL[1];
        	}
    	   self::$hasAction = false;
    	   return self::$defaultValues["Action"];
        }

        private static function GetURLParameters($explodedURL)
        {
        	if (self::$hasAction && count($explodedURL) > 2)
        	{
                $i = 2;
                $retAry = array();
                while (count($explodedURL) > $i)
                {
                    $current = $explodedURL[$i];
                    if (strpos($current, "?") === false && strpos($current, "#") === false)
                    {
                        $retAry[] = $current;
                    }
                    else
                    {
                        $i = count($explodedURL);
                    }
                    
                    ++$i;
                }     
                return $retAry;
        	}
        	
            return array();
        }

        public static function GetRoutingInfo($url = "/HOME/INDEX", $method = "GET", $namedParameters = null)
        {
            $explodedURL = explode("/", strtoupper(trim($url, '/')));
            
            $controller = self::GetController($explodedURL);
            $action = self::GetAction($explodedURL);
            // re-do exploding the URL so the parameter doesn't get capitilized unnecessarily. 
            $urlParams = self::GetURLParameters(explode("/", trim($url, '/')));
            $retNamedParameters = array();
            if ($namedParameters != null)
            {
                foreach($namedParameters as $key => $value)
                {
                    $retNamedParameters[$key] = $value;
                }
            }
            
            return array(
            	"Controller" => strtoupper($controller),
                "Action" => strtoupper($action),
                "Method" => strtoupper($method),
                "URLParams" => $urlParams,
                "NamedParams" => $retNamedParameters
            );
        }
    }
}
