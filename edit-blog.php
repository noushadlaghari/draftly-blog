<?php
require_once("./middlewares/auth.php");
require_once("./controllers/CategoriesController.php");
require_once("./controllers/BlogController.php");

$categogies_controller = new CategoriesController();
$categories = $categogies_controller->getAll();

$id = $_GET["id"] ?? null;
$blog = (new BlogController())->findById($id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Blog - Draftly</title>
    <link rel="icon" type="image/png" href="./assets/images/favicon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
  <style>
    :root {
      --primary: #6f42c1;
      --primary-dark: #5a32a3;
      --light-bg: #f8f9fa;
    }
    
    body {
      background-color: var(--light-bg);
    }
    
    .card {
      border-radius: 12px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
      border: none;
      overflow: hidden;
    }
    
    .card-header {
      background: linear-gradient(120deg, var(--primary), var(--primary-dark));
      color: white;
      border-bottom: none;
      padding: 1.5rem;
    }
    
    .btn-primary {
      background: linear-gradient(120deg, var(--primary), var(--primary-dark));
      border: none;
      padding: 10px 24px;
      font-weight: 600;
      transition: all 0.3s;
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(111, 66, 193, 0.3);
    }
    
    .form-control, .form-select {
      border-radius: 8px;
      padding: 12px 16px;
      border: 1px solid #e2e8f0;
      transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
      box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.15);
      border-color: var(--primary);
    }
    
    .error {
      color: #e53e3e;
      font-size: 0.875rem;
      margin-top: 5px;
      display: block;
    }
    
    #img_preview {
      transition: all 0.3s;
    }
    
    #img_preview img {
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.3s;
    }
    
    #img_preview img:hover {
      transform: scale(1.02);
    }
    
    .ql-toolbar.ql-snow {
      border-radius: 8px 8px 0 0;
      border: 1px solid #e2e8f0;
    }
    
    .ql-container.ql-snow {
      border-radius: 0 0 8px 8px;
      border: 1px solid #e2e8f0;
      min-height: 250px;
    }
    
    .page-title {
      color: var(--primary);
      font-weight: 700;
      margin-bottom: 0.5rem;
    }
    
    .page-subtitle {
      color: #718096;
      margin-bottom: 2rem;
    }
    
    @media (max-width: 768px) {
      .container {
        width: 95% !important;
      }
    }
  </style>
</head>

