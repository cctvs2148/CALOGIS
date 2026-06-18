</main>
<footer class="bg-navy text-white py-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-6">
                <h5>Logistics College</h5>
                <p>Leading logistics and supply chain education with a focus on career-ready training and industry partnerships.</p>
            </div>
            <div class="col-md-3">
                <h6>Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="<?= e(site_url('pages/about.php')) ?>" class="text-white">About</a></li>
                    <li><a href="<?= e(site_url('pages/courses.php')) ?>" class="text-white">Courses</a></li>
                    <li><a href="<?= e(site_url('pages/contact.php')) ?>" class="text-white">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6>Contact</h6>
                <p class="mb-1"><?= e(get_setting($pdo, 'contact_email', 'info@logisticscollege.edu')) ?></p>
                <p class="mb-1"><?= e(get_setting($pdo, 'contact_phone', '+1 234 567 890')) ?></p>
            </div>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= e(site_url('assets/js/main.js')) ?>"></script>
</body>
</html>
