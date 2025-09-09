<?php
require_once(__DIR__ . "/../middlewares/Admin.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Draftly Admin Panel</title>
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

    .sidebar {
      height: 100vh;
      background: var(--dark);
      color: #fff;
      position: fixed;
      top: 0;
      left: 0;
      width: 230px;
      padding-top: 20px;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
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
      background: var(--primary);
      color: #fff;
      border-radius: 5px;
    }

    .sidebar h4 {
      color: var(--light);
      font-weight: 600;
    }

    .content {
      margin-left: 240px;
      padding: 20px;
    }

    .card {
      border: none;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08);
      border-radius: 12px;
      background-color: white;
    }

    .table th {
      background: var(--light);
      color: var(--text-primary);
      font-weight: 600;
    }

    .btn-sm {
      border-radius: 20px;
      padding: 3px 12px;
      font-size: 0.875rem;
    }

    .navbar {
      margin-left: 240px;
      background-color: white;
    }

    .btn-primary {
      background-color: var(--primary);
      border-color: var(--primary);
    }

    .btn-primary:hover {
      background-color: var(--primary-dark);
      border-color: var(--primary-dark);
    }

    .btn-outline-danger {
      color: #dc3545;
      border-color: #dc3545;
    }

    .btn-outline-danger:hover {
      background-color: #dc3545;
      color: white;
    }

    .alert-success {
      background-color: rgba(40, 167, 69, 0.1);
      color: #28a745;
      border: none;
    }

    .alert-danger {
      background-color: rgba(220, 53, 69, 0.1);
      color: #dc3545;
      border: none;
    }

    h4 {
      color: var(--text-primary);
      font-weight: 600;
    }

    .navbar-brand {
      color: var(--text-primary) !important;
      font-weight: 600;
    }

    .badge-published {
      background-color: rgba(40, 167, 69, 0.15);
      color: #28a745;
    }

    .badge-draft {
      background-color: rgba(255, 193, 7, 0.15);
      color: #ffc107;
    }

    .pagination .page-link {
      color: var(--primary);
    }

    .pagination .page-item.active .page-link {
      background-color: var(--primary);
      border-color: var(--primary);
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center mb-4">Draftly Admin</h4>
    <a href="index.php"><i class="fas fa-chart-bar me-2"></i> Dashboard</a>
    <a href="users.php"><i class="fas fa-users me-2"></i> Manage Users</a>
    <a href="blogs.php"><i class="fas fa-blog me-2"></i> Manage Blogs</a>
    <a href="categories.php"><i class="fas fa-blog me-2"></i> Manage Categories</a>
    <a href="comments.php" class="active"><i class="fas fa-comments me-2"></i> Comments</a>
    <a href="contact.php"><i class="fas fa-envelope me-2"></i> Contact Messages</a>
    <a href="profile.php"><i class="fas fa-cog me-2"></i> My Profile</a>
  </div>


  <!-- Content -->
  <div class="content">
    <!-- Navbar -->
    <nav class="navbar navbar-light shadow-sm mb-4 rounded">
      <div class="container-fluid">
        <span class="navbar-brand mb-0 h5">Welcome, Admin</span>
        <a href="../logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
      </div>
    </nav>

    <!-- Manage Blogs -->
    <div id="blogs" class="section">
      <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4><i class="fas fa-blog me-2"></i> Manage Blogs</h4>
          <a class="btn btn-primary" href="./../add-new-blog.php"><i class="fas fa-plus me-1"></i> Add New Blog</a>
        </div>
        <div id="message"></div>
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Author</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="blogs_container"></tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
          <nav aria-label="Blog pagination">
            <ul class="pagination">
              <li class="page-item">
                <a href="#" class="page-link" onclick="previous(); return false;">
                  <i class="fas fa-chevron-left me-1"></i> Previous
                </a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#" onclick="next(); return false;">
                  Next <i class="fas fa-chevron-right ms-1"></i>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <script>
    let offset = 0;
    let limit = 6;
    let disable_next = false;
    let blogs_container = document.getElementById("blogs_container");
    let message = document.getElementById("message");

    function loadBlogs() {
      let formdata = new FormData();
      formdata.append("controller", "BlogController");
      formdata.append("action", "findAll");
      formdata.append("offset", offset);
      formdata.append("limit", limit);
      
      let xhr = new XMLHttpRequest();
      xhr.onreadystatechange = () => {
        if (xhr.status == 200 && xhr.readyState == 4) {
          let response = JSON.parse(xhr.responseText);
          
          if (response && response["status"] == "success") {
            blogs_container.innerHTML = "";
            let blogs = response.blogs;

            blogs.forEach(blog => {
              blogs_container.innerHTML += `           
                <tr>
                  <td>${blog.id}</td>
                  <td>${blog.title}</td>
                  <td>${blog.author}</td>
                  <td>
                    <span class="badge rounded-pill ${blog.status=="published" ? "badge-published" : "badge-draft"}">
                      ${blog.status}
                    </span>
                  </td>
                  <td>
                    <a class="btn btn-sm btn-outline-primary" href="../single-post.php?id=${blog.id}">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a class="btn btn-sm btn-outline-warning" href="./edit-blog.php?blog_id=${blog.id}">
                      <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteBlog(${blog.id})">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
              `;
            });
          } else {
            disable_next = true;
          }
        }
      }
      xhr.open("POST", "./handler.php", true);
      xhr.send(formdata);
    }

    loadBlogs();

    function deleteBlog(id) {
      if(!confirm("Are you sure you want to delete this blog?")) {
        return;
      }
      
      let formdata = new FormData();
      formdata.append("controller", "BlogController");
      formdata.append("action", "delete");
      formdata.append("blog_id", id);
      
      let xhr = new XMLHttpRequest();
      xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
          let response = JSON.parse(xhr.responseText);

          if (response && response.status == "success") {
            message.innerHTML = `
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                ${response.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            `;
            loadBlogs();
          } else {
            message.innerHTML = `
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${response.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            `;
          }

          setTimeout(() => {
            message.innerHTML = "";
          }, 3000);
        }
      }

      xhr.open("POST", "./handler.php", true);
      xhr.send(formdata);
    }

    function next() {
      if (!disable_next) {
        offset += limit;
        loadBlogs();
      }
    }

    function previous() {
      if (offset - limit >= 0) {
        offset -= limit;
        loadBlogs();
      }
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>