<?php
namespace YourMVC\UnitTest\Framework
{

    use YourMVC\Libraries\Routing;

    class RoutingTest extends \YourMVC\Testing\UnitTestFramework
    {

        function ControllerAndActionTest()
        {
            $route = "/home/stephen/";
            $method = "GET";
            $params = null;
            $routeInfo = Routing::GetRoutingInfo($route, $method, $params);
            
            $this->AssertAreEqual($routeInfo["Controller"], "HOME");
            $this->AssertAreEqual($routeInfo["Action"], "STEPHEN");
            $this->AssertAreEqual($routeInfo["Method"], "GET");
            $this->AssertAreEqual(count($routeInfo["URLParams"]), 0);
            $this->AssertAreEqual(count($routeInfo["NamedParams"]), 0);
        }

        function ControllerActionPostTest()
        {
            $route = "/mycontroller/myaction/";
            $method = "POST";
            $params = null;
            $routeInfo = Routing::GetRoutingInfo($route, $method, $params);
            
            $this->AssertAreEqual($routeInfo["Controller"], "MYCONTROLLER");
            $this->AssertAreEqual($routeInfo["Action"], "MYACTION");
            $this->AssertAreEqual($routeInfo["Method"], "POST");
            $this->AssertAreEqual(count($routeInfo["URLParams"]), 0);
            $this->AssertAreEqual(count($routeInfo["NamedParams"]), 0);
        }

        function NoControllerNoMethodTest()
        {
            $routeInfo = Routing::GetRoutingInfo();
            
            $this->AssertAreEqual($routeInfo["Controller"], "HOME");
            $this->AssertAreEqual($routeInfo["Action"], "INDEX");
            $this->AssertAreEqual($routeInfo["Method"], "GET");
            $this->AssertAreEqual(count($routeInfo["URLParams"]), 0);
            $this->AssertAreEqual(count($routeInfo["NamedParams"]), 0);
        }

        function ControllerNoActionNoMethodTest()
        {
            $route = "/mycontroller/";
            $routeInfo = Routing::GetRoutingInfo($route);
            
            $this->AssertAreEqual($routeInfo["Controller"], "MYCONTROLLER");
            $this->AssertAreEqual($routeInfo["Action"], "INDEX");
            $this->AssertAreEqual($routeInfo["Method"], "GET");
            $this->AssertAreEqual(count($routeInfo["URLParams"]), 0);
            $this->AssertAreEqual(count($routeInfo["NamedParams"]), 0);
        }

        function ControllerActionOneURLParamTest()
        {
            $route = "/mycontroller/myaction/Param1";
            $routeInfo = Routing::GetRoutingInfo($route);
            
            $this->AssertAreEqual($routeInfo["Controller"], "MYCONTROLLER");
            $this->AssertAreEqual($routeInfo["Action"], "MYACTION");
            $this->AssertAreEqual($routeInfo["Method"], "GET");
            $this->AssertAreEqual(count($routeInfo["URLParams"]), 1);
            $this->AssertAreEqual($routeInfo["URLParams"][0], "Param1");
            $this->AssertAreEqual(count($routeInfo["NamedParams"]), 0);
        }
        
        function ControllerActionMulitpleURLParamTest()
        {
            $route = "/mycontroller/myaction/Param1/Param2/3/4/";
            $routeInfo = Routing::GetRoutingInfo($route);
        
            $this->AssertAreEqual($routeInfo["Controller"], "MYCONTROLLER");
            $this->AssertAreEqual($routeInfo["Action"], "MYACTION");
            $this->AssertAreEqual($routeInfo["Method"], "GET");
            $this->AssertAreEqual(count($routeInfo["URLParams"]), 4);
            $this->AssertAreEqual($routeInfo["URLParams"][0], "Param1");
            $this->AssertAreEqual($routeInfo["URLParams"][1], "Param2");
            $this->AssertAreEqual($routeInfo["URLParams"][2], 3);
            $this->AssertAreEqual($routeInfo["URLParams"][3], 4);
            $this->AssertAreEqual(count($routeInfo["NamedParams"]), 0);
        }
        
        function ControllerActionWithPoundSymbolTest()
        {
            $route = "/mycontroller/myaction/Param1/#Param2/3/4/";
            $routeInfo = Routing::GetRoutingInfo($route);
        
            $this->AssertAreEqual($routeInfo["Controller"], "MYCONTROLLER");
            $this->AssertAreEqual($routeInfo["Action"], "MYACTION");
            $this->AssertAreEqual($routeInfo["Method"], "GET");
            $this->AssertAreEqual(count($routeInfo["URLParams"]), 1);
            $this->AssertAreEqual($routeInfo["URLParams"][0], "Param1");
            $this->AssertAreEqual(count($routeInfo["NamedParams"]), 0);
        }
        
        function ControllerActionWithQuestionSymbolTest()
        {
            $route = "/mycontroller/myaction/Param1/?Param2=10&a=3";
            $routeInfo = Routing::GetRoutingInfo($route);
        
            $this->AssertAreEqual($routeInfo["Controller"], "MYCONTROLLER");
            $this->AssertAreEqual($routeInfo["Action"], "MYACTION");
            $this->AssertAreEqual($routeInfo["Method"], "GET");
            $this->AssertAreEqual(count($routeInfo["URLParams"]), 1);
            $this->AssertAreEqual($routeInfo["URLParams"][0], "Param1");
            $this->AssertAreEqual(count($routeInfo["NamedParams"]), 0);
        }
        
        
        function ControllerActionWithNamedParametersTest()
        {
            $route = "/mycontroller/myaction/Param1/?Param2=10&a=3";
            $namedParams = array(
            	"Param2" => 10,
                "a" => 3
                
            );
            $routeInfo = Routing::GetRoutingInfo($route, "get", $namedParams);
        
            $this->AssertAreEqual($routeInfo["Controller"], "MYCONTROLLER");
            $this->AssertAreEqual($routeInfo["Action"], "MYACTION");
            $this->AssertAreEqual($routeInfo["Method"], "GET");
            $this->AssertAreEqual(count($routeInfo["URLParams"]), 1);
            $this->AssertAreEqual($routeInfo["URLParams"][0], "Param1");
            $this->AssertAreEqual(count($routeInfo["NamedParams"]), 2);
            $this->AssertAreEqual($routeInfo["NamedParams"]["Param2"], 10);
            $this->AssertAreEqual($routeInfo["NamedParams"]["a"], 10);
        }
        
        function ControllerAndActionWithPoundAndNamedParamsTest()
        {
            function ControllerActionWithNamedParametersTest()
            {
                $route = "/mycontroller/myaction/Param1/?Param2=10&a=3";
                $namedParams = array(
                    "Param2" => 10,
                    "a" => 3
            
                );
                $routeInfo = Routing::GetRoutingInfo($route, "get", $namedParams);
            
                $this->AssertAreEqual($routeInfo["Controller"], "MYCONTROLLER");
                $this->AssertAreEqual($routeInfo["Action"], "MYACTION");
                $this->AssertAreEqual($routeInfo["Method"], "GET");
                $this->AssertAreEqual(count($routeInfo["URLParams"]), 1);
                $this->AssertAreEqual($routeInfo["URLParams"][0], "Param1");
                $this->AssertAreEqual(count($routeInfo["NamedParams"]), 2);
                $this->AssertAreEqual($routeInfo["NamedParams"]["Param2"], 10);
                $this->AssertAreEqual($routeInfo["NamedParams"]["a"], 10);
            }
        }
    }
}