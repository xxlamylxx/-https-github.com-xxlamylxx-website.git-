<?php
session_start();

// Database Connection
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "college_db";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($email) && !empty($password)) {
        if ($conn->connect_error) {
            $error = "Database connection failed: " . $conn->connect_error;
        } else {
            $stmt = $conn->prepare("SELECT id, name, email, password FROM students WHERE email = ?");
            if ($stmt) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($user = $res->fetch_assoc()) {
                    if ($password === $user['password'] || password_verify($password, $user['password'])) {
                        $_SESSION['student_id'] = $user['id'];
                        $_SESSION['student_name'] = $user['name'];
                        header("Location: student/index.php");
                        exit();
                    } else {
                        $error = "Invalid password.";
                    }
                } else {
                    $error = "No student account found with this email.";
                }
                $stmt->close();
            }
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal Login - EmeraldMoon University</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background: #092624; color: #ffffff; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1.5rem; }
        .login-card { background: #0f3d3a; border-radius: 24px; padding: 2.5rem; width: 100%; max-width: 420px; border: 1px solid #14524e; box-shadow: 0 15px 35px rgba(0,0,0,0.5); }
        .login-header { text-align: center; margin-bottom: 2rem; }
        .login-icon { width: 70px; height: 70px; border-radius: 50%; background: #6c151e; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1rem; border: 2px solid #8b1e2b; box-shadow: 0 4px 15px rgba(0,0,0,0.3); }
        .login-header h2 { font-size: 1.5rem; font-weight: 900; }
        .login-header p { font-size: 0.82rem; opacity: 0.75; margin-top: 0.25rem; }
        .form-group { display: flex; flex-direction: column; gap: 0.4rem; margin-bottom: 1.2rem; }
        .form-group label { font-size: 0.78rem; font-weight: 800; color: #d97706; letter-spacing: 0.5px; }
        .input-wrapper { position: relative; }
        .input-wrapper i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.5); font-size: 0.9rem; }
        .input-wrapper input { width: 100%; background: #092624; border: 1.5px solid #14524e; border-radius: 12px; padding: 0.8rem 1rem 0.8rem 2.6rem; color: #ffffff; outline: none; font-size: 0.9rem; transition: border 0.2s; }
        .input-wrapper input:focus { border-color: #d97706; }
        .btn-submit { width: 100%; background: linear-gradient(135deg, #6c151e 0%, #8b1e2b 100%); color: #ffffff; border: 1px solid rgba(255,255,255,0.15); padding: 0.85rem; border-radius: 12px; font-weight: 800; font-size: 0.95rem; cursor: pointer; transition: transform 0.2s; margin-top: 0.5rem; }
        .btn-submit:hover { transform: translateY(-2px); }
        .error-alert { background: #8b1e2b; color: #ffffff; padding: 0.8rem 1rem; border-radius: 10px; font-size: 0.82rem; font-weight: 700; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 0.5rem; }
        .login-footer { text-align: center; margin-top: 1.5rem; font-size: 0.82rem; opacity: 0.8; }
        .login-footer a { color: #d97706; text-decoration: none; font-weight: 800; }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <div class="login-icon"><i class="fa-solid fa-user-graduate"></i></div>
            <h2>Student Portal</h2>
            <p>EmeraldMoon University Academic Sign In</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-alert">
                <i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>EMAIL ADDRESS</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="student@emeraldmoon.edu" required>
                </div>
            </div>

            <div class="form-group">
                <label>PASSWORD</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" name="login" class="btn-submit">Sign In to Portal</button>
        </form>

        <div class="login-footer">
            <span>Return to main website? <a href="index.php">Click Here</a></span>
        </div>
    </div>

</body>
</html>