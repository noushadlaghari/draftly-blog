<?php
require_once("./middlewares/auth.php");
require_once("./controllers/CategoriesController.php");

$categogies_controller = new CategoriesController();
$categories = $categogies_controller->findAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create New Blog - Draftly</title>
  <link rel="icon" type="image/png" href="./assets/images/favicon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
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

    .create-blog-card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      margin: 2rem 0;
    }

    .card-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: white;
      border-bottom: none;
      padding: 2rem;
      text-align: center;
    }

    .card-header h2 {
      font-weight: 800;
      margin: 0;
    }

    .card-body {
      padding: 2.5rem;
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

    .form-control-lg {
      padding: 1rem 1.2rem;
      font-size: 1.05rem;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border: none;
      border-radius: 10px;
      padding: 1rem 2.5rem;
      font-weight: 600;
      font-size: 1.1rem;
      transition: all 0.3s;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(111, 66, 193, 0.35);
    }

    .error {
      color: #e74c3c;
      font-size: 0.9rem;
      margin-top: 0.5rem;
      display: block;
    }

    .img-preview-container {
      border: 2px dashed #dee2e6;
      border-radius: 12px;
      padding: 2rem;
      text-align: center;
      margin-top: 1rem;
      transition: all 0.3s;
      background: var(--light);
    }

    .img-preview-container:hover {
      border-color: var(--primary);
    }

    .section-title {
      position: relative;
      padding-left: 2.5rem;
      margin-bottom: 1.5rem;
      color: var(--dark);
      font-weight: 600;
    }

    .section-title i {
      position: absolute;
      left: 0;
      top: 0.2rem;
      width: 30px;
      height: 30px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
    }

    #content {
      height: 70vh;
      margin-bottom: 1.5rem;
      border-radius: 10px;
      border: 1px solid #e2e8f0;
    }

    .ql-toolbar {
      border-radius: 10px 10px 0 0;
      border-color: #e2e8f0 !important;
    }

    .ql-container {
      border-radius: 0 0 10px 10px;
      border-color: #e2e8f0 !important;
      font-family: inherit;
    }

    .alert {
      border-radius: 10px;
      border: none;
      padding: 1rem 1.5rem;
    }

    .alert-success {
      background: rgba(28, 200, 138, 0.15);
      color: var(--dark);
      border-left: 4px solid var(--success);
    }

    .alert-danger {
      background: rgba(231, 76, 60, 0.15);
      color: var(--dark);
      border-left: 4px solid #e74c3c;
    }

    @media (max-width: 768px) {
      .container {
        width: 95% !important;
        padding: 0 1rem;
      }

      .card-body {
        padding: 1.5rem;
      }

      .card-header {
        padding: 1.5rem;
      }

      .section-title {
        padding-left: 2rem;
      }


    }

    .ql-editor {
      font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
      font-size: 16px;
      line-height: 1.6;
      color: var(--text-primary);
    }
  </style>
</head>

