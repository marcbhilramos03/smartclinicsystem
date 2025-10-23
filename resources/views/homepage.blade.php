<!-- resources/views/homepage.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SmartClinic</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* ===== GLOBAL STYLING ===== */
   

    h1, h2, h5, h6 {
      font-weight: 700;
      letter-spacing: 0.3px;
    }

    /* ===== NAVBAR ===== */
    .navbar {
      padding: 15px 0;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .navbar-brand {
      font-weight: 700;
      color: #1e3a8a !important;
      font-size: 1.5rem;
    }

    .nav-link {
      font-weight: 500;
      margin-left: 15px;
      color: #374151 !important;
      transition: 0.3s;
    }

    .nav-link:hover {
      color: #1e3a8a !important;
    }

    /* ===== HERO SECTION ===== */
    .hero {
      position: relative;
      color: white;
      text-align: left;
      padding: 120px 20px;
      border-bottom-left-radius: 60px;
      border-bottom-right-radius: 60px;
      background: linear-gradient(135deg, #007bff, #20c997);
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      overflow: hidden;
    }

    .hero::after {
      content: '';
      position: absolute;
      top: -150px;
      right: -150px;
      width: 400px;
      height: 400px;
      background: rgba(255, 255, 255, 0.15);
      border-radius: 50%;
    }

    .hero h1 {
      font-size: 3.2rem;
      font-weight: 800;
      color: #fff;
    }

    .hero p {
      font-size: 1.15rem;
      margin-top: 15px;
      line-height: 1.6;
      color: #f1f5f9;
    }

    .btn-light {
      font-weight: 600;
      padding: 12px 32px;
      border-radius: 12px;
      transition: all 0.3s ease;
      background-color: #ffffff;
      color: #1e3a8a;
    }

    .btn-light:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(255,255,255,0.3);
    }

    /* ===== FEATURES ===== */
    .feature-card {
      background: rgba(255,255,255,0.95);
      border: solid black 2px;
      border-radius: 16px;
      padding: 35px 25px;
      box-shadow: 0 5px 25px rgba(0,0,0,0.08);
      transition: all 0.3s ease;
      height: 100%;
    }

    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 35px rgba(0,0,0,0.12);
    }

    .feature-card h5 {
      color: #1e3a8a;
      font-weight: 700;
      margin-top: 15px;
    }

    .feature-card p {
      color: #6b7280;
    }

    /* ===== FOOTER ===== */
    .footer {
      background: #0f172a;
      color: #cbd5e1;
      padding: 60px 0;
      border-top: 4px solid #1e3a8a;
    }

    .footer h5, .footer h6 {
      color: #ffffff;
      font-weight: 700;
    }

    .footer a {
      color: #f5f7fa;
      text-decoration: none;
      transition: 0.3s;
    }

    .footer a:hover {
      color: #ffffff;
    }

    /* ===== MODAL ===== */
    .modal-content {
      border-radius: 18px;
      overflow: hidden;
      border: none;
      box-shadow: 0 8px 40px rgba(0,0,0,0.2);
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(10px);
    }

    .modal-header {
      background: linear-gradient(135deg, #1e3a8a, #3b82f6);
      color: white;
      border-bottom: none;
    }

    .btn-primary, .btn-success {
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-primary:hover, .btn-success:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(59,130,246,0.4);
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#hero">SmartClinic</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-lg-center">
          <li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
          <li class="nav-item ms-lg-4 mt-3 mt-lg-0">
            <a href="{{ route('admin.login.form') }}" class="btn btn-primary px-4 py-2">Admin Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero" id="hero">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h1>SmartClinic</h1>
          <p>Streamline your school’s clinic management with smart technology — securely manage records, monitor health trends, and simplify your operations.</p>
          <button type="button" class="btn btn-light btn-lg mt-3" data-bs-toggle="modal" data-bs-target="#loginModal">
            Get Started
          </button>
        </div>
        <div class="col-lg-6 text-center mt-5 mt-lg-0">
          <img src="{{ asset('images/clinic-illustration.png') }}" alt="Clinic Illustration" class="img-fluid" style="max-width: 85%;">
        </div>
      </div>
    </div>
  </section>

  <!-- Features -->
  <section class="container text-center my-5" id="features">
    <h2 class="fw-bold mb-5 text-dark">Key Features</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="feature-card">
          <div style="font-size: 2.5rem;">📑</div>
          <h5>Electronic Health Records</h5>
          <p>Store and access student health information securely and efficiently.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card">
          <div style="font-size: 2.5rem;">📅</div>
          <h5>Checkup Scheduling</h5>
          <p>Effortlessly book and manage appointments through the system.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card">
          <div style="font-size: 2.5rem;">📊</div>
          <h5>Reporting & Analytics</h5>
          <p>Visualize health trends with auto-generated statistics and reports.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-md-3 mb-4">
          <h5>SmartClinic</h5>
          <p>Empowering schools with smarter healthcare management.</p>
        </div>
        <div class="col-md-3 mb-4">
          <h6>Quick Links</h6>
          <ul class="list-unstyled">
            <li><a href="#hero">Home</a></li>
            <li><a href="#features">Features</a></li>
          </ul>
        </div>
        <div class="col-md-3 mb-4">
          <h6>Resources</h6>
          <ul class="list-unstyled">
            <li><a href="#">Help Center</a></li>
            <li><a href="#">User Guide</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h6>Contact Us</h6>
          <p>Christ the King College, Philippines</p>
          <p>📞 (555) 123-4567<br>📧 info@smartclinic.com</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Continue as</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center py-5">
          <div class="d-grid gap-3 px-4">
            <a href="{{ route('admin.login.form') }}" class="btn btn-primary btn-lg py-3">Doctor / Nurse</a>
            <a href="{{ route('patient.login.form') }}" class="btn btn-success btn-lg py-3">Student</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
