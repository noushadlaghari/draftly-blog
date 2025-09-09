<?php 
require_once(__DIR__ ."/middlewares/Auth.php");
require_once(__DIR__ ."/controllers/BlogController.php");
require_once(__DIR__ ."/controllers/CategoriesController.php");

$categories = (new CategoriesController())->findAll()["categories"];


$blogs = (new BlogController())->findAll(["limit"=>3,"offset"=>0])["blogs"];
$featured_blogs = (new BlogController())->findFeatured()["featured"];


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Draftly - Your Blogging Platform</title>
  <link rel="icon" type="image/png" href="./assets/images/favicon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
      font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
      background-color: var(--light-bg);
    }
    
    .hero {
      background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                  url('./assets/images/background.jpg') no-repeat center center;
      background-size:cover;
      color: white;
      padding: 150px 0;
    }
    
    .gradient-bg {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    }
    
    .stat-number {
      font-size: 2.5rem;
      font-weight: 700;
    }
    
    .testimonial-card {
      border-left: 4px solid var(--primary);
    }
    
    .category-card {
      transition: all 0.3s ease;
      border: none;
      border-radius: 12px;
    }
    
    .category-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .newsletter-form {
      border-radius: 50px;
      overflow: hidden;
    }
    
    .post-card {
      overflow: hidden;
      border: none;
      border-radius: 12px;
      transition: all 0.3s ease;
    }
    
    .post-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .post-card img {
      height: 200px;
      object-fit: cover;
      transition: transform 0.5s;
    }
    
    .post-card:hover img {
      transform: scale(1.05);
    }
    
    .author-img {
      width: 50px;
      height: 50px!important;
      border-radius: 100%;
      object-fit:scale-down;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border: none;
    }
    
    .btn-primary:hover {
      background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(111, 66, 193, 0.3);
    }
    
    .btn-outline-light:hover {
      background-color: rgba(255, 255, 255, 0.1);
      color: white;
    }
    
    .badge.bg-primary {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
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
  <section class="hero">
    <div class="container">
      <div class="row justify-content-center text-center">
        <div class="col-lg-8">
          <h1 class="display-4 fw-bold mb-4">Welcome to Draftly</h1>
          <p class="lead mb-5">Discover, create, and share inspiring stories with our community of passionate writers and readers.</p>
          <div class="d-flex flex-wrap gap-3 justify-content-center">
            <a href="blogs.php" class="btn btn-primary btn-lg px-4 py-3 rounded-pill">Start Reading</a>
            <a href="add-new-blog.php" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill">Start Writing</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Stats Section -->
  <section class="py-5 gradient-bg text-white">
    <div class="container">
      <div class="row g-4 text-center">
        <div class="col-md-3 col-6">
          <div class="p-3">
            <div class="stat-number">1,250+</div>
            <p class="mb-0">Published Posts</p>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="p-3">
            <div class="stat-number">500+</div>
            <p class="mb-0">Active Writers</p>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="p-3">
            <div class="stat-number">10K+</div>
            <p class="mb-0">Monthly Readers</p>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="p-3">
            <div class="stat-number">25+</div>
            <p class="mb-0">Categories</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Posts -->
  <section class="py-5">
    <div class="container">
      <div class="row align-items-end mb-5">
        <div class="col-md-8">
          <h2 class="fw-bold mb-2">Featured Stories</h2>
          <p class="text-muted">Discover the most engaging content from our community</p>
        </div>
        <div class="col-md-4 text-md-end">
          <a href="#" class="btn btn-link text-decoration-none">View All <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
      </div>
      <div class="row g-4">

      <?php 
        if(!empty($featured_blogs)){
          foreach($featured_blogs as $blog){
      ?>

        <div class="col-lg-4 col-md-6">
          <div class="card post-card shadow-sm h-100">
            <div class="position-relative overflow-hidden">
              <img src="public/<?=$blog["featured_image"]?>" class="card-img-top" alt="">
              <span class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1 m-3 rounded-pill small"><?=$blog["category"]?></span>
            </div>
            <div class="card-body">
              <a href="single-post.php?id=<?=$blog["id"]?>" style="text-decoration: none; color:black">
                <h5 class="card-title fw-bold"><?=$blog['title']?></h5>
              </a>
              <p class="card-text text-muted"><?=substr(strip_tags($blog["content"]),0,110)?>...</p>
              <div class="d-flex align-items-center mt-4">
                <img src="public/<?=$blog["user_image"]?>" class="author-img me-2" alt="Author">
                <div>
                  <p class="small mb-0 fw-bold"><?=$blog["author"]?></p>
                  <p class="small text-muted mb-0"><?=$blog["created_at"]?> · 8 min read</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php 
          }}
        ?>

    
      </div>
    </div>
  </section>

  <!-- Categories -->
  <section class="py-5 bg-white">
    <div class="container">
      <div class="row justify-content-center text-center mb-5">
        <div class="col-lg-6">
          <h2 class="fw-bold mb-3">Explore Categories</h2>
          <p class="text-muted">Find content that matches your interests across various topics</p>
        </div>
      </div>
      <div class="row g-4">

      <?php 
      
       if($categories){
        foreach($categories as $index=>$category){
          if($index>=8){
            break;
          }
      ?>
        <div class="col-md-3 col-6">

          <a href="category.php?category_id=<?=$category['id']?>" style="text-decoration: none;">
            <div class="card category-card text-center shadow-sm p-4">
              <div class="mb-3">
                
              </div>
              <h5 class="fw-bold"><?=$category["name"]?></h5>
              <p class="small text-muted mb-0"><?=$category["total_blogs"]?> articles</p>
            </div>
            
          </a>
        </div>

        <?php }}?>
   
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row justify-content-center text-center mb-5">
        <div class="col-lg-6">
          <h2 class="fw-bold mb-3">What Our Readers Say</h2>
          <p class="text-muted">Discover why people love reading and writing on Draftly</p>
        </div>
      </div>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card testimonial-card border-0 shadow-sm h-100">
            <div class="card-body p-4">
              <div class="mb-4">
                <i class="fas fa-quote-left fa-2x text-primary opacity-25"></i>
              </div>
              <p class="card-text mb-4">Draftly has completely transformed my reading habits. The quality of content and the diversity of topics keep me coming back every day.</p>
              <div class="d-flex align-items-center">
                <img src="https://source.unsplash.com/100x100/?woman" class="author-img me-3" alt="Reader">
                <div>
                  <p class="fw-bold mb-0">Jessica Taylor</p>
                  <p class="small text-muted mb-0">Regular Reader</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card testimonial-card border-0 shadow-sm h-100">
            <div class="card-body p-4">
              <div class="mb-4">
                <i class="fas fa-quote-left fa-2x text-primary opacity-25"></i>
              </div>
              <p class="card-text mb-4">As a writer, I appreciate the clean interface and engaged community. Draftly makes it easy to share my stories and connect with readers.</p>
              <div class="d-flex align-items-center">
                <img src="https://source.unsplash.com/100x100/?man" class="author-img me-3" alt="Writer">
                <div>
                  <p class="fw-bold mb-0">David Wilson</p>
                  <p class="small text-muted mb-0">Content Creator</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card testimonial-card border-0 shadow-sm h-100">
            <div class="card-body p-4">
              <div class="mb-4">
                <i class="fas fa-quote-left fa-2x text-primary opacity-25"></i>
              </div>
              <p class="card-text mb-4">The curated content and thoughtful community make Draftly my go-to platform for both reading and publishing articles.</p>
              <div class="d-flex align-items-center">
                <img src="https://source.unsplash.com/100x100/?person" class="author-img me-3" alt="User">
                <div>
                  <p class="fw-bold mb-0">Alex Morgan</p>
                  <p class="small text-muted mb-0">Blogger</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Recent Posts -->
  <section class="py-5">
    <div class="container">
      <div class="row align-items-end mb-5">
        <div class="col-md-8">
          <h2 class="fw-bold mb-2">Recent Articles</h2>
          <p class="text-muted">Latest publications from our community</p>
        </div>
        <div class="col-md-4 text-md-end">
          <a href="#" class="btn btn-link text-decoration-none">View All <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="list-group shadow-sm">

          <?php  
          if ($blogs) {
            foreach ($blogs as $blog) {
          ?>
            <a href="single-post.php?id=<?=$blog["id"]?>" class="list-group-item list-group-item-action border-0 py-4">
              <div class="d-flex align-items-center">
                <span class="badge bg-primary me-3"><?=$blog["category"]?></span>
                <h5 class="mb-0 flex-grow-1"><?=$blog["title"]?></h5>
                <span class="text-muted small"><?=$blog["created_at"]?></span>
              </div>
            </a>

            <?php
            }}
            ?>

          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Newsletter -->
  <section class="py-5 gradient-bg text-white">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <h2 class="fw-bold mb-3">Stay Updated</h2>
          <p class="mb-4">Subscribe to our newsletter and never miss our latest articles and updates</p>
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <form class="newsletter-form bg-white p-1 shadow">
                <div class="input-group">
                  <input type="email" class="form-control border-0 shadow-none" placeholder="Your email address">
                  <button class="btn btn-dark rounded-pill px-4" type="submit">Subscribe</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <?php
    require_once("././partials/footer.php");
    ?>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>