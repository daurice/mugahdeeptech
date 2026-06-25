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