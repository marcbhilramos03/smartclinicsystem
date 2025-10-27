<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SmartClinic</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="{{ asset('/favicon.ico') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon-16x16.png') }}">
<style>
body {
font-family: 'Poppins', sans-serif;
line-height: 1.6;
color: #000000;
background-color: #f8faff;
}
h1, h2, h5, h6 {
font-weight: 700;
letter-spacing: 0.3px;
/* Base color remains dark, overwritten in hero */
color: #01050c; 
}
.navbar {
padding: 15px 0;
background: rgba(255, 255, 255, 0.98);
backdrop-filter: blur(12px);
color: #000000;
box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}
.navbar-brand {
font-weight: 800;
font-size: 1.7rem;
/* IMPROVEMENT 3: Brand text color is now primary blue */
color: #1a56db; 
}
.navbar .logo {
    width: 45px; /* IMPROVEMENT 3: Reduced logo size */
    height: 45px;
    margin-right: 10px;
}
.nav-link {
font-weight: 500;
margin-left: 20px;
transition: all 0.3s ease;
}
.nav-link:hover {
color: #1a56db !important;
transform: translateY(-2px);
}
.hero {
position: relative;
color: rgb(5, 1, 1);
text-align: left;
padding: 140px 20px 100px;
border-bottom-left-radius: 80px;
border-bottom-right-radius: 80px;
background: linear-gradient(135deg, #1a56db, #3f83f8);
box-shadow: 0 15px 50px rgba(0,0,0,0.25);
overflow: hidden;
}
.hero::after {
content: '';
position: absolute;
top: -100px;
right: -100px;
width: 350px;
height: 350px;
background: rgba(255, 255, 255, 0.1);
border-radius: 50%;
z-index: 1;
}
.hero h1 {
font-size: 3.8rem;
font-weight: 800;
color: hsl(0, 29%, 94%);
line-height: 1.2;
}
.hero p {
font-size: 1.2rem;
margin-top: 20px;
line-height: 1.7;
color: #c2d0d7;
max-width: 600px;
}
/* IMPROVEMENT 1: Styling for About Us section */
#about {
    padding: 80px 0;
    /* Changed background from bg-light/text-white for high contrast */
    background: #f0f4f8; 
}
#about h2 {
    color: #01050c; /* Ensure section title is dark and readable */
}
#about p {
    color: #000000; /* Ensure body text is dark */
}

