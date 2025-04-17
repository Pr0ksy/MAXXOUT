<?php
session_start();



?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <meta http-equiv="X-UA-Compatible" content="ie=edge"> 
  <meta http-equiv="refresh" content="30">
  <meta name="description" content="MAXXOUT - FITNESS APP"> 
  <meta name="keywords" content="Fitness, Gym, App, Workout, Training, Leveling, Levels"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="css/style.css?v=2.0">
  <title>MAXXOUT</title>
</head>
<body>
  <header id="home"class="navbar">
    <div class="logo">
      <h1>MAXXOUT</h1>
    </div>

    <button class="menu-toggle">&#9776;</button>
    <div class="nav-container">
      <nav class="nav-links">
        <a href="#home">Home</a>
        <a href="#features">Features</a>
        <a href="#pricing">Pricing</a>
        <a href="#cta">Download</a>
        <a href="#contact">Contact</a>
      </nav>

      <div class="auth-buttons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php">My Account</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
  </header>

  <section class="hero">
  <div class="hero-content">
    <h2>Welcome to MAXXOUT</h2>
    <p>Workout, level up, earn rewards, and unlock your full potential! Combine fitness and gamification to reach new heights.</p>
    <a href="#cta" class="hero-btn">Get Started</a>
  </div>
  </section>

  <section class="how-it-works">
  <div class="how-it-works-content">
    <h2>How MAXXOUT Works</h2>
    <p>Combine your fitness goals with a gamified experience. Track your progress, earn XP, and unlock real rewards as you level up!</p>
    <div class="steps">
      <div class="step">
        <h3>1. Track Your Progress</h3>
        <p>Log your workouts and see your fitness progress through detailed tracking.</p>
      </div>
      <div class="step">
        <h3>2. Earn XP & Level Up</h3>
        <p>Collect XP for your efforts and level up through different challenges.</p>
      </div>
      <div class="step">
        <h3>3. Unlock Real Rewards</h3>
        <p>Earn exclusive merch, discounts, and special products as you advance!</p>
      </div>
    </div>
  </div>
  </section>

  <section id="features" class="features">
  <div class="features-content">
    <h2>Features of MAXXOUT</h2>
    <p>Our app is designed to provide you with the best fitness experience, combining progress tracking, real rewards, and community support.</p>
    <div class="feature">
      <i class="fas fa-gamepad"></i>
      <h3>Gamified Progress Tracking</h3>
      <p>Track your workouts and level up with XP. Your progress becomes your game!</p>
    </div>
    <div class="feature">
      <i class="fas fa-gift"></i>
      <h3>Exclusive Rewards</h3>
      <p>Earn actual rewards like merchandise, discounts, and exclusive gear as you hit milestones!</p>
    </div>
    <div class="feature">
      <i class="fas fa-users"></i>
      <h3>Community Challenges</h3>
      <p>Compete with your friends or the whole community in regular fitness challenges.</p>
    </div>
  </div>
  </section>

  <section id="pricing" class="pricing">
  <div class="pricing-content">
    <h2>Choose Your Plan</h2>
    <p>Pick the plan that fits your fitness journey and unlock exclusive rewards, premium features, and more!</p>
    <div class="pricing-plans">
      <div class="plan">
        <h3>Free Plan</h3>
        <p class="price">$0/month</p>
        <ul>
          <li>Track workouts</li>
          <li>Earn XP</li>
          <li>Access to basic rewards</li>
          <li>Community challenges</li>
        </ul>
        <a href="#" class="btn">Get Started</a>
      </div>
      <div class="plan premium">
        <h3 id="premiumplan">Premium Plan</h3>
        <p class="price">$14.99/month</p>
        <ul>
          <li>Everything in Free Plan</li>
          <li>XP Boost</li>
          <li>Exclusive rewards</li>
          <li>Premium challenges</li>
          <li>Personalized fitness plans</li>
        </ul>
        <a href="#" class="premiumbtn">Upgrade Now</a>
      </div>
      <div class="plan">
        <h3>Pro Plan</h3>
        <p class="price">$24.99/month</p>
        <ul>
          <li>Everything in Premium Plan</li>
          <li>Priority customer support</li>
          <li>Exclusive merchandise drops</li>
          <li>Access to partner gym discounts</li>
        </ul>
        <a href="#" class="btn">Get Pro</a>
      </div>
    </div>
  </div>
  </section>
  
  <div class="pricing-comparison">
  <h3>Compare Plans</h3>
  <table>
    <thead>
      <tr>
        <th>Feature</th>
        <th>Free Plan</th>
        <th>Premium Plan</th>
        <th>Pro Plan</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Track Workouts</td>
        <td>✔</td>
        <td>✔</td>
        <td>✔</td>
      </tr>
      <tr>
        <td>XP Boost</td>
        <td>❌</td>
        <td>✔</td>
        <td>✔</td>
      </tr>
      <tr>
        <td>Exclusive Rewards</td>
        <td>✔</td>
        <td>✔</td>
        <td>✔</td>
      </tr>
      <tr>
        <td>Premium Challenges</td>
        <td>❌</td>
        <td>✔</td>
        <td>✔</td>
      </tr>
      <tr>
        <td>Exclusive Merchandise</td>
        <td>❌</td>
        <td>❌</td>
        <td>✔</td>
      </tr>
    </tbody>
  </table>
  </div>

  <section id="cta" class="cta">
  <div class="cta-content">
    <img src="images/maxxout-logo.png" alt="MAXXOUT Logo" class="cta-logo" />
    <h3>Join the MAXXOUT Beta!</h3>
    <p>We are excited to invite you to be one of the first users to experience <b>MAXXOUT</b>! As we’re in the beta phase, you’ll get exclusive early access to all features, and you’ll be among the first to earn rewards while leveling up your fitness.</p>
    <p>Be part of something new. Train hard. Earn rewards. And help us make <b>MAXXOUT</b> even better!</p>
    <div class="cta-buttons">
      <a href="https://play.google.com/store/apps/details?id=com.maxxout" class="cta-store-button google" target="_blank">
        <i class="fab fa-google-play"></i>
        <span class="text">
          <small>GET IT ON</small><br>
          Google Play
        </span>
      </a>
      <a href="https://apps.apple.com/us/app/maxxout/id123456789" class="cta-store-button apple" target="_blank">
        <i class="fab fa-apple"></i>
        <span class="text">
          <small>Download on the</small><br>
          App Store
        </span>
      </a>
    </div>
    <p class="beta-note">*Note: This is the beta version of MAXXOUT. We're constantly improving and adding new features. Your feedback is essential to shaping the future of the app!</p>
  </div>
