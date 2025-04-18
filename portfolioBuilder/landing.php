<?php
require_once 'includes/header.php';
?>

<style>
/* ===== MODERN UI DESIGN - PORTFOLIO BUILDER ===== */
:root {
  /* Color Scheme - Sleek Dark & Gradient */
  --primary: #6366f1;
  --primary-dark: #4f46e5;
  --secondary: #8b5cf6;
  --accent: #06b6d4;
  --dark: #0f172a;
  --dark-light: #1e293b;
  --light: #f8fafc;
  --gray: #64748b;
  --success: #10b981;
  --warning: #f59e0b;
  --danger: #ef4444;
  
  /* Typography */
  --font-sans: 'Inter', system-ui, -apple-system, sans-serif;
  --font-heading: 'Plus Jakarta Sans', var(--font-sans);
  
  /* Spacing */
  --space-1: 0.5rem;
  --space-2: 1rem;
  --space-3: 1.5rem;
  --space-4: 2rem;
  --space-5: 3rem;
  --space-6: 5rem;
  
  /* Borders & Shadows */
  --radius-sm: 0.25rem;
  --radius-md: 0.5rem;
  --radius-lg: 1rem;
  --radius-xl: 1.5rem;
  --radius-full: 9999px;
  --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
  --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  
  /* Transitions */
  --transition-fast: 0.2s ease;
  --transition-normal: 0.3s ease;
  --transition-slow: 0.5s ease;
}

/* Base Styles */
body {
  font-family: var(--font-sans);
  color: var(--dark);
  line-height: 1.6;
  overflow-x: hidden;
  background-color: var(--light);
}

h1, h2, h3, h4, h5, h6 {
  font-family: var(--font-heading);
  font-weight: 700;
  line-height: 1.2;
}

a {
  text-decoration: none;
  transition: all var(--transition-fast);
}

img {
  max-width: 100%;
  height: auto;
}

.container {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 var(--space-2);
  position: relative;
  z-index: 2;
}

.row {
  display: flex;
  flex-wrap: wrap;
  margin: 0 -15px;
}

.col-md-4, .col-lg-4, .col-lg-6, .col-lg-8 {
  padding: 0 15px;
  width: 100%;
}

@media (min-width: 768px) {
  .col-md-4 {
    width: 33.333333%;
  }
}

@media (min-width: 992px) {
  .col-lg-4 {
    width: 33.333333%;
  }
  .col-lg-6 {
    width: 50%;
  }
  .col-lg-8 {
    width: 66.666667%;
  }
}

.align-items-center {
  align-items: center;
}

.text-lg-end {
  text-align: left;
}

@media (min-width: 992px) {
  .text-lg-end {
    text-align: right;
  }
}

/* .g-4 {
  gap: 1.5rem;
} */

/* ===== HERO SECTION ===== */
.hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  background-color: var(--dark);
  color: white;
  overflow: hidden;
  padding: 100px 0;
}

.hero::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: url('assets/images/port.jpg') center/cover no-repeat;
  opacity: 0.15;
  z-index: 0;
  filter: blur(2px);
}

.hero::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(15, 23, 42, 0.9), rgba(30, 41, 59, 0.8));
  z-index: 1;
}

.hero-content {
  position: relative;
  z-index: 3;
}

.hero-title {
  font-size: clamp(2.5rem, 8vw, 5rem);
  font-weight: 800;
  line-height: 1;
  margin-bottom: var(--space-3);
  background: linear-gradient(to right, #fff, #c7d2fe);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  letter-spacing: -0.02em;
}

.hero-text {
  font-size: clamp(1.1rem, 2vw, 1.25rem);
  color: rgba(255, 255, 255, 0.9);
  margin-bottom: var(--space-4);
  max-width: 600px;
}

.hero-buttons {
  display: flex;
  gap: var(--space-2);
  margin-bottom: var(--space-4);
}

.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.75rem 1.75rem;
  font-weight: 600;
  border-radius: var(--radius-md);
  transition: all var(--transition-normal);
  cursor: pointer;
  gap: 0.5rem;
}

