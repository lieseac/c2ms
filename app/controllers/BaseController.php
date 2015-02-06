<?php

namespace Controllers;
use Libraries\Router;

abstract class BaseController
{
    protected $arguments;
    
    protected $user;
    protected $router;
    protected $messenger;
    
    public function __construct(Router $route)
    {
        $this->user         =& $route->getUser();
        $this->messenger    =& $route->getMessenger();
        $this->router       = $route;
        ;
    }
    /**
     * Load view with optional arguments
     * 
     * @param type $view
     * @param type $args
     * @param type $return
     */
    protected function view($view, $args = [], $return = false)
    {        
        extract($args);
        
        ob_start();
        
        include(APP_PATH . '/views/' . $view . '.php');
        
        if ($return) {
            return ob_get_clean();
        } else {
            if (ob_get_level() > 1) {
                echo ob_get_clean();
            } else {
                return ob_flush();
            }
        }
    }
    
    public function attach($arguments)
    {
        $this->arguments = array_merge($this->arguments, $arguments);
    }
    
    public function __get($name) {
        return $this->arguments[$name];
    }
        
    protected function layout($view, $args = [], $return = false)
    {
        $content = $this->view($view, $args, true);
        return $this->view('layout', ['content' => $content, 'breadcrumbs' => $this->router->getCrumbs()], $return);
        
    }
    
    protected function route($route)
    {
        $this->router->dispatch($route);
        exit();
    }
    
    protected function abort()
    {
        http_response_code(404);
        $this->layout('exception\404');
        exit();
    }
    
}