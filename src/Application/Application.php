<?php
namespace Application;

use Application\Route\Route;

class Application 
{
    private $route;
    private $config;

    public function __construct()
    {
        $this->config = require __APP_ROOT__ . '\\config\\local.php';
        
        $this->route = new Route($this->config['module']);
    }
    

    public function init()
    {
        header('Content-Type: application/json');
        $this->route->load();
        return $this;
    }

    public function start(){
        $this->route->run();
    }
}