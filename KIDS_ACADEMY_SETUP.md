# AI Kids Academy

The Kids Academy is an isolated, child-friendly module inside the existing Mugah DeepTech Academy. It reuses the existing PHP session, learner login, PDO connection, and admin authentication while keeping its courses, lessons, activities, progress, and rewards separate from the professional LMS.

## Routes

Public pages:

- `/kids/` — landing page
- `/kids/courses.php` — age-filtered catalog
- `/kids/course.php?slug=ai-for-beginners` — course map
- `/kids/lesson.php?id=1` — animated lesson
- `/kids/activity.php?id=1` — interactive activity
- `/kids/quiz.php?lesson=1` — scored quiz
- `/kids/parents.php` — guardian information and safety disclaimer
- `/kids/join.php` — guardian-consented learner profile
- `/kids/progress.php` — saved progress and badge shelf

Admin pages:

- `/admin/kids-dashboard.php`
- `/admin/kids-courses.php`
- `/admin/kids-lessons.php`
- `/admin/kids-activities.php`
- `/admin/kids-quizzes.php`
- `/admin/kids-progress.php`
- `/admin/kids-badges.php`

## Database setup

Import the existing `database.sql` first, then run these files in order:

```bash
mysql -u root -p mugahdeeptech < database/kids-academy.sql
mysql -u root -p mugahdeeptech < database/kids-certificates.sql
```

For this project's local MariaDB on port 3307:

```bash
C:/xampp/mysql/bin/mysql.exe --host=127.0.0.1 --port=3307 --user=root --execute="source database/kids-academy.sql; source database/kids-certificates.sql" mugahdeeptech
```

The seed is idempotent and creates six courses, the “What is AI?” Amani story lesson, three activities, a three-question quiz, and three badges.

## Content management

1. Sign in through `/admin/login.php`.
2. Open Kids Academy Admin.
3. Create a course and choose an age group: 6–8, 9–12, 13–15, or All.
4. Add lessons. Each lesson supports three story steps, narration text, a built-in animated theme, or uploaded/remote media.
5. Add matching, flashcard, or coding activities using the JSON examples shown in the activity editor.
6. Create a quiz, open Questions, and add its answer choices and friendly explanations.
7. Track completions in Learner Progress and manually award badges or course certificates where appropriate.

Accepted lesson uploads are JPG, PNG, GIF, WebP, MP4, and Lottie JSON, with an 8 MB limit. Files are saved under `assets/uploads/kids/` using randomized filenames. Keep videos short and optimized for mobile.

## Folder structure

```text
kids/                         Public Kids Academy pages
admin/kids-*.php              Protected CRUD and reporting pages
includes/kids-functions.php   Queries, progress, rewards, media validation
includes/kids-header.php      Child-friendly public navigation
includes/kids-footer.php      Safety footer and scripts
includes/kids-admin-*.php     Protected admin shell
assets/css/kids-*.css         Components, lessons, activities, responsive UI
assets/js/kids-academy.js     Matching, flashcards, coding, narration, motion
assets/uploads/kids/          Admin-uploaded lesson media
database/kids-academy.sql     Core schema and sample content
database/kids-certificates.sql Certificate extension
```

## Safety and privacy

- No public chat, comments, profiles, or child-to-child messaging.
- Kids registration stores only a learner name/nickname, age group, guardian email, password hash, and learning progress.
- The Kids Academy form does not request phone number, school, home address, or sensitive information.
- Public activities can be explored without an account; an account is only needed to save progress and badges.
- Parents and guardians should review external media or tools before children use them.

For production, use HTTPS, replace the default admin password, review uploaded media, and add your organization’s formal privacy/retention policy.