#features {
padding: 80px 0;
}
.feature-card {
background: #ffffff;
border: 1px solid #e2e8f0;
border-radius: 18px;
padding: 40px 30px;
box-shadow: 0 8px 30px rgba(0,0,0,0.06);
transition: all 0.3s ease;
height: 100%;
display: flex;
flex-direction: column;
align-items: center;
text-align: center;
cursor: pointer;
}
.feature-card:hover {
transform: translateY(-8px);
box-shadow: 0 15px 45px rgba(0,0,0,0.1);
}
.feature-card .icon {
font-size: 3.5rem;
margin-bottom: 20px;
color: #1a56db;
}
.feature-card h5 {
color: #01050c;
font-weight: 700;
margin-top: 10px;
margin-bottom: 15px;
}
.feature-card p {
color: #080808;
line-height: 1.7;
}
.footer {
background: #1f2937;
color: #d1d5db;
padding: 70px 0;
}
.footer h5, .footer h6 {
color: #ffffff;
font-weight: 700;
margin-bottom: 20px;
}
.footer a {
color: #e5e7eb;
text-decoration: none;
transition: 0.3s;
display: block;
padding: 5px 0;
}
.footer a:hover {
color: #ffffff;
transform: translateX(5px);
}
.modal-content {
border-radius: 20px;
overflow: hidden;
border: none;
box-shadow: 0 10px 50px rgba(0,0,0,0.25);
background: rgba(255,255,255,0.98);
backdrop-filter: blur(15px);
}
.modal-header {
background: linear-gradient(135deg, #1a56db, #3f83f8);
color: white;
border-bottom: none;
padding: 25px;
}
.modal-title {
font-weight: 700;
font-size: 1.7rem;
}
.btn-primary, .btn-success {
border-radius: 14px;
font-weight: 600;
transition: all 0.3s ease;
padding: 15px 30px;
font-size: 1.1rem;
}
.btn-primary {
background-color: #1a56db;
border-color: #1a56db;
}
.btn-success {
background-color: #22c55e;
border-color: #22c55e;
}
.btn-success:hover {
transform: translateY(-4px);
box-shadow: 0 8px 25px rgba(34,197,94,0.4);
background-color: #1ba84d;
border-color: #1ba84d;
}
.btn-close-white {
filter: brightness(0) invert(1);
}
.hero img {
max-width: 70%; 
transform: scale(1);
transition: transform 0.3s ease;
}
.btn-bordered {
border: 2px solid #1a56db;
border-radius: 12px;
transition: all 0.3s ease;
}
.btn-bordered:hover {
background-color: #1a56db;
color: white;
}
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top">
<div class="container">
<img src="{{ asset('images/logo.png') }}" alt="SmartClinic Logo" class="logo">
<a class="navbar-brand" href="#">SmartClinic</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
<ul class="navbar-nav align-items-lg-center">
<li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
<li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
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
<h1>SmartClinic</h1>
<p>Smart Clinic helps your school deliver better healthcare with less hassle. Securely store and access student medical records anytime, anywhere. Gain insights into student health trends to support proactive care. Make your clinic smarter, faster, and more focused on student well-being.</p>
<button type="button" class="btn btn-light btn-lg mt-3" data-bs-toggle="modal" data-bs-target="#loginModal">Get Started</button>
</div>
<div class="col-lg-6 text-center mt-5 mt-lg-2">
<img src="{{ asset('images/clinic-illustration.png') }}" alt="Clinic Illustration" class="img-fluid">
</div>
</div>
</div>
</section>

<section id="about" class="section py-5">
<div class="container">
<h2 class="section-title text-center mb-5">About Us</h2>
<div class="row align-items-center">
<div class="col-md-6 mb-4 mb-md-0 text-center">
    <img src="{{ asset('images/about-us.png') }}" alt="Security and Team Illustration" class="img-fluid rounded-3 shadow-sm" style="max-height: 350px;">
</div>
<div class="col-md-6">
    <p class="lead fw-semibold">Modernizing School Healthcare</p>
    <p>SmartClinic was developed to modernize and simplify the management of school clinic operations. Our goal is to help schools maintain **accurate health records**, streamline clinic workflows, and enhance student wellness through technology-driven solutions.</p>
    <p>We believe that efficient healthcare management in educational institutions promotes better learning and overall well-being. With SmartClinic, administrators, medical staff, and students can connect seamlessly in a secure and user-friendly environment.</p>
</div>
</div>
</div>
</section>

<section class="container text-center my-5" id="features">
<h2 class="fw-bold mb-5 text-dark">Key Features</h2>
<div class="row g-4">
<div class="col-md-4">
<div class="feature-card" data-bs-toggle="modal" data-bs-target="#ehrModal">
<div class="icon">📑</div>
<h5>Electronic Health Records</h5>
<p>Store and access student health information securely and efficiently.</p>
</div>
</div>
<div class="col-md-4">
<div class="feature-card" data-bs-toggle="modal" data-bs-target="#schedulingModal">
<div class="icon">📅</div>
<h5>Checkup Scheduling</h5>
<p>Effortlessly book and manage appointments through the system.</p>
</div>
</div>
<div class="col-md-4">
<div class="feature-card" data-bs-toggle="modal" data-bs-target="#reportingModal">
<div class="icon">📊</div>
<h5>Reporting & Analytics</h5>
<p>Visualize health trends with auto-generated statistics and reports.</p>
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
<h6>Quick Links</h6>
<ul class="list-unstyled">
<li><a href="#hero">Home</a></li>
<li><a href="#features">Features</a></li>
</ul>
</div>
<div class="col-md-4 mb-3">
<h6>Contact Us</h6>
<p>Christ the King College, Philippines</p>
<p>📞 (555) 123-4567<br>📧 info@smartclinic.com</p>
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
<a href="{{ route('admin.login.form') }}" class="btn btn-light btn-lg py-3 btn-bordered">🩺 Doctor / Nurse</a>
<a href="{{ route('patient.login.form') }}" class="btn btn-light btn-lg py-3 btn-bordered">🎓 Student</a>
</div>
</div>
</div>
</div>
</div>
<div class="modal fade" id="ehrModal" tabindex="-1" aria-labelledby="ehrModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="ehrModalLabel">Electronic Health Records (EHR)</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body py-4 px-5">
<p class="lead"><strong>Digitize, Centralize, and Secure Health Data</strong></p>
<p>Our **EHR system** replaces paper files with secure, digital records, making patient information easily accessible for authorized staff. Key benefits include:</p>
<ul class="list-unstyled lh-lg">
<li><strong>✅ Secure Storage:</strong> AES-256 encryption protects all sensitive student data.</li>
<li><strong>✅ Quick Retrieval:</strong> Instantly search records by student ID, name, or class.</li>
<li><strong>✅ Visit Logging:</strong> Detailed logs of every clinic visit, treatment, and medication administered.</li>
<li><strong>✅ Consent Management:</strong> Track parental consent forms and allergy information efficiently.</li>
</ul>
</div>
<div class="modal-footer justify-content-center">
    <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-success btn-lg ms-3" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">
        Start Using SmartClinic
    </button>
</div>
</div>
</div>
</div>
<div class="modal fade" id="schedulingModal" tabindex="-1" aria-labelledby="schedulingModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="schedulingModalLabel">Checkup Scheduling</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body py-4 px-5">
<p class="lead"><strong>Manage Appointments with Ease and Precision</strong></p>
<p>Streamline your clinical workflow with our integrated **scheduling tool**. Reduce no-shows and optimize your daily calendar.</p>
<ul class="list-unstyled lh-lg">
<li><strong>✅ Automated Reminders:</strong> Send SMS or email reminders to parents and students.</li>
<li><strong>✅ Custom Calendar Views:</strong> See daily, weekly, or monthly appointments at a glance.</li>
<li><strong>✅ Bulk Scheduling:</strong> Easily set up school-wide health screening events.</li>
<li><strong>✅ Conflict Prevention:</strong> The system flags double-bookings and time conflicts automatically.</li>
</ul>
</div>
<div class="modal-footer justify-content-center">
    <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-success btn-lg ms-3" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">
        Start Using SmartClinic
    </button>
</div>
</div>
</div>
</div>
<div class="modal fade" id="reportingModal" tabindex="-1" aria-labelledby="reportingModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="reportingModalLabel">Reporting & Analytics</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body py-4 px-5">
<p class="lead"><strong>Insight-Driven Health Management</strong></p>
<p>Gain valuable insights into your school's health profile with automatically generated reports and **data visualizations**. This helps in proactive health management.</p>
<ul class="list-unstyled lh-lg">
<li><strong>✅ Customizable Reports:</strong> Generate reports on immunization status, most common complaints, and recurring issues.</li>
<li><strong>✅ Trend Monitoring:</strong> Identify health trends quickly with visual dashboards.</li>
<li><strong>✅ Export Functionality:</strong> Export reports as PDF or CSV for sharing with administrators.</li>
<li><strong>✅ Data Security:</strong> All reports comply with data privacy regulations.</li>
</ul>
</div>
<div class="modal-footer justify-content-center">
    <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-success btn-lg ms-3" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">
        Start Using SmartClinic
    </button>
</div>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>