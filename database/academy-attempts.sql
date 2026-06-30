USE mugahdeeptech;
CREATE TABLE IF NOT EXISTS academy_quiz_attempts (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 pathway ENUM('Kids','Business','General') NOT NULL,
 learner_id INT UNSIGNED NOT NULL,
 quiz_id INT UNSIGNED NOT NULL,
 lesson_id INT UNSIGNED NOT NULL,
 score INT UNSIGNED NOT NULL,
 total_questions INT UNSIGNED NOT NULL,
 passed TINYINT(1) NOT NULL DEFAULT 0,
 answers_json LONGTEXT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 INDEX idx_pathway_attempts (pathway,learner_id,created_at),
 CONSTRAINT fk_academy_attempt_learner FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;