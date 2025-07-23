<?php include 'header.php'; ?>
<div class="auth-modal" style="margin: 80px auto;">
    <h2>Login to BUSY RIDE</h2>
    <form class="auth-form">
        <div class="input-group">
            <label>Email</label>
            <input type="email" placeholder="Enter your email" required>
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" placeholder="Enter your password" required>
        </div>
        <button type="submit"  class="auth-submit-btn">Log In</button>
        <div class="auth-footer">
            <p>Don't have an account? <a href="register.php" class="switch-auth">Register</a></p>
            <a href="forgot_password.php" class="forgot-password">Forgot password?</a>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?> 