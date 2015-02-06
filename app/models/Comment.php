<?php

namespace Models;
use PDO;

class Comment extends BaseModel
{
    public function getItemBySlug($slug)
    {
        $sql = 'SELECT id FROM items WHERE slug = :slug';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    public function post($params)
    {
        $sql = 'INSERT INTO comments (item_id, user_id, comment) VALUES (:item_id, :user_id, :comment)';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':item_id', $params['item_id'], PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $params['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':comment', $params['comment'], PDO::PARAM_STR);
        $stmt->execute();
        
        return $this->db->lastInsertId();
    }
    
    public function update($id, $params)
    {
        $sql = 'UPDATE comments SET comment = :comment WHERE id = :id';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':comment', $params['comment'], PDO::PARAM_STR);
        $stmt->execute();
    }
    
    public function delete($id)
    {
        $sql = 'DELETE FROM comments WHERE id = :id';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    public function getFor($item_id)
    {
        $sql = 'SELECT * FROM comments WHERE item_id = :item_id';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':item_id', $item_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function get($id)
    {
        $sql = 'SELECT * FROM comments WHERE id = :id LIMIT 0,1';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        return $stmt->fetch();
    }
}