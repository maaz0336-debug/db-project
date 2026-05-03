<div class="container py-8">
    <div class="card auth-card" style="max-width: 600px; margin: 0 auto;">
        <h2 style="margin-bottom: 20px; text-align: center;">Register as a Seller</h2>
        <p style="text-align: center; color: var(--text-muted); margin-bottom: 30px;">
            Join our platform and start selling your products to thousands of customers.
        </p>

        <form action="<?= BASE_URL ?>/seller/register" method="POST">
            
            <?php if (!isLoggedIn()): ?>
                <h3 style="margin-bottom: 15px; font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 5px;">Personal Information</h3>
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" required value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="form-group" style="margin-bottom: 30px;">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                </div>
            <?php else: ?>
                <div style="background: var(--bg-hover); padding: 15px; border-radius: 8px; margin-bottom: 30px; text-align: center;">
                    <p style="margin: 0;">You are logged in as <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>.</p>
                    <p style="margin: 5px 0 0 0; color: var(--text-muted); font-size: 0.9rem;">Please provide your store details below to upgrade your account to a seller.</p>
                </div>
            <?php endif; ?>

            <h3 style="margin-bottom: 15px; font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 5px;">Store Information</h3>
            <div class="form-group">
                <label for="store_name">Store Name</label>
                <input type="text" id="store_name" name="store_name" class="form-control" required value="<?= isset($_POST['store_name']) ? htmlspecialchars($_POST['store_name']) : '' ?>">
            </div>

            <div class="form-group">
                <label for="store_description">Store Description (Optional)</label>
                <textarea id="store_description" name="store_description" class="form-control" rows="4"><?= isset($_POST['store_description']) ? htmlspecialchars($_POST['store_description']) : '' ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="width: 100%; margin-top: 20px;">Register Store</button>
        </form>

        <?php if (!isLoggedIn()): ?>
            <div class="auth-links" style="margin-top: 20px; text-align: center;">
                <p>Already have an account? <a href="<?= BASE_URL ?>/login">Login here</a> and then upgrade to a seller.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
