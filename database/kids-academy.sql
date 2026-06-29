USE mugahdeeptech;

CREATE TABLE IF NOT EXISTS badges (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    slug VARCHAR(140) NOT NULL UNIQUE,
    description VARCHAR(255) NOT NULL,
    icon VARCHAR(40) NOT NULL DEFAULT '⭐',
    color VARCHAR(20) NOT NULL DEFAULT '#7c3aed',
    criteria VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS kids_courses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    slug VARCHAR(190) NOT NULL UNIQUE,
    short_description VARCHAR(300) NOT NULL,
    description LONGTEXT NOT NULL,
    age_group ENUM('6-8','9-12','13-15','All') NOT NULL DEFAULT 'All',
    difficulty VARCHAR(40) NOT NULL DEFAULT 'Beginner',
    duration VARCHAR(80) NOT NULL DEFAULT '30 minutes',
    icon VARCHAR(40) NOT NULL DEFAULT '🤖',
    theme_color VARCHAR(20) NOT NULL DEFAULT '#6757f5',
    thumbnail VARCHAR(255) NULL,
    learning_outcomes LONGTEXT NULL,
    status ENUM('Draft','Published') NOT NULL DEFAULT 'Published',
    sort_order INT UNSIGNED NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS kids_lessons (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_id INT UNSIGNED NOT NULL,
    title VARCHAR(180) NOT NULL,
    slug VARCHAR(190) NOT NULL,
    story_title VARCHAR(180) NULL,
    story_text LONGTEXT NOT NULL,
    learning_blocks LONGTEXT NULL,
    animation_type ENUM('robot','computer','code','safety','robotics','creative','lottie','video','image') NOT NULL DEFAULT 'robot',
    animation_source VARCHAR(500) NULL,
    narration_text LONGTEXT NULL,
    media_path VARCHAR(255) NULL,
    duration VARCHAR(80) NOT NULL DEFAULT '10 minutes',
    sort_order INT UNSIGNED NOT NULL DEFAULT 1,
    status ENUM('Draft','Published') NOT NULL DEFAULT 'Published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_kids_course_lesson (course_id, slug),
    CONSTRAINT fk_kids_lessons_course FOREIGN KEY (course_id) REFERENCES kids_courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS kids_quizzes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_id INT UNSIGNED NOT NULL,
    lesson_id INT UNSIGNED NULL,
    title VARCHAR(180) NOT NULL,
    pass_mark INT UNSIGNED NOT NULL DEFAULT 70,
    badge_id INT UNSIGNED NULL,
    status ENUM('Draft','Published') NOT NULL DEFAULT 'Published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_kids_quiz_course FOREIGN KEY (course_id) REFERENCES kids_courses(id) ON DELETE CASCADE,
    CONSTRAINT fk_kids_quiz_lesson FOREIGN KEY (lesson_id) REFERENCES kids_lessons(id) ON DELETE CASCADE,
    CONSTRAINT fk_kids_quiz_badge FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS kids_quiz_questions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT UNSIGNED NOT NULL,
    question TEXT NOT NULL,
    options_json LONGTEXT NOT NULL,
    correct_answer VARCHAR(255) NOT NULL,
    explanation TEXT NOT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 1,
    CONSTRAINT fk_kids_question_quiz FOREIGN KEY (quiz_id) REFERENCES kids_quizzes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS kids_activities (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_id INT UNSIGNED NOT NULL,
    lesson_id INT UNSIGNED NULL,
    title VARCHAR(180) NOT NULL,
    instructions TEXT NOT NULL,
    activity_type ENUM('matching','flashcards','coding','quiz') NOT NULL DEFAULT 'matching',
    config_json LONGTEXT NOT NULL,
    badge_id INT UNSIGNED NULL,
    status ENUM('Draft','Published') NOT NULL DEFAULT 'Published',
    sort_order INT UNSIGNED NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_kids_activity_course FOREIGN KEY (course_id) REFERENCES kids_courses(id) ON DELETE CASCADE,
    CONSTRAINT fk_kids_activity_lesson FOREIGN KEY (lesson_id) REFERENCES kids_lessons(id) ON DELETE CASCADE,
    CONSTRAINT fk_kids_activity_badge FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS learner_progress (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    learner_id INT UNSIGNED NOT NULL,
    course_id INT UNSIGNED NOT NULL,
    lesson_id INT UNSIGNED NULL,
    activity_id INT UNSIGNED NULL,
    status ENUM('started','completed') NOT NULL DEFAULT 'started',
    score INT UNSIGNED NULL,
    completed_at TIMESTAMP NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_kids_progress (learner_id, lesson_id, activity_id),
    CONSTRAINT fk_kids_progress_learner FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
    CONSTRAINT fk_kids_progress_course FOREIGN KEY (course_id) REFERENCES kids_courses(id) ON DELETE CASCADE,
    CONSTRAINT fk_kids_progress_lesson FOREIGN KEY (lesson_id) REFERENCES kids_lessons(id) ON DELETE CASCADE,
    CONSTRAINT fk_kids_progress_activity FOREIGN KEY (activity_id) REFERENCES kids_activities(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS learner_badges (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    learner_id INT UNSIGNED NOT NULL,
    badge_id INT UNSIGNED NOT NULL,
    awarded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_learner_badge (learner_id, badge_id),
    CONSTRAINT fk_kids_learner_badge_learner FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
    CONSTRAINT fk_kids_learner_badge_badge FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS kids_guardian_profiles (
    learner_id INT UNSIGNED PRIMARY KEY,
    guardian_email VARCHAR(190) NOT NULL,
    age_group ENUM('6-8','9-12','13-15') NOT NULL,
    consent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_kids_guardian_learner FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO badges (name, slug, description, icon, color, criteria) VALUES
('AI Explorer', 'ai-explorer', 'Completed the first AI lesson and activity.', '🤖', '#6757f5', 'Complete What is AI?'),
('Code Starter', 'code-starter', 'Solved a first coding puzzle.', '💻', '#0ea5e9', 'Complete a coding activity'),
('Safety Star', 'safety-star', 'Learned how to make safe choices online.', '🛡️', '#16a34a', 'Complete Internet Safety')
ON DUPLICATE KEY UPDATE name=VALUES(name), description=VALUES(description);

INSERT INTO kids_courses (title,slug,short_description,description,age_group,difficulty,duration,icon,theme_color,learning_outcomes,sort_order) VALUES
('Introduction to Computers','introduction-to-computers','Meet the parts of a computer and discover how they work together.','A friendly first journey through screens, keyboards, memory, files, and the clever instructions that make computers useful.','6-8','Beginner','6 lessons · 45 min','🖥️','#0ea5e9','Name key computer parts\nExplain input and output\nCreate and save a simple file',1),
('Coding for Kids','coding-for-kids','Build sequences, spot patterns, and give a character clear instructions.','Children learn coding through movement, colorful blocks, patterns, loops, and tiny puzzles—no prior experience needed.','6-8','Beginner','8 lessons · 60 min','🧩','#f97316','Create a sequence\nUse a loop\nDebug a simple puzzle',2),
('AI for Beginners','ai-for-beginners','Teach a friendly robot using examples and explore how AI makes predictions.','A story-led introduction to artificial intelligence, examples, patterns, predictions, creativity, and responsible use.','9-12','Beginner','7 lessons · 55 min','🤖','#6757f5','Describe AI in simple words\nTrain a pretend model with examples\nExplain why people guide AI',3),
('Internet Safety','internet-safety','Become a web safety hero with strong passwords and smart choices.','Practical, calm guidance on privacy, trusted adults, kind communication, suspicious links, and safe browsing.','9-12','Beginner','6 lessons · 45 min','🛡️','#16a34a','Protect private information\nRecognize unsafe messages\nAsk a trusted adult for help',4),
('Robotics Basics','robotics-basics','Explore sensors, motors, and the instructions that help robots move.','A playful robotics track connecting code to real-world machines through missions and design challenges.','9-12','Beginner','7 lessons · 60 min','⚙️','#eab308','Identify sensors and motors\nPlan a robot mission\nTest and improve instructions',5),
('Creative Digital Projects','creative-digital-projects','Make digital stories, animations, posters, and imaginative tech projects.','A creative studio for combining art, storytelling, safe media, simple animation, and presentation skills.','13-15','Beginner','8 lessons · 75 min','🎨','#ec4899','Plan a digital project\nCreate an animated story\nShare work safely and kindly',6)
ON DUPLICATE KEY UPDATE title=VALUES(title), short_description=VALUES(short_description), description=VALUES(description);

INSERT INTO kids_lessons (course_id,title,slug,story_title,story_text,learning_blocks,animation_type,narration_text,duration,sort_order)
SELECT id,'What is AI?','what-is-ai','Amani and the Fruit-Sorting Robot','Meet Amani, a curious child who teaches a robot how to recognize fruits. Amani shows the robot many examples: round red apples, long yellow bananas, and bumpy orange oranges. Each example helps the robot notice a pattern. When it sees a new fruit, it makes its best prediction—and Amani checks whether it was right.','[{"title":"Look at examples","text":"AI learns patterns from examples people choose."},{"title":"Make a prediction","text":"The robot uses a pattern to make its best guess."},{"title":"Check and improve","text":"People test the answer and help the AI improve."}]','robot','AI is a way for computers to learn patterns from examples and make helpful predictions. People still choose the examples and check the results.','12 minutes',1
FROM kids_courses WHERE slug='ai-for-beginners'
ON DUPLICATE KEY UPDATE story_text=VALUES(story_text), learning_blocks=VALUES(learning_blocks);

INSERT INTO kids_quizzes (course_id,lesson_id,title,pass_mark,badge_id)
SELECT c.id,l.id,'Amani’s AI Check-in',67,b.id FROM kids_courses c JOIN kids_lessons l ON l.course_id=c.id LEFT JOIN badges b ON b.slug='ai-explorer' WHERE c.slug='ai-for-beginners' AND l.slug='what-is-ai' AND NOT EXISTS (SELECT 1 FROM kids_quizzes q WHERE q.lesson_id=l.id);

INSERT INTO kids_quiz_questions (quiz_id,question,options_json,correct_answer,explanation,sort_order)
SELECT q.id,'What does AI help computers do?','["Sleep at night","Find patterns and make predictions","Eat fruit","Grow bigger"]','Find patterns and make predictions','AI can find patterns in examples and use them to make a prediction.',1 FROM kids_quizzes q JOIN kids_lessons l ON l.id=q.lesson_id WHERE l.slug='what-is-ai' AND NOT EXISTS (SELECT 1 FROM kids_quiz_questions x WHERE x.quiz_id=q.id AND x.sort_order=1);
INSERT INTO kids_quiz_questions (quiz_id,question,options_json,correct_answer,explanation,sort_order)
SELECT q.id,'Can AI learn from examples?','["Yes","No","Only on Tuesdays","Only without people"]','Yes','Examples help an AI system notice useful patterns.',2 FROM kids_quizzes q JOIN kids_lessons l ON l.id=q.lesson_id WHERE l.slug='what-is-ai' AND NOT EXISTS (SELECT 1 FROM kids_quiz_questions x WHERE x.quiz_id=q.id AND x.sort_order=2);
INSERT INTO kids_quiz_questions (quiz_id,question,options_json,correct_answer,explanation,sort_order)
SELECT q.id,'Why should we use AI safely?','["Because people can be affected by its answers","So robots can hide","To avoid learning","Because fruit is noisy"]','Because people can be affected by its answers','People should check AI answers, protect private information, and use AI kindly.',3 FROM kids_quizzes q JOIN kids_lessons l ON l.id=q.lesson_id WHERE l.slug='what-is-ai' AND NOT EXISTS (SELECT 1 FROM kids_quiz_questions x WHERE x.quiz_id=q.id AND x.sort_order=3);

INSERT INTO kids_activities (course_id,lesson_id,title,instructions,activity_type,config_json,badge_id,sort_order)
SELECT c.id,l.id,'Fruit Prediction Lab','Drag each fruit to the prediction that best matches it.','matching','{"pairs":[{"item":"🍎 Apple","match":"Round + red"},{"item":"🍌 Banana","match":"Long + yellow"},{"item":"🍊 Orange","match":"Round + orange"}]}',b.id,1 FROM kids_courses c JOIN kids_lessons l ON l.course_id=c.id LEFT JOIN badges b ON b.slug='ai-explorer' WHERE c.slug='ai-for-beginners' AND l.slug='what-is-ai' AND NOT EXISTS (SELECT 1 FROM kids_activities a WHERE a.lesson_id=l.id AND a.activity_type='matching');
INSERT INTO kids_activities (course_id,lesson_id,title,instructions,activity_type,config_json,badge_id,sort_order)
SELECT c.id,l.id,'AI Word Cards','Flip each card to reveal a helpful AI idea.','flashcards','{"cards":[{"front":"Example","back":"Something we show an AI so it can learn a pattern."},{"front":"Pattern","back":"A detail that repeats or connects examples."},{"front":"Prediction","back":"The AI’s best guess from what it learned."}]}',b.id,2 FROM kids_courses c JOIN kids_lessons l ON l.course_id=c.id LEFT JOIN badges b ON b.slug='ai-explorer' WHERE c.slug='ai-for-beginners' AND l.slug='what-is-ai' AND NOT EXISTS (SELECT 1 FROM kids_activities a WHERE a.lesson_id=l.id AND a.activity_type='flashcards');
INSERT INTO kids_activities (course_id,lesson_id,title,instructions,activity_type,config_json,badge_id,sort_order)
SELECT c.id,l.id,'Guide Robo to the Apple','Arrange the commands in the correct order.','coding','{"commands":["Move forward","Turn right","Move forward","Pick up apple"],"solution":["Move forward","Turn right","Move forward","Pick up apple"]}',b.id,3 FROM kids_courses c JOIN kids_lessons l ON l.course_id=c.id LEFT JOIN badges b ON b.slug='code-starter' WHERE c.slug='ai-for-beginners' AND l.slug='what-is-ai' AND NOT EXISTS (SELECT 1 FROM kids_activities a WHERE a.lesson_id=l.id AND a.activity_type='coding');
