<?php
$page_title = "Manage Teachers - EmeraldMoon University";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/sidebar.php';

/** @var PDO $pdo */

$message = '';
$error = '';

// Handle Add Teacher Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_teacher'])) {
    $name          = trim($_POST['name'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');
    $qualification = trim($_POST['qualification'] ?? '');
    $dept_id       = !empty($_POST['department_id']) ? intval($_POST['department_id']) : null;

    if (!empty($name) && !empty($email)) {
        if (isset($pdo)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO teachers (name, email, phone, qualification, department_id) VALUES (:name, :email, :phone, :qual, :dept)");
                $stmt->execute([
                    'name'  => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'qual'  => $qualification,
                    'dept'  => $dept_id
                ]);
                $message = "Teacher registered successfully!";
            } catch (PDOException $e) {
                $error = "Error adding teacher: " . $e->getMessage();
            }
        }
    } else {
        $error = "Name and email are required.";
    }
}

// Fetch Departments and Teachers
$departments = [];
$teachers = [];

if (isset($pdo)) {
    try {
        $departments = $pdo->query("SELECT * FROM departments ORDER BY department_name ASC")->fetchAll(PDO::FETCH_ASSOC);
        
        $sql = "SELECT t.*, d.department_name 
                FROM teachers t 
                LEFT JOIN departments d ON t.department_id = d.id 
                ORDER BY t.id DESC";
        $teachers = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Database query error: " . $e->getMessage();
    }
}
?>

<main class="dashboard-canvas">
    <div class="panel-header-title">
        <h2>Teacher Management</h2>
        <p>Manage faculty directory and academic assignments</p>
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
                <h3><i class="fa-solid fa-user-plus"></i> Add Teacher</h3>
            </div>
            <form action="teachers.php" method="POST" class="styled-form">
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
                    <label>FULL NAME</label>
                    <input type="text" name="name" placeholder="e.g. Dr. Alan Turing" required>
                </div>

                <div class="form-group">
                    <label>EMAIL ADDRESS</label>
                    <input type="email" name="email" placeholder="e.g. teacher@emeraldmoon.edu" required>
                </div>

                <div class="form-group">
                    <label>PHONE</label>
                    <input type="text" name="phone" placeholder="e.g. +91 9876543210">
                </div>

                <div class="form-group">
                    <label>QUALIFICATION</label>
                    <input type="text" name="qualification" placeholder="e.g. Ph.D. in Computer Science">
                </div>

                <button type="submit" name="add_teacher" class="btn-submit">
                    <i class="fa-solid fa-floppy-disk"></i> Register Teacher
                </button>
            </form>
        </div>

        <!-- Table Panel Card -->
        <div class="card-panel">
            <div class="card-header">
                <h3><i class="fa-solid fa-chalkboard-user"></i> Faculty Directory</h3>
            </div>
            <div class="table-responsive">
                <table class="panel-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Qualification</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($teachers)): ?>
                            <?php foreach ($teachers as $t): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($t['name'] ?? ''); ?></strong></td>
                                    <td><?php echo htmlspecialchars($t['department_name'] ?? '—'); ?></td>
                                    <td><?php echo htmlspecialchars($t['email'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($t['phone'] ?? '—'); ?></td>
                                    <td><span class="badge-qual"><?php echo htmlspecialchars($t['qualification'] ?? 'M.A.'); ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" style="text-align: center; opacity: 0.7; padding: 2rem;">No teachers registered.</td></tr>
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
.styled-form label { font-size: 0.72rem; font-weight: 800; color: #d97706; letter-spacing: 0.5px; }
.styled-form input, .styled-form select { background: #092624; border: 1.5px solid #14524e; border-radius: 10px; padding: 0.75rem 0.9rem; color: #ffffff; outline: none; font-size: 0.88rem; }
.styled-form input:focus, .styled-form select:focus { border-color: #d97706; }
.btn-submit { background: #6c151e; color: #ffffff; border: none; padding: 0.85rem; border-radius: 10px; font-weight: 800; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-top: 0.5rem; }
.btn-submit:hover { background: #8b1e2b; }
.table-responsive { overflow-x: auto; }
.panel-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem; }
.panel-table th { background: #092624; color: #d97706; padding: 0.85rem 1rem; font-weight: 800; font-size: 0.75rem; letter-spacing: 0.5px; border-bottom: 2px solid #14524e; }
.panel-table td { padding: 0.85rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.05); color: #ffffff; }
.panel-table tr:hover { background: rgba(255,255,255,0.02); }
.badge-qual { background: #6c151e; color: #d97706; border: 1px solid #8b1e2b; padding: 0.2rem 0.55rem; border-radius: 6px; font-weight: 800; font-size: 0.75rem; }
.alert-box { padding: 0.8rem 1.2rem; border-radius: 10px; font-size: 0.85rem; font-weight: 700; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 0.6rem; }
.alert-success { background: #0f3d3a; color: #34d399; border: 1px solid #14524e; }
.alert-danger { background: #6c151e; color: #f87171; border: 1px solid #8b1e2b; }
@media (max-width: 960px) { .grid-layout { grid-template-columns: 1fr; } }
</style>

<?php require_once __DIR__ . '/footer.php'; ?>