</main>
<footer class="footer academy-footer">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-6">
                <a class="brand-mark footer-brand" href="<?= academy_url('index.php'); ?>"><img class="logo-mark" src="<?= site_url('assets/images/mugah-deeptech-logo.svg'); ?>" alt="" aria-hidden="true"><span class="brand-text">Mugah DeepTech Academy</span></a>
                <p class="mt-3">Learn AI. Master Data. Build Intelligent Solutions.</p>
            </div>
            <div class="col-lg-3"><h6>Academy</h6><a href="<?= academy_url('courses.php'); ?>">Course Catalog</a><a href="<?= academy_url('dashboard.php'); ?>">Learner Dashboard</a></div>
            <div class="col-lg-3"><h6>Company</h6><a href="<?= site_url('services.php'); ?>">Consulting Services</a><a href="<?= site_url('contact.php'); ?>">Contact</a></div>
        </div>
        <div class="footer-bottom"><span>&copy; <?= date('Y'); ?> Mugah DeepTech Academy</span><span>AI, Data & Automation Learning</span></div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= site_url('assets/js/main.js'); ?>"></script>
</body>
</html>