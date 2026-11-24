<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Blue Moon College</title>
    <link rel="stylesheet" href="css/style.css?v=2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<aside class="app-sidebar">
    <div>
        <div class="brand-logo">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Smart</span>
        </div>
        <nav class="nav-menu">
            <a href="dashboard.php" class="nav-item active"><i class="fa-solid fa-border-all"></i> Dashboard</a>
            <a href="profile.php" class="nav-item"><i class="fa-regular fa-user"></i> My Profile</a>
            <a href="#" class="nav-item"><i class="fa-solid fa-book-bookmark"></i> Lessons</a>
            <a href="#" class="nav-item"><i class="fa-regular fa-calendar"></i> Schedule</a>
            <a href="#" class="nav-item"><i class="fa-regular fa-folder-open"></i> Materials</a>
            <a href="#" class="nav-item"><i class="fa-regular fa-comments"></i> Forum</a>
            <a href="#" class="nav-item"><i class="fa-regular fa-circle-check"></i> Assessments</a>
            <a href="#" class="nav-item"><i class="fa-solid fa-gear"></i> Settings</a>
        </nav>
    </div>
    <a href="logout.php" class="logout-link"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out</a>
</aside>

<div class="app-main">
    <header class="app-header">
        <div class="search-bar">
            <input type="text" placeholder="Search...">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>

        <div class="header-user-panel">
            <span class="pill-select">ENG <i class="fa-solid fa-chevron-down" style="font-size: 0.65rem;"></i></span>
            <div class="action-icon"><i class="fa-regular fa-envelope"></i></div>
            <div class="action-icon"><i class="fa-regular fa-bell"></i></div>
            <div class="user-profile">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['student_name']) ?>&background=5c72ea&color=fff" alt="Avatar">
                <span class="user-name"><?= htmlspecialchars($_SESSION['student_name']) ?></span>
                <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem; color: #8c93b0;"></i>
            </div>
        </div>
    </header>