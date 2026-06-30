USE mugahdeeptech;

CREATE TABLE IF NOT EXISTS course_card_settings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pathway ENUM('Kids','Business','General') NOT NULL,
  course_id INT UNSIGNED NOT NULL,
  category VARCHAR(140) NULL,
  media_id INT UNSIGNED NULL,
  animation_url VARCHAR(500) NULL,
  price_type ENUM('Free','Paid') NOT NULL DEFAULT 'Free',
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  button_text VARCHAR(100) NOT NULL DEFAULT 'Start Learning',
  sort_order INT UNSIGNED NOT NULL DEFAULT 1,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY unique_pathway_course_card (pathway,course_id),
  CONSTRAINT fk_course_card_media FOREIGN KEY (media_id) REFERENCES media_library(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO course_card_settings (pathway,course_id,category,button_text,sort_order,is_active)
SELECT 'Kids',id,'Kids Technology','Start Adventure',sort_order,status='Published' FROM kids_courses
ON DUPLICATE KEY UPDATE sort_order=VALUES(sort_order);
INSERT INTO course_card_settings (pathway,course_id,category,button_text,sort_order,is_active)
SELECT 'Business',id,'Business Capability','Open Program',sort_order,status='Published' FROM business_courses
ON DUPLICATE KEY UPDATE sort_order=VALUES(sort_order);
INSERT INTO course_card_settings (pathway,course_id,category,button_text,sort_order,is_active)
SELECT 'General',id,COALESCE((SELECT name FROM lms_categories WHERE id=lms_courses.category_id),'Professional Learning'),'View Course',id,status='Published' FROM lms_courses
ON DUPLICATE KEY UPDATE sort_order=VALUES(sort_order);

CREATE TABLE IF NOT EXISTS lesson_content_settings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pathway ENUM('Kids','Business','General') NOT NULL,
  lesson_id INT UNSIGNED NOT NULL,
  avatar_id INT UNSIGNED NULL,
  narration_media_id INT UNSIGNED NULL,
  quiz_button_text VARCHAR(100) NOT NULL DEFAULT 'Take Quiz',
  activity_button_text VARCHAR(100) NOT NULL DEFAULT 'Start Activity',
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY unique_pathway_lesson_content (pathway,lesson_id),
  CONSTRAINT fk_lesson_content_avatar FOREIGN KEY (avatar_id) REFERENCES avatars(id) ON DELETE SET NULL,
  CONSTRAINT fk_lesson_narration_media FOREIGN KEY (narration_media_id) REFERENCES media_library(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO lesson_content_settings (pathway,lesson_id,is_active)
SELECT 'Kids',id,status='Published' FROM kids_lessons ON DUPLICATE KEY UPDATE is_active=VALUES(is_active);
INSERT INTO lesson_content_settings (pathway,lesson_id,is_active)
SELECT 'Business',id,status='Published' FROM business_lessons ON DUPLICATE KEY UPDATE is_active=VALUES(is_active);
INSERT INTO lesson_content_settings (pathway,lesson_id,is_active)
SELECT 'General',id,status='Published' FROM lms_lessons ON DUPLICATE KEY UPDATE is_active=VALUES(is_active);
