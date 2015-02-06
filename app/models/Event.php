<?php

namespace Models;
use PDO;

class Event extends BaseModel
{
    
    public function all()
    {
        $sql = 'SELECT  i.id,
                        i.slug,
                        i.title,
                        e.description,
                        e.start,
                        e.end,
                        e.fullday,
                        e.attendance,
                        e.attend_end,
                        e.comment,
                        t.slug AS cat_slug,
                        t.title AS cat_title
                FROM events AS e
                JOIN items AS i ON e.id = i.item_id AND i.module = :model
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
                        e.description,
                        e.start,
                        e.end,
                        e.fullday,
                        e.attendance,
                        e.attend_end,
                        e.comment
                FROM events AS e
                JOIN items AS i ON e.id = iitem_id AND i.module = :model
                WHERE id = :id';
        
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
                        e.description,
                        e.start,
                        e.end,
                        e.fullday,
                        e.attendance,
                        e.attend_end,
                        e.comment
                FROM events AS e
                JOIN items AS i ON e.id = i.item_id AND i.module = :model
                WHERE i.slug = :slug';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindValue(':model', get_class(), PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    public function attendance($id)
    {
        $sql = 'SELECT  u.id,
                        u.name,
                        a.status 
                FROM attendances AS a
                JOIN users AS u ON u.id = a.user_id
                WHERE a.event_id = :id';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function attend($event_id, $user_id, $status)
    {
        $sql = 'INSERT INTO attendances (event_id, user_id, status) VALUES (:event_id, :user_id, :status) ON DUPLICATE KEY UPDATE status = :status';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status, PDO::PARAM_INT);
        $stmt->execute();
        
        return $this->db->lastInsertId();
    }

}