.btn i {
  font-size: 1.1em;
}

.btn-primary {
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  color: white;
  box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
  border: none;
}

.btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(99, 102, 241, 0.5);
  color: white;
}

.btn-outline {
  background: rgba(255, 255, 255, 0.1);
  border: 2px solid rgba(255, 255, 255, 0.8);
  color: white;
  backdrop-filter: blur(5px);
}

.btn-outline:hover {
  background: rgba(255, 255, 255, 0.2);
  transform: translateY(-3px);
  color: white;
}

.hero-image-wrapper {
  position: relative;
  z-index: 2;
}

.hero-image-container {
  position: relative;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-xl), 0 0 30px rgba(99, 102, 241, 0.3);
  transform: perspective(1200px) rotateY(-8deg) rotateX(5deg);
  transition: transform var(--transition-slow);
}

.hero-image-container:hover {
  transform: perspective(1200px) rotateY(0) rotateX(0);
}

.hero-image {
  width: 100%;
  height: auto;
  display: block;
  transition: transform var(--transition-slow);
}

.hero-image-container:hover .hero-image {
  transform: scale(1.05);
}

.hero-shape {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  z-index: 1;
  opacity: 0.4;
}

.hero-shape-1 {
  width: 300px;
  height: 300px;
  background: radial-gradient(circle, var(--primary), transparent 70%);
  top: -100px;
  right: -100px;
  animation: float 15s ease-in-out infinite alternate;
}

.hero-shape-2 {
  width: 400px;
  height: 400px;
  background: radial-gradient(circle, var(--secondary), transparent 70%);
  bottom: -200px;
  left: -200px;
  animation: float 20s ease-in-out infinite alternate-reverse;
}

@keyframes float {
  0% {
    transform: translate(0, 0) scale(1);
  }
  100% {
    transform: translate(20px, -20px) scale(1.05);
  }
}

.hero-scroll {
  position: absolute;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 10;
  color: white;
  font-size: 2rem;
  opacity: 0.7;
  animation: bounce 2s infinite;
}

@keyframes bounce {
  0%, 20%, 50%, 80%, 100% {
    transform: translateY(0) translateX(-50%);
  }
  40% {
    transform: translateY(-20px) translateX(-50%);
  }
  60% {
    transform: translateY(-10px) translateX(-50%);
  }
}

/* ===== FEATURES SECTION ===== */
.section {
  padding: var(--space-6) 0;
  position: relative;
}

.section-header {
  text-align: center;
  margin-bottom: var(--space-5);
  position: relative;
}

.section-title {
  font-size: clamp(2rem, 4vw, 2.5rem);
  font-weight: 800;
  margin-bottom: var(--space-1);
  position: relative;
  display: inline-block;
}

.section-title::after {
  content: "";
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
  width: 80px;
  height: 4px;
  background: linear-gradient(to right, var(--primary), var(--secondary));
  border-radius: var(--radius-full);
}

.section-subtitle {
  font-size: 1.125rem;
  color: var(--gray);
  max-width: 700px;
  margin: var(--space-3) auto 0;
}

.feature-card {
  background: white;
  border-radius: var(--radius-lg);
  padding: var(--space-4);
  box-shadow: var(--shadow-md);
  transition: all var(--transition-normal);
  height: 100%;
  position: relative;
  overflow: hidden;
  z-index: 1;
  border-top: 4px solid transparent;
}

.feature-card::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background: linear-gradient(to right, var(--primary), var(--secondary));
  transform: scaleX(0);
  transform-origin: left;
  transition: transform var(--transition-normal);
  z-index: -1;
}

.feature-card:hover {
  transform: translateY(-10px);
  box-shadow: var(--shadow-lg);
}

.feature-card:hover::before {
  transform: scaleX(1);
}

.feature-icon {
  width: 70px;
  height: 70px;
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  border-radius: var(--radius-md);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: var(--space-3);
  color: white;
  font-size: 1.75rem;
  box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
}

.feature-card h3 {
  font-size: 1.25rem;
  margin-bottom: var(--space-2);
}

.feature-card p {
  color: var(--gray);
  margin-bottom: 0;
}

