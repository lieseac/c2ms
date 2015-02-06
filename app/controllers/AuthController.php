<?php

namespace Controllers;
use Models\User;
use Libraries\Authentication;

class AuthController extends BaseController
{
    public function login()
    {
        if (isset($_SESSION['uid'])) {
            // already logged in
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // login attempt
            $this->postLogin();
        } else {
            $this->layout('auth/login');
        }
    }
    
    protected function postLogin()
    {
        // user is not yet logged in, start validation
        $username   = filter_input(INPUT_POST, 'username');
        $password   = filter_input(INPUT_POST, 'password');

        // get user from database and match the hash
        $model = new User();
        $user = $model->getByName($username);
        
        if (Authentication::verify($password, $user['password'])) {
            // successful login
            session_regenerate_id(true);

            $_SESSION['uid'] = $user['id'];
            echo 'logged in';
        } else {
            // failed to login
            echo 'failed';
        }
    }
    
    public function logout()
    {
        session_destroy();
        
        $this->layout('auth/logout');
    }
}