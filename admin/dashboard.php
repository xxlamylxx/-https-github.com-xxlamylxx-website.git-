<?php
$page_title = "Admin Dashboard - EmeraldMoon University";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/sidebar.php';

/** @var PDO $pdo */

$total_departments = 0;
$total_teachers = 0;
$total_students = 0;
$total_courses = 0;
$recent_students = [];
$dept_stats = [];

if (isset($pdo)) {
    try {
        // 1. Total Departments
        $stmt = $pdo->query("SELECT COUNT(*) FROM departments");
        $total_departments = (int)$stmt->fetchColumn();

        // 2. Total Teachers
        $stmt = $pdo->query("SELECT COUNT(*) FROM teachers");
        $total_teachers = (int)$stmt->fetchColumn();

        // 3. Total Students
        $stmt = $pdo->query("SELECT COUNT(*) FROM students");
        $total_students = (int)$stmt->fetchColumn();

        // 4. Total Courses
        $stmt = $pdo->query("SELECT COUNT(*) FROM courses");
        $total_courses = (int)$stmt->fetchColumn();

        // 5. Recent Student Registrations (Latest 5)
        $sql_recent = "SELECT s.*, d.department_name 
                       FROM students s 
                       LEFT JOIN departments d ON s.department_id = d.id 
                       ORDER BY s.id DESC LIMIT 5";
        $recent_students = $pdo->query($sql_recent)->fetchAll(PDO::FETCH_ASSOC);

        // 6. Department breakdown for metrics chart
        $sql_dept_stats = "SELECT d.department_name, d.department_code, COUNT(s.id) as student_count 
                           FROM departments d 
                           LEFT JOIN students s ON s.department_id = d.id 
                           GROUP BY d.id 
                           LIMIT 5";
        $dept_stats = $pdo->query($sql_dept_stats)->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        // Fallback gracefully if schema uses alternate column naming
    }
}
?>

<main class="dashboard-canvas">
    
    <div class="panel-header-title">
        <h2>System Dashboard</h2>
        <p>Real-time university overview and metric analytics</p>
    </div>

    <!-- Top KPI Metric Cards -->
    <div class="kpi-grid">
        <div class="kpi-card kpi-amber">
            <div class="kpi-info">
                <span>Departments</span>
                <h3><?php echo $total_departments; ?> <i>Active</i></h3>
            </div>
            <div class="kpi-icon"><i class="fa-solid fa-building-columns"></i></div>
        </div>

        <div class="kpi-card kpi-teal">
            <div class="kpi-info">
                <span>Total Faculty</span>
                <h3><?php echo $total_teachers; ?> <i>Teachers</i></h3>
            </div>
            <div class="kpi-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
        </div>

        <div class="kpi-card kpi-maroon">
            <div class="kpi-info">
                <span>Enrolled Students</span>
                <h3><?php echo $total_students; ?> <i>Active</i></h3>
            </div>
            <div class="kpi-icon"><i class="fa-solid fa-user-graduate"></i></div>
        </div>
    </div>

    <!-- Middle Content Grid -->
    <div class="dashboard-grid">
        
        <!-- Recent Registrations Table -->
        <div class="dashboard-card">
            <div class="card-header">
                <div>
                    <h3>Recent Registrations</h3>
                    <p>Overview of latest student enrollments</p>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Roll No</th>
                            <th>Department</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recent_students)): ?>
                            <?php foreach ($recent_students as $st): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo htmlspecialchars($st['name'] ?? ''); ?></strong><br>
                                        <small style="opacity: 0.7;"><?php echo htmlspecialchars($st['email'] ?? ''); ?></small>
                                    </td>
                                    <td><span class="badge-roll"><?php echo htmlspecialchars($st['roll_no'] ?? 'N/A'); ?></span></td>
                                    <td><?php echo htmlspecialchars($st['department_name'] ?? $st['department'] ?? 'General'); ?></td>
                                    <td><span class="status-active"><i class="fa-solid fa-circle"></i> Active</span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="no-records">No recent records found in database.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Statistics Panel -->
        <div class="dashboard-card">
            <div class="card-header">
                <div>
                    <h3>Department Metrics</h3>
                    <p>Student distribution by department</p>
                </div>
            </div>

            <div class="bar-chart-container">
                <?php if (!empty($dept_stats)): ?>
                    <?php foreach ($dept_stats as $stat): ?>
                        <?php 
                            $code = htmlspecialchars($stat['department_code'] ?? $stat['department_name'] ?? 'DEPT');
                            $count = (int)($stat['student_count'] ?? 0);
                            $height = min(100, max(20, $count * 15));
                        ?>
                        <div class="bar-column">
                            <div class="bar-fill" style="height: <?php echo $height; ?>%;"></div>
                            <span class="bar-label"><?php echo $code; ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bar-column"><div class="bar-fill" style="height: 60%;"></div><span class="bar-label">CSE</span></div>
                    <div class="bar-column"><div class="bar-fill" style="height: 85%;"></div><span class="bar-label">BA</span></div>
                    <div class="bar-column"><div class="bar-fill" style="height: 45%;"></div><span class="bar-label">ME</span></div>
                <?php endif; ?>
            </div>
        </div>

    </div>

