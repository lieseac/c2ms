<?php
namespace Models;
use PDO;

class Article extends BaseModel
{    
    public function all()
    {
        $sql = 'SELECT  i.id,
                        i.slug,
                        i.title,
                        a.content,
                        a.comment,
                        t.slug AS cat_slug,
                        t.title AS cat_title
                FROM articles AS a
                JOIN items AS i ON a.id = i.item_id AND i.module = :model
                JOIN item_topics AS it ON it.item_id = i.id
                JOIN topics AS t ON t.id = it.topic_id
                WHERE t.category = 1';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':model', get_class(), PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll();        
    }
    
    public function get($id)
    {
        $sql = 'SELECT  i.id,
                        i.slug,
                        i.title,
                        a.content,
                        a.comment 
                FROM articles
                JOIN items ON articles.id = items.item_id AND items.module = :model
                WHERE articles.id = :id';

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':model', get_class(), PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();
    }
    
    public function getBySlug($slug)
    {
        $sql = 'SELECT  i.id,
                        i.slug,
                        i.title,
                        a.content,
                        a.comment
                FROM articles AS a
                JOIN items AS i ON a.id = i.item_id AND i.module = :model
                WHERE i.slug = :slug';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindValue(':model', get_class(), PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch();        
    }
}