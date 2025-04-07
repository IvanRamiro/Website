<?php
require 'ADMIN DASHBOARD/config.php';

include 'db.php';

$bg_image = "";
$bg_result = $conn->query("SELECT bg_image FROM bgchanger ORDER BY id DESC LIMIT 1");
if ($bg_result && $bg_result->num_rows > 0) {
    $bg_row = $bg_result->fetch_assoc();
    $bg_image = "ADMIN DASHBOARD/" . $bg_row['bg_image'];
}
// Fetch featured events (max 3)
$featured_events = $conn->query("SELECT * FROM NewsEvents 
    WHERE is_featured = 1 
    ORDER BY event_date DESC 
    LIMIT 3");

// Fetch upcoming events (next 30 days)
$upcoming_events = $conn->query("SELECT * FROM NewsEvents 
    WHERE event_date >= CURDATE() 
    AND event_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
    AND is_featured = 0
    ORDER BY event_date ASC 
    LIMIT 6");

// Fetch past events (excluding featured)
$past_events = $conn->query("SELECT * FROM NewsEvents 
    WHERE event_date < CURDATE()
    AND is_featured = 0
    ORDER BY event_date DESC 
    LIMIT 6");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News & Events | QCREDIT</title>
    <meta name="description" content="Latest news and events from QCREDIT">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="news-events.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .event-card {
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            border: none;
            border-radius: 8px;
            overflow: hidden;
        }
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .event-img-container {
            height: 200px;
            overflow: hidden;
        }
        .event-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .event-card:hover .event-img {
            transform: scale(1.05);
        }
        .featured-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #dc3545;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            z-index: 2;
        }
        .event-date {
            color: #dc3545;
            font-weight: 600;
        }
        .section-title {
            text-align: center;
            margin-bottom: 40px;
        }
        .section-title h6 {
            color: #dc3545;
            font-weight: 600;
        }
        .section-title h2 {
            font-weight: 700;
        }
    </style>
</head>
<body>

<!-- Header Section -->
<header class="top-bar bg-light py-2 border-bottom" role="banner">
    <div class="container">
        <div class="row align-items-center">
            <!-- Logo Section -->
            <div class="col-12 col-md-3 d-flex align-items-center mb-3 mb-md-0">
                <img src="Images/logo.jpg" alt="QCREDIT Logo" class="logo-img me-2" height="50">
                <span class="brand-name fw-bold text-danger fs-5">QCREDIT</span>
            </div>

            <!-- Contact & Links -->
            <nav class="col-12 col-md-7 mb-3 mb-md-0" aria-label="Main Contact Links">
                <ul class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-4 list-unstyled mb-0">
                    <li>
                        <p class="mb-0 text-center text-md-start"><strong>Trunkline</strong><br>
                            <a href="tel:(02)5310-2796">(02) 5310-2796 loc. 5100</a>
                        </p>
                    </li>
                    <li>
                        <p class="mb-0 text-center text-md-start"><strong>Help & Support</strong><br>
                            <a href="mailto:wecare@qcreditcorp.net">wecare@qcreditcorp.net</a>
                        </p>
                    </li>
                    <li>
                        <p class="mb-0 text-center text-md-start"><strong>Hiring</strong><br>
                            <a href="mailto:hiring@qcreditcorp.net">hiring@qcreditcorp.net</a>
                        </p>
                    </li>
                    <li>
                        <p class="mb-0 text-center text-md-start"><strong>Complaints</strong><br>
                            <a href="mailto:ireport@qcreditcorp.net">ireport@qcreditcorp.net</a>
                        </p>
                    </li>
                </ul>
            </nav>

            <!-- Loan Inquiry Button -->
            <div class="col-12 col-md-2 text-center text-md-end">
                <a href="login.php" class="btn btn-danger text-white px-3 py-1 fw-bold fs-7">Login</a>
            </div>
        </div>
    </div>
</header>

<!-- Hero Section -->
<section class="hero"
    style="height: 500px; background: url('<?php echo $bg_image; ?>') no-repeat center center / cover;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark position-sticky top-0 w-100 z-3 border-bottom border-white border-opacity-50" role="navigation">
        <!-- Your existing navbar content remains exactly the same -->
        <div class="container">
            <!-- Collapsible Navigation -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav text-center">
                    <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="help-support.php">Help & Support</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="about-us.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="careers.php">Careers</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="news-events.php">News and Events</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="contact-us.php">Contact Us</a></li>
                </ul>
            </div>
            <!-- Search Form (Responsive) -->
            <form class="d-none d-lg-flex ms-3" role="search" aria-label="Search the site">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-light" type="submit" aria-label="Submit search"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </nav>
</section>



    <!-- News & Events Content -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="section-title">
                <h6 class="text-danger">NEWS & EVENTS</h6>
                <h2>Latest <strong>Updates and Activities</strong></h2>
            </div>

            <!-- Featured Events -->
            <?php if ($featured_events->num_rows > 0): ?>
                <div class="mb-5">
                    <h3 class="mb-4">Featured Events</h3>
                    <div class="row g-4">
                        <?php while ($event = $featured_events->fetch_assoc()): ?>
                            <div class="col-md-4">
                                <div class="card event-card h-100 shadow-sm">
                                    <div class="position-relative">
                                        <div class="event-img-container">
                                            <img src="<?= htmlspecialchars($event['image_path'] ?? 'Images/events/default.jpg') ?>" 
                                                 alt="<?= htmlspecialchars($event['title']) ?>" 
                                                 class="event-img">
                                        </div>
                                        <span class="featured-badge">Featured</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="event-date mb-2">
                                            <?= date('F j, Y', strtotime($event['event_date'])) ?>
                                        </div>
                                        <h4 class="card-title"><?= htmlspecialchars($event['title']) ?></h4>
                                        <?php if (!empty($event['location'])): ?>
                                            <p class="text-muted">
                                                <i class="fas fa-map-marker-alt"></i> 
                                                <?= htmlspecialchars($event['location']) ?>
                                            </p>
                                        <?php endif; ?>
                                        <p class="card-text"><?= substr(htmlspecialchars($event['description']), 0, 100) ?>...</p>
                                        <a href="event-details.php?id=<?= $event['id'] ?>" class="btn btn-danger">Read More</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Upcoming Events -->
            <?php if ($upcoming_events->num_rows > 0): ?>
                <div class="mb-5">
                    <h3 class="mb-4">Upcoming Events</h3>
                    <div class="row g-4">
                        <?php while ($event = $upcoming_events->fetch_assoc()): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card event-card h-100 shadow-sm">
                                    <?php if (!empty($event['image_path'])): ?>
                                        <div class="event-img-container">
                                            <img src="<?= htmlspecialchars($event['image_path']) ?>" 
                                                 alt="<?= htmlspecialchars($event['title']) ?>" 
                                                 class="event-img">
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <div class="event-date mb-2">
                                            <?= date('F j, Y', strtotime($event['event_date'])) ?>
                                        </div>
                                        <h4 class="card-title"><?= htmlspecialchars($event['title']) ?></h4>
                                        <?php if (!empty($event['location'])): ?>
                                            <p class="text-muted">
                                                <i class="fas fa-map-marker-alt"></i> 
                                                <?= htmlspecialchars($event['location']) ?>
                                            </p>
                                        <?php endif; ?>
                                        <a href="event-details.php?id=<?= $event['id'] ?>" class="btn btn-outline-danger">View Details</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Past Events -->
            <?php if ($past_events->num_rows > 0): ?>
                <div class="mb-5">
                    <h3 class="mb-4">Past Events</h3>
                    <div class="row g-4">
                        <?php while ($event = $past_events->fetch_assoc()): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card event-card h-100 shadow-sm">
                                    <?php if (!empty($event['image_path'])): ?>
                                        <div class="event-img-container">
                                            <img src="<?= htmlspecialchars($event['image_path']) ?>" 
                                                 alt="<?= htmlspecialchars($event['title']) ?>" 
                                                 class="event-img">
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <div class="event-date mb-2">
                                            <?= date('F j, Y', strtotime($event['event_date'])) ?>
                                        </div>
                                        <h4 class="card-title"><?= htmlspecialchars($event['title']) ?></h4>
                                        <a href="event-details.php?id=<?= $event['id'] ?>" class="btn btn-outline-danger">View Recap</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>

 <!-- Footer Section -->
<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <!-- Left Section: Company Info -->
            <div class="col-md-4 mb-4">
                <div class="d-flex align-items-center mb-3">
                    <img src="Images/logo.jpg" alt="QCREDIT Logo" height="40" class="me-2">
                    <p class="mb-0"><strong>QCREDIT CORP.</strong></p>
                </div>
                <p>SEC Reg. No. CS201738217</p>
                <p>Certificate of Authority No. 2617</p>
                <p>Please study the terms and conditions in the disclosure statement before proceeding with your loan transaction.</p>
                
                <!-- Social Media Icons -->
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-danger btn-sm"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-danger btn-sm"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="btn btn-danger btn-sm"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="btn btn-danger btn-sm"><i class="fab fa-tiktok"></i></a>
                </div>

                <img src="Images/SEAL.jpg" alt="DPO DPS Certificate" class="mt-3 img-fluid" width="150">
            </div>

            <!-- Middle Section: Menu & Quick Links -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">Menu</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php" class="footer-link">Home</a></li>
                    <li><a href="#" class="footer-link">Loans</a></li>
                    <li><a href="help-support.php" class="footer-link">Help & Support</a></li>
                    <li><a href="#" class="footer-link">Consumer Protection</a></li>
                    <li><a href="about-us.php" class="footer-link">About Us</a></li>
                    <li><a href="careers.php" class="footer-link">Careers</a></li>
                    <li><a href="news-events.php" class="footer-link">News and Events</a></li>
                    <li><a href="contact-us.php" class="footer-link">Contact Us</a></li>
                </ul>

                <h5 class="fw-bold mt-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="footer-link">About MVL</a></li>
                    <li><a href="#" class="footer-link">Apply Online</a></li>
                    <li><a href="#" class="footer-link">Affordability Assessment</a></li>
                    <li><a href="#" class="footer-link">Accepted IDs</a></li>
                    <li><a href="#" class="footer-link">Loan Calculator</a></li>
                    <li><a href="#" class="footer-link">FAQs</a></li>
                    <li><a href="help-support.php" class="footer-link">Help & Support</a></li>
                    <li><a href="#" class="footer-link">Find Us</a></li>
                    <li><a href="#" class="footer-link">Data Privacy Notice</a></li>
                    <li><a href="#" class="footer-link">Site Map</a></li>
                </ul>
            </div>

            <!-- Right Section: Contact Info -->
            <div class="col-md-4">
                <h5 class="fw-bold">Contact Us</h5>
                <p><i class="fas fa-map-marker-alt text-danger me-2"></i> <strong>Main Office:</strong> 2602 Antel 2000 Corporate Center, 121 Valero Street, Salcedo Village, Barangay Bel-air, Makati City 1227, Philippines</p>
                <p><i class="fas fa-phone text-danger me-2"></i> <strong>Trunkline:</strong> (02) 5310-2796 loc. 5100</p>
                <p><i class="fas fa-envelope text-danger me-2"></i> <strong>Help & Support:</strong> wecare@qcreditcorp.net</p>
                <p><i class="fas fa-user text-danger me-2"></i> <strong>Hiring:</strong> hiring@qcreditcorp.net</p>
                <p><i class="fas fa-exclamation-circle text-danger me-2"></i> <strong>Complaint:</strong> ireport@qcreditcorp.net</p>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="text-center mt-4 pt-3 border-top border-secondary">
            <p class="mb-0">&copy; 2025 QCREDIT CORP. ALL RIGHTS RESERVED.</p>
            <p class="mb-0">WEBSITE BY WEB DESIGN PHILIPPINES</p>
        </div>
    </div>
</footer>

</body>
</html>
<?php $conn->close(); ?>