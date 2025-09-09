<?php
require_once(__DIR__ . "/../middlewares/Admin.php");

if (!checkAdmin()) {
  die("Unauthorized Access!");
}
require_once(__DIR__ . "/../controllers/CategoriesController.php");

$categories = (new CategoriesController())->findAll(0, 50)["categories"];

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

    .btn-outline-secondary {
      color: var(--secondary);
      border-color: var(--secondary);
    }

    .btn-outline-secondary:hover {
      background-color: var(--secondary);
      color: white;
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

    .badge-pending {
      background-color: rgba(13, 110, 253, 0.15);
      color: #0d6efd;
    }

    .pagination .page-link {
      color: var(--primary);
    }

    .pagination .page-item.active .page-link {
      background-color: var(--primary);
      border-color: var(--primary);
    }

    .page-item.disabled .page-link {
      color: var(--secondary);
    }

    .search-form {
      background-color: var(--light);
      border-radius: 12px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center mb-4">Draftly Admin</h4>
    <a href="index.php"><i class="fas fa-chart-bar me-2"></i> Dashboard</a>
    <a href="users.php"><i class="fas fa-users me-2"></i> Manage Users</a>
    <a href="blogs.php" class="active"><i class="fas fa-blog me-2"></i> Manage Blogs</a>
    <a href="categories.php"><i class="fas fa-tags me-2"></i> Manage Categories</a>
    <a href="comments.php"><i class="fas fa-comments me-2"></i> Comments</a>
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
        
        <!-- Search Form -->
        <div class="search-form">
          <form id="searchForm">
            <div class="row g-3">
              <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Search blogs..." name="query">
              </div>
              <div class="col-md-3">
                <select name="category_id" id="category" class="form-select">
                  <option value="0">All Categories</option>
                  <?php if ($categories):
                    foreach ($categories as $category):
                  ?>
                      <option value="<?= $category["id"] ?>"><?= htmlspecialchars($category["name"]) ?></option>
                  <?php endforeach;
                  endif; ?>
                </select>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                  <i class="fas fa-search me-1"></i> Search
                </button>
              </div>
              <div class="col-md-1">
                <a href="./blogs.php" class="btn btn-secondary">Reset</a>
              </div>
            </div>
          </form>
        </div>
        
        <div id="message"></div>
        
        <!-- Blogs Table -->
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Author</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="blogs_container"></tbody>
          </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
          <nav aria-label="Blog pagination">
            <ul class="pagination">
              <li class="page-item">
                <button id="previous" class="page-link" onclick="previous()">
                  <i class="fas fa-chevron-left me-1"></i> Previous
                </button>
              </li>
              <li class="page-item">
                <button id="next" class="page-link" onclick="next()">
                  Next <i class="fas fa-chevron-right ms-1"></i>
                </button>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <script>
    async function request(url, data) {
      try {
        const response = await fetch(url, {
          method: "POST",
          body: data
        });

        const raw = await response.text();

        if (!response.ok) {
          throw new Error(`HTTP ${response.status}`);
        }

        try {
          return JSON.parse(raw);
        } catch {
          return raw;
        }

      } catch (e) {
        console.error("Request Error:", e.message);
        return null;
      }
    }

    function showMessage(type, message) {
      let message_container = document.getElementById("message");
      message_container.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
          ${message}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `;
      setTimeout(() => {
        message_container.innerHTML = "";
      }, 3000);
    }

    let offset = 0;
    let limit = 8;
    let total = 0;
    let blogs_container = document.getElementById("blogs_container");
    let searchForm = document.getElementById("searchForm");
    let query = "";
    let category_id = 0;

    function searchBlogs() {
      let urlParams = new URLSearchParams(window.location.search);
      query = urlParams.get("query") || "";
      category_id = urlParams.get("category_id") || 0;
      loadBlogs();
    }

    async function loadBlogs() {
      let urlParams = new URLSearchParams(window.location.search);

      if (urlParams.has("query")) {
        query = urlParams.get("query");
        document.querySelector('input[name="query"]').value = query;
      }
      if (urlParams.has("category_id")) {
        category_id = urlParams.get("category_id");
        document.querySelector('select[name="category_id"]').value = category_id;
      }

      let formdata = new FormData();
      formdata.append("controller", "BlogController");
      formdata.append("action", "findAll");
      formdata.append("query", query);
      formdata.append("category_id", category_id);
      formdata.append("offset", offset);

      let response = await request("./handler.php", formdata);

      if (!response) {
        showMessage("danger", "Something Went Wrong!");
        return;
      }

      if (response.status && response.status == "success") {
        blogs_container.innerHTML = "";
        let blogs = response.blogs;
        total = response.total;

        if (blogs.length === 0) {
          blogs_container.innerHTML = `
            <tr>
              <td colspan="6" class="text-center text-muted py-4">
                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                No blogs found
              </td>
            </tr>`;
          return;
        }

        blogs.forEach(blog => {
          let statusClass = "badge-draft";
          if (blog.status === "published") statusClass = "badge-published";
          if (blog.status === "pending") statusClass = "badge-pending";

          blogs_container.innerHTML += `           
            <tr>
              <td>${blog.id}</td>
              <td>${blog.title}</td>
              <td>${blog.category}</td>
              <td>${blog.author}</td>
              <td>
                <span class="badge rounded-pill ${statusClass}">
                  ${blog.status}
                </span>
              </td>
              <td>
                <div class="btn-group" role="group">
                  <a class="btn btn-sm btn-outline-primary" href="../single-post.php?id=${blog.id}" title="View">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a class="btn btn-sm btn-outline-warning" href="./edit-blog.php?blog_id=${blog.id}" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <button class="btn btn-sm btn-outline-danger" onclick="deleteBlog(${blog.id})" title="Delete">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          `;
        });

        document.getElementById("next").disabled = (offset + limit) >= total;
        document.getElementById("previous").disabled = offset == 0;

      } else if (response.status && response.status == "error") {
        blogs_container.innerHTML = `
          <tr>
            <td colspan="6" class="text-center text-muted py-4">
              <i class="fas fa-exclamation-triangle fa-2x mb-2 d-block"></i>
              ${response.message}
            </td>
          </tr>`;
      } else {
        showMessage("danger", "Something Went Wrong!");
      }
    }

    async function deleteBlog(id) {
      if (!confirm("Are you sure you want to delete this blog?")) {
        return;
      }

      let formdata = new FormData();
      formdata.append("controller", "BlogController");
      formdata.append("action", "delete");
      formdata.append("blog_id", id);

      let response = await request("./handler.php", formdata);

      if (!response) {
        showMessage("danger", "Something Went Wrong!");
        return;
      }
      if (response.status && response.status == "success") {
        showMessage("success", response.message);
        loadBlogs();
      } else if (response.status && response.status == "error") {
        showMessage("danger", response.message);
      } else {
        showMessage("danger", "Something Went Wrong!");
      }
    }

    function next() {
      if ((offset + limit) < total) {
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

    searchForm.addEventListener("submit", (e) => {
      e.preventDefault();
      let formData = new FormData(searchForm);
      let query = formData.get("query") || "";
      let category_id = formData.get("category_id") || 0;

      let urlParams = new URLSearchParams(window.location.search);
      urlParams.set("query", query);
      urlParams.set("category_id", category_id);

      window.history.pushState({}, "", "?" + urlParams.toString());
      searchBlogs();
    });

    // Initial load
    loadBlogs();
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>