<?php
namespace Application;

use Application\Route\Route;

class Application 
{
    private $route;

    public function __construct()
    {
        $this->route = new Route();
    }

    public function init()
    {
        echo "iniciado";
    }
}