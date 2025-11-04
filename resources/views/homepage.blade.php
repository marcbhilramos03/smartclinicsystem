<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SmartClinic</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link rel="icon" type="image/png" href="{{ asset('/favicon-32x32.png') }}">

<style>
    html {
  font-size: 110%; 
}

:root {
    --primary: #1a56db;
    --secondary: #3f83f8;
    --dark: #0f172a;
    --light: #f8faff;
}

body {
    font-family: 'Poppins', sans-serif;
    color: var(--dark);
    background-color: var(--light);
    overflow-x: hidden;
}

.navbar {
    padding: 15px 0;
    background: rgba(255, 255, 255, 0.98);
    box-shadow: 0 2px 20px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
}
.navbar.scrolled {
    box-shadow: 0 4px 25px rgba(0,0,0,0.12);
}
.navbar-brand {
    font-weight: 800;
    color: var(--primary);
    font-size: 1.7rem;
}
.navbar li{
    color: #000000;
}
.hero {
    position: relative;
    padding: 160px 0 120px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    overflow: hidden;
}
.hero h1 {
    font-size: 3.5rem;
    font-weight: 800;
}
.hero p {
    font-size: 1.15rem;
    color: rgba(255,255,255,0.9);
    max-width: 550px;
}
.hero button {
    color: #f6f5fc;
}
.hero img {
    width:85%;
    max-width: 1000px;
    transition: transform 0.4s ease;
}
.hero img:hover {
    transform: scale(1.05);
}


.section-title {
    font-weight: 700;
    color: var(--dark);
}

#about {
  min-height: 100vh; 
  background: linear-gradient(180deg, #f0f4f8 0%, #ffffff 100%);
  display: flex;
  align-items: center;
  padding: 80px 0;
  position: relative;
}

#about::before {
  content: '';
  position: absolute;
  top: -50px;
  right: -50px;
  width: 300px;
  height: 300px;
  border-radius: 50%;
  background: rgba(26, 86, 219, 0.1);
  z-index: 0;
}

#about h2 {
  position: relative;
  z-index: 1;
  color: #0f172a;
}

#about p {
  position: relative;
  z-index: 1;
  color: #111;
  line-height: 1.8;
}

#about img {
  position: relative;
  z-index: 1;
  transition: transform 0.3s ease;
}

#about img:hover {
  transform: scale(1.05);
}


#features {
    padding: 90px 0;
}
.feature-card {
    background: #fff;
    border-radius: 20px;
    padding: 40px 25px;
    box-shadow: 0 8px 25px rgba(35, 35, 35, 0.05);
    transition: all 0.3s ease;
    text-align: center;
}

.feature-card i {
    font-size: 3rem;
    color: var(--primary);
    margin-bottom: 15px;
}
.feature-card h5 {
    font-weight: 700;
    margin-bottom: 10px;
}
.feature-card p {
    color: #0f0e0e;
}

.footer {
    background: #1f2937;
    color: #d1d5db;
    padding: 70px 0 30px;
}
.footer h5 {
    color: #fff;
    font-weight: 700;
}
.footer a {
    color: #e5e7eb;
    text-decoration: none;
    transition: all 0.3s;
}
.footer a:hover {
    color: #fff;
    transform: translateX(5px);
}
.footer .copyright {
    border-top: 1px solid rgba(255,255,255,0.1);
    margin-top: 40px;
    padding-top: 20px;
    text-align: center;
    font-size: 0.9rem;
}

.btn-primary, .btn-success {
    border-radius: 14px;
    font-weight: 600;
    padding: 12px 28px;
    font-size: 1.05rem;
}
.btn-bordered {
    border: 2px solid var(--primary);
    border-radius: 12px;
    color: var(--primary);
    background: transparent;
    transition: 0.3s;
}
.btn-bordered:hover {
    background: var(--primary);
    color: white;
}

.modal-content {
    border-radius: 20px;
    border: none;
    background: rgba(255,255,255,0.97);
    box-shadow: 0 10px 50px rgba(0,0,0,0.25);
}
.modal-header {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    border-bottom: none;
}
</style>
</head>

