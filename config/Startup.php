<?php
require 'Controllers/HomeController.php';

class AppStartup
{
    public function __construct()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        if(count($url) <= 2)
        {
            if(empty($url[0]))
            {
                $controller = new HomeController();
                $controller->Index();
                return false;
            }

            $fileController = 'Controllers/' . $url[0] . 'Controller.php';
            $class = $url[0] . 'Controller';

            if(file_exists($fileController))
            {
                require_once $fileController;
                $controller = new $class;

                if(isset($url[1]))
                {
                    if(method_exists($controller,$url[1]))
                    {
                        $controller->{$url[1]}();
                    }
                    else
                    {
                        $controller = new HomeController();
                        $controller->Error();
                    }
                }
                else
                {
                    $controller->Index();
                }
            }
            else
            {
                $controller = new HomeController();
                $controller->Error();
            }
        }
        else
        {
            $controller = new HomeController();
            $controller->Error();
        }
    }
}