</section>

  <section id="contact" class="contact">
  <h3>Contact Us</h3>
  <p>Have questions? Get in touch with us below!</p>
  <form class="contact-form">
    <input type="text" placeholder="Your Name" required>
    <input type="email" placeholder="Your Email" required>
    <textarea placeholder="Your Message" required></textarea>
    <button type="submit">Send Message</button>
  </form>
  </section>
  <section class="join-community">
  <h2>Join the MAXXOUT Community</h2>
  <p>Connect with thousands of fitness warriors. Join challenges, get motivated, and level up together!</p>
  <div class="discord-button-wrapper">
    <a href="#" target="_blank" class="discord-button">
      <i class="fab fa-discord"></i> Join Our Discord
    </a>
  </div>
</section>

<footer class="site-footer">
  <div class="footer-container">
    <div class="footer-left">
      <h3>MAXXOUT</h3>
      <p>LEVEL UP. MAXX OUT.<br>Gamified fitness for real results.</p>
    </div>
    <div class="footer-middle">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="#hero">Home</a></li>
        <li><a href="#features">Features</a></li>
        <li><a href="#pricing">Pricing</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="#cta">Download</a></li>
      </ul>
    </div>
    <div class="footer-right">
      <h4>Get in Touch</h4>
      <p>Email: support@maxxout.com</p>
      <p>Phone: +381 (0) 64 057 8600</p>
      <div class="social-icons">
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-tiktok"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
        <a href="#"><i class="fab fa-telegram-plane"></i></a>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; 2025 MAXXOUT. All rights reserved.</p>
  </div>
  </footer>

  <script src="js/index.js"></script>
</body>
</html>