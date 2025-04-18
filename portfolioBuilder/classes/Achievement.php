<?php
class Achievement {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Ensure the Database object is instantiated
    }

    // Add a new achievement
    public function addAchievement($userId, $title, $description, $dateAchieved, $category, $imageUrl, $isFeatured) {
        try {
            $sql = "INSERT INTO achievements (user_id, title, description, date_achieved, category, image_url, is_featured) 
                    VALUES (:user_id, :title, :description, :date_achieved, :category, :image_url, :is_featured)";
            
            // Prepare the query
            $this->db->query($sql);
            
            // Bind the parameters
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':title', $title);
            $this->db->bind(':description', $description);
            $this->db->bind(':date_achieved', $dateAchieved);
            $this->db->bind(':category', $category);
            $this->db->bind(':image_url', $imageUrl);
            $this->db->bind(':is_featured', $isFeatured ? 1 : 0);
            
            // Execute the query
            $this->db->execute();
            
            // Return the last inserted ID
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error adding achievement: " . $e->getMessage());
            return false;
        }
    }
    
    // Update an existing achievement
    public function updateAchievement($achievementId, $userId, $title, $description, $dateAchieved, $category, $imageUrl, $isFeatured) {
        try {
            $sql = "UPDATE achievements 
                    SET title = :title, 
                        description = :description, 
                        date_achieved = :date_achieved, 
                        category = :category, 
                        image_url = :image_url, 
                        is_featured = :is_featured,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = :id AND user_id = :user_id";
    
            $this->db->query($sql);
    
            // Log the SQL query and parameters
            error_log("SQL Query: " . $sql);
            error_log("Achievement ID: " . $achievementId);
            error_log("User ID: " . $userId);
            error_log("Title: " . $title);
            error_log("Description: " . $description);
            error_log("Date Achieved: " . $dateAchieved);
            error_log("Category: " . $category);
            error_log("Image URL: " . $imageUrl);
            error_log("Is Featured: " . $isFeatured);
    
            // Bind the parameters
            $this->db->bind(':id', $achievementId);
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':title', $title);
            $this->db->bind(':description', $description);
            $this->db->bind(':date_achieved', $dateAchieved);
            $this->db->bind(':category', $category);
            $this->db->bind(':image_url', $imageUrl);
            $this->db->bind(':is_featured', $isFeatured ? 1 : 0);
    
            // Execute the query
            $this->db->execute();
    
            // Log the number of rows affected
            $rowCount = $this->db->rowCount();
            error_log("Rows updated: " . $rowCount);
    
            return $rowCount > 0;
        } catch (PDOException $e) {
            error_log("Error updating achievement: " . $e->getMessage());
            return false;
        }
    }
    
    // Delete an achievement
    public function deleteAchievement($achievementId, $userId) {
        try {
            $sql = "DELETE FROM achievements WHERE id = :id AND user_id = :user_id";
            
            // Prepare the query
            $this->db->query($sql);
            
            // Bind the parameters
            $this->db->bind(':id', $achievementId);
            $this->db->bind(':user_id', $userId);
            
            // Execute the query
            $this->db->execute();
            
            // Return true if rows were deleted
            return $this->db->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error deleting achievement: " . $e->getMessage());
            return false;
        }
    }
    
    // Get a specific achievement
    public function getAchievement($achievementId, $userId) {
        try {
            $sql = "SELECT * FROM achievements WHERE id = :id AND user_id = :user_id LIMIT 1";
            
            // Prepare the query
            $this->db->query($sql);
            
            // Bind the parameters
            $this->db->bind(':id', $achievementId);
            $this->db->bind(':user_id', $userId);
            
            // Return the single result
            return $this->db->single();
        } catch (PDOException $e) {
            error_log("Error getting achievement: " . $e->getMessage());
            return false;
        }
    }
    
    // Get all achievements for a user
    public function getUserAchievements($userId, $category = '') {
        try {
            $sql = "SELECT * FROM achievements WHERE user_id = :user_id";
            
            // Add category filter if provided
            if (!empty($category)) {
                $sql .= " AND category = :category";
            }
            
            $sql .= " ORDER BY date_achieved DESC";
            
            // Prepare the query
            $this->db->query($sql);
            
            // Bind the parameters
            $this->db->bind(':user_id', $userId);
            if (!empty($category)) {
                $this->db->bind(':category', $category);
            }
            
            // Return the result set
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log("Error in getUserAchievements: " . $e->getMessage());
            return [];
        }
    }
    
    // Get featured achievements for a user
    public function getFeaturedAchievements($userId) {
        try {
            $sql = "SELECT * FROM achievements 
                    WHERE user_id = :user_id AND is_featured = 1 
                    ORDER BY date_achieved DESC 
                    LIMIT 10";
            
            // Prepare the query
            $this->db->query($sql);
            
            // Bind the parameters
            $this->db->bind(':user_id', $userId);
            
            // Return the result set
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log("Error getting featured achievements: " . $e->getMessage());
            return [];
        }
    }
    
    // Get all unique categories for a user's achievements
    public function getAchievementCategories($userId) {
        try {
            $sql = "SELECT DISTINCT category FROM achievements 
                    WHERE user_id = :user_id AND category IS NOT NULL AND category != '' 
                    ORDER BY category";
            
            // Prepare the query
            $this->db->query($sql);
            
            // Bind the parameters
            $this->db->bind(':user_id', $userId);
            
            // Fetch the results
            $results = $this->db->resultSet();
            $categories = [];
            
            foreach ($results as $row) {
                $categories[] = $row->category;
            }
            
            return $categories;
        } catch (PDOException $e) {
            error_log("Error getting achievement categories: " . $e->getMessage());
            return [];
        }
    }
}