<?php if ($_SESSION['role'] == 'admin'): ?>
    </div>
    </div>
<?php else: ?>
    </div>
<?php endif; ?>
    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-section info-section">
                <p>&copy; <?php echo date('Y'); ?> EcoShift. All rights reserved.</p>
                <p>EcoShift adalah aplikasi web untuk mengatur jadwal pembuangan sampah siswa PPLG, membantu menjaga kebersihan lingkungan sekolah.</p>
            </div>
            <div class="footer-section contact-section">
                <p>Email Admin: admin@ecoshift.com</p>
                <p>Nomor Admin: 0824-9856-4573</p>
                <p>Alamat Admin: Jl.Kuncen, Purwasaba, Mandiraja</p>
            </div>
        </div>
    </footer>
    <button id="scrollTopBtn" title="Kembali ke atas">&uarr;</button>
    <script src="assets/js/script.js"></script>
</body>
</html>