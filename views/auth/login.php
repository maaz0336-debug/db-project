<?php
// views/auth/login.php
?>
<div class="card" style="max-width: 400px; margin: 40px auto; padding: 30px;">
    <h2 class="text-center mb-4" style="color: var(--primary-color);">Welcome Back</h2>
    <p class="text-center text-muted mb-8">Login to your account to continue shopping.</p>
    
    <form action="<?= BASE_URL ?>/login" method="POST">
        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="you@example.com" required>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; font-size: 14px;">
            <label style="display: flex; align-items: center; gap: 5px;">
                <input type="checkbox"> Remember me
            </label>
            <a href="#" style="color: var(--primary-color);">Forgot Password?</a>
        </div>
        
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
    
    <div class="text-center mt-4" style="font-size: 14px;">
        Don't have an account? <a href="<?= BASE_URL ?>/register" style="color: var(--primary-color); font-weight: 600;">Sign Up</a>
    </div>
</div>
