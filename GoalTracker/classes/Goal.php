<?php
// Goal class for goal-related operations
class Goal {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Create a new goal
    public function create($userId, $title, $description, $dueDate, $priority, $progress) {
        $this->db->query("INSERT INTO goals (user_id, title, description, due_date, priority, progress) VALUES (:user_id, :title, :description, :due_date, :priority, :progress)");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':title', $title);
        $this->db->bind(':description', $description);
        $this->db->bind(':due_date', $dueDate);
        $this->db->bind(':priority', $priority);
        $this->db->bind(':progress', $progress);
        
        if($this->db->execute()) {
            $goalId = $this->db->lastInsertId();
            logActivity($userId, 'goal_created', $goalId, "Created goal: $title");
            return $goalId;
        }
        return false;
    }
    
    // Update a goal
    public function update($goalId, $userId, $title, $description, $dueDate, $priority, $progress, $status) {
        $this->db->query("UPDATE goals SET title = :title, description = :description, due_date = :due_date, priority = :priority, progress = :progress, status = :status WHERE id = :id AND user_id = :user_id");
        $this->db->bind(':id', $goalId);
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':title', $title);
        $this->db->bind(':description', $description);
        $this->db->bind(':due_date', $dueDate);
        $this->db->bind(':priority', $priority);
        $this->db->bind(':progress', $progress);
        $this->db->bind(':status', $status);
        
        if($this->db->execute()) {
            logActivity($userId, 'goal_updated', $goalId, "Updated goal: $title");
            return true;
        }
        return false;
    }
    
    // Delete a goal
    public function delete($goalId, $userId) {
        $goal = $this->getGoalById($goalId, $userId);
        if(!$goal) return false;
        
        $this->db->query("DELETE FROM goals WHERE id = :id AND user_id = :user_id");
        $this->db->bind(':id', $goalId);
        $this->db->bind(':user_id', $userId);
        
        if($this->db->execute()) {
            logActivity($userId, 'goal_deleted', null, "Deleted goal: {$goal->title}");
            return true;
        }
        return false;
    }
    
    // Get goal by ID
    public function getGoalById($goalId, $userId) {
        $this->db->query("SELECT * FROM goals WHERE id = :id AND user_id = :user_id");
        $this->db->bind(':id', $goalId);
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }
    
    // Get all goals for user
    public function getAllGoals($userId, $status = 'active') {
        $this->db->query("SELECT * FROM goals WHERE user_id = :user_id AND status = :status ORDER BY due_date ASC");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':status', $status);
        return $this->db->resultSet();
    }
    
    // Get goals count by status
    public function getGoalsCount($userId) {
        $this->db->query("SELECT status, COUNT(*) as count FROM goals WHERE user_id = :user_id GROUP BY status");
        $this->db->bind(':user_id', $userId);
        $result = $this->db->resultSet();
        
        $counts = [
            'active' => 0,
            'completed' => 0,
            'archived' => 0
        ];
        
        foreach($result as $row) {
            $counts[$row->status] = $row->count;
        }
        
        return $counts;
    }
    
    // Get upcoming due goals
    public function getUpcomingGoals($userId, $days = 7) {
        $today = date('Y-m-d');
        $futureDate = date('Y-m-d', strtotime("+$days days"));
        
        $this->db->query("SELECT * FROM goals WHERE user_id = :user_id AND status = 'active' AND due_date BETWEEN :today AND :future_date ORDER BY due_date ASC");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':today', $today);
        $this->db->bind(':future_date', $futureDate);
        return $this->db->resultSet();
    }
    
    // Get overdue goals
    public function getOverdueGoals($userId) {
        $today = date('Y-m-d');
        
        $this->db->query("SELECT * FROM goals WHERE user_id = :user_id AND status = 'active' AND due_date < :today ORDER BY due_date ASC");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':today', $today);
        return $this->db->resultSet();
    }
    
    // Get goals for calendar
    public function getCalendarGoals($userId, $startDate, $endDate) {
        $this->db->query("SELECT id, title, due_date, priority FROM goals WHERE user_id = :user_id AND due_date BETWEEN :start_date AND :end_date ORDER BY due_date ASC");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);
        return $this->db->resultSet();
    }
    
    // Get recent activities
    public function getRecentActivities($userId, $limit = 5) {
        $this->db->query("SELECT a.*, g.title as goal_title FROM activities a LEFT JOIN goals g ON a.goal_id = g.id WHERE a.user_id = :user_id ORDER BY a.created_at DESC LIMIT :limit");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }
}
?>