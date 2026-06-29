# Business AI Academy

Business AI Academy is the professional learning pathway for entrepreneurs, MSMEs, startup founders, sales and operations teams, managers, and working professionals. It shares the existing learner login and protected admin session while keeping business courses, progress, rewards, and certificates separate from Kids Academy and General Academy.

## Public routes

- `/business/` — animated Business AI Academy landing page
- `/business/courses.php` — Business/General program catalog
- `/business/course.php?slug=ai-for-business-beginners` — program overview
- `/business/lesson.php?id=1` — Wanjiku case-study lesson
- `/business/activity.php?id=1` — practical business activity
- `/business/quiz.php?lesson=1` — scored lesson quiz
- `/business/dashboard.php` — learner progress and credentials
- `/business/certificate.php?code=...` — printable certificate

## Admin routes

- `/admin/business-dashboard.php`
- `/admin/business-courses.php`
- `/admin/business-lessons.php`
- `/admin/business-activities.php`
- `/admin/business-quizzes.php`
- `/admin/business-progress.php`
- `/admin/business-rewards.php`

The course editor includes a learner type selector for `Business` or `General`. Kids content remains explicitly categorized and managed in Kids Academy Admin. This keeps reporting and content tone separate while all three pathways remain accessible from Academy navigation.

## Database setup

Import the main LMS and Kids Academy schemas first if needed, then run:

```bash
mysql -u root -p mugahdeeptech < database/business-academy.sql
```

For this project's local MariaDB on port 3307:

```bash
C:/xampp/mysql/bin/mysql.exe --host=127.0.0.1 --port=3307 --user=root --execute="source database/business-academy.sql" mugahdeeptech
```

The script is safe to rerun. It seeds ten programs, three business badges, Wanjiku’s “How AI Can Help Your Business Grow” lesson, four activities, and a four-question quiz.

## Authoring content

1. Sign in at `/admin/login.php` and open Business Academy Admin.
2. Create a course and select `Business` or `General` learner type.
3. Add a case-study lesson with four practical steps and a business checklist.
4. Select a built-in animated scene or upload a coach avatar, GIF, image, Lottie JSON, or MP4.
5. Upload a downloadable PDF, Word, Excel, or CSV template.
6. Add matching, prompt-building, dashboard-decision, and risk-review activities using the seeded JSON as a pattern.
7. Create quizzes and friendly answer explanations.
8. Review Business Progress separately, then issue badges or certificates.

Uploads use randomized filenames under `assets/uploads/business/`, are MIME-validated, and are limited to 15 MB.

## Folder structure

```text
business/                              Public learner pages
admin/business-*.php                   Protected CRUD/reporting pages
includes/business-functions.php        Queries, progress, uploads, credentials
includes/business-header.php           Dark professional public navigation
includes/business-admin-header.php     Business admin navigation
assets/css/business-academy.css        Landing page and program cards
assets/css/business-learning.css       Lesson, office, coach, and dashboard scenes
assets/css/business-responsive.css     Activities, credentials, and responsive rules
assets/js/business-academy.js          Activity logic and micro-interactions
assets/uploads/business/               Uploaded media and templates
database/business-academy.sql          Schema and idempotent demo seed
```

## Production notes

- Serve the site over HTTPS.
- Review and approve uploaded learning media and templates.
- Keep customer, financial, employee, and operational data out of public AI tools.
- Ensure each business lesson reinforces human oversight and measurable outcomes.
- Replace the default admin password before deployment.
