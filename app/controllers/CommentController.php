<?php

namespace Controllers;
use Libraries\Router;
use Models\Comment;

class CommentController extends BaseController
{
    protected $model;
    
    public function __construct(Router $route)
    {
        parent::__construct($route);
        $this->model = new Comment();
    }
    
    public function postComment($slug)
    {
        $item = $this->model->getItemBySlug($slug);
        
        if ($item != false) {
                        
            // TODO verify if this user is allowed to post commments
            
            $params['user_id'] = $this->user->getId();
            $params['item_id'] = $item['id'];
            $params['comment'] = $_POST['comment'];
            
            $this->model->post($params);
            
        } else {
            // item is not found so we can not comment on it
            $this->abort();
        }
    }
}