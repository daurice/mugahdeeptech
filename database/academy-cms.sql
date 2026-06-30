USE mugahdeeptech;

CREATE TABLE IF NOT EXISTS media_library (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  file_path VARCHAR(255) NOT NULL,
  file_type ENUM('image','gif','video','lottie','audio','pdf','template') NOT NULL,
  mime_type VARCHAR(120) NOT NULL,
  file_size INT UNSIGNED NOT NULL DEFAULT 0,
  alt_text VARCHAR(255) NULL,
  uploaded_by INT UNSIGNED NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_media_type (file_type,is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS avatars (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(140) NOT NULL,
  role VARCHAR(180) NOT NULL,
  learner_type ENUM('Kids','Business','General') NOT NULL,
  media_id INT UNSIGNED NULL,
  animation_url VARCHAR(500) NULL,
  description TEXT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT UNSIGNED NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_avatar_media FOREIGN KEY (media_id) REFERENCES media_library(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS site_sections (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  page_key VARCHAR(80) NOT NULL,
  section_key VARCHAR(100) NOT NULL,
  section_type ENUM('hero','pathways','courses','story','features','stats','testimonials','faq','banner','cta','custom') NOT NULL,
  admin_label VARCHAR(180) NOT NULL,
  title VARCHAR(255) NULL,
  subtitle TEXT NULL,
  body_text LONGTEXT NULL,
  eyebrow VARCHAR(140) NULL,
  background_color VARCHAR(20) NULL,
  text_color VARCHAR(20) NULL,
  media_id INT UNSIGNED NULL,
  avatar_id INT UNSIGNED NULL,
  button_text VARCHAR(120) NULL,
  button_link VARCHAR(255) NULL,
  secondary_button_text VARCHAR(120) NULL,
  secondary_button_link VARCHAR(255) NULL,
  settings_json LONGTEXT NULL,
  sort_order INT UNSIGNED NOT NULL DEFAULT 1,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY unique_page_section (page_key,section_key),
  INDEX idx_section_display (page_key,is_active,sort_order),
  CONSTRAINT fk_section_media FOREIGN KEY (media_id) REFERENCES media_library(id) ON DELETE SET NULL,
  CONSTRAINT fk_section_avatar FOREIGN KEY (avatar_id) REFERENCES avatars(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS section_components (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  section_id INT UNSIGNED NOT NULL,
  component_type ENUM('card','button','stat','feature','testimonial','faq','checklist','text','media') NOT NULL DEFAULT 'card',
  title VARCHAR(255) NULL,
  subtitle VARCHAR(255) NULL,
  body_text LONGTEXT NULL,
  icon VARCHAR(40) NULL,
  media_id INT UNSIGNED NULL,
  button_text VARCHAR(120) NULL,
  button_link VARCHAR(255) NULL,
  accent_color VARCHAR(20) NULL,
  settings_json LONGTEXT NULL,
  sort_order INT UNSIGNED NOT NULL DEFAULT 1,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_component_display (section_id,is_active,sort_order),
  CONSTRAINT fk_component_section FOREIGN KEY (section_id) REFERENCES site_sections(id) ON DELETE CASCADE,
  CONSTRAINT fk_component_media FOREIGN KEY (media_id) REFERENCES media_library(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS academy_pathways (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  slug VARCHAR(170) NOT NULL UNIQUE,
  learner_type ENUM('Kids','Business','General') NOT NULL,
  description TEXT NOT NULL,
  icon VARCHAR(40) NULL,
  animation_url VARCHAR(500) NULL,
  media_id INT UNSIGNED NULL,
  button_text VARCHAR(120) NOT NULL,
  button_link VARCHAR(255) NOT NULL,
  accent_color VARCHAR(20) NULL,
  sort_order INT UNSIGNED NOT NULL DEFAULT 1,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_pathway_media FOREIGN KEY (media_id) REFERENCES media_library(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS lesson_blocks (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pathway ENUM('Kids','Business','General') NOT NULL,
  lesson_id INT UNSIGNED NOT NULL,
  block_type ENUM('story','text','step','media','video','lottie','audio','download','checklist','quiz_link','activity_link') NOT NULL,
  title VARCHAR(255) NULL,
  body_text LONGTEXT NULL,
  media_id INT UNSIGNED NULL,
  button_text VARCHAR(120) NULL,
  button_link VARCHAR(255) NULL,
  settings_json LONGTEXT NULL,
  sort_order INT UNSIGNED NOT NULL DEFAULT 1,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_lesson_blocks (pathway,lesson_id,is_active,sort_order),
  CONSTRAINT fk_lesson_block_media FOREIGN KEY (media_id) REFERENCES media_library(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS activity_items (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pathway ENUM('Kids','Business','General') NOT NULL,
  activity_id INT UNSIGNED NOT NULL,
  prompt_text TEXT NOT NULL,
  answer_text TEXT NULL,
  is_correct TINYINT(1) NULL,
  settings_json LONGTEXT NULL,
  sort_order INT UNSIGNED NOT NULL DEFAULT 1,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  INDEX idx_activity_items (pathway,activity_id,is_active,sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS quiz_answers (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pathway ENUM('Kids','Business','General') NOT NULL,
  question_id INT UNSIGNED NOT NULL,
  answer_text TEXT NOT NULL,
  is_correct TINYINT(1) NOT NULL DEFAULT 0,
  explanation TEXT NULL,
  sort_order INT UNSIGNED NOT NULL DEFAULT 1,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  INDEX idx_quiz_answers (pathway,question_id,is_active,sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS settings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  setting_group VARCHAR(100) NOT NULL DEFAULT 'academy',
  setting_key VARCHAR(150) NOT NULL,
  setting_value LONGTEXT NULL,
  input_type ENUM('text','textarea','color','number','boolean','url','email','json') NOT NULL DEFAULT 'text',
  label VARCHAR(180) NOT NULL,
  description VARCHAR(255) NULL,
  is_public TINYINT(1) NOT NULL DEFAULT 0,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY unique_setting (setting_group,setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO academy_pathways (name,slug,learner_type,description,icon,button_text,button_link,accent_color,sort_order) VALUES
('Kids AI Academy','kids-ai-academy','Kids','Playful, animated lessons in AI, coding, digital safety, robotics, and creativity.','✦','Explore Kids Academy','../kids/index.php','#6757f5',1),
('Business AI Academy','business-ai-academy','Business','Practical AI, analytics, marketing, automation, and digital business capability for entrepreneurs and teams.','◆','Explore Business Academy','../business/index.php','#d7b56d',2),
('General Academy','general-academy','General','Professional courses in AI, data, machine learning, automation, and intelligent solutions.','◈','Browse General Courses','courses.php','#38bdf8',3)
ON DUPLICATE KEY UPDATE name=VALUES(name),description=VALUES(description),button_text=VALUES(button_text),button_link=VALUES(button_link);

INSERT INTO site_sections (page_key,section_key,section_type,admin_label,title,subtitle,body_text,eyebrow,button_text,button_link,secondary_button_text,secondary_button_link,background_color,sort_order) VALUES
('academy_home','hero','hero','Academy Homepage Hero','Learn boldly. Build intelligently.','Three learning pathways for curious children, ambitious professionals, and growing businesses.','Choose the pathway that matches your goals, learn through animated cases and activities, and turn ideas into practical capability.','Mugah DeepTech Academy','Explore pathways','#pathways','Learner login','login.php','#080b12',1),
('academy_home','pathways','pathways','Academy Pathway Cards','Choose your Academy pathway','Kids, Business, or General professional learning—each with its own experience and progress journey.',NULL,'Three focused learning environments',NULL,NULL,NULL,NULL,'#0f141e',2),
('academy_home','stats','stats','Academy Statistics','Learning designed for action',NULL,NULL,'Academy snapshot',NULL,NULL,NULL,NULL,'#080b12',3),
('academy_home','testimonials','testimonials','Academy Testimonials','Built around real progress',NULL,NULL,'Learner perspectives',NULL,NULL,NULL,NULL,'#101620',4),
('academy_home','faq','faq','Academy FAQs','Questions before you begin',NULL,NULL,'Helpful answers',NULL,NULL,NULL,NULL,'#080b12',5),
('academy_home','cta','cta','Academy Closing CTA','Start the pathway that fits your next chapter.','You can explore public lessons before creating an account.',NULL,'Ready to learn?','View all pathways','#pathways','Contact the Academy','../contact.php','#d7b56d',6),
('kids_home','hero','hero','Kids Homepage Hero','AI Kids Academy','Fun, animated lessons that help kids learn coding, AI, creativity, and problem-solving.','Learn through stories, colorful activities, safe challenges, and friendly characters.','Learn · Play · Create','Start Learning','course.php?slug=ai-for-beginners','View Courses','courses.php','#f7f4ff',1),
('kids_home','courses','courses','Kids Course Grid','Grow your tech superpowers','Choose a colorful learning adventure and start at your own pace.',NULL,'Pick an adventure','View all courses','courses.php',NULL,NULL,'#ffffff',2),
('kids_home','story','story','Kids Featured Story','Meet Amani and Robo','Amani teaches a curious robot to recognize fruit using examples, patterns, and careful checking.','Try the story, play the fruit matching game, and earn an AI Explorer badge.','Featured animated story','Begin the story','course.php?slug=ai-for-beginners',NULL,NULL,'#1f2452',3),
('kids_home','features','features','Kids Learning Features','Learning that feels like play','Tap, try, think, and celebrate every small step.',NULL,'Interactive learning',NULL,NULL,NULL,NULL,'#fbfaff',4),
('kids_home','safety','banner','Kids Safety Banner','Built with children’s safety in mind','No public chat, minimal data, and clear guidance for parents and guardians.',NULL,'Safety promise','Parent and guardian info','parents.php',NULL,NULL,'#e9fbf4',5),
('business_home','hero','hero','Business Homepage Hero','Turn AI into business advantage.','Practical, animated learning for entrepreneurs, MSME owners, founders, managers, sales teams, and operations professionals.','Build business capability through case studies, dashboard decisions, templates, and responsible AI workflows.','Business AI Academy · Africa-ready skills','Start with AI for Business','course.php?slug=ai-for-business-beginners','Explore all programs','courses.php','#080b12',1),
('business_home','audience','banner','Business Audience Banner','Built for ambitious operators','Entrepreneurs · MSME owners · Startup founders · Sales teams · Operations teams · Managers',NULL,'Target learners',NULL,NULL,NULL,NULL,'#0b0f17',2),
('business_home','courses','courses','Business Course Grid','Skills that move directly into the work.','Build focused capability in AI, data, marketing, automation, security, e-commerce, finance, and reporting.',NULL,'Capability pathways','View program catalog','courses.php',NULL,NULL,'#080b12',3),
('business_home','case','story','Business Featured Case','Meet Wanjiku. Build the workflow.','A Nairobi boutique owner applies AI to sales insight, WhatsApp marketing, customer response, and sales tracking.','Work through the decisions while protecting customer trust and keeping people accountable.','Featured business case','Work through the case','course.php?slug=ai-for-business-beginners',NULL,NULL,'#101620',4),
('business_home','outcomes','features','Business Outcomes','From concept to confident action.','Watch the move, apply the case, use the template, and prove capability.',NULL,'Learn by doing',NULL,NULL,NULL,NULL,'#080b12',5),
('business_home','cta','cta','Business Closing CTA','Build one useful AI workflow this week.','Start with a real business goal and a result you can measure.',NULL,'Move from interest to action','Start learning','course.php?slug=ai-for-business-beginners',NULL,NULL,'#d7b56d',6)
ON DUPLICATE KEY UPDATE admin_label=VALUES(admin_label),title=VALUES(title),subtitle=VALUES(subtitle),body_text=VALUES(body_text);

INSERT INTO section_components (section_id,component_type,title,subtitle,body_text,icon,button_text,button_link,accent_color,sort_order)
SELECT id,'stat','16','Seeded programs','Across Kids and Business pathways','▥',NULL,NULL,'#38bdf8',1 FROM site_sections WHERE page_key='academy_home' AND section_key='stats' AND NOT EXISTS(SELECT 1 FROM section_components c WHERE c.section_id=site_sections.id AND c.sort_order=1);
INSERT INTO section_components (section_id,component_type,title,subtitle,body_text,icon,accent_color,sort_order)
SELECT id,'stat','8','Interactive activities','Matching, quizzes, decisions, prompts, and puzzles','◆','#d7b56d',2 FROM site_sections WHERE page_key='academy_home' AND section_key='stats' AND NOT EXISTS(SELECT 1 FROM section_components c WHERE c.section_id=site_sections.id AND c.sort_order=2);
INSERT INTO section_components (section_id,component_type,title,subtitle,body_text,icon,accent_color,sort_order)
SELECT id,'stat','3','Distinct pathways','Age-aware, role-aware, and independently tracked','◈','#34d399',3 FROM site_sections WHERE page_key='academy_home' AND section_key='stats' AND NOT EXISTS(SELECT 1 FROM section_components c WHERE c.section_id=site_sections.id AND c.sort_order=3);
INSERT INTO section_components (section_id,component_type,title,subtitle,body_text,icon,sort_order)
SELECT id,'testimonial','A practical way to begin','Entrepreneur pathway','The case studies connect AI concepts to decisions I already make in my business.','“',1 FROM site_sections WHERE page_key='academy_home' AND section_key='testimonials' AND NOT EXISTS(SELECT 1 FROM section_components c WHERE c.section_id=site_sections.id AND c.sort_order=1);
INSERT INTO section_components (section_id,component_type,title,subtitle,body_text,sort_order)
SELECT id,'faq','Can I explore before registering?',NULL,'Yes. Public course, lesson, activity, and quiz pages can be previewed. An account is only required to save progress and credentials.',1 FROM site_sections WHERE page_key='academy_home' AND section_key='faq' AND NOT EXISTS(SELECT 1 FROM section_components c WHERE c.section_id=site_sections.id AND c.sort_order=1);
INSERT INTO section_components (section_id,component_type,title,body_text,sort_order)
SELECT id,'faq','Are Kids and Business progress separate?','Yes. Each pathway uses separate progress, badge, and certificate records while sharing secure learner authentication.',2 FROM site_sections WHERE page_key='academy_home' AND section_key='faq' AND NOT EXISTS(SELECT 1 FROM section_components c WHERE c.section_id=site_sections.id AND c.sort_order=2);
INSERT INTO section_components (section_id,component_type,title,body_text,icon,accent_color,sort_order)
SELECT id,'feature','Match and move','Drag ideas into place and receive immediate feedback.','↔','#6757f5',1 FROM site_sections WHERE page_key='kids_home' AND section_key='features' AND NOT EXISTS(SELECT 1 FROM section_components c WHERE c.section_id=site_sections.id AND c.sort_order=1);
INSERT INTO section_components (section_id,component_type,title,body_text,icon,accent_color,sort_order)
SELECT id,'feature','Flip and discover','Animated flashcards turn new words into memorable ideas.','▣','#ec4899',2 FROM site_sections WHERE page_key='kids_home' AND section_key='features' AND NOT EXISTS(SELECT 1 FROM section_components c WHERE c.section_id=site_sections.id AND c.sort_order=2);
INSERT INTO section_components (section_id,component_type,title,body_text,icon,accent_color,sort_order)
SELECT id,'feature','Earn badges','Every finished challenge adds a milestone to the learner journey.','★','#16a34a',3 FROM site_sections WHERE page_key='kids_home' AND section_key='features' AND NOT EXISTS(SELECT 1 FROM section_components c WHERE c.section_id=site_sections.id AND c.sort_order=3);
INSERT INTO section_components (section_id,component_type,title,body_text,icon,accent_color,sort_order)
SELECT id,'feature','Watch the business move','Animated office scenes and dashboards make abstract ideas visible.','01','#38bdf8',1 FROM site_sections WHERE page_key='business_home' AND section_key='outcomes' AND NOT EXISTS(SELECT 1 FROM section_components c WHERE c.section_id=site_sections.id AND c.sort_order=1);
INSERT INTO section_components (section_id,component_type,title,body_text,icon,accent_color,sort_order)
SELECT id,'feature','Apply a realistic case','Decide, draft, match, calculate, and review—not just read.','02','#d7b56d',2 FROM site_sections WHERE page_key='business_home' AND section_key='outcomes' AND NOT EXISTS(SELECT 1 FROM section_components c WHERE c.section_id=site_sections.id AND c.sort_order=2);
INSERT INTO section_components (section_id,component_type,title,body_text,icon,accent_color,sort_order)
SELECT id,'feature','Take the template','Download practical checklists and worksheets for real work.','03','#34d399',3 FROM site_sections WHERE page_key='business_home' AND section_key='outcomes' AND NOT EXISTS(SELECT 1 FROM section_components c WHERE c.section_id=site_sections.id AND c.sort_order=3);
INSERT INTO settings (setting_group,setting_key,setting_value,input_type,label,description,is_public) VALUES
('academy','academy_name','Mugah DeepTech Academy','text','Academy name','Displayed across Academy pathway pages.',1),
('academy','default_accent','#6757f5','color','Default accent color','Fallback color for CMS sections.',1),
('academy','privacy_notice','No public child chat. Minimal learner data. Human oversight for important AI decisions.','textarea','Academy privacy notice','Global learning safety and privacy message.',1),
('academy','allow_public_previews','1','boolean','Allow public previews','Allow lesson and activity previews before login.',0)
ON DUPLICATE KEY UPDATE label=VALUES(label),description=VALUES(description);
