<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Admin - EmeraldMoon University'; ?></title>
    <link rel="stylesheet" href="css/style.css?v=700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// AUTH GUARD
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require_once __DIR__ . '/../db.php';
global $pdo;

// Fetch active teacher count for sidebar badge
$sidebar_teacher_count = 0;
if (isset($pdo)) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM teachers");
        $sidebar_teacher_count = (int)($stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
    } catch (PDOException $e) {
        $sidebar_teacher_count = 0;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Admin - EmeraldMoon University'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background: #092624; color: #ffffff; min-height: 100vh; display: flex; }

        /* Curved Vertical Sidebar Rules */
        .curved-sidebar {
            width: 260px;
            min-width: 260px;
            background: #6c151e;
            height: 100vh;
            padding: 2rem 1.2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-top-right-radius: 30px;
            border-bottom-right-radius: 30px;
            box-shadow: 5px 0 25px rgba(0,0,0,0.4);
            border-right: 1px solid #8b1e2b;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
        }

        .sidebar-user-card {
            text-align: center;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1.5rem;
        }

        .avatar-ring {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: #0f3d3a;
            color: #d97706;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin: 0 auto 0.8rem;
            border: 2px solid #14524e;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .sidebar-user-card h3 { font-size: 1.05rem; font-weight: 900; color: #ffffff; letter-spacing: 0.5px; }
        .sidebar-user-card span { font-size: 0.75rem; opacity: 0.75; color: #ffffff; }

        .curved-nav { display: flex; flex-direction: column; gap: 0.5rem; }

        .nav-pill {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.85rem 1.2rem;
            color: #ffffff;
            text-decoration: none;
            font-weight: 800;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border-radius: 14px;
            transition: all 0.2s ease;
        }

        .nav-pill i { font-size: 1.1rem; width: 22px; text-align: center; color: rgba(255,255,255,0.8); }

        .nav-pill:hover {
            background: rgba(255,255,255,0.1);
            color: #ffffff;
            transform: translateX(4px);
        }

        .nav-pill.active {
            background: #0f3d3a;
            color: #ffffff;
            border: 1px solid #14524e;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .nav-pill.active i { color: #d97706; }
        .nav-pill.logout { margin-top: 1rem; color: #f87171; }
        .nav-pill.logout i { color: #f87171; }
        .nav-pill.logout:hover { background: rgba(248, 113, 113, 0.15); }

        .active-users-block {
            background: #541017;
            padding: 1rem;
            border-radius: 16px;
            border: 1px solid #8b1e2b;
        }

        .block-title { font-size: 0.7rem; font-weight: 900; color: #d97706; letter-spacing: 0.5px; display: block; margin-bottom: 0.6rem; }
        
        .avatar-stack { display: flex; align-items: center; gap: 0.3rem; }
        .mini-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #0f3d3a;
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid #6c151e;
        }
        .mini-avatar.count { background: #d97706; color: #000000; font-weight: 900; }

        /* Shift content area clear of fixed 260px sidebar */
        .dashboard-canvas {
            margin-left: 260px;
            flex: 1;
            padding: 2rem 2.5rem;
            min-height: 100vh;
            background: #092624;
            width: calc(100% - 260px);
        }
    </style>
</head>
<body>