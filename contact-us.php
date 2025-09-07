<?php 
require_once("./middlewares/auth.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - Draftly</title>
    <link rel="icon" type="image/png" href="./assets/images/favicon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #6f42c1;
      --primary-dark: #5a32a3;
      --secondary: #6c757d;
      --success: #1cc88a;
      --dark: #2e3a59;
      --light: #f8f9fc;
      --light-bg: #f8f9fa;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--light-bg);
      color: var(--dark);
    }
    
    .contact-hero {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      padding: 4rem 0;
      color: white;
      text-align: center;
      margin-bottom: 3rem;
      border-radius: 0 0 15px 15px;
    }
    
    .contact-section {
      background: #fff;
      padding: 3rem;
      margin: 0 auto 4rem;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
      max-width: 1000px;
    }
    
    .contact-title {
      text-align: center;
      margin-bottom: 2.5rem;
      color: var(--dark);
      font-weight: 700;
    }
    
    .form-control, .form-select {
      border-radius: 10px;
      padding: 12px 15px;
      border: 1px solid #e2e8f0;
      transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.15);
    }
    
    .btn-primary {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border: none;
      border-radius: 10px;
      padding: 12px 20px;
      font-weight: 600;
      transition: all 0.3s;
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(111, 66, 193, 0.4);
    }
    
    .info-box {
      background: linear-gradient(to bottom right, var(--light) 0%, #fff 100%);
      padding: 2rem;
      border-radius: 15px;
      height: 100%;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      border-left: 4px solid var(--primary);
    }
    
    .contact-icon {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1rem;
      color: white;
      font-size: 1.2rem;
    }
    
    .social-links a {
      display: inline-block;
      width: 40px;
      height: 40px;
      background: var(--light);
      border-radius: 50%;
      text-align: center;
      line-height: 40px;
      color: var(--primary);
      margin-right: 10px;
      transition: all 0.3s;
    }
    
    .social-links a:hover {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: white;
      transform: translateY(-3px);
    }
    
    @media (max-width: 768px) {
      .contact-section {
        padding: 2rem;
        margin: 0 1rem 3rem;
      }
      
      .contact-hero {
        padding: 3rem 1rem;
        border-radius: 0;
      }
      
      .info-box {
        margin-top: 2rem;
      }
    }
  </style>
</head>
<body>

<header>
  <?php 
    require_once("././partials/header.php");
  ?>
</header>

  <!-- Hero Section -->
  <section class="contact-hero">
    <div class="container">
      <h1 class="display-5 fw-bold">Get in Touch</h1>
      <p class="lead">We'd love to hear from you. Reach out to us with any questions or feedback.</p>
    </div>
  </section>

  <!-- Contact Section -->
  <div class="container contact-section">
    <h2 class="contact-title">Contact Us</h2>
    <div class="row">
      <!-- Contact Form -->
      <div class="col-lg-7">
        <form>
          <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Your Name</label>
            <input type="text" class="form-control" id="name" placeholder="John Doe" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Your Email</label>
            <input type="email" class="form-control" id="email" placeholder="example@mail.com" required>
          </div>
          <div class="mb-3">
            <label for="subject" class="form-label fw-semibold">Subject</label>
            <input type="text" class="form-control" id="subject" placeholder="Subject of your message" required>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label fw-semibold">Your Message</label>
            <textarea class="form-control" id="message" rows="5" placeholder="Write your message here..." required></textarea>
          </div>
          <button type="submit" class="btn btn-primary w-100 py-2">Send Message</button>
        </form>
      </div>

      <!-- Contact Info -->
      <div class="col-lg-5 mt-5 mt-lg-0">
        <div class="info-box">
          <div class="contact-icon">
            <i class="fas fa-envelope"></i>
          </div>
          <h5>Get in Touch</h5>
          <p class="mb-4">If you have any questions or feedback, feel free to reach out to us. We'd love to hear from you!</p>
          
          <div class="mb-3">
            <h6 class="fw-semibold"><i class="fas fa-envelope me-2 text-primary"></i> Email</h6>
            <p class="ms-4">support@draftly.com</p>
          </div>
          
          <div class="mb-3">
            <h6 class="fw-semibold"><i class="fas fa-phone me-2 text-primary"></i> Phone</h6>
            <p class="ms-4">+1 234 567 890</p>
          </div>
          
          <div class="mb-4">
            <h6 class="fw-semibold"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Address</h6>
            <p class="ms-4">123 Draftly Street, Blog City, USA</p>
          </div>
          
          <hr>
          
          <h6 class="fw-semibold mb-3">Follow Us</h6>
          <div class="social-links">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <?php 
      require_once("././partials/footer.php");
    ?>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>