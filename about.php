<?php include_once __DIR__ . '/includes/header.php'; ?>

<!-- Top Page Banner -->
<section class="page-banner">
    <div class="banner-inner">
        <h1>About Us</h1>
        <p>Empowering generations of innovators, technicians, and scholars through academic distinction and values.</p>
    </div>
</section>

<!-- Brand / Partner Logos Strip -->
<div class="partner-strip">
    <div class="partner-item"><i class="fa-solid fa-microchip"></i> TECH RESEARCH</div>
    <div class="partner-item"><i class="fa-solid fa-award"></i> GLOBAL ACCREDITED</div>
    <div class="partner-item"><i class="fa-solid fa-book-bookmark"></i> OPEN LIBRARY</div>
    <div class="partner-item"><i class="fa-solid fa-network-wired"></i> INNOVATION HUBS</div>
</div>

<main class="page-container">

    <!-- Mission & Vision 2-Column Section -->
    <div class="about-top-grid">
        <div class="about-form-box">
            <span class="sub-label">OUR CORE FOUNDATION</span>
            <h2>Our Mission & Vision</h2>
            
            <div class="statement-group">
                <div class="stmt-header">
                    <i class="fa-solid fa-compass"></i>
                    <h3>Our Mission</h3>
                </div>
                <p>To cultivate intellectual curiosity, technical capability, and ethical values through a dynamic curriculum tailored to emerging technology and scientific practices.</p>
            </div>

            <div class="statement-group">
                <div class="stmt-header">
                    <i class="fa-solid fa-eye"></i>
                    <h3>Our Vision</h3>
                </div>
                <p>To stand as a recognized center of academic excellence, delivering equitable access to quality training, active research, and professional opportunities.</p>
            </div>
        </div>

        <!-- Right Side Highlight Card (Newsletter / Bulletin Style) -->
        <div class="about-side-card">
            <h3>University Bulletin</h3>
            <p>Stay informed about current research grants, campus news, and community leadership developments at EmeraldMoon University.</p>
            <form onsubmit="event.preventDefault();" class="side-sub-form">
                <input type="email" placeholder="Enter your academic email" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </div>

    <!-- 3-Column Info Cards Section -->
    <div class="about-cards-row">
        <div class="info-card">
            <div class="info-card-icon">
                <i class="fa-solid fa-laptop-code"></i>
            </div>
            <h4>Active Departments</h4>
            <p>Comprehensive computer science, web development, and data analytics faculties supporting multi-disciplinary studies.</p>
        </div>

        <div class="info-card">
            <div class="info-card-icon">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <h4>Specialized Courses</h4>
            <p>Curricula designed around practical application, database architecture, and industry-standard development toolkits.</p>
        </div>

        <div class="info-card">
            <div class="info-card-icon">
                <i class="fa-solid fa-users"></i>
            </div>
            <h4>Faculty Instructors</h4>
            <p>Dedicated mentors and domain specialists committed to academic growth, research leadership, and career direction.</p>
        </div>
    </div>

    <!-- Interactive Campus Map Section -->
    <div class="map-card-wrapper">
        <div class="map-header">
            <i class="fa-solid fa-location-dot"></i>
            <div>
                <h4>EmeraldMoon University Campus Location</h4>
                <span>Bhatkal Campus, Karnataka, India</span>
            </div>
        </div>
        <div class="map-container">
            <iframe 
                src="https://maps.google.com/maps?q=Bhatkal,%20Karnataka&t=&z=13&ie=UTF8&iwloc=&output=embed" 
                width="100%" 
                height="320" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>

</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>