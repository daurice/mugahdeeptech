CREATE DATABASE IF NOT EXISTS mugahdeeptech CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mugahdeeptech;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin','editor') NOT NULL DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS inquiries (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(160) NOT NULL,
    email VARCHAR(190) NOT NULL,
    phone VARCHAR(60) NULL,
    company VARCHAR(160) NULL,
    service VARCHAR(120) NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    ip_address VARCHAR(45) NULL,
    user_agent VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_inquiries_read (is_read),
    INDEX idx_inquiries_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS blog_posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(220) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    category VARCHAR(120) NOT NULL,
    excerpt TEXT NOT NULL,
    content LONGTEXT NULL,
    published TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_posts_published (published),
    INDEX idx_posts_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS case_studies (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(220) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    industry VARCHAR(120) NOT NULL,
    summary TEXT NOT NULL,
    result_metric VARCHAR(160) NOT NULL,
    content LONGTEXT NULL,
    published TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_cases_published (published),
    INDEX idx_cases_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (name, email, password_hash, role) VALUES
('Mugah DeepTech Admin', 'admin@mugahdeeptech.net', '$2y$10$B9DQbxOz5CV/w2UKykAuIugyJCiw46kOv.fELryJj5LobQitbrzXu', 'admin')
ON DUPLICATE KEY UPDATE email = email;

INSERT INTO blog_posts (title, slug, category, excerpt, content, published) VALUES
('How AI Strategy Becomes Revenue Strategy', 'ai-strategy-revenue-strategy', 'AI Strategy', 'AI initiatives succeed when they are tied to revenue, margin, risk, and speed of execution.', 'A practical AI roadmap starts with business outcomes, data readiness, governance, and adoption.', 1),
('The Executive Case for Decision Intelligence', 'executive-case-decision-intelligence', 'Data Analytics', 'Modern analytics helps leaders move from delayed reporting to confident, forward-looking decisions.', 'Decision intelligence connects KPIs, forecasting, workflows, and accountability.', 1),
('Automation Without Losing Control', 'automation-without-losing-control', 'Automation', 'The best automation programs reduce manual work while improving visibility, controls, and customer experience.', 'Automation should be governed, measurable, and designed around human accountability.', 1)
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO case_studies (title, slug, industry, summary, result_metric, content, published) VALUES
('Executive BI Command Center', 'executive-bi-command-center', 'Retail', 'Unified sales, inventory, and operations data into a leadership dashboard for faster weekly decisions.', '38% faster reporting cycle', 'A retail leadership team replaced spreadsheet reporting with executive dashboards and operational scorecards.', 1),
('AI-Assisted Customer Support', 'ai-assisted-customer-support', 'Telecommunications', 'Designed a secure knowledge assistant to improve response consistency and reduce escalation load.', '27% reduction in repeat tickets', 'A support team used AI-assisted retrieval and guided responses to improve service quality.', 1),
('Demand Forecasting Pilot', 'demand-forecasting-pilot', 'Agriculture', 'Built forecasting models for seasonal demand planning across product categories and regions.', '19% planning accuracy lift', 'Predictive analytics helped improve replenishment planning and reduce avoidable stock pressure.', 1)
ON DUPLICATE KEY UPDATE title = VALUES(title);
-- Mugah DeepTech Academy LMS
CREATE TABLE IF NOT EXISTS learners (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 full_name VARCHAR(160) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 phone VARCHAR(60) NULL,
 password_hash VARCHAR(255) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS courses (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 title VARCHAR(220) NOT NULL,
 slug VARCHAR(220) NOT NULL UNIQUE,
 category VARCHAR(160) NOT NULL,
 level VARCHAR(60) NOT NULL DEFAULT 'Beginner',
 duration VARCHAR(80) NOT NULL DEFAULT '6 lessons',
 short_description TEXT NOT NULL,
 description LONGTEXT NOT NULL,
 outcomes LONGTEXT NOT NULL,
 price DECIMAL(10,2) NOT NULL DEFAULT 0,
 is_published TINYINT(1) NOT NULL DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS modules (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 course_id INT UNSIGNED NOT NULL,
 title VARCHAR(220) NOT NULL,
 position INT UNSIGNED NOT NULL DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS lessons (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 course_id INT UNSIGNED NOT NULL,
 module_id INT UNSIGNED NOT NULL,
 title VARCHAR(220) NOT NULL,
 slug VARCHAR(220) NOT NULL,
 notes LONGTEXT NOT NULL,
 video_url VARCHAR(255) NULL,
 resources TEXT NULL,
 takeaways TEXT NOT NULL,
 assignment TEXT NOT NULL,
 position INT UNSIGNED NOT NULL DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY unique_course_lesson_slug (course_id, slug),
 FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
 FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS enrollments (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 learner_id INT UNSIGNED NOT NULL,
 course_id INT UNSIGNED NOT NULL,
 enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 completed_at TIMESTAMP NULL,
 UNIQUE KEY unique_enrollment (learner_id, course_id),
 FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
 FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS lesson_progress (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 learner_id INT UNSIGNED NOT NULL,
 course_id INT UNSIGNED NOT NULL,
 lesson_id INT UNSIGNED NOT NULL,
 completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY unique_lesson_progress (learner_id, lesson_id),
 FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
 FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
 FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS quizzes (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 course_id INT UNSIGNED NOT NULL UNIQUE,
 title VARCHAR(220) NOT NULL,
 pass_mark INT UNSIGNED NOT NULL DEFAULT 70,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS quiz_questions (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 quiz_id INT UNSIGNED NOT NULL,
 question TEXT NOT NULL,
 option_a VARCHAR(255) NOT NULL,
 option_b VARCHAR(255) NOT NULL,
 option_c VARCHAR(255) NOT NULL,
 option_d VARCHAR(255) NOT NULL,
 correct_option ENUM('A','B','C','D') NOT NULL,
 explanation TEXT NOT NULL,
 position INT UNSIGNED NOT NULL DEFAULT 1,
 FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS quiz_attempts (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 learner_id INT UNSIGNED NOT NULL,
 course_id INT UNSIGNED NOT NULL,
 quiz_id INT UNSIGNED NOT NULL,
 score INT UNSIGNED NOT NULL,
 total_questions INT UNSIGNED NOT NULL,
 percentage INT UNSIGNED NOT NULL,
 passed TINYINT(1) NOT NULL DEFAULT 0,
 answers LONGTEXT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
 FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
 FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS certificates (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 learner_id INT UNSIGNED NOT NULL,
 course_id INT UNSIGNED NOT NULL,
 certificate_id VARCHAR(80) NOT NULL UNIQUE,
 issued_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY unique_certificate (learner_id, course_id),
 FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
 FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Rebuilt Mugah DeepTech Academy LMS v2
CREATE TABLE IF NOT EXISTS admin_users (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL,
 role VARCHAR(60) NOT NULL DEFAULT 'admin',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS lms_categories (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(160) NOT NULL UNIQUE,
 slug VARCHAR(180) NOT NULL UNIQUE,
 description TEXT NULL,
 status ENUM('active','inactive') NOT NULL DEFAULT 'active',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS lms_courses (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 category_id INT UNSIGNED NULL,
 title VARCHAR(220) NOT NULL,
 slug VARCHAR(220) NOT NULL UNIQUE,
 short_description TEXT NOT NULL,
 full_description LONGTEXT NOT NULL,
 level ENUM('Beginner','Intermediate','Advanced') NOT NULL DEFAULT 'Beginner',
 duration VARCHAR(80) NOT NULL,
 instructor VARCHAR(160) NOT NULL DEFAULT 'Mugah DeepTech Academy',
 thumbnail_image VARCHAR(255) NULL,
 price_type ENUM('Free','Paid') NOT NULL DEFAULT 'Free',
 price DECIMAL(10,2) NOT NULL DEFAULT 0,
 status ENUM('Draft','Published') NOT NULL DEFAULT 'Published',
 learning_outcomes LONGTEXT NOT NULL,
 requirements LONGTEXT NOT NULL,
 target_audience LONGTEXT NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 FOREIGN KEY (category_id) REFERENCES lms_categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS lms_modules (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 course_id INT UNSIGNED NOT NULL,
 title VARCHAR(220) NOT NULL,
 description TEXT NOT NULL,
 sort_order INT UNSIGNED NOT NULL DEFAULT 1,
 status ENUM('Draft','Published') NOT NULL DEFAULT 'Published',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 FOREIGN KEY (course_id) REFERENCES lms_courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS lms_lessons (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 module_id INT UNSIGNED NOT NULL,
 title VARCHAR(220) NOT NULL,
 lesson_type ENUM('Text','Video','Assignment','Resource') NOT NULL DEFAULT 'Text',
 content LONGTEXT NOT NULL,
 video_url VARCHAR(255) NULL,
 resource_url VARCHAR(255) NULL,
 assignment_instructions LONGTEXT NULL,
 estimated_duration VARCHAR(80) NOT NULL DEFAULT '20 minutes',
 sort_order INT UNSIGNED NOT NULL DEFAULT 1,
 status ENUM('Draft','Published') NOT NULL DEFAULT 'Published',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 FOREIGN KEY (module_id) REFERENCES lms_modules(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS lms_enrollments (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 learner_id INT UNSIGNED NOT NULL,
 course_id INT UNSIGNED NOT NULL,
 status ENUM('active','completed','disabled') NOT NULL DEFAULT 'active',
 enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 completed_at TIMESTAMP NULL,
 UNIQUE KEY unique_lms_enrollment (learner_id, course_id),
 FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
 FOREIGN KEY (course_id) REFERENCES lms_courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS lms_lesson_progress (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 learner_id INT UNSIGNED NOT NULL,
 course_id INT UNSIGNED NOT NULL,
 lesson_id INT UNSIGNED NOT NULL,
 completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY unique_lms_lesson_progress (learner_id, lesson_id),
 FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
 FOREIGN KEY (course_id) REFERENCES lms_courses(id) ON DELETE CASCADE,
 FOREIGN KEY (lesson_id) REFERENCES lms_lessons(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS lms_quizzes (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 course_id INT UNSIGNED NOT NULL UNIQUE,
 title VARCHAR(220) NOT NULL,
 pass_mark INT UNSIGNED NOT NULL DEFAULT 70,
 status ENUM('Draft','Published') NOT NULL DEFAULT 'Published',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 FOREIGN KEY (course_id) REFERENCES lms_courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS lms_quiz_questions (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 quiz_id INT UNSIGNED NOT NULL,
 question TEXT NOT NULL,
 option_a VARCHAR(255) NOT NULL,
 option_b VARCHAR(255) NOT NULL,
 option_c VARCHAR(255) NOT NULL,
 option_d VARCHAR(255) NOT NULL,
 correct_option ENUM('A','B','C','D') NOT NULL,
 explanation TEXT NOT NULL,
 sort_order INT UNSIGNED NOT NULL DEFAULT 1,
 FOREIGN KEY (quiz_id) REFERENCES lms_quizzes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS lms_quiz_attempts (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 learner_id INT UNSIGNED NOT NULL,
 course_id INT UNSIGNED NOT NULL,
 quiz_id INT UNSIGNED NOT NULL,
 score INT UNSIGNED NOT NULL,
 total_questions INT UNSIGNED NOT NULL,
 percentage INT UNSIGNED NOT NULL,
 passed TINYINT(1) NOT NULL DEFAULT 0,
 answers LONGTEXT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
 FOREIGN KEY (course_id) REFERENCES lms_courses(id) ON DELETE CASCADE,
 FOREIGN KEY (quiz_id) REFERENCES lms_quizzes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS lms_certificates (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 learner_id INT UNSIGNED NOT NULL,
 course_id INT UNSIGNED NOT NULL,
 certificate_id VARCHAR(80) NOT NULL UNIQUE,
 verification_code VARCHAR(80) NOT NULL UNIQUE,
 issued_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY unique_lms_certificate (learner_id, course_id),
 FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
 FOREIGN KEY (course_id) REFERENCES lms_courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS lms_settings (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 setting_key VARCHAR(120) NOT NULL UNIQUE,
 setting_value TEXT NOT NULL,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
