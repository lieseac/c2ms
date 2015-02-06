<?php

namespace Libraries;
use Libraries\CurrentUser;

class Router
{
    
    protected $routes       = [];
    protected $arguments    = [];
    protected $path         = [];
    protected $level        = 0;
    
    protected $user;
    protected $messenger;
    
    public function __construct(CurrentUser $user, Messenger $messenger)
    {
        $this->user         = $user;
        $this->messenger    = $messenger;
        $this->next();
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function getMessenger()
    {
        return $this->messenger;
    }
    
    public function getCrumbs()
    {
        return $this->path;
    }
    
    public function subRoute()
    {
        $this->level++;
        $this->next();
        return $this;
    }
    
    protected function next()
    {
        $this->routes[$this->level]     = [];
        $this->arguments[$this->level]  = [];
    }
    
    /**
     * Add an url to the router (match is auto case-insensitive)
     * 
     * @param regex $path
     * @param type $action
     */
    public function add($path, $action, $callback = null)
    {
        $this->routes[$this->level][$path] = [$action, $callback];
    }
    
    public function attach($arguments)
    {
        $this->arguments[$this->level] = array_merge($this->arguments[$this->level], $arguments);
    }
    
    public function __get($name)
    {
        if (isset($this->arguments[$this->level][$name])) {
            return $this->arguments[$this->level][$name];
        } else {
            throw new \OutOfBoundsException($name . ' not found');
        }
    }
    
    /**
     * Call the correct controller according to this url
     */
    public function dispatch($currentPath = null, $args = [])
    {   
        if (is_null($currentPath)) {
            $currentPath    = CURRENT_URL;
        }
                
        $currentPath = explode('/', $currentPath);
        
        if ($this->level == 0) {
            $this->path     = $currentPath;
        }
        
        foreach($this->routes[$this->level] as $path => $route) {
            
            if ( $this->match($path, $currentPath, $args) == 1 ) {
                
                // transform the route into a class and method
                list($className, $method) = $route[0];
                
                // attach callback at the beginning of the arguments
                if ($route[1]) {                    
                    array_unshift($args, $route[1]);
                }

                // build the class
                $class = new $className($this);
                        
                // call the method with arguments
                call_user_func_array([$class, $method], $args);
                    
                break;
            }     
        }
    }
    
    protected function match($matchTo, $solution, &$args)
    {
        $matchTo = explode('/', $matchTo);
        $segCount = count($solution);
        
        if (count($matchTo) > $segCount) { return 0; }
        
        for ($i = 0; $i < $segCount; $i++)
        {
            if (!isset($matchTo[$i])  || ($matchTo[$i] == '*' && strlen($solution[$i]) > 0 ) ) {
                $args[] = $solution[$i];
                continue;
            }
            
            if ($matchTo[$i] != $solution[$i]) {
                return 0;
            }
        }
        
        return 1;
    }
}