<?php

namespace Controllers;
use Models\User;
use Libraries\Authentication;
use Libraries\Router;

class UserController extends BaseController
{
    protected $model;
    
    public function __construct(Router $route)
    {
        parent::__construct($route);
        $this->model = new User();
    }
    
    public function index()
    {
        
    }
    
    public function getMe()
    {        
        if ( $this->user->isGuest() ) {
            // not logged in redirect to login page
            $this->route('login');
            
        } else {
            
            // logged, so lets show the profile
            $user = $this->model->get($this->user->getId() );
            
            if ($user != false) {
                
                $this->layout('user/profile', $user);
                
            } else {
                
                $this->abort();
            }
        }
    }
    
    public function getShow($name)
    {
        $user = $this->model->getByUsername($name);
        
        if ($user != false) {
            // article found, render
            $this->layout('user/profile', $user);
        } else {
            // article not found return 404
            $this->abort();
            
        }
    }
    
    public function postRegister()
    {
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        
        $hash = Authentication::generate($password);
        
        $user = compact('username', 'hash');
        
        $this->model->register($user);
    }
}