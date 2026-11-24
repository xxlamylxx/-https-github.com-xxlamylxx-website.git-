<?php
$page_title = "Admin Dashboard - EmeraldMoon University";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/sidebar.php';

/** @var mysqli $conn */

$dept_count = 0;
$teacher_count = 0;
$student_count = 0;

if (isset($conn) && $conn instanceof mysqli && !$conn->connect_error) {
    if ($res = $conn->query("SELECT COUNT(*) AS total FROM departments")) {
        $dept_count = (int)($res->fetch_assoc()['total'] ?? 0);
    }
    if ($res = $conn->query("SELECT COUNT(*) AS total FROM teachers")) {
        $teacher_count = (int)($res->fetch_assoc()['total'] ?? 0);
    }
    if ($res = $conn->query("SELECT COUNT(*) AS total FROM students")) {
        $student_count = (int)($res->fetch_assoc()['total'] ?? 0);
    }
}

// Fetch recent student registrations
$recent_students = [];
if (isset($conn) && $conn instanceof mysqli && !$conn->connect_error) {
    $s_query = "SELECT s.name, s.email, d.department_name 
                FROM students s 
                LEFT JOIN departments d ON s.department_id = d.id 
                ORDER BY s.id DESC LIMIT 3";
    if ($res = $conn->query($s_query)) {
        while ($row = $res->fetch_assoc()) {
            $recent_students[] = $row;
        }
    }
}
?>

<!-- Main Content Canvas -->
<main class="dashboard-canvas">

    <!-- Top Row Metrics Cards -->
    <div class="top-cards-grid">
        <div class="hero-metric-card card-gold">
            <div class="card-meta">
                <span class="card-label">Departments</span>
                <h2 class="card-value"><?php echo $dept_count; ?> Active</h2>
            </div>
            <div class="card-graphic">
                <i class="fa-solid fa-building-columns"></i>
            </div>
        </div>

        <div class="hero-metric-card card-darkteal">
            <div class="card-meta">
                <span class="card-label">Total Faculty</span>
                <h2 class="card-value"><?php echo $teacher_count; ?> Teachers</h2>
            </div>
            <div class="card-graphic">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
        </div>

        <div class="hero-metric-card card-maroon">
            <div class="card-meta">
                <span class="card-label">Enrolled Students</span>
                <h2 class="card-value"><?php echo $student_count; ?> Active</h2>
            </div>
            <div class="card-graphic">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>
    </div>

    <!-- Middle Section Grid -->
    <div class="mid-layout-grid">
        
        <!-- Recent Registrations Table -->
        <div class="content-panel-card">
            <div class="panel-header">
                <h3>Recent Registrations</h3>
                <span>Overview of latest students</span>
            </div>
            
            <div class="panel-table-wrapper">
                <table class="panel-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recent_students)): ?>
                            <?php foreach ($recent_students as $st): ?>
                                <tr>
                                    <td>
                                        <div class="table-user">
                                            <div class="table-user-avatar"><i class="fa-solid fa-user"></i></div>
                                            <div>
                                                <strong><?php echo htmlspecialchars($st['name']); ?></strong>
                                                <small><?php echo htmlspecialchars($st['email']); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($st['department_name'] ?? 'General'); ?></td>
                                    <td><span class="badge-pill active">Enrolled</span></td>
                                    <td><a href="students.php" class="btn-link">View Details</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center; opacity: 0.7; padding: 1.5rem;">No recent records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Vertical Bar Chart -->
        <div class="content-panel-card">
            <div class="panel-header">
                <h3>Statistics</h3>
                <span>Course Enrolment Metrics</span>
            </div>
            <div class="bar-chart-wrapper">
                <div class="bar-chart-item">
                    <div class="bar-line" style="--bar-height: 70%;"></div>
                    <span>BCA</span>
                </div>
                <div class="bar-chart-item">
                    <div class="bar-line" style="--bar-height: 95%;"></div>
                    <span>BBA</span>
                </div>
                <div class="bar-chart-item">
                    <div class="bar-line" style="--bar-height: 50%;"></div>
                    <span>B.Com</span>
                </div>
                <div class="bar-chart-item">
                    <div class="bar-line" style="--bar-height: 80%;"></div>
                    <span>B.A</span>
                </div>
                <div class="bar-chart-item">
                    <div class="bar-line" style="--bar-height: 60%;"></div>
                    <span>B.Tech</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Section Grid -->
    <div class="bottom-layout-grid">
        
        <!-- Circular Donut Chart -->
        <div class="content-panel-card">
            <div class="panel-header">
                <h3>Faculty Share</h3>
            </div>
            <div class="donut-chart-container">
                <div class="donut-ring">
                    <div class="donut-inner-text">
                        <strong>100%</strong>
                        <span>Faculty</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Schedule Wave Chart -->
        <div class="content-panel-card">
            <div class="panel-header">
                <h3>Academic Schedule</h3>
            </div>
            <div class="wave-chart-container">
                <div class="wave-badge-tooltip">
                    <i class="fa-solid fa-chart-line"></i> <strong><?php echo $student_count; ?> Enrolled Students</strong>
                </div>
                <div class="wave-chart-illustration">
                    <div class="wave-node node-1"></div>
                    <div class="wave-node node-2"></div>
                    <div class="wave-node node-3"></div>
                </div>
                <div class="wave-labels">
                    <span>Jan</span>
                    <span>Feb</span>
                    <span>Mar</span>
                    <span>Apr</span>
                    <span>May</span>
                    <span>Jun</span>
                </div>
            </div>
        </div>

    </div>

</main>

<?php require_once __DIR__ . '/footer.php'; ?>