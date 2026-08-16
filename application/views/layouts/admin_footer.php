    </main>

    <!-- APP FOOTER -->
    <footer class="app-footer">
        <span class="footer-text">&copy; <?= date('Y') ?> <strong>RSU Catharina 1914</strong> — Sistem Inventaris & Serah Terima Kamar</span>
        <span class="footer-text">v1.0</span>
    </footer>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Auto-dismiss flash alerts after 5 seconds
document.querySelectorAll('.alert-dismissible').forEach(function(alert) {
    setTimeout(function() {
        var bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
        if (bsAlert) bsAlert.close();
    }, 5000);
});
</script>
</body>
</html>
