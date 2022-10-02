<?php
require 'View.php';

class Controller
{
    protected $View;

    public function __construct()
    {
        $this->View = new View();
    }
}