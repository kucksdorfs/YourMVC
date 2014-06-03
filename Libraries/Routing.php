<?php
namespace YourMVC\Libraries
{

    class Routing
    {

        private static $defaultValues =  array(
            "Controller" => "Home",
            "Action" => "Index"
        );

        private static $hasController = false, $hasAction = false;

        private static function GetController($explodedURL)
        {
            if (count($explodedURL) > 0 && strlen($explodedURL[0]) > 0) {
                self::$hasController = true;
                return ucfirst($explodedURL[0]);
            }
            self::$hasController = false;
            return self::$defaultValues["Controller"];
        }

        private static function GetAction($explodedURL)
        {
        	if (self::$hasController && count($explodedURL) > 1 && strlen($explodedURL[1]) > 0)
        	{
        	    self::$hasAction = true;
        	    return ucfirst($explodedURL[1]);
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

        public static function GetRoutingInfo($url = "/Home/Index", $method = "GET", $namedParameters = null)
        {
            $explodedURL = explode("/", trim($url, '/'));

            $controller = self::GetController($explodedURL);
            $action = self::GetAction($explodedURL);
            $urlParams = self::GetURLParameters($explodedURL);
            $retNamedParameters = array();
            if ($namedParameters != null)
            {
                foreach($namedParameters as $key => $value)
                {
                    $retNamedParameters[$key] = $value;
                }
            }

            return array(
            	"Controller" => ucfirst($controller),
                "Action" => ucfirst($action),
                "Method" => strtoupper($method),
                "URLParams" => $urlParams,
                "NamedParams" => $retNamedParameters
            );
        }
    }
}