/* ===== STATS SECTION ===== */
.stats {
  background-color: #f1f5f9;
  position: relative;
  overflow: hidden;
}

.stats::before, .stats::after {
  content: "";
  position: absolute;
  width: 100%;
  height: 1px;
  background: linear-gradient(to right, transparent, rgba(99, 102, 241, 0.2), transparent);
}

.stats::before {
  top: 0;
}

.stats::after {
  bottom: 0;
}

.stat-card {
  background: white;
  border-radius: var(--radius-lg);
  padding: var(--space-4);
  box-shadow: var(--shadow-md);
  text-align: center;
  transition: all var(--transition-normal);
  height: 100%;
  position: relative;
  overflow: hidden;
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
}

.stat-number {
  font-size: 3rem;
  font-weight: 800;
  background: linear-gradient(to right, var(--primary), var(--secondary));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  line-height: 1;
  margin-bottom: var(--space-1);
}

.stat-card h3 {
  font-size: 1.25rem;
  color: var(--gray);
  margin-bottom: var(--space-3);
  font-weight: 600;
}

.stat-progress {
  width: 100%;
  height: 6px;
  background-color: #e2e8f0;
  border-radius: var(--radius-full);
  overflow: hidden;
}

.stat-progress-bar {
  height: 100%;
  background: linear-gradient(to right, var(--primary), var(--secondary));
  border-radius: var(--radius-full);
  transition: width 1.5s ease-in-out;
}

/* ===== SHOWCASE SECTION ===== */
.showcase {
  background-color: white;
}

.showcase-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: var(--space-3);
}

.showcase-item {
  position: relative;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-md);
  aspect-ratio: 16 / 9;
  transition: all var(--transition-normal);
}

.showcase-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform var(--transition-normal);
}

.showcase-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(to top, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.5));
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity var(--transition-normal);
  padding: var(--space-3);
  text-align: center;
}

.showcase-item:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
}

.showcase-item:hover img {
  transform: scale(1.05);
}

.showcase-item:hover .showcase-overlay {
  opacity: 1;
}

.showcase-overlay h4 {
  color: white;
  margin-bottom: var(--space-3);
  font-size: 1.25rem;
}

.btn-sm {
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
}

.btn-light {
  background: white;
  color: var(--primary);
  border: none;
}

.btn-light:hover {
  background: rgba(255, 255, 255, 0.9);
  transform: translateY(-2px);
}

/* ===== CTA SECTION ===== */
.cta {
  padding: var(--space-5) 0;
}

.cta-card {
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  border-radius: var(--radius-lg);
  padding: var(--space-5);
  color: white;
  position: relative;
  overflow: hidden;
  box-shadow: var(--shadow-lg);
}

.cta-card::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
  opacity: 0.2;
}

.cta-card h2 {
  font-size: 2rem;
  margin-bottom: var(--space-1);
  color: white;
}

.cta-card p {
  font-size: 1.125rem;
  color: rgba(255, 255, 255, 0.9);
  margin-bottom: 0;
}

.btn-lg {
  padding: 1rem 2rem;
  font-size: 1.125rem;
}

/* ===== TESTIMONIALS SECTION ===== */
.testimonials {
  background-color: #f8fafc;
  position: relative;
  overflow: hidden;
}

.testimonial-card {
  background: white;
  border-radius: var(--radius-lg);
  padding: var(--space-4);
  box-shadow: var(--shadow-md);
  transition: all var(--transition-normal);
  height: 100%;
  position: relative;
}

.testimonial-card:hover {
  transform: translateY(-8px);
  box-shadow: var(--shadow-lg);
}

.testimonial-quote {
  color: var(--primary);
  font-size: 2rem;
  margin-bottom: var(--space-2);
  opacity: 0.3;
}

.testimonial-card p {
  font-size: 1rem;
  color: var(--dark);
  margin-bottom: var(--space-4);
  font-style: italic;
}

.testimonial-author {
  display: flex;
  align-items: center;
  gap: var(--space-2);
}

