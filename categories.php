<?php
require_once(__DIR__ ."/middlewares/Auth.php");
require_once(__DIR__ ."/controllers/BlogController.php");
require_once(__DIR__ ."/controllers/CategoriesController.php");

$categories = (new CategoriesController())->findAll();
$blogs_by_category = [];

// Get 3 blogs for each category
foreach($categories as $category) {
    $blogs = (new BlogController())->findByCategory([
        "limit" => 3,
        "offset" => 0,
        "category_id" => $category['id']
    ]);
    
    if($blogs && isset($blogs['blogs'])) {
        $blogs_by_category[$category['id']] = $blogs['blogs'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draftly - Blog Categories</title>
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
        
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 15px;
            padding: 3rem 2rem;
            margin-bottom: 2rem;
            color: white;
            box-shadow: 0 5px 20px rgba(111, 66, 193, 0.2);
        }
        
        .category-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 2.5rem;
            overflow: hidden;
        }
        
        .category-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 1.5rem;
        }
        
        .post-card {
            overflow: hidden;
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            height: 100%;
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
            width: 40px!important;
            height: 40px!important;
            border-radius: 100%;
            object-fit: cover;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(111, 66, 193, 0.3);
        }
        
        .badge-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }
        
        .view-all-btn {
            color: var(--light);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s;
        }
        
        .view-all-btn:hover {
          
            letter-spacing: 0.5px;
        }
        
        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
            color: var(--secondary);
        }
        
        .empty-state i {
            font-size: 3.5rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<header>
    <?php require_once("././partials/header.php"); ?>
</header>

<div class="container mt-5">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-5 fw-bold mb-3">Blog Categories</h1>
                <p class="lead mb-0">Explore our diverse collection of articles organized by topics</p>
            </div>
        </div>
    </div>

    <!-- Categories with Blogs -->
    <?php if(!empty($categories)): ?>
        <?php foreach($categories as $category): ?>
            <div class="category-section">
                <!-- Category Header -->
                <div class="category-header d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1"><?= htmlspecialchars($category['name']) ?></h3>
                        <p class="mb-0"><?= $category['total_blogs'] ?> articles</p>
                    </div>
                    <a href="category.php?category_id=<?= $category['id'] ?>" class="view-all-btn">
                        View All <i class="fas fa-arrow-right ms-2 small"></i>
                    </a>
                </div>
                
                <!-- Blogs in this category -->
                <div class="p-4">
                    <?php if(isset($blogs_by_category[$category['id']]) && !empty($blogs_by_category[$category['id']])): ?>
                        <div class="row g-4">
                            <?php foreach($blogs_by_category[$category['id']] as $blog): ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="card post-card shadow-sm h-100">
                                        <div class="position-relative overflow-hidden">
                                            <img src="public/<?= $blog['featured_image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($blog['title']) ?>">
                                            <span class="position-absolute top-0 end-0 badge bg-primary m-3"><?= $blog['category'] ?></span>
                                        </div>
                                        <div class="card-body">
                                            <a href="single-post.php?id=<?= $blog['id'] ?>" style="text-decoration: none; color: inherit;">
                                                <h5 class="card-title fw-bold"><?= htmlspecialchars($blog['title']) ?></h5>
                                            </a>
                                            <p class="card-text text-muted"><?= substr(strip_tags($blog['content']), 0, 100) ?>...</p>
                                            <div class="d-flex align-items-center mt-3">
                                                <img src="public/<?= $blog['author_image'] ?>" class="author-img me-2" alt="Author">
                                                <div>
                                                    <p class="small mb-0 fw-bold"><?= $blog['author'] ?></p>
                                                    <p class="small text-muted mb-0"><?= $blog['created_at'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-file-alt"></i>
                            <h4>No articles yet</h4>
                            <p class="mb-0">Be the first to write in this category!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-folder-open"></i>
            <h4>No categories available</h4>
            <p class="mb-0">Check back later for organized content.</p>
        </div>
    <?php endif; ?>
</div>

<footer>
    <?php require_once("././partials/footer.php"); ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>