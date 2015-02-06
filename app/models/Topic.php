<?php
namespace Models;
use PDO;

class Topic extends BaseModel
{
    
    public function all()
    {
        $sql = 'SELECT * FROM topics';
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();        
    }
    
    public function get($id)
    {
        $sql = 'SELECT * FROM topics WHERE id = :id LIMIT 0,1';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    public function getItemThroughTopic($topic_slug, $item_slug)
    {
        $topic = $this->getBySlug($topic_slug);

        if ($topic) {
            $item = $this->getItemFrom($topic['id'], $item_slug);
            
            $item['topic'] = $topic;
            
            return $item;
        }
        
        return false;
    }
    
    public function getItem($module, $id)
    {
        $model = new $module();
        return $model->get($id);
    }
    
    public function getItems($topic_id)
    {
        $sql = 'SELECT * FROM item_topics 
                JOIN items ON item_topics.item_id = items.id
                WHERE topic_id = :topic_id';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':topic_id', $topic_id, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function getBySlug($slug)
    {
        $sql = 'SELECT * FROM topics WHERE slug = :slug';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch();        
    }
    
    public function getItemFrom($topic_id, $item_slug)
    {
        $sql = 'SELECT items.module, items.item_id 
                FROM items
                JOIN item_topics ON item_topics.topic_id = :topic_id AND item_topics.item_id = items.id
                WHERE items.slug = :slug';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':topic_id', $topic_id, PDO::PARAM_INT);
        $stmt->bindValue(':slug', $item_slug, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(); 
    }
}