<?php
require_once(__DIR__ . "/controllers/BlogController.php");

if (isset($_GET["id"])) {
  $controller = new BlogController();
  $blog = $controller->findById($_GET["id"])["blog"];

  if (empty($blog)) {
    header("location: not-found.php");
    exit;
  }

  $cookieName = "viewed_blog_" . $blog["id"];

  if (!isset($_COOKIE[$cookieName])) {
    $controller->addView($blog["id"]);
    setcookie($cookieName, "1", time() + 86400, "/");
  }

  $related = $controller->findByCategory(["category_id" => $blog["category_id"], "limit" => 6, "offset" => 0]);
} else {
  header("location: not-found.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $blog["title"] ?> - Draftly</title>
  <meta name="description" content="<?= substr(strip_tags($blog["content"]), 0, 160) ?>">
  <link rel="icon" type="image/png" href="./assets/images/favicon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

    /* Typography improvements */
    h1 {
      font-size: 2.8rem;
      font-weight: 800;
      line-height: 1.2;
      margin-bottom: 1.5rem;
      color: var(--dark);
    }

    h2 {
      font-size: 2rem;
      font-weight: 700;
      margin-top: 2.5rem;
      margin-bottom: 1rem;
      color: var(--dark);
    }

    h3 {
      font-size: 1.5rem;
      font-weight: 600;
      margin-top: 2rem;
      margin-bottom: 0.8rem;
      color: var(--dark);
    }

    h4 {
      font-size: 1.25rem;
      font-weight: 600;
      margin-top: 1.8rem;
      margin-bottom: 0.7rem;
      color: var(--dark);
    }

    p {
      margin-bottom: 1.5rem;
      font-size: 1.1rem;
    }

    /* Blog content styling */
    .blog-content {
      font-size: 1.1rem;
      line-height: 1.8;
    }

    .blog-content img {
      max-width: 100%;
      height: auto;
      border-radius: 12px;
      margin: 2rem 0;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .blog-content p {
      margin-bottom: 1.8rem;
    }

    .blog-content blockquote {
      border-left: 4px solid var(--primary);
      padding-left: 1.5rem;
      margin: 2rem 0;
      font-style: italic;
      color: var(--text-secondary);
    }

    .blog-content ul,
    .blog-content ol {
      margin-bottom: 1.8rem;
      padding-left: 1.5rem;
    }

    .blog-content li {
      margin-bottom: 0.2rem;
    }

    /* Header styling */
    .blog-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: white !important;
      text-align: center;
      padding: 4rem 0;
      margin-bottom: 3rem;
    }

    .blog-header h1 {
      color: white;
    }

    .blog-meta {
      font-size: 1rem;
      opacity: 0.9;
      margin-top: 1rem;
    }

    .blog-meta a {
      text-decoration: none;
      color: white;
    }

    .blog-meta i {
      margin-right: 0.5rem;
    }

    /* Comments section */
    .comment-box {
      margin-top: 3rem;
      padding-top: 2rem;
      border-top: 1px solid #e2e8f0;
    }

    .comment {
      background: white;
      padding: 1.5rem;
      border-radius: 12px;
      margin-bottom: 1.5rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      border-left: 3px solid var(--primary);
    }

    .comment strong {
      color: var(--primary-dark);
      font-size: 1.05rem;
    }

    /* Form styling */
    #form textarea {
      border-radius: 12px;
      padding: 1rem;
      font-size: 1rem;
      border: 1px solid #e2e8f0;
      transition: all 0.3s;
    }

    #form textarea:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.15);
    }



    /* Related blogs */
    .related-blogs {
      margin-top: 4rem;
      padding-top: 3rem;
      border-top: 1px solid #e2e8f0;
    }

    .related-blogs .card {
      border: none;
      border-radius: 12px;
      overflow: hidden;
      transition: all 0.3s;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .related-blogs .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .related-blogs img {
      margin: 0;
      height: 200px;
      object-fit: cover;
    }

    .related-blogs .card-title {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }

    .related-blogs .btn {
      border-radius: 20px;
      padding: 0.5rem 1.2rem;
    }

    /* Message styling */
    #message {
      font-weight: 500;
      margin: 1rem 0;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      h1 {
        font-size: 2.2rem;
      }

      h2 {
        font-size: 1.7rem;
      }

      h3 {
        font-size: 1.3rem;
      }

      .blog-content {
        font-size: 1rem;
      }

      .blog-header {
        padding: 2.5rem 0;
      }
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

    .btn-outline-primary {
      color: var(--primary);
      border: 1px solid var(--primary);
    }

    .btn-outline-primary:hover {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border: 1px solid var(--primary);
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

    require_once("./partials/header.php")
    ?>
  </header>

  <!-- Blog Header -->
  <div class="blog-header">
    <div class="container">
      <h1 id="blog-title"><?= $blog["title"] ?></h1>
      <div class="blog-meta">
        
        <span><i class="fas fa-user"></i> By <a href="author.php?user_id=<?= $blog["user_id"] ?>"><strong><?= $blog["username"] ?></strong></a></span> •
        <span><i class="fas fa-calendar"></i> <?= date('F j, Y', strtotime($blog["created_at"])) ?></span> •  
        
          <span id="views-count"><i class="fas fa-eye"></i><?= $blog["views_count"] ?> views</span> •  
        <span><i class="fas fa-clock"></i> <?= max(1, round(str_word_count($blog["content"]) / 120)) ?> min read
        </span>
      </div>
    </div>
  </div>

  <!-- Blog Content -->
  <div class="container blog-content">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <img src="public/<?= htmlspecialchars($blog["featured_image"]) ?>" class="img-fluid" alt="<?= $blog["title"] ?>">
        <div id="blog-content"><?= $blog["content"] ?></div>



        <!-- Comments Section -->
        <div class="comment-box" id="comment-box">
          <h3><i class="fas fa-comments me-2"></i>Comments</h3>

          <!-- Existing Comments will be loaded here -->
        </div>

        <!-- Add Comment Form -->
        <div class="mt-4">
          <h4><i class="fas fa-edit me-2"></i>Add a Comment</h4>
          <form id="form">
            <div class="mb-3">
              <textarea class="form-control" rows="4" name="comment" placeholder="Share your thoughts..."></textarea>
            </div>
            <input type="hidden" name="blog_id" value="<?= $_GET["id"] ?>">
            <div id="message" class="text-success"></div>
            <button type="submit" id="submit-comment" class="btn btn-primary">
              <i class="fas fa-paper-plane me-2"></i>Post Comment
            </button>
          </form>
        </div>

        <!-- Related Blogs -->
        <div class="related-blogs">
          <h3><i class="fas fa-newspaper me-2"></i>You Might Also Like</h3>
          <div class="row mt-4">

            <?php
            if ($related && $related["status"] == "success") {
              foreach ($related["blogs"] as $related_blog) {

            ?>
                <div class="col-md-4 mb-4">
                  <div class="card h-100">
                    <img src="public/<?= $related_blog["featured_image"] ?>" class="card-img-top" alt="">
                    <div class="card-body">
                      <h5 class="card-title"><?= $related_blog["title"] ?></h5>
                      <p class="card-text text-muted small"><?= substr(strip_tags($related_blog["content"]), 0, 150) ?>...</p>
                      <a href="single-post.php?id=<?= $related_blog["id"] ?>" class="btn btn-outline-primary btn-sm">Read More</a>
                    </div>
                  </div>
                </div>

            <?php }
            } ?>

          </div>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <?php

    require_once("./partials/footer.php");

    ?>
  </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


  <script>
    function loadComments() {
      let commentBox = document.getElementById("comment-box");
      let urlparams = new URLSearchParams(window.location.search);
      let blog_id = urlparams.get("id");

      let formdata = new FormData();
      formdata.append("controller", "CommentsController");
      formdata.append("action", "findAll");
      formdata.append("blog_id", blog_id);

      let xhr = new XMLHttpRequest();

      xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
          let response = JSON.parse(xhr.responseText);

          if (response && response.length > 0) {
            let commentsHTML = '';
            response.forEach(comment => {
              commentsHTML += `
              <div class="comment">
                <strong>${comment.author}:</strong> 
                <p class="mb-0 mt-1">${comment.content}</p>
                <small class="text-muted">${new Date(comment.created_at).toLocaleDateString()}</small>
              </div>
              `;
            });
            commentBox.innerHTML += commentsHTML;
          } else {
            commentBox.innerHTML += `<p class="text-muted">No comments yet. Be the first to share your thoughts!</p>`;
          }
        }
      }

      xhr.open("POST", "./handler/handler.php", true);
      xhr.send(formdata);
    }

    // Load comments when page loads
    document.addEventListener('DOMContentLoaded', function() {
      loadComments();

      // Add comment form submission
      let form = document.getElementById("form");
      let message = document.getElementById("message");

      form.addEventListener("submit", function(e) {
        e.preventDefault();

        let formdata = new FormData(form);
        formdata.append("action", "create");
        formdata.append("controller", "CommentsController");

        let xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            let response = JSON.parse(xhr.responseText);

            if (response && response.status == "success") {
              message.innerHTML = `<i class="fas fa-check-circle me-1"></i> ${response.message}`;
              form.reset();
              // Reload comments
              let commentBox = document.getElementById("comment-box");
              commentBox.querySelectorAll('.comment').forEach(el => el.remove());
              loadComments();

              setTimeout(() => {
                message.innerHTML = "";
              }, 3000);
            }
          }
        };

        xhr.open("POST", "./handler/handler.php", true);
        xhr.send(formdata);
      });
    });
  </script>

</body>

</html>