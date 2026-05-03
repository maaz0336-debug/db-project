<?php
// views/auth/register.php
?>
<div class="card" style="max-width: 500px; margin: 40px auto; padding: 30px;">
    <h2 class="text-center mb-4" style="color: var(--primary-color);">Create an Account</h2>
    <p class="text-center text-muted mb-8">Join <?= APP_NAME ?> today for the best shopping experience.</p>
    
    <form action="<?= BASE_URL ?>/register" method="POST">
        <div class="form-group">
            <label class="form-label" for="name">Full Name</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="John Doe" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="you@example.com" required>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="At least 6 characters" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Retype your password" required>
        </div>
        
        <button type="submit" class="btn btn-primary btn-block mt-4">Register</button>
    </form>
    
    <div class="text-center mt-4" style="font-size: 14px;">
        Already have an account? <a href="<?= BASE_URL ?>/login" style="color: var(--primary-color); font-weight: 600;">Login</a>
    </div>
</div>
