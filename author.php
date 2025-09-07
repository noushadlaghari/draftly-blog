<?php
require_once("./controllers/UserController.php");
require_once("./controllers/BlogController.php");


if (isset($_GET["user_id"])) {
    $user_id = $_GET["user_id"];
    $user = (new UserController())->findById($user_id);
    if (!$user) {

        header("location: not-found.php");
    }

    $blogs = (new BlogController())->findByUserId($user_id);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author Profile - Draftly</title>
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

        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--dark);
        }

        .author-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }

        .author-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .social-icon {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 50%;
            transition: all 0.3s;
        }

        .social-icon:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-3px);
        }

        .stat-box {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }

        .stat-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .blog-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            height: 100%;
        }

        .blog-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .blog-img {
            height: 200px;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .blog-card:hover .blog-img {
            transform: scale(1.05);
        }

        .category-badge {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(111, 66, 193, 0.4);
        }

        .follow-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .follow-btn:hover {
            background: white;
            color: var(--primary);
        }
    </style>
</head>

<body>

    <header>
        <?php
        require_once("./partials/header.php");
        ?>
    </header>

    <!-- Header Section -->
    <header class="author-header">
        <div class="container">

            <div class="d-flex align-items-center justify-content-center">
                <img src="public/<?= $user["profile_image"] ?>"
                    alt="Author" class="author-img me-4">
                <div>
                    <h1 class="fw-bold mb-1"><?= $user["name"] ?></h1>
                    <p class="mb-2"><?= $user["bio"] ?></p>
                    <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i> <?= $user["address"] ?? "Pakistan" ?></p>
                    <p class="mb-2">Total Articles: 24</p>
                    <p class="mb-2">Joined: <?=$user["created_at"]?></p>
                </div>

            </div>


        </div>
    </header>

    <!-- Main Content -->
    <div class="container mb-5">
        <div class="row">
            <!-- Main Content - Author's Blogs -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Articles by <?= $user["name"] ?></h3>
                <div>
                    <select class="form-select form-select-sm w-auto d-inline-block">
                        <option>Newest First</option>
                        <option>Most Popular</option>
                        <option>Oldest First</option>
                    </select>
                </div>
            </div>

            <div class="row g-4">

                <?php

                if (!empty($blogs)) {
                    foreach ($blogs as $blog) {
                ?>

                        <div class="col-md-4">
                            <div class="blog-card card">
                                <div class="position-relative">
                                    <img src="public/<?= $blog["featured_image"] ?>"
                                        class="blog-img card-img-top" alt="Blog Image">
                                    <span class="category-badge position-absolute top-0 start-0 m-3"><?= $blog["category"] ?></span>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold"><?= $blog["title"] ?></h5>
                                    <p class="card-text text-muted">Exploring the latest features and updates in React and how they will shape frontend development.</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <small class="text-muted"><i class="far fa-clock me-1"></i> <?= round(str_word_count($blog["content"]) / 150) ?> min read</small>
                                        <small class="text-muted"><?= $blog["created_at"] ?></small>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-0 pt-0">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span class="text-muted small"><i class="far fa-eye me-1"></i> <?= $blog["views_count"] ?></span>
                                            <span class="text-muted small ms-3"><i class="far fa-comment me-1"></i> 24</span>
                                        </div>
                                        <a href="single-post.php?id=<?= $blog["id"] ?>" class="text-primary text-decoration-none">Read More <i class="fas fa-arrow-right ms-1 small"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                <?php }
                } ?>

            </div>


        </div>
    </div>

    <footer>
        <?php

        require_once("./partials/footer.php");

        ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>