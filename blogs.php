<?php
require_once("./controllers/CategoriesController.php");
require_once("./middlewares/Auth.php");
$categories = (new CategoriesController())->findAll()["categories"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Draftly - Blog Archive</title>
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
    }

    .page-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border-radius: 15px;
      padding: 3rem 2rem;
      margin-bottom: 2rem;
      color: white;
      box-shadow: 0 5px 20px rgba(111, 66, 193, 0.2);
    }

    .search-section {
      background: white;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
      border: none;
      margin-bottom: 2rem;
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

    .input-group-text {
      background: transparent;
      border-radius: 10px 0 0 10px;
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

    .btn-outline-primary {
      color: var(--primary);
      border-color: var(--primary);
      border-radius: 10px;
      padding: 12px 20px;
      font-weight: 600;
      transition: all 0.3s;
    }

    .btn-outline-primary:hover {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border-color: var(--primary);
      transform: translateY(-2px);
      color: white;
    }

    .card {
      border: none;
      border-radius: 15px;
      overflow: hidden;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      height: 100%;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }

    .card-img-top {
      height: 220px;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .card:hover .card-img-top {
      transform: scale(1.05);
    }

    .card-title {
      font-weight: 700;
      font-size: 1.2rem;
      color: var(--dark);
      margin-bottom: 0.8rem;
    }

    .card-text {
      color: var(--secondary);
      line-height: 1.6;
    }

    .read-more-link {
      color: var(--primary);
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s;
    }

    .read-more-link:hover {
      color: var(--primary-dark);
      letter-spacing: 0.5px;
    }

    .no-results {
      padding: 4rem 1rem;
    }

    .no-results i {
      font-size: 4rem;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 1.5rem;
    }

    .pagination {
      margin-top: 3rem;
    }

    .page-link {
      border-radius: 8px;
      margin: 0 5px;
      border: 1px solid #e2e8f0;
      color: var(--primary);
      font-weight: 500;
      transition: all 0.3s;
    }

    .page-link:hover {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: white;
      border-color: var(--primary);
      transform: translateY(-2px);
    }

    .page-item.active .page-link {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border-color: var(--primary);
    }

    .page-item.disabled .page-link {
      color: #6c757d;
    }

    .alert-info {
      background: rgba(28, 200, 138, 0.15);
      border: 1px solid rgba(28, 200, 138, 0.3);
      color: var(--dark);
      border-radius: 10px;
    }

    @media (max-width: 768px) {
      .search-section {
        padding: 1.5rem;
      }

      .card {
        margin-bottom: 1.5rem;
      }

      .btn-primary,
      .btn-outline-primary {
        padding: 10px 15px;
      }

      .page-header {
        padding: 2rem 1rem;
      }
    }
  </style>
</head>

<body class="bg-light">
  <header>
    <?php require_once("././partials/header.php"); ?>
  </header>

  <div class="container mt-5">
    <!-- Page Header -->
    <div class="page-header">
      <div class="row">
        <div class="col-12 text-center">
          <h1 class="display-5 fw-bold mb-3">Blog Archive</h1>
          <p class="lead mb-0">Discover our collection of insightful articles</p>
        </div>
      </div>
    </div>

    <!-- Search & Filter -->
    <div class="search-section p-4">
      <form method="GET" id="search_form">
        <div class="row g-3 align-items-end">
          <div class="col-md-6">
            <label for="search" class="form-label fw-semibold">Search blogs</label>
            <div class="input-group shadow-sm">
              <span class="input-group-text bg-transparent">
                <i class="fas fa-search text-muted"></i>
              </span>
              <input type="text" class="form-control" id="query" name="query" value="<?= $query ?? "" ?>" placeholder="Type to search...">
            </div>
          </div>
          <div class="col-md-4">
            <label for="category_id" class="form-label fw-semibold">Category</label>
            <select class="form-select shadow-sm" id="category_id" name="category_id">
              <option value="0">All Categories</option>
              <?php if (!empty($categories)) : ?>
                <?php foreach ($categories as $category) : ?>
                  <option value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>
          <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-primary w-100" type="submit" id="submit_search">
              Search
            </button>
            <a class="btn btn-outline-primary w-100" href="blogs.php">
              Clear
            </a>
          </div>
        </div>
      </form>
    </div>


    <!-- Blog List -->
    <div class="row g-4 mb-5" id="blogsContainer"></div>

    <div id="loader" style="display:none; text-align:center; margin:20px 0;">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <div id="scrollSentinel"></div>

  </div>

  <footer>
    <?php require_once("././partials/footer.php"); ?>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


  <script>
    let limit = 8;
    let offset = 0;
    let category_id = 0;
    let query = "";
    let blogsContainer = document.getElementById("blogsContainer");
    let sentinel = document.getElementById("scrollSentinel");
    let observer; // declare on top so it's always defined
    let loader = document.getElementById("loader");
    let timer;

    function loadBlogs() {


      if (observer) observer.unobserve(sentinel);


      let urlParams = new URLSearchParams(window.location.search);

      if (urlParams.has("query")) {
        query = urlParams.get("query");
      }

      if (urlParams.has("category_id")) {
        category_id = urlParams.get("category_id");
      }



      document.getElementById("query").value = query;
      document.getElementById("category_id").value = category_id;

      let formdata = new FormData();
      formdata.append("controller", "BlogController");
      formdata.append("action", "findAll");
      formdata.append("offset", offset);
      formdata.append("limit", limit);
      formdata.append("query", query);
      formdata.append("category_id", category_id);

      let xhr = new XMLHttpRequest();

      xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
          loader.style.display = "none";
          let response = JSON.parse(xhr.responseText);

       
          if (response.status == "success") {
            response.blogs.forEach(blog => {
              blogsContainer.innerHTML += `
                                <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <img src="public/${blog.featured_image}" class="card-img-top" alt="Blog">
                                          <span class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1 m-3 rounded-pill small">${blog.category}</span>
                                        <div class="card-body">
                                            <h5 class="card-title">${blog.title}</h5>
                                            <p class="card-text">${stripTags(blog.content).substring(0,150)}...</p>
                                            <a href="single-post.php?id=${blog.id}" class="read-more-link d-inline-flex align-items-center">
                                                Read more <i class="fas fa-arrow-right ms-2 small"></i>
                                            </a>
                                        </div>
                                        <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">
                                            <small class="text-muted"><i class="fas fa-clock me-1"></i> ${new Date(blog.created_at).toLocaleDateString()}</small>
                                            <small class="text-muted"><i class="fas fa-eye me-1"></i>${blog.views_count}</small>
                                        </div>
                                    </div>
                                </div>
                            `;
            });

            // Increment offset
            offset += limit;

            // re-observe after blogs are added
            if (observer) observer.observe(sentinel);

          } else {
            if (blogsContainer.innerHTML.trim() === "") {
              blogsContainer.innerHTML = `
                                <div class="col-12">
                                    <div class="no-results text-center py-5 my-5">
                                        <i class="fas fa-search"></i>
                                        <h3 class="text-muted mt-3">No results found</h3>
                                        <p class="text-muted">Try different search terms or browse all posts</p>
                                        <a href="blogs.php" class="btn btn-primary mt-3">
                                            Browse All Posts
                                        </a>
                                    </div>
                                </div>
                            `;

            } else {
              let child = document.createElement("div");
              child.innerHTML = "No More Blogs!";
              child.style.textAlign = "center";
              child.style.marginBlock = "30px";
              blogsContainer.appendChild(child);
            }
            if (observer) observer.disconnect(); // stop infinite scroll
            loader.style.display = "none"; // hide loader AFTER blogs appended
          }
        }
      };

      xhr.open("POST", "./handler/handler.php", true);
      xhr.send(formdata);
    }


    // IntersectionObserver with pause + loader
    observer = new IntersectionObserver((entries) => {
      if (entries[0].isIntersecting) {
        clearTimeout(timer);

        loader.style.display = "block"; // show loader immediately

        timer = setTimeout(() => {
          loadBlogs();
        }, 300); // 1 second pause
      }
    }, {
      threshold: 1.0
    });

    observer.observe(sentinel);

    loadBlogs();

    function loadMore() {
      offset += limit;
      loadBlogs();
    }

    let search_form = document.getElementById("search_form");

    search_form.addEventListener("submit", (e) => {
      e.preventDefault();
      let urlParams = new URLSearchParams(window.location.search);
      query = document.getElementById("query").value;
      category_id = document.getElementById("category_id").value;
      offset = 0;
      urlParams.set("query", query);
      urlParams.set("category_id", category_id);

      history.pushState({}, "", "?" + urlParams.toString());

      blogsContainer.innerHTML = "";

      if (observer) observer.observe(sentinel); // re-enable observer

      loadBlogs();
    });



function stripTags(html) {
  let div = document.createElement("div");
  div.innerHTML = html;
  return div.textContent || div.innerText || "";
}

</script>
</body>

</html>