<body>
<nav class="navbar navbar-expand-lg fixed-top">
<div class="container">
    <a class="navbar-brand d-flex align-items-center" href="#">
                SmartClinic
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-lg-center">
            <li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
            <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
            <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        </ul>
    </div>
</div>
</nav>

<section class="hero" id="hero">
<div class="container">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <h1>Smarter School Healthcare</h1>
            <p>SmartClinic helps your school deliver better healthcare with less hassle. Securely store and access student medical records anytime, anywhere — empowering your clinic to focus on student wellness.</p>
            <button class="btn btn-success btn-lg mt-3" data-bs-toggle="modal" data-bs-target="#loginModal">Get Started</button>
        </div>
        <div class="col-lg-6 text-center mt-5 mt-lg-0">
            <img src="{{ asset('images/logo1.png') }}" alt="SmartClinic Logo" class="img-fluid">
        </div>
    </div>
</div>
</section>


<section id="about" class="d-flex align-items-center">
  <div class="container">
    <div class="row align-items-center justify-content-between flex-column-reverse flex-md-row">
      

      <div class="col-md-5 text-center">
        <img src="{{ asset('images/about-us.png') }}" alt="About SmartClinic"
             class="img-fluid rounded-4 shadow-lg"
             style="max-height: 500px; width: 100%; object-fit: contain;">
      </div>

      <div class="col-md-6 mt-5 mt-md-0">
        <h2 class="fw-bold mb-4 display-6">About </h2>
        <p class="lead fw-semibold text-dark mb-3">Modernizing School Healthcare</p>
        <p class="text-dark mb-3">
          SmartClinic is designed to modernize and simplify the way school clinics manage healthcare operations.
          Our system helps schools maintain <strong>accurate health records</strong>, streamline workflows, and
          enhance student wellness through smart, technology-driven tools.
        </p>
        <p class="text-dark">
          We believe that efficient healthcare management in educational institutions promotes better learning and
          well-being. SmartClinic connects <strong>administrators, medical staff, and students</strong> in a secure and user-friendly environment.
        </p>
      </div>
    </div>
  </div>
</section>


<section id="features">
<div class="container text-center">
    <h2 class="fw-bold mb-5 text-dark">Key Features</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-card">
                <i class="bi bi-file-earmark-medical"></i>
                <h5>Electronic Health Records</h5>
                <p>Securely manage student medical histories, medications, and treatments all in one place.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <i class="bi bi-calendar-check"></i>
                <h5>Checkup Scheduling</h5>
                <p>Book, manage, and track appointments with automated reminders and calendar integration.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <i class="bi bi-bar-chart-line"></i>
                <h5>Reports & Analytics</h5>
                <p>Monitor health trends, generate reports, and make data-driven decisions for better care.</p>
            </div>
        </div>
    </div>
</div>
</section>

<footer class="footer" id="contact">
<div class="container">
    <div class="row">
        <div class="col-md-4 mb-3">
            <h5>SmartClinic</h5>
            <p>Empowering schools with smarter healthcare management.</p>
        </div>
        <div class="col-md-4 mb-3">
            <h5>Quick Links</h5>
            <a href="#hero">Home</a><br>
            <a href="#features">Features</a><br>
            <a href="#about">About</a>
        </div>
        <div class="col-md-4 mb-3">
            <h5>Contact Us</h5>
            <p>Christ the King College, Gingoog City</p>
            <p>📧 ckc.edu.ph</p>
        </div>
    </div>
</div>
</footer>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Continue as</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body text-center py-5">
        <div class="d-grid gap-3 px-2">
            <a href="{{ route('admin.login.form') }}" class="btn btn-bordered btn-lg py-3">🩺 Doctor / Nurse</a>
            <a href="{{ route('patient.login.form') }}" class="btn btn-bordered btn-lg py-3">🎓 Student</a>
        </div>
    </div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
