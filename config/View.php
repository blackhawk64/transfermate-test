<?php

class View
{
    public function Render($view)
    {
        require_once "Views/{$view}.php";
    }
}