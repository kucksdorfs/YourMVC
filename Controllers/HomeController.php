<?php
namespace YourMVC\Controllers
{

    class HomeController extends \YourMVC\Libraries\BaseController
    {

        public function GET_Index()
        {
            header("Content-type: text/plain");
            return "Welcome to YourMVC!\nVersion 0.4a";
        }
    }
}