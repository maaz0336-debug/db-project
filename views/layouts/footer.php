<?php
// views/layouts/footer.php
?>
</main> <!-- End Main Container -->

<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="logo mb-4" style="color: white;">
                    Selling<span style="color: var(--primary-color);">.</span>
                </div>
                <p style="color: #A0AEC0; font-size: 14px;">The premier destination for online shopping, providing the best deals and quality products.</p>
            </div>
            <div class="footer-col">
                <h4>Customer Care</h4>
                <ul>
                    <li><a href="<?= BASE_URL ?>/help">Help Center</a></li>
                    <li><a href="<?= BASE_URL ?>/help">How to Buy</a></li>
                    <li><a href="<?= BASE_URL ?>/help">Returns & Refunds</a></li>
                    <li><a href="<?= BASE_URL ?>/help">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4><?= APP_NAME ?></h4>
                <ul>
                    <li><a href="<?= BASE_URL ?>/about">About Us</a></li>
                    <li><a href="<?= BASE_URL ?>/careers">Careers</a></li>
                    <li><a href="<?= BASE_URL ?>/seller/register">Sell on <?= APP_NAME ?></a></li>
                    <li><a href="<?= BASE_URL ?>/privacy">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Payment Methods</h4>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <div style="background: white; padding: 5px 10px; border-radius: 4px; color: black; font-weight: bold; font-size: 12px;">VISA</div>
                    <div style="background: white; padding: 5px 10px; border-radius: 4px; color: black; font-weight: bold; font-size: 12px;">MasterCard</div>
                    <div style="background: white; padding: 5px 10px; border-radius: 4px; color: black; font-weight: bold; font-size: 12px;">COD</div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; <?= date('Y') ?> <?= APP_NAME ?>. All Rights Reserved.
        </div>
    </div>
</footer>

<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
</body>
</html>
