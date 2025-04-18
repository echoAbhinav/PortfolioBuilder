# PortfolioBuilder
⚙️ Tech Stack Used

Layer and Technologies
Frontend-HTML, Tailwind CSS, JavaScript
Backend-PHP
Database-MySQL

DATABASE NAME-
```
goaltrack_pro
```
MYSQL CODE TO ADD IN DATABASE
```
CREATE DATABASE goaltrack_pro;
USE goaltrack_pro;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    dark_mode BOOLEAN DEFAULT FALSE
);

CREATE TABLE goals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    due_date DATE,
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    progress INT DEFAULT 0,
    status ENUM('active', 'completed', 'archived') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    activity_type VARCHAR(50) NOT NULL,
    goal_id INT,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (goal_id) REFERENCES goals(id) ON DELETE SET NULL
);
CREATE TABLE IF NOT EXISTS skills (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  skill_name varchar(100) NOT NULL,
  proficiency int(11) NOT NULL DEFAULT 5,
  category varchar(100) DEFAULT NULL,
  description text DEFAULT NULL,
  created_at datetime NOT NULL,
  updated_at datetime NOT NULL,
  PRIMARY KEY (id),
  KEY user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add constraint to ensure skills are deleted when user is deleted
ALTER TABLE skills
  ADD CONSTRAINT skills_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE;

CREATE TABLE IF NOT EXISTS achievements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    date_achieved DATE NOT NULL,
    category VARCHAR(50),
    image_url VARCHAR(255),
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```
Structure of code 
```
portfolioBuilder/
│
├── ajax/                       # AJAX endpoints
│   ├── get_achievement.php
│   └── get_skill.php
│
├── assets/                     # Static assets
│   ├── images/                 # Avatars and project images
│   └── js/
│       └── main.js             # Custom JS logic
│
├── classes/                    # Core logic classes
│   ├── Achievement.php
│   ├── CSRF.php
│   ├── Goal.php
│   └── skill.php
│
├── includes/                   # Reusable includes
│   ├── auth.php
│   ├── config.php
│   ├── db.php
│   ├── footer.php
│   ├── functions.php
│   ├── header.php
│   ├── sidebar.php
│   └── topnav.php
│
├── achievements.php            # User achievements page
├── add_goal.php                # Form to add goals
├── dashboard.php               # Main dashboard
├── delete_goal.php             # Delete a goal
├── edit_goal.php               # Edit a goal
├── goals.php                   # Goal listing
├── index.php                   # Entry point
├── landing.php                 # Landing page
├── login.php                   # Login page
├── logout.php                  # Logout handler
├── profile.php                 # User profile
├── register.php                # Register page
├── report.txt                  # Development report or logs
├── skills.php                  # User skills page
├── update_dark_mode.php        # Toggle dark mode
└── README.md                   # Project overview

```
✨ Key Features
🔓 Authentication System:-
Sign Up: Users can register using their name, email, and password.
Sign In: Secure login system using PHP & MySQL.
Redirect to Dashboard after login for personalized experience.

🏠 Landing Page:-
Introductory screen to show what the platform offers.
Highlights features like project management, skill tracking, and achievement uploads.

📊 Dashboard:-
Central hub of the platform.

Displays:-
Active Projects with progress bars and priority tags.
Completed Projects
Recent Activity Logs

📌 Projects Management:-
Add, edit, and delete projects.
Each project shows:
Name, description
Due date, status
Progress bar
Priority label (High/Medium/Low)

🧠 Skills Section:-
Add technical or soft skills.
Select proficiency: Beginner, Intermediate, Expert.
Skill-based self-evaluation system.

🏆 Achievements Section:-
Upload certificates, awards, or project screenshots.
Add a short description for each.
Great for showcasing:

Certifications:-
Hackathon wins
Internship completions
Personal milestones

⚙️ Settings Page:-
Change username and email.
Update/reset password with validation.
Keep user data secure and customizable.

![image](https://github.com/user-attachments/assets/00501e8a-ba46-4a0a-9546-9b5c0f4a5ca8)
![image](https://github.com/user-attachments/assets/f36b7a8b-d4ff-471e-85d3-a508f26902bf)
![image](https://github.com/user-attachments/assets/4adbdc8f-ee17-45f4-be93-71e8a4c89b4e)
![image](https://github.com/user-attachments/assets/5d73584e-1c9c-4508-9102-a1090d296d84)
![image](https://github.com/user-attachments/assets/d7e7c3b6-0e82-4eba-a1ca-b3ae3ff9e580)

