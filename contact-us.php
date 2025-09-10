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
      --light: #f8f9fa;
      --dark: #343a40;
      --text-primary: #2d3748;
      --text-secondary: #718096;
      --line-height: 1.7;
    }

    body {
      font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
      background-color: var(--light);
      color: var(--text-primary);
      line-height: var(--line-height);
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
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      max-width: 1000px;
    }

    .contact-title {
      text-align: center;
      margin-bottom: 2.5rem;
      color: var(--text-primary);
      font-weight: 700;
    }

    .form-control,
    .form-select {
      border-radius: 10px;
      padding: 12px 15px;
      border: 1px solid #e2e8f0;
      transition: all 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.15);
    }

    .btn-primary {
      background-color: var(--primary);
      border: none;
      border-radius: 10px;
      padding: 12px 20px;
      font-weight: 600;
      transition: all 0.3s;
    }

    .btn-primary:hover {
      background-color: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(111, 66, 193, 0.4);
    }

    .info-box {
      background: var(--light);
      padding: 2rem;
      border-radius: 15px;
      height: 100%;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
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

    .error {
      color: #dc3545;
      margin-top: 5px;
      margin-bottom: 10px;
      font-size: 0.875rem;
    }

    .alert-success {
      background-color: rgba(40, 167, 69, 0.1);
      color: #28a745;
      border: none;
    }

    .alert-danger {
      background-color: rgba(220, 53, 69, 0.1);
      color: #dc3545;
      border: none;
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


    a {
      color: var(--primary);
      text-decoration: none;
    }

    a:hover {
      color: var(--primary-dark);
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
      <h1 class="display-5 fw-bold text-white">Get in Touch</h1>
      <p class="lead">We'd love to hear from you. Reach out to us with any questions or feedback.</p>
    </div>
  </section>

  <!-- Contact Section -->
  <div class="container contact-section">
    <h2 class="contact-title">Contact Us</h2>
    <div id="message"></div>
    <div class="row">
      <!-- Contact Form -->
      <div class="col-lg-7">
        <form id="contact_form">
          <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Your Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required>
            <div id="name_error" class="error"></div>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Your Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="example@mail.com" autocomplete="email" required>
            <div id="email_error" class="error"></div>
          </div>
          <div class="mb-3">
            <label for="subject" class="form-label fw-semibold">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject of your message" required>
            <div id="subject_error" class="error"></div>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label fw-semibold">Your Message</label>
            <textarea class="form-control" name="message" rows="5" minlength="50" placeholder="Write your message here..." required></textarea>
            <div id="message_error" class="error"></div>
          </div>
          <button type="submit" class="btn btn-primary w-100 py-2">
            <i class="fas fa-paper-plane me-2"></i>Send Message
          </button>
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
            <p class="ms-4">
              <a href="mailto:noshadlaghari46@gmail.com">noshadlaghari46@gmail.com</a>
            </p>
          </div>

          <div class="mb-3">
            <h6 class="fw-semibold"><i class="fas fa-phone me-2 text-primary"></i> Phone</h6>
            <p class="ms-4">+923173257965</p>
          </div>

          <div class="mb-4">
            <h6 class="fw-semibold"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Address</h6>
            <p class="ms-4">Hyderabad, Sindh, Pk</p>
          </div>

          <hr>

          <h6 class="fw-semibold mb-3">Follow Us</h6>
          <div class="social-links">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="https://linkedin.com/noushadleghari"><i class="fab fa-linkedin-in"></i></a>
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

  <script src="./js/define.js"></script>

  <script>
    let contact_form = document.getElementById("contact_form");
    let name_error = document.getElementById("name_error");
    let email_error = document.getElementById("email_error");
    let subject_error = document.getElementById("subject_error");
    let message_error = document.getElementById("message_error");

    async function submit_form() {

      let formdata = new FormData(contact_form);
      formdata.append("controller", "ContactsController");
      formdata.append("action", "create");
      name_error.innerHTML = "";
      email_error.innerHTML = "";
      subject_error.innerHTML = "";
      message_error.innerHTML = "";

      let response = await request("./handler/handler.php", formdata);

      if (!response) {
        showMessage("danger", "Something Went Wrong!");
        return;
      }
      if (response.status && response.status == "success") {
        showMessage("success", response.message);
        contact_form.reset();
      } else if (response.status && response.status == "error" && response.errors) {
        let errors = response.errors;
        name_error.innerText = errors.name ?? "";
        email_error.innerText = errors.email ?? "";
        subject_error.innerText = errors.subject ?? "";
        message_error.innerText = errors.message ?? "";
      } else if (response.status && response.status == "error" && response.message) {
        showMessage("danger", response.message);
      } else {
        showMessage("danger", "Something Went Wrong!");
      }
    }

    contact_form.addEventListener("submit", (e) => {
      e.preventDefault();
      submit_form();
    });
  </script>
</body>

</html>