<?php

namespace Controllers;
use Libraries\Router;
use Models\Article;
use Models\Comment;

class ArticleController extends BaseController
{
    protected $model;
    
    public function __construct(Router $route)
    {
        parent::__construct($route);
        $this->model = new Article();
    }
    
    /**
     * Display all articles
     */
    public function getIndex()
    {        
        $articles   = $this->model->all($this->user->categories());

        if ($articles != false) {
            
            array_walk($articles, [$this, 'parseItems'] );

            $this->layout('article/list-articles', ['articles' => $articles]);
        } else {
            
            $this->abort();
        }
    }
    
    public function getForm()
    {
        // TODO verify the user can do this
        
        // TODO add script to head to load the editor
        
        
        $this->layout('article/single-article', ['title' => '', 'content' => '', 'comment' => 0]);
    }
    
    /**
     * Display an article
     * 
     * @param type $id
     */
    public function getShow($slug)
    {              
        $article = $this->model->getBySlug($slug);
        
        if ($article != false ) {
            
            if ($this->user->can('article.comment') && $article['comment']) {
                $commentModel = new Comment;
                $article['comments'] = $commentModel->getFor($article['id']);
            }
            
            // article found, render
            $this->layout('article/single-article', $article);
        } else {
            // article not found return 404
            $this->abort();
        }
    }
    
    
    protected function parseItems(&$item, $key)
    {
        $item['url'] = url( $item['cat_slug'] . '/' . $item['slug']);
    }
}