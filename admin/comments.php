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

    .btn-success {
      background-color: #28a745;
      border-color: #28a745;
    }

    .btn-success:hover {
      background-color: #218838;
      border-color: #1e7e34;
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

    .comment-content {
      max-width: 300px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
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
        <button class="btn btn-outline-danger btn-sm">Logout</button>
      </div>
    </nav>

    <!-- Comments -->
    <div id="comments" class="section">
      <div class="card p-4">
        <div id="message"></div>
        <h4 class="mb-3"><i class="fas fa-comments me-2"></i>Manage Comments</h4>
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Comment</th>
              <th>User</th>
              <th>Blog</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="comments_container"></tbody>
        </table>
        <nav aria-label="Comments pagination" class="d-flex justify-content-center">
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

  <script src="./js/define.js"></script>
  <script>

    let offset = 0;
    let limit = 8;
    let total = 0;
    
    async function loadComments() {
      const formdata = new FormData();
      formdata.append("controller", "CommentsController");
      formdata.append("action", "findAll");
      formdata.append("offset", offset);

      const response = await request("./handler.php", formdata);

      if (response.status && response.status == "success") {
        total = response.total;
        let comments_container = document.getElementById("comments_container");
        comments_container.innerHTML = "";

        response.comments.forEach(comment => {
          comments_container.innerHTML += `
            <tr>
              <td>${comment.id}</td>
              <td class="comment-content" title="${comment.content}">${comment.content}</td>
              <td>${comment.author}</td>
              <td>${comment.blog_title}</td>
              <td>
                <span class="badge bg-${comment.status === 'approved' ? 'success' : 'warning'}">
                  ${comment.status}
                </span>
              </td>
              <td>
                ${comment.status != "approved" ? 
                  `<button class="btn btn-sm btn-success me-1" onclick="approveComment(${comment.id})">
                    <i class="fas fa-check me-1"></i>Approve
                  </button>` : 
                  ``
                }
                <button class="btn btn-sm btn-danger" onclick="deleteComment(${comment.id})">
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

    loadComments();

    async function deleteComment(id) {
      if (!confirm("Are you sure you want to delete this comment?")) {
        return;
      }
      
      let formdata = new FormData();
      formdata.append("controller", "CommentsController");
      formdata.append("action", "delete");
      formdata.append("comment_id", id);

      let response = await request("./handler.php", formdata);

      if (!response) {
        showMessage("danger", "Something went wrong!");
        return;
      }

      if (response.status && response.status == "success") {
        showMessage("success", response.message);
        setTimeout(() => {
          loadComments();
        }, 3000);
      } else if (response.status && response.status == "error") {
        showMessage("danger", response.message);
      } else {
        showMessage("danger", "Something went wrong!");
      }
    }

    async function approveComment(id) {
      let formdata = new FormData();
      formdata.append("controller", "CommentsController");
      formdata.append("action", "approve");
      formdata.append("comment_id", id);

      let response = await request("./handler.php", formdata);

      if (!response) {
        showMessage("danger", "Something went wrong!");
        return;
      }

      if (response.status && response.status == "success") {
        showMessage("success", response.message);
        setTimeout(() => {
          loadComments();
        }, 3000);
      } else if (response.status && response.status == "error") {
        showMessage("danger", response.message);
      } else {
        showMessage("danger", "Something went wrong!");
      }
    }

    function previous() {
      if (offset - limit >= 0) {
        offset -= limit;
        loadComments();
      }
    }

    function next() {
      if (offset + limit < total) {
        offset += limit;
        loadComments();
      }
    }

    function updatePagination() {
      document.querySelector(".pagination .prev button").disabled = (offset === 0);
      document.querySelector(".pagination .next button").disabled = (offset + limit >= total);
    }

  </script>
</body>

</html>