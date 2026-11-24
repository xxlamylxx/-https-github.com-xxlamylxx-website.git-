<?php
session_start();
require_once __DIR__ . '/../db.php';

$student_name = $_SESSION['student_name'] ?? 'Fathima Musba';
$student_email = $_SESSION['student_email'] ?? 'fathimamusba671@gmail.com';
$roll_number = $_SESSION['roll_number'] ?? 'cse-002';
$department = $_SESSION['department'] ?? 'Computer Science & Engineering';
$phone = $_SESSION['phone'] ?? '9738258281';
$dob = $_SESSION['dob'] ?? '2006-04-25';
$address = $_SESSION['address'] ?? 'bengaluru';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = trim($_POST['phone'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $address = trim($_POST['address'] ?? '');

    $_SESSION['phone'] = $phone;
    $_SESSION['dob'] = $dob;
    $_SESSION['address'] = $address;

    $message = "Profile details updated successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - EmeraldMoon University</title>
    <link rel="stylesheet" href="css/style.css?v=20">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Sidebar Menu -->
    <aside class="app-sidebar">
        <div>
            <div class="brand-logo">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>EmeraldMoon</span>
            </div>
            <nav class="nav-menu">
                <a href="index.php" class="nav-item"><i class="fa-solid fa-border-all"></i> Dashboard</a>
                <a href="profile.php" class="nav-item active"><i class="fa-solid fa-user-gear"></i> My Profile</a>
                <a href="lessons.php" class="nav-item"><i class="fa-solid fa-book-bookmark"></i> Lessons</a>
                <a href="schedule.php" class="nav-item"><i class="fa-solid fa-calendar-days"></i> Schedule</a>
                <a href="materials.php" class="nav-item"><i class="fa-solid fa-folder-open"></i> Materials</a>
                <a href="forum.php" class="nav-item"><i class="fa-solid fa-comments"></i> Forum</a>
                <a href="assessments.php" class="nav-item"><i class="fa-solid fa-circle-check"></i> Assessments</a>
                <a href="settings.php" class="nav-item"><i class="fa-solid fa-gear"></i> Settings</a>
            </nav>
        </div>
        <a href="../index.php" class="logout-link"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>
    </aside>

    <!-- Main Content Area -->
    <main class="app-main">

        <!-- Top Header Bar -->
        <header class="app-header">
            <div class="search-bar">
                <input type="text" placeholder="Search...">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div class="header-user-panel">
                <div class="action-icon"><i class="fa-solid fa-bell"></i></div>
                <div class="user-profile">
                    <div class="user-avatar-badge">FM</div>
                    <span class="user-name"><?php echo htmlspecialchars($student_name); ?></span>
                </div>
            </div>
        </header>

        <!-- Profile Body -->
        <div class="profile-page-wrapper">

            <?php if (!empty($message)): ?>
                <div class="alert-success-box">
                    <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Hero Banner Section -->
            <div class="profile-hero-card">
                <div class="profile-identity-block">
                    <div class="avatar-upload-wrapper">
                        <div class="large-avatar-badge">FM</div>
                        <div class="btn-upload-photo" title="Upload Photo"><i class="fa-solid fa-camera"></i></div>
                    </div>
                    <div class="profile-titles">
                        <h2><?php echo htmlspecialchars($student_name); ?></h2>
                        <span class="student-tag"><i class="fa-solid fa-graduation-cap"></i> <?php echo htmlspecialchars($department); ?></span>
                    </div>
                </div>
            </div>

            <!-- Profile Details Grid -->
            <div class="profile-details-grid">
                
                <!-- Academic Info -->
                <div class="profile-card-box">
                    <h3 class="box-title"><i class="fa-solid fa-id-card"></i> Academic Info</h3>
                    <div class="info-read-list">
                        <div class="info-field-group">
                            <label>Roll Number</label>
                            <p><?php echo htmlspecialchars($roll_number); ?></p>
                        </div>
                        <div class="info-field-group">
                            <label>Email Address</label>
                            <p><?php echo htmlspecialchars($student_email); ?></p>
                        </div>
                        <div class="info-field-group">
                            <label>Department</label>
                            <p class="highlight-dept"><?php echo htmlspecialchars($department); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Personal Details Form -->
                <div class="profile-card-box">
                    <h3 class="box-title"><i class="fa-solid fa-user-pen"></i> Personal Details</h3>
                    <form action="profile.php" method="POST" class="profile-form">
                        <div class="form-grid-2">
                            <div class="input-field-group">
                                <label><i class="fa-solid fa-phone"></i> Phone Number</label>
                                <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                            </div>
                            <div class="input-field-group">
                                <label><i class="fa-solid fa-calendar"></i> Date of Birth</label>
                                <input type="date" name="dob" value="<?php echo htmlspecialchars($dob); ?>" required>
                            </div>
                        </div>

                        <div class="input-field-group">
                            <label><i class="fa-solid fa-location-dot"></i> Permanent Address</label>
                            <textarea name="address" rows="3" required><?php echo htmlspecialchars($address); ?></textarea>
                        </div>

                        <button type="submit" class="btn-save-profile">
                            <i class="fa-solid fa-floppy-disk"></i> Save Changes
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </main>

</body>
</html>