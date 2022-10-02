<?php
require_once 'config/Controller.php';

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function Index()
    {
        $this->View->Render("Home/Index");
    }
}