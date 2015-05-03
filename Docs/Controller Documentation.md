<h1 style="text-align:center">YourMVC</h1>
<h2 style="text-align:center">Documentation for Controllers</h2>
******
###Table of Content
* [Controllers](#TOC_Controllers)

<h4 id="TOC_Controllers">Controllers</h4>

YourMVC includes some built in controller functionality. Each controller class should go into it's own files (adhearing to PSR-4). Each controller should have the word controller at the end of it (for example, a controller named home should have the class name of HomeController).

Each controller should implement YourMVC\Libraries\BaseController. Actions can be called in one of two ways. The first is just the name of the action. For example, in the home controller may have an action called index, the name of the function would be Index. The second way it to prepend the method used to access the controller. In the previous example, assuming the method used is GET, the function can be called GET_Index.

Note that the controllers and actions are case sensitive.
******
<p class="footer" style="text-align:center">
Written on June 2, 2014 by Stephen
Modified on April 27, 2015 by Stephen
Version 0.4A
</p>
