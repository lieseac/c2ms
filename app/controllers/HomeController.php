<?php

namespace Controllers;

class HomeController extends BaseController
{
    
    public function getIndex()
    {
        $this->layout('home/timeline');
    }
    
}