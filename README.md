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