</main>

<style>
.panel-header-title { margin-bottom: 1.5rem; }
.panel-header-title h2 { font-size: 1.6rem; font-weight: 900; color: #ffffff; }
.panel-header-title p { font-size: 0.85rem; opacity: 0.75; margin-top: 0.2rem; }

.kpi-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 1.5rem; }
.kpi-card { border-radius: 20px; padding: 1.5rem; display: flex; align-items: center; justify-content: space-between; color: #ffffff; box-shadow: 0 10px 25px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); }
.kpi-amber { background: #d97706; }
.kpi-teal { background: #0f3d3a; border-color: #14524e; }
.kpi-maroon { background: #6c151e; border-color: #8b1e2b; }

.kpi-info span { font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9; }
.kpi-info h3 { font-size: 1.8rem; font-weight: 900; margin-top: 0.2rem; }
.kpi-info h3 i { font-size: 0.9rem; font-weight: 600; font-style: normal; opacity: 0.85; }
.kpi-icon { width: 55px; height: 55px; border-radius: 14px; background: rgba(0,0,0,0.15); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }

.dashboard-grid { display: grid; grid-template-columns: 1.8fr 1.2fr; gap: 1.5rem; }
.dashboard-card { background: #0f3d3a; border-radius: 20px; border: 1.5px solid #14524e; padding: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.3); }
.card-header h3 { font-size: 1.1rem; color: #ffffff; font-weight: 800; }
.card-header p { font-size: 0.78rem; opacity: 0.75; margin-top: 0.2rem; margin-bottom: 1.2rem; }

.table-wrapper { overflow-x: auto; }
.dash-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem; }
.dash-table th { background: #092624; color: #d97706; padding: 0.75rem 0.9rem; font-weight: 800; font-size: 0.75rem; border-bottom: 2px solid #14524e; }
.dash-table td { padding: 0.85rem 0.9rem; border-bottom: 1px solid rgba(255,255,255,0.05); color: #ffffff; }
.dash-table tr:hover { background: rgba(255,255,255,0.02); }

.badge-roll { background: #6c151e; color: #d97706; border: 1px solid #8b1e2b; padding: 0.2rem 0.55rem; border-radius: 6px; font-weight: 800; font-size: 0.75rem; }
.status-active { color: #34d399; font-size: 0.78rem; font-weight: 800; }
.status-active i { font-size: 0.5rem; vertical-align: middle; margin-right: 0.2rem; }
.no-records { text-align: center; opacity: 0.7; padding: 2rem !important; }

.bar-chart-container { display: flex; align-items: flex-end; justify-content: space-around; height: 180px; padding-top: 1rem; border-bottom: 2px solid #14524e; }
.bar-column { display: flex; flex-direction: column; align-items: center; height: 100%; justify-content: flex-end; width: 40px; }
.bar-fill { width: 24px; background: #d97706; border-top-left-radius: 6px; border-top-right-radius: 6px; transition: height 0.5s ease; }
.bar-label { font-size: 0.75rem; font-weight: 800; color: #ffffff; margin-top: 0.6rem; }

@media (max-width: 1024px) {
    .kpi-grid { grid-template-columns: 1fr; }
    .dashboard-grid { grid-template-columns: 1fr; }
}
</style>

<?php require_once __DIR__ . '/footer.php'; ?>