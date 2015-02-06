<?php

namespace Controllers;
use Models\Topic;
use Libraries\Router;

class TopicController extends BaseController
{
    protected $model;
    
    public function __construct(Router $route)
    {
        parent::__construct($route);
        $this->model = new Topic();
    }
    
    public function route($callback, $topic_slug, $item_slug, $action = "")
    {

        // get item from topic
        $topic = $this->model->getItemThroughTopic($topic_slug, $item_slug);

        if ($topic != false) {
            
            // route through callback
            $route = $this->router->subRoute();

            $route->attach($topic);

            $callback($route);
            
            $route->dispatch($action, [$item_slug]);
        } else {
            // not found
            $this->abort();
        }
    }
    
    /**
     * Display all articles
     */
    public function getIndex()
    {
         $topics = $this->model->all();
         
         if ($topics != false) {
             $this->layout('topic/list-topic', ['topics' => $topics]);
         } else {
             $this->abort();
         }
    }
    
    /**
     * Display an article
     * 
     * @param type $id
     */
    public function getShow($slug)
    {
        $category = $this->model->getBySlug($slug);

        if ($category != false) {
            // get items with this topic
            $items = $this->model->getItems($category['id']);

            array_walk($items, [$this, 'parseItems'], $category['slug'] );
            
            $category['items'] = $items;
            
            // topic found, render
            $this->layout('topic/single-topic', $category);
        } else {
            // article not found return 404
            $this->abort();
        }
    }
    
    protected function parseItems(&$item, $key, $category)
    {
        $item['url'] = url($item['slug'], true);
    }
}