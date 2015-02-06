<?php

namespace Libraries;
use Models\User;

class CurrentUser
{
    
    protected $rights = [];
    protected $categories = [];
    
    protected static $self;
    
    public function __construct()
    {
        $this->update();        
    }
    
    public function update()
    {
        $this->rights = [];
        $this->categories = [];
        
        $user_id = $this->getId();
        
        $this->register($user_id);
    }
    
    public function getId()
    {
        $user_id = 0;
        
        if (isset($_SESSION['uid'])) {
            $user_id = $_SESSION['uid'];
        }
        
        return $user_id;
    }
    
    public function isGuest()
    {
        return $this->getId() == 0;
    }
    
    protected function register($user_id)
    {
        $model  = new User();
        $rights = $model->getRights($user_id);
        
        // flatten rights
        $this->rights = $this->flattenRights($rights);
        
        // find all the view rights
        $viewRights = [];
        foreach ($rights as $right) {
            if (strpos($right['permission'], '.view')) {
                $viewRights[] = $rights['topic_id'];
            }
        }
        $this->categories = $viewRights;
    }
    
    protected function flattenRights($rights)
    {
        $result = [];
        
        foreach ($rights as $right) {
            if ( isset($right['category_id']) ) {
                $result[] = $right['category_id'] . '.' . $right['permission'];
            } else {
                $result[] = $right['permission'];
            }
        }
        
        $result = array_unique($result);
        
        return $result;
    }
    
    public function can($action, $category_id = false)
    {   
        $result = false;
        
        // check for category level permission
        if ($category_id) {
            $result = in_array($category_id . '.' . $action, $this->rights);
        }
        // no category level permission found, so we use global
        if ($result === false && !is_null($this->rights)) {
            $result = in_array($action, $this->rights);
        }
        return $result;
    }
    
    public function categories()
    {
        return $this->categories;
    }
}