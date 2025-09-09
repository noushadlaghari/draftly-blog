<?php
require_once(__DIR__ . "/../middlewares/Admin.php");

if (!checkAdmin()) {
  die("Unauthorized access!");
}
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

    .btn-warning {
      background-color: #ffc107;
      border-color: #ffc107;
      color: #000;
    }

    .btn-warning:hover {
      background-color: #e0a800;
      border-color: #d39e00;
      color: #000;
    }

    .btn-danger {
      background-color: #dc3545;
      border-color: #dc3545;
    }

    .btn-danger:hover {
      background-color: #c82333;
      border-color: #bd2130;
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

    .page-link {
      color: var(--primary);
    }

    .page-item.active .page-link {
      background-color: var(--primary);
      border-color: var(--primary);
    }

    .page-item.disabled .page-link {
      color: var(--secondary);
    }

    .modal-header {
      background-color: var(--light);
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .modal-title {
      color: var(--text-primary);
      font-weight: 600;
    }

    .badge-count {
      background-color: var(--primary);
      color: white;
      border-radius: 10px;
      padding: 0.25rem 0.5rem;
      font-size: 0.75rem;
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
    <a href="categories.php" class="active"><i class="fas fa-tags me-2"></i> Manage Categories</a>
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
        <button class="btn btn-outline-danger btn-sm">Logout</button>
      </div>
    </nav>

    <!-- Categories -->
    <div id="categories" class="section">
      <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4><i class="fas fa-tags me-2"></i>Manage Categories</h4>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="fas fa-plus me-2"></i>Add New Category
          </button>
        </div>
        
        <div id="message"></div>
        
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Total Blogs</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="categories_container"></tbody>
        </table>
        
        <nav aria-label="Categories pagination" class="d-flex justify-content-center">
          <ul class="pagination">
            <li class="page-item prev">
              <button class="page-link" onclick="previous()">
                <i class="fas fa-chevron-left me-1"></i>Previous
              </button>
            </li>
            <li class="page-item next">
              <button class="page-link" onclick="next()">
                Next<i class="fas fa-chevron-right ms-1"></i>
              </button>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>

  <!-- Update Modal -->
  <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content"></div>
    </div>
  </div>

  <!-- Add Category Modal -->
  <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="add_message"></div>
          <form id="addCategoryForm">
            <div class="mb-3">
              <label for="categoryName" class="form-label">Category Name</label>
              <input type="text" class="form-control" id="categoryName" name="category_name" required>
            </div>
            <div class="mb-3">
              <label for="categorySlug" class="form-label">Category Slug</label>
              <input type="text" class="form-control" id="categorySlug" name="category_slug" required>
              <div class="form-text">URL-friendly version of the name (e.g., "web-development")</div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="addCategory()">Add Category</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="./js/define.js"></script>
<script>


    let offset = 0;
    let limit = 8;
    let total = 0;

    async function loadCategories() {
      const formdata = new FormData();
      formdata.append("controller", "CategoriesController");
      formdata.append("action", "findAll");
      formdata.append("offset", offset);

      const response = await request("./handler.php", formdata);

      if (response.status && response.status == "success") {
        total = response.total;
        let categories_container = document.getElementById("categories_container");
        categories_container.innerHTML = "";

        response.categories.forEach(category => {
          categories_container.innerHTML += `
            <tr>
              <td>${category.id}</td>
              <td>${category.name}</td>
              <td>
                <span class="badge-count">${category.total_blogs}</span>
              </td>
              <td>
                <button class="btn btn-sm btn-warning me-2" onclick="showUpdateModal(${category.id})">
                  <i class="fas fa-edit me-1"></i>Edit
                </button>
                <button class="btn btn-sm btn-danger" onclick="deleteCategory(${category.id})">
                  <i class="fas fa-trash me-1"></i>Delete
                </button>
              </td>
            </tr>
          `;
        });

        updatePagination();

      } else if (response.status && response.status == "error") {
        showMessage("danger", response.message);
      } else {
        showMessage("danger", "Something went wrong!");
      }
    }

    loadCategories();

    async function deleteCategory(id) {
      if (!confirm("Are you sure you want to delete this category? All associated blogs will be affected.")) {
        return;
      }

      let formdata = new FormData();
      formdata.append("controller", "CategoriesController");
      formdata.append("action", "delete");
      formdata.append("category_id", id);

      let response = await request("./handler.php", formdata);

      if (!response) {
        showMessage("danger", "Something went wrong!");
        return;
      }

      if (response.status && response.status == "success") {
        showMessage("success", response.message);
        setTimeout(() => {
          loadCategories();
        }, 3000);
      } else if (response.status && response.status == "error") {
        showMessage("danger", response.message);
      } else {
        showMessage("danger", "Something went wrong!");
      }
    }

    async function showUpdateModal(id) {
      let update_modal = new bootstrap.Modal(document.getElementById("updateModal"));
      let modal_content = document.querySelector(".modal-content");

      let formdata = new FormData();
      formdata.append("controller", "CategoriesController");
      formdata.append("action", "findById");
      formdata.append("category_id", id);

      let response = await request("./handler.php", formdata);

      if (response.status && response.status == "success") {
        let category = response.category;
        modal_content.innerHTML = `
          <div class="modal-header">
            <h5 class="modal-title">Edit Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div id="update_message"></div>
            <form id="update_form_${category.id}">
              <input type="hidden" name="category_id" value="${category.id}">
              <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="category_name" value="${category.name}" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Category Slug</label>
                <input type="text" name="category_slug" value="${category.slug}" class="form-control" required>
                <div class="form-text">URL-friendly version of the name</div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="updateCategory(${category.id})">Save Changes</button>
          </div>
        `;

        update_modal.show();
      }
    }

    async function updateCategory(id) {
      let update_form = document.getElementById("update_form_" + id);
      let update_message = document.getElementById("update_message");
      let formdata = new FormData(update_form);
      formdata.append("controller", "CategoriesController");
      formdata.append("action", "update");

      let response = await request("./handler.php", formdata);

      if (!response) {
        update_message.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Something Went Wrong!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        `;
        return;
      }

      if (response.status && response.status == "success") {
        update_message.innerHTML = `
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            ${response.message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        `;
        
        setTimeout(() => {
          let modal = bootstrap.Modal.getInstance(document.getElementById('updateModal'));
          modal.hide();
          loadCategories();
        }, 2000);
      } else if (response.status && response.status == "error") {
        update_message.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            ${response.message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        `;
      } else {
        update_message.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Something Went Wrong!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        `;
      }
    }

    async function addCategory() {
      let form = document.getElementById("addCategoryForm");
      let add_message = document.getElementById("add_message");
      let formdata = new FormData(form);
      formdata.append("controller", "CategoriesController");
      formdata.append("action", "create");

      let response = await request("./handler.php", formdata);

      if (!response) {
        add_message.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Something Went Wrong!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        `;
        return;
      }

      if (response.status && response.status == "success") {
        add_message.innerHTML = `
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            ${response.message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        `;
        
        form.reset();
        setTimeout(() => {
          let modal = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'));
          modal.hide();
          loadCategories();
        }, 2000);
      } else if (response.status && response.status == "error") {
        add_message.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            ${response.message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        `;
      } else {
        add_message.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Something Went Wrong!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        `;
      }
    }

    function previous() {
      if (offset - limit >= 0) {
        offset -= limit;
        loadCategories();
      }
    }

    function next() {
      if (offset + limit < total) {
        offset += limit;
        loadCategories();
      }
    }

    function updatePagination() {
      document.querySelector(".pagination .prev button").disabled = (offset === 0);
      document.querySelector(".pagination .next button").disabled = (offset + limit >= total);
    }

  </script>
</body>

</html>