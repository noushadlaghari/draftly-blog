<?php 
require_once("./middlewares/auth.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - Draftly</title>
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
      background-color: var(--light-bg);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: var(--dark);
    }
    
    .about-hero {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: white;
      padding: 5rem 0;
      text-align: center;
      margin-bottom: 3rem;
      border-radius: 0 0 15px 15px;
    }
    
    .about-hero h1 {
      font-size: 3.5rem;
      font-weight: 800;
      margin-bottom: 1rem;
    }
    
    .about-hero p {
      font-size: 1.2rem;
      opacity: 0.9;
      max-width: 600px;
      margin: 0 auto;
    }
    
    .about-section {
      padding: 2rem 0 4rem;
    }
    
    .about-card {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
      padding: 2.5rem;
      margin-bottom: 2.5rem;
      transition: all 0.3s ease;
      border: none;
    }
    
    .about-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.12);
    }
    
    .about-card h2 {
      color: var(--primary);
      font-weight: 700;
      margin-bottom: 1.5rem;
      position: relative;
      padding-bottom: 0.5rem;
    }
    
    .about-card h2:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 50px;
      height: 3px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border-radius: 3px;
    }
    
    .about-card p {
      color: var(--secondary);
      line-height: 1.8;
      font-size: 1.05rem;
    }
    
    .team-member {
      text-align: center;
      padding: 1.5rem;
    }
    
    .team-img {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 50%;
      margin: 0 auto 1.5rem;
      border: 4px solid var(--light);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }
    
    .team-member:hover .team-img {
      transform: scale(1.05);
      border-color: var(--primary);
    }
    
    .team-member h5 {
      color: var(--dark);
      font-weight: 700;
      margin-bottom: 0.5rem;
    }
    
    .team-member p {
      color: var(--primary);
      font-weight: 500;
    }
    
    .icon-box {
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      color: white;
      font-size: 1.5rem;
    }
    
    @media (max-width: 768px) {
      .about-hero {
        padding: 3rem 1rem;
        border-radius: 0;
      }
      
      .about-hero h1 {
        font-size: 2.5rem;
      }
      
      .about-card {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
      }
      
      .team-member {
        margin-bottom: 2rem;
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
  <section class="about-hero">
    <div class="container">
      <h1>About Draftly</h1>
      <p>Your space for ideas, stories, and inspiration.</p>
    </div>
  </section>

  <!-- About Section -->
  <section class="about-section container">
    <!-- Who We Are -->
    <div class="about-card">
      <div class="row align-items-center">
        <div class="col-md-2 text-center">
          <div class="icon-box">
            <i class="fas fa-users"></i>
          </div>
        </div>
        <div class="col-md-10">
          <h2>Who We Are</h2>
          <p>
            Draftly is a modern blogging platform designed to connect writers and readers worldwide. 
            We provide a clean, simple, and beautiful environment for sharing stories, tutorials, news, and personal experiences. 
            Our mission is to give every voice a platform to be heard.
          </p>
        </div>
      </div>
    </div>

    <!-- Our Mission -->
    <div class="about-card">
      <div class="row align-items-center">
        <div class="col-md-2 text-center">
          <div class="icon-box">
            <i class="fas fa-bullseye"></i>
          </div>
        </div>
        <div class="col-md-10">
          <h2>Our Mission</h2>
          <p>
            We aim to empower creators by offering tools that make writing, publishing, and engaging with an audience easy and fun. 
            Draftly is built to be responsive, user-friendly, and equipped with modern features like comments, likes, categories, and more.
          </p>
        </div>
      </div>
    </div>

    <!-- Team Section -->
    <div class="about-card">
      <h2 class="text-center mb-4">Meet Our Team</h2>
      <div class="row">
        <div class="col-md-4 team-member">
          <img src="https://via.placeholder.com/150" alt="Team Member" class="team-img">
          <h5>Noshad Laghari</h5>
          <p>Founder & CEO</p>
        </div>
        <div class="col-md-4 team-member">
          <img src="https://via.placeholder.com/150" alt="Team Member" class="team-img">
          <h5>Mahram Ali</h5>
          <p>Lead Developer</p>
        </div>
        <div class="col-md-4 team-member">
          <img src="https://via.placeholder.com/150" alt="Team Member" class="team-img">
          <h5>Zeeshan</h5>
          <p>Community Manager</p>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <?php 
      require_once("././partials/footer.php");
    ?>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>