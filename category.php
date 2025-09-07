<?php 
require_once(__DIR__ ."/middlewares/Auth.php");
if(isset($_GET["category_id"])){

    $category_id = $_GET["category_id"];
    
    require_once("./controllers/CategoriesController.php");
    
    $category = (new CategoriesController())->findById($category_id);

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Technology Blogs - Draftly</title>
    <link rel="icon" type="image/png" href="./assets/images/favicon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    
    .category-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    }
    
    .blog-card {
      transition: transform 0.3s ease;
      border: none;
      overflow: hidden;
    }
    
    .blog-card:hover {
      transform: translateY(-5px);
    }
    
    .blog-card-img {
      height: 220px;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    
    .blog-card:hover .blog-card-img {
      transform: scale(1.05);
    }
    
    .category-badge {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    }
    
    .author-img {
      width: 40px;
      height: 40px;
      object-fit: cover;
    }
  </style>
</head>
<body class="bg-light">

 <header>
    <?php require_once("partials/header.php");?>
 </header>

  <!-- Category Header -->
  <div class="category-header text-white py-5 mb-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0">
              <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
              <li class="breadcrumb-item"><a href="categories.php" class="text-white">Categories</a></li>
              <li class="breadcrumb-item active text-white" aria-current="page">Technology</li>
            </ol>
          </nav>
          <h1 class="display-4 fw-bold mb-3"><?=$category["name"]??"Unknown"?></h1>
          <p class="lead mb-4">Explore the latest trends, innovations, and insights in the world of technology</p>
          <div class="d-flex align-items-center text-white">
            <span class="me-4"><i class="fas fa-file-alt me-2"></i> 128 Articles</span>
            <span><i class="fas fa-users me-2"></i> 24 Authors</span>
          </div>
        </div>
        <div class="col-md-4 text-center">
          <i class="fas fa-laptop-code display-1 opacity-75"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="container mb-5">
    <div class="row">
      <!-- Main Content -->
      <div class="col-lg-8">
        <!-- Sort & Filter -->
        <div class="card shadow-sm mb-4">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-md-6 mb-3 mb-md-0">
                <h5 class="card-title mb-0"><?=$category["name"]??""?> Articles</h5>
              </div>
              <div class="col-md-6">
                <div class="d-flex justify-content-md-end gap-2">
                  <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                      <i class="fas fa-sort me-2"></i>Sort By
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Newest First</a></li>
                      <li><a class="dropdown-item" href="#">Most Popular</a></li>
                      <li><a class="dropdown-item" href="">Trending</a></li>
                    </ul>
                  </div>
                  <button class="btn btn-outline-secondary">
                    <i class="fas fa-filter me-2"></i>Filter
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Blog List -->
        <div class="row g-4" id="blogsContainer">


    


        </div>

        <!-- Pagination -->

        <div class="text-center my-4">
            <button class="btn btn-primary text-center" id="loadMore" onclick="loadMore()">Load More</button>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <!-- About Category -->
        <div class="card shadow-sm mb-4">
          <div class="card-body">
            <h5 class="card-title">About Technology</h5>
            <p class="card-text">The technology category covers the latest innovations, trends, and news in software development, hardware, AI, cybersecurity, and emerging technologies that are shaping our future.</p>
            <div class="d-flex gap-2 flex-wrap">
              <span class="badge bg-primary">Software</span>
              <span class="badge bg-primary">Hardware</span>
              <span class="badge bg-primary">AI</span>
              <span class="badge bg-primary">Cloud</span>
              <span class="badge bg-primary">Security</span>
              <span class="badge bg-primary">IoT</span>
            </div>
          </div>
        </div>

        <!-- Popular Articles -->
        <div class="card shadow-sm mb-4">
          <div class="card-body">
            <h5 class="card-title mb-4">Popular in Technology</h5>
            
            <div class="d-flex mb-3">
              <div class="flex-shrink-0">
                <span class="fw-bold text-primary me-2">1</span>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mt-0 mb-1">How Blockchain is Changing Finance</h6>
                <p class="mb-0 small text-muted">4.2K views · 312 likes</p>
              </div>
            </div>
            
            <div class="d-flex mb-3">
              <div class="flex-shrink-0">
                <span class="fw-bold text-primary me-2">2</span>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mt-0 mb-1">The Rise of Quantum Computing</h6>
                <p class="mb-0 small text-muted">3.8K views · 298 likes</p>
              </div>
            </div>
            
            <div class="d-flex mb-3">
              <div class="flex-shrink-0">
                <span class="fw-bold text-primary me-2">3</span>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mt-0 mb-1">5G Technology: What to Expect</h6>
                <p class="mb-0 small text-muted">3.5K views · 264 likes</p>
              </div>
            </div>
            
            <div class="d-flex">
              <div class="flex-shrink-0">
                <span class="fw-bold text-primary me-2">4</span>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mt-0 mb-1">The Future of Autonomous Vehicles</h6>
                <p class="mb-0 small text-muted">3.1K views · 237 likes</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Newsletter -->
        <div class="card shadow-sm">
          <div class="card-body text-center">
            <i class="fas fa-envelope-open-text display-4 text-primary mb-3"></i>
            <h5>Tech Newsletter</h5>
            <p class="text-muted">Get the latest technology news and insights delivered to your inbox weekly.</p>
            <div class="input-group mb-3">
              <input type="email" class="form-control" placeholder="Your email address">
              <button class="btn btn-primary" type="button">Subscribe</button>
            </div>
            <p class="small text-muted">No spam. Unsubscribe anytime.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

 <footer>
    <?php 

        require_once("partials/footer.php");
    
    ?>
 </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


  <script>
let limit = 5;
let offset = 0;
    function loadBlogs(){
        let urlParams = new URLSearchParams(window.location.search);
        let category_id = urlParams.get("category_id");
        let blogsContainer = document.getElementById("blogsContainer");
        let formdata = new FormData();
        formdata.append("controller","BlogController");
        formdata.append("action","findByCategory");
        formdata.append("category_id",category_id);
        formdata.append("offset",offset);
        formdata.append("limit",limit);

        let xhr = new XMLHttpRequest();

        xhr.onreadystatechange = ()=>{

            if(xhr.readyState ==4 && xhr.status ==200){

                let response = JSON.parse(xhr.responseText);

                if(response && response.status=="success"){

                    response.blogs.forEach(blog => {

                        blogsContainer.innerHTML += `       
                                  
          <div class="col-12">
            <div class="card blog-card shadow-sm h-100">
              <div class="row g-0">
                <div class="col-md-4">
                  <img src="public/${blog.featured_image}" class="blog-card-img w-100 h-100" alt="AI Technology">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <span class="badge category-badge text-white mb-2">${blog.category}</span>

                    <a href="single-post.php?id=${blog.id}" style="text-decoration:none; color:black;"><h3 class="card-title h5">${blog.title}</h3></a>
                    
                    <p class="card-text text-muted">Exploring how AI is transforming industries and what to expect in the coming years as machine learning algorithms become more sophisticated.</p>
                  
                    <div class="d-flex align-items-center mt-3">
                      <img src="public/${blog.author_image}" class="author-img rounded-circle me-2" alt="Author">
                      <div class="flex-grow-1">
                      <a href="author.php?user_id=${blog.user_id}" style="text-decoration:none; color:black">
                      <p class="mb-0 fw-semibold">${blog.author}</p>
                      </a>
                      <p class="mb-0 small text-muted">May 15, 2023 · 8 min read</p>
                      </div>
                      <div class="text-muted">
                        <i class="fas fa-eye me-2"></i> 2.4K
                        <i class="fas fa-heart ms-3 me-2"></i> 184
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
                        
                        
                        `;
                        
                    });

                }else{
                    document.getElementById("loadMore").style.display = "none"
                }

            }
        }
        xhr.open("POST","./handler/handler.php",true);
        xhr.send(formdata);


    }
    loadBlogs();

    function loadMore(){
        offset +=limit;
        loadBlogs()
    }
  </script>
</body>
</html>