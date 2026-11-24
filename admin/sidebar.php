<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="curved-sidebar">
    <div>
        <div class="sidebar-user-card">
            <div class="avatar-ring">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <h3>SYSTEM ADMIN</h3>
            <span>admin@emeraldmoon.edu</span>
        </div>

        <nav class="curved-nav">
            <a href="dashboard.php" class="nav-pill <?php echo ($current_page === 'dashboard.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-chart-pie"></i>
                <span>DASHBOARD</span>
            </a>
            <a href="departments.php" class="nav-pill <?php echo ($current_page === 'departments.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-building-columns"></i>
                <span>DEPARTMENTS</span>
            </a>
            <a href="courses.php" class="nav-pill <?php echo ($current_page === 'courses.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-book-bookmark"></i>
                <span>COURSES</span>
            </a>
            <a href="teachers.php" class="nav-pill <?php echo ($current_page === 'teachers.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span>TEACHERS</span>
            </a>
            <a href="students.php" class="nav-pill <?php echo ($current_page === 'students.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-user-graduate"></i>
                <span>STUDENTS</span>
            </a>
            <a href="logout.php" class="nav-pill logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>SIGN OUT</span>
            </a>
        </nav>
    </div>

    <div class="active-users-block">
        <span class="block-title">ACTIVE FACULTY</span>
        <div class="avatar-stack">
            <div class="mini-avatar">CS</div>
            <div class="mini-avatar">EC</div>
            <div class="mini-avatar">ME</div>
            <div class="mini-avatar count">+<?php echo max(1, $sidebar_teacher_count ?? 0); ?></div>
        </div>
    </div>
</aside>