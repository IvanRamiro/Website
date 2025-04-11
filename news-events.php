<?php
require 'ADMIN DASHBOARD/config.php';
include 'db.php';

// Fetch background image
$bg_image = "";
$bg_result = $conn->query("SELECT bg_image FROM bgchanger ORDER BY id DESC LIMIT 1");
if ($bg_result && $bg_result->num_rows > 0) {
    $bg_row = $bg_result->fetch_assoc();
    $bg_image = "ADMIN DASHBOARD/" . $bg_row['bg_image'];
}

// Fetch events with proper image paths
$featured_events = $conn->query("SELECT *, 
    CONCAT('ADMIN DASHBOARD/', thumbnail) as image_path
    FROM NewsEvents 
    WHERE is_featured = 1 
    ORDER BY event_date DESC 
    LIMIT 3");

$upcoming_events = $conn->query("SELECT *, 
    CONCAT('ADMIN DASHBOARD/', thumbnail) as image_path
    FROM NewsEvents 
    WHERE event_date >= CURDATE() 
    AND event_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
    AND is_featured = 0
    ORDER BY event_date ASC 
    LIMIT 6");

$past_events = $conn->query("SELECT *, 
    CONCAT('ADMIN DASHBOARD/', thumbnail) as image_path
    FROM NewsEvents 
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
    <title>QCREDIT</title>
    <meta name="description" content="QCREDIT - Delivering financial access to everyone...">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css?v=1.1"> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="script.js" defer></script>
</head>
<body>
    
    <style>
        /* Enhanced Event Card Styles */
        .event-card {
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            margin-bottom: 30px;
        }
        
        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .event-img-container {
            height: 220px;
            overflow: hidden;
            position: relative;
        }
        
        .event-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .event-card:hover .event-img {
            transform: scale(1.1);
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
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .event-date {
            color: #dc3545;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        
        .event-date i {
            margin-right: 8px;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-title h6 {
            color: #dc3545;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }
        
        .section-title h2 {
            font-weight: 700;
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
        }
        
        .section-title h2:after {
            content: '';
            position: absolute;
            width: 80px;
            height: 3px;
            background: #dc3545;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .card-body {
            padding: 25px;
        }
        
        .card-title {
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
        }
        
        .card-text {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .btn-danger {
            background: #dc3545;
            border: none;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        
        .btn-outline-danger {
            border-color: #dc3545;
            color: #dc3545;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-outline-danger:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
        }
        
        .location-info {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: #666;
        }
        
        .location-info i {
            margin-right: 8px;
            color: #dc3545;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .empty-state i {
            font-size: 50px;
            color: #dc3545;
            margin-bottom: 20px;
        }
        
        .empty-state h4 {
            color: #333;
            margin-bottom: 15px;
        }
        
        .empty-state p {
            color: #666;
            max-width: 500px;
            margin: 0 auto 20px;
        }
        
        /* Hero Section Enhancements */
        .hero {
            height: 400px;
            background: url('<?php echo $bg_image; ?>') no-repeat center center / cover;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        
        .hero:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            padding: 0 20px;
        }
        
        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .hero {
                height: 300px;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .event-img-container {
                height: 180px;
            }
            
            .section-title h2 {
                font-size: 1.8rem;
            }
        }
        
        .event-img-container {
            height: 220px;
            overflow: hidden;
            position: relative;
        }
        
        .event-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .no-image {
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }
        
        /* External link indicator */
        .external-link-indicator {
            display: inline-flex;
            align-items: center;
            color: #6c757d;
            font-size: 0.8rem;
            margin-left: 5px;
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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark position-sticky top-0 w-100 z-3 border-bottom border-white border-opacity-50" role="navigation">
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
                <li class="nav-item"><a class="nav-link active text-white" href="news-events.php">News and Events</a></li>
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

<section class="hero">
    <div class="hero-content">
        <h1>News & Events</h1>
        <p>Stay updated with the latest happenings and announcements from QCREDIT</p>
    </div>
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
                                        <?php if (!empty($event['image_path']) && file_exists($event['image_path'])): ?>
                                            <img src="<?= htmlspecialchars($event['image_path']) ?>" 
                                                 alt="<?= htmlspecialchars($event['title']) ?>" 
                                                 class="event-img">
                                        <?php else: ?>
                                            <div class="event-img no-image">
                                                <i class="fas fa-calendar-alt fa-3x"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <span class="featured-badge">Featured</span>
                                </div>
                                <div class="card-body">
                                    <div class="event-date mb-2">
                                        <i class="far fa-calendar-alt"></i>
                                        <?= date('F j, Y', strtotime($event['event_date'])) ?>
                                    </div>
                                    <h4 class="card-title"><?= htmlspecialchars($event['title']) ?>
                                        <?php if (!empty($event['external_url'])): ?>
                                            <span class="external-link-indicator" title="Has external link">
                                                <i class="fas fa-external-link-alt"></i>
                                            </span>
                                        <?php endif; ?>
                                    </h4>
                                    <?php if (!empty($event['location'])): ?>
                                        <div class="location-info">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <?= htmlspecialchars($event['location']) ?>
                                        </div>
                                    <?php endif; ?>
                                    <p class="card-text"><?= substr(htmlspecialchars($event['description']), 0, 100) ?>...</p>
                                    <div class="d-flex justify-content-between">
                                        <?php if (!empty($event['external_url'])): ?>
                                            <a href="<?= htmlspecialchars($event['external_url']) ?>" target="_blank" class="btn btn-outline-danger">
                                            Read More <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="far fa-calendar-star"></i>
                <h4>No Featured Events</h4>
                <p>There are currently no featured events. Check back later for updates.</p>
                <a href="index.php" class="btn btn-danger">Back to Home</a>
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
                                <div class="event-img-container">
                                    <?php if (!empty($event['image_path']) && file_exists($event['image_path'])): ?>
                                        <img src="<?= htmlspecialchars($event['image_path']) ?>" 
                                             alt="<?= htmlspecialchars($event['title']) ?>" 
                                             class="event-img">
                                    <?php else: ?>
                                        <div class="event-img no-image">
                                            <i class="fas fa-calendar-alt fa-3x"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <div class="event-date mb-2">
                                        <i class="far fa-calendar-alt"></i>
                                        <?= date('F j, Y', strtotime($event['event_date'])) ?>
                                    </div>
                                    <h4 class="card-title"><?= htmlspecialchars($event['title']) ?>
                                        <?php if (!empty($event['external_url'])): ?>
                                            <span class="external-link-indicator" title="Has external link">
                                                <i class="fas fa-external-link-alt"></i>
                                            </span>
                                        <?php endif; ?>
                                    </h4>
                                    <?php if (!empty($event['location'])): ?>
                                        <div class="location-info">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <?= htmlspecialchars($event['location']) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="d-flex justify-content-between">
                                        <a href="event-details.php?id=<?= $event['id'] ?>" class="btn btn-outline-danger">View Details</a>
                                        <?php if (!empty($event['external_url'])): ?>
                                            <a href="<?= htmlspecialchars($event['external_url']) ?>" target="_blank" class="btn btn-outline-secondary">
                                                Link <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="far fa-calendar-plus"></i>
                <h4>No Upcoming Events</h4>
                <p>There are currently no upcoming events scheduled. Check back later for updates.</p>
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
                                <div class="event-img-container">
                                    <?php if (!empty($event['image_path']) && file_exists($event['image_path'])): ?>
                                        <img src="<?= htmlspecialchars($event['image_path']) ?>" 
                                             alt="<?= htmlspecialchars($event['title']) ?>" 
                                             class="event-img">
                                    <?php else: ?>
                                        <div class="event-img no-image">
                                            <i class="fas fa-calendar-alt fa-3x"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <div class="event-date mb-2">
                                        <i class="far fa-calendar-alt"></i>
                                        <?= date('F j, Y', strtotime($event['event_date'])) ?>
                                    </div>
                                    <h4 class="card-title"><?= htmlspecialchars($event['title']) ?>
                                        <?php if (!empty($event['external_url'])): ?>
                                            <span class="external-link-indicator" title="Has external link">
                                                <i class="fas fa-external-link-alt"></i>
                                            </span>
                                        <?php endif; ?>
                                    </h4>
                                    <div class="d-flex justify-content-between">
                                        <a href="event-details.php?id=<?= $event['id'] ?>" class="btn btn-outline-danger">View Recap</a>
                                        <?php if (!empty($event['external_url'])): ?>
                                            <a href="<?= htmlspecialchars($event['external_url']) ?>" target="_blank" class="btn btn-outline-secondary">
                                                Link <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="far fa-calendar-check"></i>
                <h4>No Past Events</h4>
                <p>There are currently no past events to display.</p>
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