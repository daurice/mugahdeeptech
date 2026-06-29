USE mugahdeeptech;
CREATE TABLE IF NOT EXISTS kids_certificates (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  learner_id INT UNSIGNED NOT NULL,
  course_id INT UNSIGNED NOT NULL,
  certificate_code VARCHAR(80) NOT NULL UNIQUE,
  awarded_by INT UNSIGNED NULL,
  issued_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_kids_certificate (learner_id,course_id),
  CONSTRAINT fk_kids_cert_learner FOREIGN KEY (learner_id) REFERENCES learners(id) ON DELETE CASCADE,
  CONSTRAINT fk_kids_cert_course FOREIGN KEY (course_id) REFERENCES kids_courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