.testimonial-avatar {
  width: 50px;
  height: 50px;
  border-radius: var(--radius-full);
  object-fit: cover;
  border: 3px solid white;
  box-shadow: var(--shadow-sm);
}

.testimonial-info h4 {
  font-size: 1rem;
  margin-bottom: 0.25rem;
}

.testimonial-rating {
  color: var(--warning);
  font-size: 0.875rem;
}

/* ===== ANIMATIONS ===== */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate {
  opacity: 0;
  animation: fadeInUp 0.8s ease forwards;
}

.delay-1 {
  animation-delay: 0.2s;
}

.delay-2 {
  animation-delay: 0.4s;
}

.delay-3 {
  animation-delay: 0.6s;
}

/* ===== RESPONSIVE STYLES ===== */
@media (max-width: 991px) {
  .hero {
    padding: 80px 0;
    min-height: auto;
  }
  
  .hero-content {
    text-align: center;
  }
  
  .hero-text {
    margin-left: auto;
    margin-right: auto;
  }
  
  .hero-buttons {
    justify-content: center;
  }
  
  .hero-image-wrapper {
    margin-top: var(--space-4);
  }
  
  .cta-card {
    text-align: center;
  }
  
  .cta-card .btn {
    margin-top: var(--space-3);
  }
}

@media (max-width: 767px) {
  .section {
    padding: var(--space-5) 0;
  }
  
  .hero-title {
    font-size: 2.5rem;
  }
  
  .hero-buttons {
    flex-direction: column;
    gap: var(--space-2);
    align-items: center;
  }
  
  .hero-buttons .btn {
    width: 100%;
    max-width: 300px;
  }
  
  .showcase-grid {
    grid-template-columns: 1fr;
  }
}
</style>

<!-- Hero Section with Full-Height Design -->
<section class="hero">
  <div class="hero-shape hero-shape-1"></div>
  <div class="hero-shape hero-shape-2"></div>
  
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="hero-content animate">
          <h1 class="hero-title">Create Your Professional Portfolio in Minutes</h1>
          <p class="hero-text">Showcase your work, skills, and achievements with our modern portfolio builder. Stand out in the digital world with a stunning portfolio website.</p>
          <div class="hero-buttons">
            <?php if(!isset($_SESSION['user_id'])): ?>
              <a href="register.php" class="btn btn-primary">
                <i class="fas fa-rocket"></i>Get Started Free
              </a>
              <a href="login.php" class="btn btn-outline">
                <i class="fas fa-sign-in-alt"></i>Sign In
              </a>
            <?php else: ?>
              <a href="dashboard.php" class="btn btn-primary">
                <i class="fas fa-tachometer-alt"></i>Go to Dashboard
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="hero-image-wrapper animate delay-1">
          <div class="hero-image-container">
            <img src="assets/images/port.jpg" alt="Portfolio Builder" class="hero-image">
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <a href="#features" class="hero-scroll">
    <i class="fas fa-chevron-down"></i>
  </a>
</section>

<!-- Features Section -->
<section id="features" class="section">
  <div class="container">
    <div class="section-header animate">
      <h2 class="section-title">Why Choose Our Portfolio Builder?</h2>
      <p class="section-subtitle">Create a stunning portfolio website with our easy-to-use tools</p>
    </div>
    
    <div class="row g-4">
      <div class="col-md-4">
        <div class="feature-card animate delay-1">
          <div class="feature-icon">
            <i class="fas fa-paint-brush"></i>
          </div>
          <h3>Beautiful Templates</h3>
          <p>Choose from our collection of professionally designed templates that make your portfolio stand out.</p>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="feature-card animate delay-2">
          <div class="feature-icon">
            <i class="fas fa-magic"></i>
          </div>
          <h3>Easy Customization</h3>
          <p>Personalize your portfolio with our intuitive drag-and-drop interface and real-time preview.</p>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="feature-card animate delay-3">
          <div class="feature-icon">
            <i class="fas fa-mobile-alt"></i>
          </div>
          <h3>Responsive Design</h3>
          <p>Your portfolio looks great on all devices, from desktop to mobile phones.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Stats Section -->
