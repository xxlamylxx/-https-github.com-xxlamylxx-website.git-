<?php
$page_title = "Manage Courses - EmeraldMoon University";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/sidebar.php';

/** @var PDO $pdo */

$message = '';
$error = '';

// Handle Add Course Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_course'])) {
    $course_name = trim($_POST['course_name'] ?? '');
    $course_code = trim($_POST['course_code'] ?? '');
    $dept_id     = !empty($_POST['department_id']) ? intval($_POST['department_id']) : null;
    $teacher_id  = !empty($_POST['teacher_id']) ? intval($_POST['teacher_id']) : null;
    $credits     = !empty($_POST['credits']) ? intval($_POST['credits']) : 3;
    $description = trim($_POST['description'] ?? '');

    if (!empty($course_name) && !empty($course_code)) {
        if (isset($pdo)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO courses (course_name, course_code, department_id, teacher_id, credits, description) VALUES (:name, :code, :dept, :teacher, :credits, :desc)");
                $stmt->execute([
                    'name'    => $course_name,
                    'code'    => strtoupper($course_code),
                    'dept'    => $dept_id,
                    'teacher' => $teacher_id,
                    'credits' => $credits,
                    'desc'    => $description
                ]);
                $message = "Course created successfully!";
            } catch (PDOException $e) {
                $error = "Error adding course: " . $e->getMessage();
            }
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}

// Fetch Departments, Teachers, and Courses
$departments = [];
$teachers = [];
$courses = [];

if (isset($pdo)) {
    try {
        $departments = $pdo->query("SELECT * FROM departments ORDER BY department_name ASC")->fetchAll(PDO::FETCH_ASSOC);
        $teachers    = $pdo->query("SELECT * FROM teachers ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
        
        $sql = "SELECT c.*, d.department_name, t.name as teacher_name 
                FROM courses c 
                LEFT JOIN departments d ON c.department_id = d.id 
                LEFT JOIN teachers t ON c.teacher_id = t.id 
                ORDER BY c.id DESC";
        $courses = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Database query error: " . $e->getMessage();
    }
}
?>

<main class="dashboard-canvas">
    <div class="panel-header-title">
        <h2>Course Management</h2>
        <p>Configure university curriculum and instructor assignments</p>
    </div>

    <?php if (!empty($message)): ?>
        <div class="alert-box alert-success"><i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert-box alert-danger"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="grid-layout">
        <!-- Form Panel Card -->
        <div class="card-panel">
            <div class="card-header">
                <h3><i class="fa-solid fa-book-medical"></i> Add Course</h3>
            </div>
            <form action="courses.php" method="POST" class="styled-form">
                <div class="form-group">
                    <label>DEPARTMENT</label>
                    <select name="department_id" required>
                        <option value="">-- Select Department --</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?php echo $dept['id']; ?>"><?php echo htmlspecialchars($dept['department_name'] ?? $dept['name'] ?? ''); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>ASSIGNED TEACHER</label>
                    <select name="teacher_id">
                        <option value="">-- Optional / Unassigned --</option>
                        <?php foreach ($teachers as $t): ?>
                            <option value="<?php echo $t['id']; ?>"><?php echo htmlspecialchars($t['name'] ?? ''); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>COURSE NAME</label>
                    <input type="text" name="course_name" placeholder="e.g. Data Structures & Algorithms" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>COURSE CODE</label>
                        <input type="text" name="course_code" placeholder="e.g. CSE201" required>
                    </div>
                    <div class="form-group">
                        <label>CREDITS</label>
                        <input type="number" name="credits" value="3" min="1" max="6" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>DESCRIPTION</label>
                    <textarea name="description" rows="3" placeholder="Brief description..."></textarea>
                </div>

                <button type="submit" name="add_course" class="btn-submit">
                    <i class="fa-solid fa-floppy-disk"></i> Save Course
                </button>
            </form>
        </div>

        <!-- Table Panel Card -->
        <div class="card-panel">
            <div class="card-header">
                <h3><i class="fa-solid fa-book-open"></i> Active Courses</h3>
            </div>
            <div class="table-responsive">
                <table class="panel-table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Teacher</th>
                            <th style="width: 70px;">Credits</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($courses)): ?>
                            <?php foreach ($courses as $c): ?>
                                <tr>
                                    <td><span class="badge-code"><?php echo htmlspecialchars($c['course_code'] ?? ''); ?></span></td>
                                    <td><strong><?php echo htmlspecialchars($c['course_name'] ?? ''); ?></strong></td>
                                    <td><?php echo htmlspecialchars($c['department_name'] ?? '—'); ?></td>
                                    <td><?php echo htmlspecialchars($c['teacher_name'] ?? 'Unassigned'); ?></td>
                                    <td><span class="badge-credit"><?php echo htmlspecialchars($c['credits'] ?? '3'); ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" style="text-align: center; opacity: 0.7; padding: 2rem;">No courses found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<style>
.panel-header-title h2 { font-size: 1.6rem; font-weight: 900; color: #ffffff; }
.panel-header-title p { font-size: 0.85rem; opacity: 0.75; margin-top: 0.2rem; margin-bottom: 1.5rem; }
.grid-layout { display: grid; grid-template-columns: 340px 1fr; gap: 1.5rem; }
.card-panel { background: #0f3d3a; border-radius: 20px; border: 1.5px solid #14524e; padding: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.3); }
.card-header h3 { font-size: 1.1rem; color: #ffffff; font-weight: 800; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 0.5rem; }
.card-header i { color: #d97706; }
.styled-form { display: flex; flex-direction: column; gap: 1rem; }
.form-group { display: flex; flex-direction: column; gap: 0.35rem; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; }
.styled-form label { font-size: 0.72rem; font-weight: 800; color: #d97706; letter-spacing: 0.5px; }
.styled-form input, .styled-form select, .styled-form textarea { background: #092624; border: 1.5px solid #14524e; border-radius: 10px; padding: 0.75rem 0.9rem; color: #ffffff; outline: none; font-size: 0.88rem; }
.styled-form input:focus, .styled-form select:focus, .styled-form textarea:focus { border-color: #d97706; }
.btn-submit { background: #6c151e; color: #ffffff; border: none; padding: 0.85rem; border-radius: 10px; font-weight: 800; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-top: 0.5rem; }
.btn-submit:hover { background: #8b1e2b; }
.table-responsive { overflow-x: auto; }
.panel-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem; }
.panel-table th { background: #092624; color: #d97706; padding: 0.85rem 1rem; font-weight: 800; font-size: 0.75rem; letter-spacing: 0.5px; border-bottom: 2px solid #14524e; }
.panel-table td { padding: 0.85rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.05); color: #ffffff; }
.panel-table tr:hover { background: rgba(255,255,255,0.02); }
.badge-code { background: #6c151e; color: #ffffff; padding: 0.2rem 0.5rem; border-radius: 6px; font-weight: 800; font-size: 0.78rem; }
.badge-credit { background: #092624; border: 1px solid #14524e; color: #d97706; padding: 0.15rem 0.5rem; border-radius: 6px; font-weight: 800; }
.alert-box { padding: 0.8rem 1.2rem; border-radius: 10px; font-size: 0.85rem; font-weight: 700; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 0.6rem; }
.alert-success { background: #0f3d3a; color: #34d399; border: 1px solid #14524e; }
.alert-danger { background: #6c151e; color: #f87171; border: 1px solid #8b1e2b; }
@media (max-width: 960px) { .grid-layout { grid-template-columns: 1fr; } }
</style>

<?php require_once __DIR__ . '/footer.php'; ?>