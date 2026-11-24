<?php 
include_once __DIR__ . '/includes/header.php'; 
require_once __DIR__ . '/db.php';

// Safe Database Query Execution
$courses_list = [];

if (isset($conn) && $conn instanceof mysqli && !$conn->connect_error) {
    $query = "SELECT courses.*, departments.department_name 
              FROM courses 
              LEFT JOIN departments ON courses.department_id = departments.id 
              ORDER BY courses.id ASC";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $courses_list[] = $row;
        }
    }
}

// Fallback catalog if database records are empty
if (empty($courses_list)) {
    $courses_list = [
        [
            'course_code' => 'BCA101',
            'course_name' => 'Bachelor of Computer Applications (BCA)',
            'department_name' => 'Computer Applications',
            'credits' => 4,
            'description' => 'Full-stack software engineering, database management systems, web technologies, and algorithm design.'
        ],
        [
            'course_code' => 'BBA101',
            'course_name' => 'Bachelor of Business Administration (BBA)',
            'department_name' => 'Business Administration',
            'credits' => 4,
            'description' => 'Core principles of organizational management, marketing strategy, human resources, and business leadership.'
        ],
        [
            'course_code' => 'BCOM101',
            'course_name' => 'Bachelor of Commerce (B.Com)',
            'department_name' => 'Commerce & Finance',
            'credits' => 4,
            'description' => 'Financial accounting, corporate taxation, auditing procedures, commercial law, and banking systems.'
        ],
        [
            'course_code' => 'BA101',
            'course_name' => 'Bachelor of Arts (B.A)',
            'department_name' => 'Arts & Humanities',
            'credits' => 3,
            'description' => 'Comprehensive study in literature, political science, history, sociology, and modern communication studies.'
        ],
        [
            'course_code' => 'BED101',
            'course_name' => 'Bachelor of Education (B.Ed)',
            'department_name' => 'Education & Pedagogy',
            'credits' => 4,
            'description' => 'Pedagogical strategies, educational psychology, curriculum design, and modern classroom technology training.'
        ],
        [
            'course_code' => 'BE101',
            'course_name' => 'Bachelor of Engineering (B.E / B.Tech)',
            'department_name' => 'Engineering & Technology',
            'credits' => 4,
            'description' => 'Core engineering principles, hardware design, systems architecture, embedded programming, and innovation labs.'
        ]
    ];
}
?>

<!-- Hero Banner -->
<section class="page-banner">
    <div class="banner-inner">
        <h1>Academic Programs & Courses</h1>
        <p>Explore our undergraduate programs tailored for technical innovation, business leadership, and research.</p>
    </div>
</section>

<!-- Academics Main Body -->
<main class="academics-page-wrapper">
    <div class="academics-container">

        <div class="academics-header-bar">
            <div>
                <h2>Available Degree Programs</h2>
                <span class="academics-subtitle">Browse through active degree courses offered at EmeraldMoon University</span>
            </div>
            <div class="course-count-badge">
                <i class="fa-solid fa-book-open"></i> 
                <?php echo count($courses_list); ?> Programs Available
            </div>
        </div>

        <div class="courses-card-grid">
            <?php foreach ($courses_list as $course): ?>
                <div class="course-card">
                    <div class="course-card-top">
                        <span class="dept-badge">
                            <i class="fa-solid fa-layer-group"></i> 
                            <?php echo htmlspecialchars($course['department_name'] ?? 'Degree Program'); ?>
                        </span>
                        <span class="credits-badge">
                            <strong><?php echo htmlspecialchars($course['credits']); ?></strong> Credits
                        </span>
                    </div>

                    <h3 class="course-title"><?php echo htmlspecialchars($course['course_name']); ?></h3>
                    
                    <div class="course-code-tag">
                        <i class="fa-solid fa-hashtag"></i> Code: <span><?php echo htmlspecialchars($course['course_code']); ?></span>
                    </div>

                    <p class="course-desc">
                        <?php echo htmlspecialchars($course['description']); ?>
                    </p>

                    <div class="course-card-footer">
                        <span class="status-indicator"><i class="fa-solid fa-circle-check"></i> Admissions Open</span>
                        <a href="student/index.php" class="btn-enroll">Portal Access <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>