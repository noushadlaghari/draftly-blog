<?php
require_once(__DIR__ . "/../middlewares/Admin.php");
require_once(__DIR__ . "/../controllers/BlogController.php");
require_once(__DIR__ . "/../controllers/CategoriesController.php");

if(!checkAdmin()){
    die("Unauthorized Access!");
}

// Check if user is admin

// In a real application, you would fetch the blog data from the database
// For this example, we'll use placeholder data
$blog_id = isset($_GET['blog_id']) ? intval($_GET['blog_id']) : 0;

$blog = (new BlogController())->findById($blog_id);


// Fetch categories (in a real app, this would come from the database)
$categories = (new CategoriesController())->findAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog - Draftly Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            height: 100vh;
            background: #343a40;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            width: 230px;
            padding-top: 20px;
        }

        .sidebar a {
            color: #adb5bd;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #495057;
            color: #fff;
            border-radius: 5px;
        }

        .content {
            margin-left: 240px;
            padding: 20px;
        }

        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
        }

        .table th {
            background: #f1f3f5;
        }

        .btn-sm {
            border-radius: 20px;
            padding: 3px 12px;
        }

        .navbar {
            margin-left: 240px;
        }

        .featured-image {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .form-control:focus,
        .form-select:focus,
        .form-check-input:focus {
            border-color: #6f42c1;
            box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25);
        }

        .form-check-input:checked {
            background-color: #6f42c1;
            border-color: #6f42c1;
        }

        .btn-primary {
            background-color: #6f42c1;
            border-color: #6f42c1;
        }

        .btn-primary:hover {
            background-color: #5a32a3;
            border-color: #5a32a3;
        }

        .section-title {
            border-bottom: 2px solid #6f42c1;
            padding-bottom: 10px;
            margin-bottom: 20px;
            color: #2e3a59;
        }
        .error{
            color:red;
            
        }

     #content {
      height: 70vh;
      margin-bottom: 1.5rem;
      border-radius: 10px;
      border: 1px solid #e2e8f0;
    }
           
    .ql-editor {
      font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
      font-size: 16px;
      line-height: 1.6;
      color: var(--text-primary);
    }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center mb-4">Draftly Admin</h4>
        <a href="index.php">📊 Dashboard</a>
        <a href="users.php">👥 Manage Users</a>
        <a href="blogs.php" class="active">📝 Manage Blogs</a>
        <a href="comments.php">💬 Comments</a>
        <a href="contact.php">📨 Contact Messages</a>
        <a href="profile.php">⚙️ My Profile</a>
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Navbar -->
        <nav class="navbar navbar-light bg-white shadow-sm mb-4 rounded">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h5">Welcome, Admin</span>
                <a href="../logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        </nav>

        <!-- Back Button -->
        <div class="mb-4">
            <a href="blogs.php" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Blogs
            </a>
        </div>

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Edit Blog</h2>
            <div>
                <button type="submit" form="form" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Blog
                </button>
            </div>
        </div>

        <form id="form" enctype="multipart/form-data">

            <input type="hidden" name="blog_id" value="<?= $blog['id'] ?>">

            <div class="row">
                <!-- Left Column - Content -->
                <div class="col-md-8">
                    <div class="card p-4 mb-4">
                        <div id="message"></div>
                        <h4 class="section-title">Blog Content</h4>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($blog['title']) ?>">
                            <div id="title_error" class="error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>

                            <div id="content"><?= $blog['content'] ?></div>
                            <div id="content_error" class="error"></div>

                        </div>
                    </div>
                </div>

                <!-- Right Column - Settings -->
                <div class="col-md-4">
                    <div class="card p-4 mb-4">
                        <h4 class="section-title">Blog Settings</h4>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $blog['category_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div id="category_error" class="error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="draft" <?= $blog['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="pending" <?= $blog['status'] == 'pending' ? 'selected' : '' ?>>Pending Review</option>
                                <option value="published" <?= $blog['status'] == 'published' ? 'selected' : '' ?>>Published</option>
                            </select>
                        </div>

                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" <?= $blog['featured'] == "on" ? 'checked' : '' ?>>
                            <label class="form-check-label" for="featured">Feature this blog</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Author</label>
                            <p class="form-control-static"><?= htmlspecialchars($blog['author']) ?></p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date Posted</label>
                            <p class="form-control-static"><?= htmlspecialchars($blog['created_at']) ?></p>
                        </div>
                    </div>

                    <div class="card p-4">
                        <h4 class="section-title">Featured Image</h4>

                        <div class="mb-3 text-center">
                            <img src="./../public/<?= $blog['featured_image'] ?>" class="featured-image mb-3" alt="Featured Image">
                        </div>


                        <div class="mb-3">
                            <label for="featured_image" class="form-label">Change Featured Image</label>
                            <input class="form-control" type="file" id="featured_image" name="featured_image" accept="image/*">
                            <div id="featured_img_error" class="error"></div>

                        </div>


                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
      // Initialize Quill editor
    const quill = new Quill('#content', {
      theme: 'snow',
      modules: {
        toolbar: [
          [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ 'color': [] }, { 'background': [] }],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          [{ 'indent': '-1'}, { 'indent': '+1' }],
          [{ 'align': [] }],
          ['link'],
          ['clean']
        ]
      },
      placeholder: 'Write your amazing blog content here...'
    });
    
    
    
    </script>
    <script>
        // Image preview functionality
        document.getElementById('featured_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Create or update image preview
                    let preview = document.querySelector('.featured-image');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.className = 'featured-image mb-3';
                        document.querySelector('.card .text-center').appendChild(preview);
                    }
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);

            }
        });
    </script>


    <script>
        let form = document.getElementById("form");
        let message = document.getElementById("message");
        let title_error = document.getElementById("title_error");
        let content_error = document.getElementById("content_error");
        let featured_img_error = document.getElementById("featured_img_error");
        let category_error = document.getElementById("category_error");

        form.addEventListener("submit", (e) => {
            e.preventDefault();

            let formdata = new FormData(form);
            formdata.append("content", quill.root.innerHTML);
            formdata.append("controller", "BlogController");
            formdata.append("action", "update");


            let xhr = new XMLHttpRequest();

            xhr.onreadystatechange = () => {
                if (xhr.readyState == 4 && xhr.status == 200) {

                    let response = JSON.parse(xhr.responseText);

                    if (response && response.status) {

                        if (response.status == "success") {

                            message.innerHTML = `
                            
                                    <div class="alert alert-success" role="alert">
                                        ${response.message}
                                        </div>
                            
                            `;

                        } else if (response.status == "error" && response.errors) {

                            let errors = response.errors;
                            title_error.innerText = errors.title || "";
                            content_error.innerText = errors.content || "";
                            category_error.innerText = errors.category || "";
                            featured_img_error.innerText = errors.featured_image || "";


                        } else if (response.status == "error" && response.message) {
                            message.innerHTML = `
                            
                                    <div class="alert alert-danger" role="alert">
                                        ${response.message}
                                        </div>
                            
                            `;
                            
                        }
                        
                    }else{
                        message.innerHTML = `
                        
                                <div class="alert alert-danger" role="alert">
                                    Unknown Error!
                                    </div>
                        
                        `;

                    }

                    setTimeout(()=>{
                        message.innerHTML = "";
                    },3000)
                }
            }

            xhr.open("POST", "./handler.php", true);
            xhr.send(formdata);

        })
    </script>
</body>

</html>