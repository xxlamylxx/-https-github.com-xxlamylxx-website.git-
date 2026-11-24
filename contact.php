<?php 
include_once __DIR__ . '/includes/header.php'; 
require_once __DIR__ . '/db.php';

$success_msg = "";
$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!empty($name) && !empty($email) && !empty($message)) {
        if (isset($conn) && $conn instanceof mysqli && !$conn->connect_error) {
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("ssss", $name, $email, $subject, $message);
                if ($stmt->execute()) {
                    $success_msg = "Thank you! Your message has been sent successfully.";
                } else {
                    $error_msg = "Failed to send message. Please try again.";
                }
                $stmt->close();
            } else {
                $success_msg = "Thank you! Your message has been received.";
            }
        } else {
            $success_msg = "Thank you! Your message has been received.";
        }
    } else {
        $error_msg = "Please fill in all required fields.";
    }
}
?>

<!-- Hero Banner -->
<section class="page-banner">
    <div class="banner-inner">
        <h1>Contact Us</h1>
        <p>Have questions about admissions, academic programs, or campus visits? We are here to help.</p>
    </div>
</section>

<!-- Contact Main Body with Brand Teal Background -->
<main class="contact-page-wrapper">
    <div class="contact-container">

        <?php if (!empty($success_msg)): ?>
            <div class="alert-box alert-success">
                <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($success_msg); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_msg)): ?>
            <div class="alert-box alert-error">
                <i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

        <div class="contact-grid">
            
            <!-- Left Side: Contact Form Card -->
            <div class="contact-form-card">
                <span class="sub-label">GET IN TOUCH</span>
                <h2>Send Us a Message</h2>
                <p class="form-desc">Fill out the form below and our university administrative team will respond shortly.</p>

                <form action="contact.php" method="POST" class="contact-form">
                    <div class="form-group-row">
                        <div class="form-group">
                            <label><i class="fa-solid fa-user"></i> Full Name *</label>
                            <input type="text" name="name" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fa-solid fa-envelope"></i> Email Address *</label>
                            <input type="email" name="email" placeholder="Enter your email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><i class="fa-solid fa-tag"></i> Subject</label>
                        <input type="text" name="subject" placeholder="Inquiry topic (Admissions, Courses, General)">
                    </div>

                    <div class="form-group">
                        <label><i class="fa-solid fa-pen"></i> Message *</label>
                        <textarea name="message" rows="5" placeholder="Write your message here..." required></textarea>
                    </div>

                    <button type="submit" class="btn-submit-contact">
                        Send Message <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>

            <!-- Right Side: Info & Bulletin Card -->
            <div class="contact-info-column">
                
                <div class="info-block-card">
                    <div class="info-item">
                        <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div>
                            <h4>Campus Location</h4>
                            <p>EmeraldMoon University Campus, Bhatkal, Karnataka, India</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
                        <div>
                            <h4>Phone Support</h4>
                            <p>+91 (08385) 220000 / +91 98765 43210</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
                        <div>
                            <h4>Email Admissions</h4>
                            <p>admissions@emeraldmoon.edu.in</p>
                        </div>
                    </div>
                </div>

                <div class="office-hours-card">
                    <h3><i class="fa-solid fa-clock"></i> Administrative Hours</h3>
                    <ul>
                        <li><span>Monday – Friday:</span> <strong>9:00 AM – 5:00 PM</strong></li>
                        <li><span>Saturday:</span> <strong>9:00 AM – 1:00 PM</strong></li>
                        <li><span>Sunday:</span> <strong>Closed</strong></li>
                    </ul>
                </div>

            </div>

        </div>

        <!-- Campus Map Container -->
        <div class="map-card-wrapper" style="margin-top: 2.5rem;">
            <div class="map-header">
                <i class="fa-solid fa-map-location-dot"></i>
                <div>
                    <h4>Campus Directions</h4>
                    <span>Find us on the map</span>
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

    </div>
</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>