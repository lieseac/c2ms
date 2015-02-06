<?php

namespace Models;
use PDO;

class User extends BaseModel
{
    public function get($id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    public function getRights($user_id)
    {
        $sql = 'SELECT p.permission, t.slug AS category_id
                FROM usergroup_permissions AS up
                JOIN user_usergroups AS uu ON uu.usergroup_id = up.usergroup_id
                JOIN permissions AS p ON up.permission_id = p.id
                LEFT JOIN topics AS t ON up.topic_id = t.id
                WHERE uu.user_id = :user_id
                GROUP BY p.permission, t.id';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function getByName($name)
    {
        $sql = 'SELECT * FROM users WHERE name = :name';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    public function profile($id)
    {
        $sql = 'SELECT * FROM profile WHERE user_id = :id';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}