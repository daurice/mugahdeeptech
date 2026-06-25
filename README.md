# Mugah DeepTech Website

Premium AI and data consulting website built with PHP 8+, MySQL, Bootstrap, HTML, CSS, and JavaScript.

## Features

- Dark luxury consulting website for Mugah DeepTech
- Responsive public pages: Home, About, Services, Solutions, Industries, Case Studies, Insights, Contact
- Animated AI particle hero, dashboard preview, reveal animations, and animated statistics
- Secure contact form with CSRF validation, server-side validation, and PDO prepared statements
- MySQL tables for users, inquiries, blog posts, and case studies
- Admin login, dashboard analytics, inquiry management, read/unread status, and delete actions
- SEO metadata, Open Graph tags, clean URL `.htaccess`, and reusable PHP includes

## Requirements

- PHP 8.0 or newer
- MySQL 5.7+ or MariaDB 10.3+
- Apache with `mod_rewrite` enabled
- PDO MySQL extension enabled

## Folder Structure

```text
index.php
about.php
services.php
solutions.php
industries.php
case-studies.php
insights.php
contact.php
admin/
  login.php
  dashboard.php
  inquiries.php
  logout.php
includes/
  db.php
  header.php
  footer.php
  functions.php
assets/
  css/style.css
  js/main.js
  images/
database.sql
.htaccess
README.md
```

## Setup on cPanel or Shared Hosting

1. Upload all files to your public web directory, usually `public_html`.
2. Create a MySQL database and database user in cPanel.
3. Import `database.sql` using phpMyAdmin.
4. Open `includes/db.php` and update:

```php
$dbHost = 'localhost';
$dbName = 'your_database_name';
$dbUser = 'your_database_user';
$dbPass = 'your_database_password';
```

5. Visit the website in your browser.
6. Visit `/admin/login` to access the admin area.

## Default Admin Login

Email: `admin@mugahdeeptech.net`
Password: `Mugah@2026`

Change this immediately after installation. To generate a new password hash, create a temporary PHP file with:

```php
<?php echo password_hash('YourStrongPasswordHere', PASSWORD_DEFAULT);
```

Run it once in your browser, copy the generated hash, update the `users.password_hash` value in phpMyAdmin, then delete the temporary file.

## Clean URLs

The included `.htaccess` allows URLs such as:

- `/about`
- `/services`
- `/solutions`
- `/industries`
- `/case-studies`
- `/insights`
- `/contact`
- `/admin/login`

If your hosting account does not force HTTPS yet, install an SSL certificate before enabling production traffic.

## Customization

- Brand colors and spacing live in `assets/css/style.css`.
- Navigation and SEO metadata are in `includes/header.php`.
- Footer CTA and footer links are in `includes/footer.php`.
- Services are defined in `includes/functions.php` and reused in the contact form.
- Seed blog posts and case studies are in `database.sql`.

## Security Notes

- Contact form uses CSRF tokens and prepared statements.
- Admin authentication uses `password_verify()` with hashed passwords.
- Admin-only pages call `require_admin()`.
- `.htaccess` blocks directory indexes and adds basic browser security headers.
- Always replace the default admin password before launch.
## Mugah DeepTech Academy LMS

The LMS adds learner registration, login, dashboard, lessons, quizzes, certificates, and admin LMS screens.

Learner pages:
- `/academy/`
- `/academy/courses`
- `/academy/register`
- `/academy/login`
- `/academy/dashboard`

Admin LMS pages:
- `/admin/lms-dashboard`
- `/admin/courses`
- `/admin/lessons`
- `/admin/quizzes`
- `/admin/learners`
- `/admin/certificates`

After importing `database.sql`, run the academy seeder once from the project root if the sample courses are not already present:

```bash
php scripts/seed_lms.php
```

On this local XAMPP run, the LMS schema has already been imported and seeded.

## Rebuilt Academy LMS v2

The Academy now uses the required structured LMS tables:
`admin_users`, `learners`, `lms_categories`, `lms_courses`, `lms_modules`, `lms_lessons`, `lms_enrollments`, `lms_lesson_progress`, `lms_quizzes`, `lms_quiz_questions`, `lms_quiz_attempts`, `lms_certificates`, and `lms_settings`.

Public learner routes:
- `/academy/index.php`
- `/academy/courses.php`
- `/academy/course.php`
- `/academy/register.php`
- `/academy/login.php`
- `/academy/dashboard.php`
- `/academy/learn.php`
- `/academy/lesson.php`
- `/academy/quiz.php`
- `/academy/certificate.php`

Admin LMS routes are all inside `/admin/`:
- `/admin/lms-dashboard.php`
- `/admin/lms-courses.php`
- `/admin/lms-course-create.php`
- `/admin/lms-course-edit.php`
- `/admin/lms-modules.php`
- `/admin/lms-lessons.php`
- `/admin/lms-quizzes.php`
- `/admin/lms-questions.php`
- `/admin/lms-learners.php`
- `/admin/lms-enrollments.php`
- `/admin/lms-progress.php`
- `/admin/lms-certificates.php`
- `/admin/lms-settings.php`

Seed the full sample academy content with:

```bash
php scripts/seed_lms.php
```

The seed creates 10 courses, 30 modules, 90 lessons, 10 final quizzes, and 100 quiz questions.
