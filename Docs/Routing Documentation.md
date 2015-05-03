<h1 style="text-align:center">YourMVC</h1>
<h2 style="text-align:center">Documentation for Routing</h2>
******
###Table of Content
* [Routing Configuration](#TOC_RoutingConfiguration)
    * [Routing Class](#TOC_RoutingClass)

<h4 id="TOC_RoutingConfiguration">Routing Configuration</h4>

There is currently no configuration for Routing. Instead, YourMVC assumes URL's are set up as www.example.com/index.php/{Controller}/{Action}/{Parameters...}, where parameters can be “/” delimited parameters

<h5 id="TOC_RoutingClass">Routing Class</h5>

The default routing class defines one static method, GetRoutingInfo, which takes $_SERVER['PATH_INFO'], the http method used, and the named parameters (either GET or POST).

This class will eventually contains methods to call a controller and action with the given parameters. It will also be used for a HTML link helper function.

******
<p class="footer" style="text-align:center">
Written on June 2, 2014 by Stephen
Modified on April 28, 2015 by Stephen
Version 0.4A
</p>
