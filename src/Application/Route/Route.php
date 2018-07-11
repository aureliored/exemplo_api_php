<?php

namespace Application\Route;

use Application\Controller\ApplicationController;

class Route 
{
	private $routes = [];
	private $modules; 
	private $application; 

	function __construct($modules)
	{
		$this->application = new ApplicationController();
		$this->modules = $modules;
	}

	public function load()
	{
		foreach($this->modules as $module){
			$file = __APP_ROOT__ . "\\src\\{$module}\\Config\\route.php";
			if(file_exists($file)) {
				$this->add($file);	
			}
		}

		return $this;
	}

	private function add($file)
	{	
		$routes = require $file;
		foreach($routes as $method => $route ){
			$this->on($method,$route);
		}	
	}

	public function on($method, $route) 
    { 
        $method = strtolower($method);
        if (!isset($this->routes[$method])) {
            $this->routes[$method] = [];
		}
		
        $uri = substr($route['path'], 0, 1) !== '/' ? '/' . $route['path'] : $route['path'];
        $pattern = str_replace('/', '\/', $uri);
        $call = '/^' . $pattern . '$/';
		
		$this->routes[$method][$call] = $route['callback'];
        return $this;
    }

	private function method()
    {
        return isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'cli';
    }

	private function uri()
    {
        $self = isset($_SERVER['PHP_SELF']) ? str_replace('index.php/', '', $_SERVER['PHP_SELF']) : '';
        $uri = isset($_SERVER['REQUEST_URI']) ? explode('?', $_SERVER['REQUEST_URI'])[0] : '';
        if ($self !== $uri) {
            $peaces = explode('/', $self);
            array_pop($peaces);
            $start = implode('/', $peaces);
            $search = '/' . preg_quote($start, '/') . '/';
            $uri = preg_replace($search, '', $uri, 1);
        }
        return $uri;
    }

	function run()
    {
		$uri = $this->uri();
        $method = $this->method();
        if (!isset($this->routes[$method])) {
			$this->application->error404Action();
			return $this;
		}
		
		$success = false;
        foreach ($this->routes[$method] as $route => $data) {
			if (preg_match($route, $uri, $parameters)) {
				array_shift($parameters);
				call_user_func_array($data,[]);
				return $this;
            }
		}
		
		$this->application->error404Action();
		return $this;
	}

}