<body>
  <header>
    <?php require_once("././partials/header.php"); ?>
  </header>

  <!-- Edit Blog Form -->
  <div class="container my-5 w-75">
    <div class="text-center mb-4">
      <h1 class="page-title"><i class="fas fa-edit me-2"></i>Edit Blog Post</h1>
      <p class="page-subtitle">Update your content and share your ideas with the world</p>
    </div>
    
    <div class="card">
      <div class="card-header text-center">
        <h3 class="mb-0"><i class="fas fa-pencil-alt me-2"></i>Blog Details</h3>
      </div>
      <div class="card-body p-4">
        <div id="message"></div>
        <form id="form" enctype="multipart/form-data">
          <div class="mb-4">
            <label for="title" class="form-label fw-semibold">Blog Title</label>
            <div class="input-group">
              <span class="input-group-text bg-transparent"><i class="fas fa-heading text-primary"></i></span>
              <input type="text" class="form-control" name="title" id="title" placeholder="Enter an engaging title" value="<?= $blog["title"] ?? "" ?>">
            </div>
            <div id="title_error" class="error"></div>
          </div>

          <div class="mb-4">
            <label for="category" class="form-label fw-semibold">Category</label>
            <div class="input-group">
              <span class="input-group-text bg-transparent"><i class="fas fa-tag text-primary"></i></span>
              <select class="form-select" name="category" id="category">
                <option selected disabled>Select a category</option>
                <?php
                if ($categories) {
                  foreach ($categories as $category) {
                ?>
                <option value="<?= $category['id'] ?>" <?= $category["id"] == $blog["category_id"] ? "selected" : "" ?>>
                  <?= $category['name'] ?>
                </option>
                <?php
                  }
                }
                ?>
              </select>
            </div>
            <div id="category_error" class="error"></div>
          </div>

          <div class="mb-4">
            <label for="content" class="form-label fw-semibold">Blog Content</label>
            <div id="content"><?= $blog["content"] ?? "" ?></div>
            <div id="content_error" class="error"></div>
          </div>


            <!-- Blog Excerpt -->
          <div class="mb-4">
            <h4 class="section-title">
              <i class="fas fa-file-lines"></i>
              Excerpt(80-200 chars)
            </h4>
            <input type="text" class="form-control form-control-lg" min="80" max="200" name="excerpt" placeholder="Short Description 80 - 200 characters">
            <div class="error" id="excerpt_error"></div>
          </div>



          <div class="mb-4">
            <label for="image" class="form-label fw-semibold">Featured Image</label>
            <div class="input-group">
              <span class="input-group-text bg-transparent"><i class="fas fa-image text-primary"></i></span>
              <input type="file" name="featured_image" class="form-control" id="image">
              <div id="img_error" class="error"></div>
            </div>
            <div id="img_preview" class="mt-3 text-center">
              <p class="text-muted small mb-2">Current featured image</p>
              <img src="public/<?= $blog["featured_image"] ?>" alt="Featured image" height="150" width="150" class="img-thumbnail">
              <p class="text-muted small mt-2">Upload a new image to replace this one</p>
            </div>
          </div>

          <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <a href="javascript:history.back()" class="btn btn-outline-secondary me-md-2">
              <i class="fas fa-arrow-left me-1"></i> Go Back
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save me-1"></i> Update Blog
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <footer>
    <?php require_once('./partials/footer.php'); ?>
  </footer>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

  <script>
    const quill = new Quill('#content', {
      theme: 'snow',
      modules: {
        toolbar: [
          [{ 'header': [1, 2, 3, false] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          ['link', 'image', 'blockquote', 'code-block'],
          [{ 'color': [] }, { 'background': [] }],
          ['clean']
        ]
      },
      placeholder: 'Write your amazing content here...'
    });

    let form = document.getElementById("form");
    let img = document.getElementById("image");
    let img_preview = document.getElementById("img_preview");
    
    img.addEventListener("change", (e) => {
      if (e.target.files && e.target.files[0]) {
        let src = URL.createObjectURL(e.target.files[0]);
        img_preview.innerHTML = `
          <p class="text-muted small mb-2">New image preview</p>
          <img src="${src}" height="150" width="150" class="img-thumbnail">
          <p class="text-muted small mt-2">This will replace your current image</p>
        `;
      }
    });

    form.addEventListener("submit", (e) => {
      e.preventDefault();

      let title_error = document.getElementById("title_error");
      let category_error = document.getElementById("category_error");
      let content_error = document.getElementById("content_error");
      let excerpt_error = document.getElementById("excerpt_error");
      let img_error = document.getElementById("img_error");
      let message = document.getElementById("message");

      let urlParams = new URLSearchParams(window.location.search);
      let id = urlParams.get("id");

      let formdata = new FormData(form);
      formdata.append("controller", "BlogController");
      formdata.append("action", "update");
      formdata.append("id", id);
      formdata.append("content", quill.root.innerHTML);
      
      let xhr = new XMLHttpRequest();

      xhr.onreadystatechange = () => {
        if (xhr.status == 200 && xhr.readyState == 4) {
          let response = JSON.parse(xhr.responseText);

          if (response.status == "error") {
            let errors = response.errors;

            title_error.innerHTML = errors.title || "";
            category_error.innerHTML = errors.category || "";
            content_error.innerHTML = errors.content || "";
            excerpt_error.innerHTML = errors.excerpt || "";
            img_error.innerHTML = errors.featured_image || "";

            if (errors.db) {
              message.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <i class="fas fa-exclamation-circle me-2"></i> ${errors.db}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
            } else {
              message.innerHTML = "";
            }
          } else if (response.status == "success") {
           title_error.innerHTML = "";
            category_error.innerHTML = "";
            content_error.innerHTML = "";
            img_error.innerHTML = "";

            message.innerHTML = `
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> ${response.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>`;
              
            // Scroll to message
            message.scrollIntoView({ behavior: 'smooth' });
          } else {
            message.innerHTML = `      
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> Unknown error occurred!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>`;
          }
        }
      }

      xhr.open("POST", "./handler/handler.php", true);
      xhr.send(formdata);
    });
  </script>
</body>
</html>