USE mugahdeeptech;

CREATE TABLE IF NOT EXISTS learner_pathways (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  learner_id INT UNSIGNED NOT NULL,
  learner_type ENUM('Kids','Business','General') NOT NULL,
  organization VARCHAR(180) NULL,
  role_title VARCHAR(140) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_learner_pathway (learner_id,learner_type),
  CONSTRAINT fk_pathway_learner FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS business_badges (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(140) NOT NULL,
  slug VARCHAR(150) NOT NULL UNIQUE,
  description VARCHAR(255) NOT NULL,
  icon VARCHAR(30) NOT NULL DEFAULT '◆',
  color VARCHAR(20) NOT NULL DEFAULT '#d7b56d',
  criteria VARCHAR(255) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS business_courses (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  slug VARCHAR(210) NOT NULL UNIQUE,
  short_description VARCHAR(350) NOT NULL,
  description LONGTEXT NOT NULL,
  learner_type ENUM('Business','General') NOT NULL DEFAULT 'Business',
  target_role VARCHAR(255) NOT NULL,
  level VARCHAR(60) NOT NULL DEFAULT 'Beginner',
  duration VARCHAR(80) NOT NULL,
  icon VARCHAR(30) NOT NULL DEFAULT '◆',
  accent_color VARCHAR(20) NOT NULL DEFAULT '#d7b56d',
  thumbnail VARCHAR(255) NULL,
  learning_outcomes LONGTEXT NULL,
  status ENUM('Draft','Published') NOT NULL DEFAULT 'Published',
  sort_order INT UNSIGNED NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS business_lessons (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  course_id INT UNSIGNED NOT NULL,
  title VARCHAR(200) NOT NULL,
  slug VARCHAR(210) NOT NULL,
  case_study_title VARCHAR(220) NOT NULL,
  case_study_text LONGTEXT NOT NULL,
  learning_steps LONGTEXT NOT NULL,
  business_checklist LONGTEXT NULL,
  animation_type ENUM('coach','dashboard','marketing','automation','chatbot','finance','security','ecommerce','productivity','reports','lottie','video','image') NOT NULL DEFAULT 'coach',
  animation_source VARCHAR(500) NULL,
  avatar_path VARCHAR(255) NULL,
  media_path VARCHAR(255) NULL,
  template_path VARCHAR(255) NULL,
  template_label VARCHAR(160) NULL,
  duration VARCHAR(80) NOT NULL DEFAULT '15 minutes',
  sort_order INT UNSIGNED NOT NULL DEFAULT 1,
  status ENUM('Draft','Published') NOT NULL DEFAULT 'Published',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY unique_business_lesson (course_id,slug),
  CONSTRAINT fk_business_lesson_course FOREIGN KEY (course_id) REFERENCES business_courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS business_activities (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  course_id INT UNSIGNED NOT NULL,
  lesson_id INT UNSIGNED NULL,
  title VARCHAR(200) NOT NULL,
  instructions TEXT NOT NULL,
  activity_type ENUM('matching','prompt','decision','risk') NOT NULL,
  config_json LONGTEXT NOT NULL,
  badge_id INT UNSIGNED NULL,
  status ENUM('Draft','Published') NOT NULL DEFAULT 'Published',
  sort_order INT UNSIGNED NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_business_activity_course FOREIGN KEY (course_id) REFERENCES business_courses(id) ON DELETE CASCADE,
  CONSTRAINT fk_business_activity_lesson FOREIGN KEY (lesson_id) REFERENCES business_lessons(id) ON DELETE CASCADE,
  CONSTRAINT fk_business_activity_badge FOREIGN KEY (badge_id) REFERENCES business_badges(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS business_quizzes (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  course_id INT UNSIGNED NOT NULL,
  lesson_id INT UNSIGNED NULL,
  title VARCHAR(200) NOT NULL,
  pass_mark INT UNSIGNED NOT NULL DEFAULT 70,
  badge_id INT UNSIGNED NULL,
  status ENUM('Draft','Published') NOT NULL DEFAULT 'Published',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_business_quiz_course FOREIGN KEY (course_id) REFERENCES business_courses(id) ON DELETE CASCADE,
  CONSTRAINT fk_business_quiz_lesson FOREIGN KEY (lesson_id) REFERENCES business_lessons(id) ON DELETE CASCADE,
  CONSTRAINT fk_business_quiz_badge FOREIGN KEY (badge_id) REFERENCES business_badges(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS business_quiz_questions (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  quiz_id INT UNSIGNED NOT NULL,
  question TEXT NOT NULL,
  options_json LONGTEXT NOT NULL,
  correct_answer VARCHAR(255) NOT NULL,
  explanation TEXT NOT NULL,
  sort_order INT UNSIGNED NOT NULL DEFAULT 1,
  CONSTRAINT fk_business_question_quiz FOREIGN KEY (quiz_id) REFERENCES business_quizzes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS business_progress (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  learner_id INT UNSIGNED NOT NULL,
  course_id INT UNSIGNED NOT NULL,
  lesson_id INT UNSIGNED NULL,
  activity_id INT UNSIGNED NULL,
  status ENUM('started','completed') NOT NULL DEFAULT 'started',
  score INT UNSIGNED NULL,
  completed_at TIMESTAMP NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_business_progress_learner (learner_id,course_id),
  CONSTRAINT fk_business_progress_learner FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
  CONSTRAINT fk_business_progress_course FOREIGN KEY (course_id) REFERENCES business_courses(id) ON DELETE CASCADE,
  CONSTRAINT fk_business_progress_lesson FOREIGN KEY (lesson_id) REFERENCES business_lessons(id) ON DELETE CASCADE,
  CONSTRAINT fk_business_progress_activity FOREIGN KEY (activity_id) REFERENCES business_activities(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS business_learner_badges (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  learner_id INT UNSIGNED NOT NULL,
  badge_id INT UNSIGNED NOT NULL,
  awarded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_business_badge_award (learner_id,badge_id),
  CONSTRAINT fk_business_award_learner FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
  CONSTRAINT fk_business_award_badge FOREIGN KEY (badge_id) REFERENCES business_badges(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS business_certificates (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  learner_id INT UNSIGNED NOT NULL,
  course_id INT UNSIGNED NOT NULL,
  certificate_code VARCHAR(80) NOT NULL UNIQUE,
  awarded_by INT UNSIGNED NULL,
  issued_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_business_certificate (learner_id,course_id),
  CONSTRAINT fk_business_cert_learner FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
  CONSTRAINT fk_business_cert_course FOREIGN KEY (course_id) REFERENCES business_courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO business_badges (name,slug,description,icon,color,criteria) VALUES
('Business AI Starter','business-ai-starter','Applied AI thinking to a practical business case.','◆','#d7b56d','Complete the first AI business lesson'),
('Data Decision Maker','data-decision-maker','Used evidence to choose a stronger business action.','▥','#38bdf8','Complete a dashboard decision activity'),
('Responsible AI Operator','responsible-ai-operator','Identified privacy and customer-data risks.','◇','#34d399','Complete a responsible data activity')
ON DUPLICATE KEY UPDATE name=VALUES(name),description=VALUES(description);

INSERT INTO business_courses (title,slug,short_description,description,learner_type,target_role,level,duration,icon,accent_color,learning_outcomes,sort_order) VALUES
('AI for Business Beginners','ai-for-business-beginners','Turn everyday business challenges into practical AI-assisted workflows.','A grounded introduction to using AI for research, customer communication, sales analysis, planning, and responsible decision-making.','Business','Entrepreneurs, MSME owners, managers and professionals','Beginner','6 lessons · 2 hours','AI','#d7b56d','Identify high-value AI use cases\nWrite useful business prompts\nReview AI output responsibly',1),
('Data Analytics for Business Decisions','data-analytics-for-business-decisions','Read business data, spot patterns, and make clearer decisions.','Learn the numbers that matter, how to ask useful questions, and how to turn trends into focused action.','Business','Owners, managers and operations teams','Beginner','8 lessons · 3 hours','▥','#38bdf8','Select useful KPIs\nInterpret trends\nMake evidence-based decisions',2),
('Digital Marketing with AI','digital-marketing-with-ai','Plan campaigns, create content, and learn faster from customer response.','Use AI carefully across audience research, campaign ideas, content drafts, testing, and performance review.','Business','Entrepreneurs, marketers and sales teams','Beginner','7 lessons · 2.5 hours','↗','#f472b6','Build a campaign brief\nDraft channel-ready content\nMeasure performance',3),
('Business Automation','business-automation','Map repetitive work and design reliable, human-supervised automation.','Find automation opportunities across leads, approvals, reporting, follow-ups, and routine operations.','Business','Operations teams, founders and managers','Beginner','7 lessons · 3 hours','⚙','#a78bfa','Map a workflow\nChoose automation steps\nAdd controls and review points',4),
('Customer Service Chatbots','customer-service-chatbots','Design helpful chatbot conversations that support customers and staff.','Plan chatbot scope, knowledge, tone, escalation paths, testing, and improvement.','Business','Customer service and sales teams','Beginner','6 lessons · 2 hours','◎','#22d3ee','Define chatbot scope\nWrite useful responses\nPlan human escalation',5),
('Financial Record Keeping with AI','financial-record-keeping-with-ai','Organize records and improve financial visibility without losing control.','Explore responsible ways AI can assist with categorization, summaries, reminders, and reporting while people verify every financial decision.','Business','MSME owners and finance teams','Beginner','6 lessons · 2.5 hours','$','#34d399','Organize transaction records\nReview AI categorization\nProtect financial data',6),
('Cybersecurity for Small Businesses','cybersecurity-for-small-businesses','Build practical habits that protect accounts, devices, customers, and operations.','A business-first approach to passwords, phishing, access, backups, incident response, and staff awareness.','Business','Small business owners and teams','Beginner','6 lessons · 2 hours','◇','#fb7185','Reduce common risks\nCreate an incident checklist\nImprove team security habits',7),
('E-commerce and Online Selling','ecommerce-and-online-selling','Build a clearer digital storefront and improve the customer journey.','Plan products, listings, trust signals, customer messages, fulfillment, and performance tracking.','Business','Retailers, founders and sales teams','Beginner','8 lessons · 3 hours','▣','#f59e0b','Improve product listings\nMap the buying journey\nTrack online sales',8),
('Productivity Tools for Teams','productivity-tools-for-teams','Help teams plan, communicate, document, and follow through more effectively.','Practical workflows for meeting notes, task planning, shared knowledge, and AI-assisted team productivity.','General','Managers, teams and professionals','Beginner','6 lessons · 2 hours','✓','#818cf8','Create clearer team workflows\nUse AI for drafts and summaries\nProtect confidential information',9),
('Using Dashboards and Reports','using-dashboards-and-reports','Turn dashboards into focused conversations, decisions, and action.','Learn how to read KPIs, question charts, identify exceptions, and communicate the next business move.','General','Managers, founders and professionals','Beginner','7 lessons · 2.5 hours','▤','#2dd4bf','Read dashboard signals\nChallenge misleading charts\nTurn insight into action',10)
ON DUPLICATE KEY UPDATE title=VALUES(title),short_description=VALUES(short_description),description=VALUES(description);

INSERT INTO business_lessons (course_id,title,slug,case_study_title,case_study_text,learning_steps,business_checklist,animation_type,duration,sort_order)
SELECT id,'How AI Can Help Your Business Grow','how-ai-can-help-your-business-grow','Wanjiku’s smarter boutique','Meet Wanjiku, a boutique owner in Nairobi. She uses AI to understand her best-selling products, create WhatsApp marketing messages, respond to customers, and track sales automatically. Wanjiku starts small: one clear business problem, one reliable data source, and one result she can measure. She reviews every customer message before sending it and never uploads private customer details to an unapproved tool.','[{"title":"Start with the business goal","text":"Choose a measurable outcome such as faster replies, more repeat purchases, or clearer stock decisions."},{"title":"Give AI useful context","text":"Use accurate product, sales, and customer-service information without exposing private data."},{"title":"Keep a person in control","text":"Review messages, predictions, and automated actions before they affect customers or money."},{"title":"Measure and improve","text":"Compare time saved, sales response, errors, and customer feedback."}]','Choose one repetitive task\nDefine the desired outcome\nCheck what data is safe to use\nReview AI output before action\nMeasure one useful result','coach','18 minutes',1
FROM business_courses WHERE slug='ai-for-business-beginners'
ON DUPLICATE KEY UPDATE case_study_text=VALUES(case_study_text),learning_steps=VALUES(learning_steps);

INSERT INTO business_activities (course_id,lesson_id,title,instructions,activity_type,config_json,badge_id,sort_order)
SELECT c.id,l.id,'Match AI Tools to Business Tasks','Connect each AI capability to the task where it adds the most value.','matching','{"pairs":[{"item":"Sales trend analysis","match":"Find best-selling products"},{"item":"Writing assistant","match":"Draft a WhatsApp campaign"},{"item":"Support chatbot","match":"Answer common customer questions"},{"item":"Workflow automation","match":"Update the sales tracker"}]}',b.id,1 FROM business_courses c JOIN business_lessons l ON l.course_id=c.id LEFT JOIN business_badges b ON b.slug='business-ai-starter' WHERE c.slug='ai-for-business-beginners' AND NOT EXISTS(SELECT 1 FROM business_activities a WHERE a.lesson_id=l.id AND a.activity_type='matching');
INSERT INTO business_activities (course_id,lesson_id,title,instructions,activity_type,config_json,badge_id,sort_order)
SELECT c.id,l.id,'Create a Customer Message','Build a clear prompt, then draft a useful customer message.','prompt','{"scenario":"Wanjiku wants to tell returning customers about a new collection arriving Friday.","fields":["Audience","Offer or update","Tone","Call to action"],"example":"Write a warm, concise WhatsApp message for returning boutique customers. Announce a new collection arriving Friday and invite them to reserve a fitting. Do not invent discounts."}',b.id,2 FROM business_courses c JOIN business_lessons l ON l.course_id=c.id LEFT JOIN business_badges b ON b.slug='business-ai-starter' WHERE c.slug='ai-for-business-beginners' AND NOT EXISTS(SELECT 1 FROM business_activities a WHERE a.lesson_id=l.id AND a.activity_type='prompt');
INSERT INTO business_activities (course_id,lesson_id,title,instructions,activity_type,config_json,badge_id,sort_order)
SELECT c.id,l.id,'Choose the Best Dashboard Decision','Review the dashboard signals and choose the strongest next action.','decision','{"metrics":[{"label":"Dresses","sales":82,"stock":12},{"label":"Shoes","sales":41,"stock":65},{"label":"Bags","sales":68,"stock":30}],"question":"What should Wanjiku investigate first?","options":["Reorder dresses and check demand","Stop tracking stock","Discount every product","Ignore the dashboard"],"correct":"Reorder dresses and check demand"}',b.id,3 FROM business_courses c JOIN business_lessons l ON l.course_id=c.id LEFT JOIN business_badges b ON b.slug='data-decision-maker' WHERE c.slug='ai-for-business-beginners' AND NOT EXISTS(SELECT 1 FROM business_activities a WHERE a.lesson_id=l.id AND a.activity_type='decision');
INSERT INTO business_activities (course_id,lesson_id,title,instructions,activity_type,config_json,badge_id,sort_order)
SELECT c.id,l.id,'Customer Data Risk Review','Identify which actions protect customers and the business.','risk','{"items":[{"text":"Upload customer phone numbers to an unapproved public AI tool","safe":false},{"text":"Remove names and identifiers before analysis","safe":true},{"text":"Check access permissions for the sales file","safe":true},{"text":"Send every AI-written reply without review","safe":false}]}',b.id,4 FROM business_courses c JOIN business_lessons l ON l.course_id=c.id LEFT JOIN business_badges b ON b.slug='responsible-ai-operator' WHERE c.slug='ai-for-business-beginners' AND NOT EXISTS(SELECT 1 FROM business_activities a WHERE a.lesson_id=l.id AND a.activity_type='risk');

INSERT INTO business_quizzes (course_id,lesson_id,title,pass_mark,badge_id)
SELECT c.id,l.id,'Business AI Growth Check',75,b.id FROM business_courses c JOIN business_lessons l ON l.course_id=c.id LEFT JOIN business_badges b ON b.slug='business-ai-starter' WHERE c.slug='ai-for-business-beginners' AND NOT EXISTS(SELECT 1 FROM business_quizzes q WHERE q.lesson_id=l.id);
INSERT INTO business_quiz_questions (quiz_id,question,options_json,correct_answer,explanation,sort_order)
SELECT q.id,'What is the best place to start with AI in a small business?','["A clear, measurable business problem","Buying every AI tool","Removing human review","Uploading all customer data"]','A clear, measurable business problem','Start with one useful problem and define how success will be measured.',1 FROM business_quizzes q JOIN business_lessons l ON l.id=q.lesson_id WHERE l.slug='how-ai-can-help-your-business-grow' AND NOT EXISTS(SELECT 1 FROM business_quiz_questions x WHERE x.quiz_id=q.id AND x.sort_order=1);
INSERT INTO business_quiz_questions (quiz_id,question,options_json,correct_answer,explanation,sort_order)
SELECT q.id,'Why should Wanjiku review AI-written customer messages?','["To protect accuracy, tone, and trust","Because AI cannot write words","To make every message longer","So sales data disappears"]','To protect accuracy, tone, and trust','A person should verify claims, tone, and suitability before a message reaches customers.',2 FROM business_quizzes q JOIN business_lessons l ON l.id=q.lesson_id WHERE l.slug='how-ai-can-help-your-business-grow' AND NOT EXISTS(SELECT 1 FROM business_quiz_questions x WHERE x.quiz_id=q.id AND x.sort_order=2);
INSERT INTO business_quiz_questions (quiz_id,question,options_json,correct_answer,explanation,sort_order)
SELECT q.id,'Which information should not be placed in an unapproved AI tool?','["Private customer details","Public product descriptions","A generic campaign goal","A fictional example"]','Private customer details','Customer information requires appropriate consent, security, and approved systems.',3 FROM business_quizzes q JOIN business_lessons l ON l.id=q.lesson_id WHERE l.slug='how-ai-can-help-your-business-grow' AND NOT EXISTS(SELECT 1 FROM business_quiz_questions x WHERE x.quiz_id=q.id AND x.sort_order=3);
INSERT INTO business_quiz_questions (quiz_id,question,options_json,correct_answer,explanation,sort_order)
SELECT q.id,'How does Wanjiku know an AI workflow is useful?','["She measures a relevant result","It looks impressive","It removes every employee","It produces the most text"]','She measures a relevant result','Useful measures include time saved, fewer errors, better response, or improved decisions.',4 FROM business_quizzes q JOIN business_lessons l ON l.id=q.lesson_id WHERE l.slug='how-ai-can-help-your-business-grow' AND NOT EXISTS(SELECT 1 FROM business_quiz_questions x WHERE x.quiz_id=q.id AND x.sort_order=4);
