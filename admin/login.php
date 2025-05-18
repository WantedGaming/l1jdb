<?php
// Include configuration
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../classes/User.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Check if already logged in
if ($user->isLoggedIn()) {
    // Redirect to admin dashboard
    header('Location: index.php');
    exit;
}

// Handle login form submission
$error = '';
$success = '';

// Check if there was a logout
if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
    $success = 'You have been successfully logged out.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        // Attempt to log in
        if ($user->login($username, $password)) {
            // Redirect to admin dashboard
            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-body">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <img src="../assets/img/favicon/favicon.ico" alt="<?php echo SITE_NAME; ?> Logo">
                </div>
                <h1 class="login-title">Admin Login</h1>
                <p class="login-subtitle">Enter your credentials to access the admin dashboard</p>
            </div>
            
            <form class="login-form" method="post" action="login.php">
                <?php if (!empty($error)): ?>
                <div class="login-error">
                    <p><?php echo $error; ?></p>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($success)): ?>
                <div class="login-success">
                    <p><?php echo $success; ?></p>
                </div>
                <?php endif; ?>
                
                <div class="login-form-group">
                    <label for="username" class="login-label">Username</label>
                    <div class="login-input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" id="username" name="username" class="login-input" placeholder="Enter your username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required autofocus>
                    </div>
                </div>
                
                <div class="login-form-group">
                    <label for="password" class="login-label">Password</label>
                    <div class="login-input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" class="login-input" placeholder="Enter your password" required>
                    </div>
                </div>
                
                <button type="submit" class="login-button">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>
            
            <div class="login-footer">
                <a href="../index.php">Back to Website</a>
            </div>
        </div>
    </div>
    
    <script src="../assets/js/admin.js"></script>
</body>
</html>