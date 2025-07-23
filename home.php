<?php include 'header.php'; ?>
<section class="hero" id="home">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Ride in <span class="highlight">Style</span>,<br>Anytime, Anywhere</h1>
                <p>Experience premium transportation with luxury vehicles, professional drivers, and instant booking. Your journey, elevated.</p>
                <div class="hero-buttons">
                    <a href="download.php" class="cta-primary">
                        <i class="fas fa-download"></i> Download App
                    </a>
                    <a href="features.php" class="cta-secondary">
                        <i class="fas fa-play"></i> Learn More
                    </a>
                </div>
            </div>
            <div class="booking-widget">
                <h3 class="widget-title">Book Your Ride</h3>
                <div class="ride-options">
                    <div class="ride-option active" onclick="selectRide(this)">
                        <i class="fas fa-car"></i>
                        <h4>Luxury Car</h4>
                        <p>Premium comfort</p>
                    </div>
                    <div class="ride-option" onclick="selectRide(this)">
                        <i class="fas fa-motorcycle"></i>
                        <h4>Express Bike</h4>
                        <p>Quick delivery</p>
                    </div>
                </div>
                <div class="input-group">
                    <label>Pickup Location</label>
                    <input type="text" placeholder="Enter pickup address">
                </div>
                <div class="input-group">
                    <label>Destination</label>
                    <input type="text" placeholder="Where are you going?">
                </div>
                <button class="book-btn">
                    <i class="fas fa-search"></i> Find Rides
                </button>
            </div>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?> 