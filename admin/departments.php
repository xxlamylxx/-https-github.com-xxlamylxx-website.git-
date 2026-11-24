<?php
$page_title = "Manage Departments - EmeraldMoon University";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/sidebar.php';

/** @var PDO $pdo */

$message = '';
$error = '';

// Handle New Department Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_department'])) {
    $dept_name = trim($_POST['department_name'] ?? '');
    $dept_code = trim($_POST['department_code'] ?? '');

    if (!empty($dept_name) && !empty($dept_code)) {
        if (isset($pdo)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO departments (department_name, department_code) VALUES (:name, :code)");
                $stmt->execute([
                    'name' => $dept_name,
                    'code' => strtoupper($dept_code)
                ]);
                $message = "Department added successfully!";
            } catch (PDOException $e) {
                $error = "Error adding department: " . $e->getMessage();
            }
        }
    } else {
        $error = "Please fill in all fields.";
    }
}

// Fetch all departments
$departments = [];
if (isset($pdo)) {
    try {
        $stmt = $pdo->query("SELECT * FROM departments ORDER BY id DESC");
        $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Failed to load departments: " . $e->getMessage();
    }
}
?>

<main class="dashboard-canvas">
    
    <div class="panel-header-title">
        <h2>Department Management</h2>
        <p>Configure university academic divisions and department codes</p>
    </div>

    <?php if (!empty($message)): ?>
        <div class="alert-box alert-success">
            <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert-box alert-danger">
            <i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="dept-grid-layout">
        
        <!-- Add Department Form -->
        <div class="content-panel-card form-card">
            <div class="panel-header">
                <h3><i class="fa-solid fa-folder-plus"></i> Add Department</h3>
            </div>
            
            <form action="departments.php" method="POST" class="styled-form">
                <div class="form-group">
                    <label>DEPARTMENT NAME</label>
                    <input type="text" name="department_name" placeholder="e.g. Computer Science & Engineering" required>
                </div>

                <div class="form-group">
                    <label>DEPARTMENT CODE</label>
                    <input type="text" name="department_code" placeholder="e.g. CSE" required>
                </div>

                <button type="submit" name="add_department" class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i> Save Department
                </button>
            </form>
        </div>

        <!-- Departments List Table -->
        <div class="content-panel-card table-card">
            <div class="panel-header">
                <h3><i class="fa-solid fa-building-columns"></i> Active Departments</h3>
            </div>

            <div class="panel-table-wrapper">
                <table class="panel-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Department Name</th>
                            <th style="width: 120px;">Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($departments)): ?>
                            <?php foreach ($departments as $dept): ?>
                                <tr>
                                    <td><strong>#<?php echo htmlspecialchars($dept['id']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($dept['department_name'] ?? $dept['name'] ?? ''); ?></td>
                                    <td>
                                        <span class="badge-code">
                                            <?php echo htmlspecialchars($dept['department_code'] ?? $dept['code'] ?? ''); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" style="text-align: center; opacity: 0.7; padding: 2rem;">
                                    No departments found in database.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</main>

<style>
.panel-header-title { margin-bottom: 1.5rem; }
.panel-header-title h2 { font-size: 1.6rem; font-weight: 900; color: #ffffff; }
.panel-header-title p { font-size: 0.85rem; opacity: 0.75; margin-top: 0.2rem; }

.dept-grid-layout { display: grid; grid-template-columns: 320px 1fr; gap: 1.5rem; }

.styled-form { display: flex; flex-direction: column; gap: 1.2rem; padding-top: 0.5rem; }
.styled-form .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
.styled-form label { font-size: 0.75rem; font-weight: 800; color: #d97706; letter-spacing: 0.5px; }
.styled-form input { background: #092624; border: 1.5px solid #14524e; border-radius: 10px; padding: 0.8rem 1rem; color: #ffffff; outline: none; font-size: 0.9rem; }
.styled-form input:focus { border-color: #d97706; }

.btn-save { background: #6c151e; color: #ffffff; border: none; padding: 0.85rem; border-radius: 10px; font-weight: 800; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: background 0.2s, transform 0.1s; }
.btn-save:hover { background: #8b1e2b; transform: translateY(-2px); }

.badge-code { background: #6c151e; color: #d97706; border: 1px solid #8b1e2b; padding: 0.25rem 0.6rem; border-radius: 6px; font-weight: 800; font-size: 0.8rem; letter-spacing: 0.5px; }

.alert-box { padding: 0.8rem 1.2rem; border-radius: 10px; font-size: 0.85rem; font-weight: 700; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 0.6rem; }
.alert-success { background: #0f3d3a; color: #34d399; border: 1px solid #14524e; }
.alert-danger { background: #6c151e; color: #f87171; border: 1px solid #8b1e2b; }

@media (max-width: 900px) {
    .dept-grid-layout { grid-template-columns: 1fr; }
}
</style>

<?php require_once __DIR__ . '/footer.php'; ?>