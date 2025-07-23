<?php include 'header.php'; ?>
<div class="auth-modal" style="margin: 80px auto;">
    <h2>Create Your Account</h2>
    <form class="auth-form">
        <div class="input-group">
            <label>Full Name</label>
            <input type="text" placeholder="Enter your full name" required>
        </div>
        <div class="input-group">
            <label>Email</label>
            <input type="email" placeholder="Enter your email" required>
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" placeholder="Create a password" required>
        </div>
        <div class="input-group">
            <label>Confirm Password</label>
            <input type="password" placeholder="Confirm your password" required>
        </div>
        <button type="submit" class="auth-submit-btn">Register</button>
        <div class="auth-footer">
            <p>Already have an account? <a href="login.php" class="switch-auth">Log In</a></p>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?> 