<body class="bg-light">

  <header>
    <?php require_once("././partials/header.php"); ?>
  </header>

  <!-- Create Blog Form -->
  <div class="container my-5 w-75">
    <div class="create-blog-card card">
      <div class="card-header">
        <h2 class="mb-0"><i class="fas fa-pen-fancy me-2"></i>Create New Blog</h2>
      </div>
      <div class="card-body">
        <div id="message"></div>
        <form id="form" enctype="multipart/form-data">
          <!-- Blog Title -->
          <div class="mb-4">
            <h4 class="section-title">
              <i class="fas fa-heading"></i>
              Blog Title
            </h4>
            <input type="text" class="form-control form-control-lg" name="title" id="title" placeholder="Enter a captivating title for your blog">
            <div class="error" id="title_error"></div>
          </div>

          <!-- Category Selection -->
          <div class="mb-4">
            <h4 class="section-title">
              <i class="fas fa-folder-open"></i>
              Category
            </h4>
            <select class="form-select form-select-lg" name="category" id="category">
              <option selected disabled>Select a category for your blog</option>
              <?php
              if ($categories) {
                foreach ($categories as $category) {
              ?>
                  <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
              <?php
                }
              }
              ?>
            </select>
            <div class="error" id="category_error"></div>
          </div>

          <!-- Blog Content -->
          <div class="mb-4">
            <h4 class="section-title">
              <i class="fas fa-edit"></i>
              Blog Content
            </h4>
            <div id="content"></div>
            <div class="error" id="content_error"></div>
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

          <!-- Featured Image -->
          <div class="mb-4">
            <h4 class="section-title">
              <i class="fas fa-image"></i>
              Featured Image
            </h4>
            <input type="file" name="featured_image" class="form-control form-control-lg" id="image" accept="image/*">
            <div class="error" id="image_error"></div>
            <div class="img-preview-container mt-3" id="img_preview">
              <i class="fas fa-cloud-upload-alt display-4 text-muted mb-2"></i>
              <p class="text-muted">Image preview will appear here</p>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary btn-lg py-3">
              <i class="fas fa-paper-plane me-2"></i>Publish Blog
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
    // Initialize Quill editor
    const quill = new Quill('#content', {
      theme: 'snow',
      modules: {
        toolbar: [
          [{
            'header': [1, 2, 3, 4, 5, 6, false]
          }],
          ['bold', 'italic', 'underline', 'strike'],
          [{
            'color': []
          }, {
            'background': []
          }],
          [{
            'list': 'ordered'
          }, {
            'list': 'bullet'
          }],
          [{
            'indent': '-1'
          }, {
            'indent': '+1'
          }],
          [{
            'align': []
          }],
          ['link'],
          ['clean']
        ]
      },
      placeholder: 'Write your amazing blog content here...'
    });

    // Image preview functionality
    let img = document.getElementById("image");
    let img_preview = document.getElementById("img_preview");

    img.addEventListener("change", (e) => {
      if (e.target.files && e.target.files[0]) {
        let reader = new FileReader();
        let src = URL.createObjectURL(e.target.files[0]);

        reader.onload = function(event) {
          img_preview.innerHTML = `
            <img src="${event.target.result}" class="img-fluid rounded" style="max-height: 200px;">
            <p class="mt-2 text-muted">Image Preview</p>
          `;
        }
        reader.readAsDataURL(e.target.files[0]);
      }
    });

    // Form submission handling
    let form = document.getElementById("form");

    form.addEventListener("submit", (e) => {
      e.preventDefault();

      // Reset error messages
      document.querySelectorAll('.error').forEach(el => el.innerHTML = '');

      let formdata = new FormData(form);
      formdata.append("controller", "BlogController");
      formdata.append("action", "create");
      formdata.append("content", quill.root.innerHTML);

      let xhr = new XMLHttpRequest();

      xhr.onreadystatechange = () => {
        if (xhr.status == 200 && xhr.readyState == 4) {
          let response = JSON.parse(xhr.responseText);

          if (response.status == "error") {
            let errors = response.errors;

            // Display field-specific errors
            if (errors.title) {
              document.getElementById('title_error').innerHTML = `<i class="fas fa-exclamation-circle me-1"></i> ${errors.title}`;
            }
            if (errors.category) {
              document.getElementById('category_error').innerHTML = `<i class="fas fa-exclamation-circle me-1"></i> ${errors.category}`;
            }
            if (errors.content) {
              document.getElementById('content_error').innerHTML = `<i class="fas fa-exclamation-circle me-1"></i> ${errors.content}`;
            }
            if (errors.excerpt) {
              document.getElementById('excerpt_error').innerHTML = `<i class="fas fa-exclamation-circle me-1"></i> ${errors.excerpt}`;
            }
            if (errors.featured_image) {
              document.getElementById('image_error').innerHTML = `<i class="fas fa-exclamation-circle me-1"></i> ${errors.featured_image}`;
            }

            // Display general error message
            if (errors.db) {
              message.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <i class="fas fa-exclamation-triangle me-2"></i> ${errors.db}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              `;
            }
            window.scrollTo({
              top: 0,
              behavior: 'smooth'
            });

          } else if (response.status == "success") {
            // Reset form on success
            form.reset();
            quill.setContents([]);
            img_preview.innerHTML = `
              <i class="fas fa-cloud-upload-alt display-4 text-muted mb-2"></i>
              <p class="text-muted">Image preview will appear here</p>
            `;

            // Show success message
            message.innerHTML = `
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> ${response.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            `;

            // Scroll to top to show message
            window.scrollTo({
              top: 0,
              behavior: 'smooth'
            });
          } else {
            // Show unknown error message
            message.innerHTML = `
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> An unknown error occurred!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            `;
          }
        }
      }

      xhr.open("POST", "./handler/handler.php", true);
      xhr.send(formdata);
    });
  </script>
</body>

</html>