<?php
namespace YourMVC\Libraries
{

    class BaseController extends \YourMVC\Libraries\Interfaces\Base
    {

        protected $activeView = null;

        protected $myModel = null;

        protected function View($view = "", $model = null)
        {
            $this->activeView = $view;
            $this->myModel = $model;
            
            return array(
                "View" => $this->activeView,
                "Controller" => get_class($this),
                "Model" => $this->myModel
            );
        }

        function __construct()
        {}

        public function Error404()
        {
            header('HTTP/1.0 404 Not Found');
            echo 'The controller/action pair could not be found.';
        }

        public function Error500()
        {
            header('HTTP/1.1 500 Internal Server Error');
            echo 'There was an internal error.';
        }
    }
}