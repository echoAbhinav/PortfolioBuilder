<?php
class Skill {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Add a new skill for the user
     */
    public function addSkill($userId, $skillName, $proficiency, $category, $description) {
        try {
            $this->db->query('INSERT INTO skills (user_id, skill_name, proficiency, category, description, created_at, updated_at) 
                            VALUES (:user_id, :skill_name, :proficiency, :category, :description, NOW(), NOW())');
            
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':skill_name', htmlspecialchars($skillName));
            $this->db->bind(':proficiency', $proficiency);
            $this->db->bind(':category', htmlspecialchars($category));
            $this->db->bind(':description', htmlspecialchars($description));
            
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Error adding skill: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update an existing skill
     */
    public function updateSkill($skillId, $userId, $skillName, $proficiency, $category, $description) {
        try {
            $this->db->query('UPDATE skills 
                            SET skill_name = :skill_name, 
                                proficiency = :proficiency, 
                                category = :category, 
                                description = :description, 
                                updated_at = NOW() 
                            WHERE id = :id AND user_id = :user_id');
            
            $this->db->bind(':id', $skillId);
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':skill_name', htmlspecialchars($skillName));
            $this->db->bind(':proficiency', $proficiency);
            $this->db->bind(':category', htmlspecialchars($category));
            $this->db->bind(':description', htmlspecialchars($description));
            
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Error updating skill: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Delete a skill
     */
    public function deleteSkill($skillId, $userId) {
        try {
            $this->db->query('DELETE FROM skills WHERE id = :id AND user_id = :user_id');
            
            $this->db->bind(':id', $skillId);
            $this->db->bind(':user_id', $userId);
            
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Error deleting skill: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get all skills for a user, optionally filtered by category
     */
    public function getUserSkills($userId, $category = '') {
        try {
            if (empty($category)) {
                $this->db->query('SELECT * FROM skills WHERE user_id = :user_id ORDER BY category, skill_name');
                $this->db->bind(':user_id', $userId);
            } else {
                $this->db->query('SELECT * FROM skills WHERE user_id = :user_id AND category = :category ORDER BY skill_name');
                $this->db->bind(':user_id', $userId);
                $this->db->bind(':category', $category);
            }
            
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log("Error getting user skills: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get a single skill by ID
     */
    public function getSkillById($skillId, $userId) {
        try {
            $this->db->query('SELECT * FROM skills WHERE id = :id AND user_id = :user_id');
            
            $this->db->bind(':id', $skillId);
            $this->db->bind(':user_id', $userId);
            
            return $this->db->single();
        } catch (PDOException $e) {
            error_log("Error getting skill by ID: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get all unique skill categories for a user
     */
    public function getSkillCategories($userId) {
        try {
            $this->db->query('SELECT DISTINCT category FROM skills WHERE user_id = :user_id AND category IS NOT NULL AND category != "" ORDER BY category');
            
            $this->db->bind(':user_id', $userId);
            
            $results = $this->db->resultSet();
            $categories = [];
            
            foreach ($results as $row) {
                $categories[] = $row->category;
            }
            
            return $categories;
        } catch (PDOException $e) {
            error_log("Error getting skill categories: " . $e->getMessage());
            return [];
        }
    }
}