<section class="section stats">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="stat-card animate">
          <div class="stat-number">10k+</div>
          <h3>Active Users</h3>
          <div class="stat-progress">
            <div class="stat-progress-bar" style="width: 85%"></div>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="stat-card animate delay-1">
          <div class="stat-number">50+</div>
          <h3>Templates</h3>
          <div class="stat-progress">
            <div class="stat-progress-bar" style="width: 65%"></div>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="stat-card animate delay-2">
          <div class="stat-number">99%</div>
          <h3>Satisfaction Rate</h3>
          <div class="stat-progress">
            <div class="stat-progress-bar" style="width: 99%"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Showcase Section -->
<section class="section showcase">
  <div class="container">
    <div class="section-header animate">
      <h2 class="section-title">Achievements Showcase</h2>
      <p class="section-subtitle">See what you can create with our platform</p>
    </div>
    
    <div class="showcase-grid">
      <div class="showcase-item animate">
        <img src="assets/images/proj1.webp" alt="Portfolio Example">
        <div class="showcase-overlay">
          <h4>Photography Portfolio</h4>
          <a href="#" class="btn btn-sm btn-light">View Demo</a>
        </div>
      </div>
      
      <div class="showcase-item animate delay-1">
        <img src="assets/images/proj2.jpeg" alt="Portfolio Example">
        <div class="showcase-overlay">
          <h4>Designer Portfolio</h4>
          <a href="#" class="btn btn-sm btn-light">View Demo</a>
        </div>
      </div>
      
      <div class="showcase-item animate delay-2">
        <img src="assets/images/proj3.jpeg" alt="Portfolio Example">
        <div class="showcase-overlay">
          <h4>Developer Portfolio</h4>
          <a href="#" class="btn btn-sm btn-light">View Demo</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="section cta">
  <div class="container">
    <div class="cta-card">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h2>Ready to Create Your Portfolio?</h2>
          <p>Join thousands of professionals who trust our platform to showcase their work.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <?php if(!isset($_SESSION['user_id'])): ?>
            <a href="register.php" class="btn btn-light btn-lg">
              <i class="fas fa-user-plus"></i>Create Your Portfolio
            </a>
          <?php else: ?>
            <a href="dashboard.php" class="btn btn-light btn-lg">
              <i class="fas fa-plus"></i>Create New Portfolio
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials Section -->
<section class="section testimonials">
  <div class="container">
    <div class="section-header animate">
      <h2 class="section-title">What Our Users Say</h2>
      <p class="section-subtitle">Trusted by thousands of creative professionals worldwide</p>
    </div>
    
    <div class="row g-4">
      <div class="col-md-4">
        <div class="testimonial-card animate">
          <div class="testimonial-quote">
            <i class="fas fa-quote-left"></i>
          </div>
          <p>"This portfolio builder made it incredibly easy for me to showcase my work. The templates are beautiful and professional."</p>
          <div class="testimonial-author">
            <img src="assets/images/avtr1.avif" alt="Sarah Johnson" class="testimonial-avatar">
            <div class="testimonial-info">
              <h4>John</h4>
              <div class="testimonial-rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="testimonial-card animate delay-1">
          <div class="testimonial-quote">
            <i class="fas fa-quote-left"></i>
          </div>
          <p>"The customization options are fantastic. I was able to create a unique portfolio that perfectly represents my brand."</p>
          <div class="testimonial-author">
            <img src="assets/images/avtr2.avif" alt="Michael Chen" class="testimonial-avatar">
            <div class="testimonial-info">
              <h4>Emily Rodriguez</h4>
              <div class="testimonial-rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="testimonial-card animate delay-2">
          <div class="testimonial-quote">
            <i class="fas fa-quote-left"></i>
          </div>
          <p>"The responsive design is perfect. My portfolio looks amazing on both desktop and mobile devices."</p>
          <div class="testimonial-author">
            <img src="assets/images/avtr3.webp" alt="Emily Rodriguez" class="testimonial-avatar">
            <div class="testimonial-info">
              <h4>Michael Chen</h4>
              <div class="testimonial-rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
