<?php
require_once(__DIR__ ."/../middlewares/Admin.php");
require_once(__DIR__ ."/../controllers/BlogController.php");
require_once(__DIR__ ."/../controllers/CommentsController.php");
require_once(__DIR__ ."/../controllers/UserController.php");

$total_blogs = ((new BlogController())->count())??0;
$total_users = (new UserController());

if(!checkAdmin()){
  die("Unauthorized Access");
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
      transition: transform 0.2s;
    }

    .card:hover {
      transform: translateY(-5px);
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

    h4, h5, h6 {
      color: var(--text-primary);
      font-weight: 600;
    }

    .navbar-brand {
      color: var(--text-primary) !important;
      font-weight: 600;
    }

    .stat-card {
      border-left: 4px solid var(--primary);
    }

    .stat-card h5 {
      color: var(--secondary);
      font-size: 0.9rem;
      margin-bottom: 0.5rem;
    }

    .stat-card .display-6 {
      color: var(--primary);
      font-weight: 700;
    }

    .list-group-item {
      border: none;
      border-left: 3px solid transparent;
      transition: all 0.2s;
    }

    .list-group-item:hover {
      border-left-color: var(--primary);
      background-color: var(--light);
    }

    .text-muted {
      color: var(--text-secondary) !important;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center mb-4">Draftly Admin</h4>
    <a href="index.php" class="active"><i class="fas fa-chart-bar me-2"></i> Dashboard</a>
    <a href="users.php"><i class="fas fa-users me-2"></i> Manage Users</a>
    <a href="blogs.php"><i class="fas fa-blog me-2"></i> Manage Blogs</a>
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
        <button class="btn btn-outline-danger btn-sm"><i class="fas fa-sign-out-alt me-1"></i> Logout</button>
      </div>
    </nav>

    <!-- Dashboard -->
    <div id="dashboard" class="section">
      <div class="row g-4 mb-4">
        <div class="col-md-3">
          <div class="card p-3 stat-card">
            <h5><i class="fas fa-users me-1"></i> Users</h5>
            <p class="display-6">120</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3 stat-card">
            <h5><i class="fas fa-blog me-1"></i> Blogs</h5>
            <p class="display-6"><?=$total_blogs?></p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3 stat-card">
            <h5><i class="fas fa-comments me-1"></i> Comments</h5>
            <p class="display-6">1.2k</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3 stat-card">
            <h5><i class="fas fa-envelope me-1"></i> Messages</h5>
            <p class="display-6">35</p>
          </div>
        </div>
      </div>

      <!-- Latest Blogs -->
      <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4><i class="fas fa-blog me-2"></i> Latest Blogs</h4>
          <a href="blogs.php" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i> Add New Blog</a>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
              <h6 class="mb-1">Understanding PHP OOP Concepts</h6>
              <small class="text-muted">2 days ago</small>
            </div>
            <small class="text-muted">by John Doe</small>
            <p class="mb-1 mt-2">An introductory guide to PHP OOP concepts with examples...</p>
          </li>
          <li class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
              <h6 class="mb-1">Bootstrap 5 Tips for Responsive Design</h6>
              <small class="text-muted">4 days ago</small>
            </div>
            <small class="text-muted">by Jane Smith</small>
            <p class="mb-1 mt-2">Some lesser-known tricks to make Bootstrap responsive design easier...</p>
          </li>
          <li class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
              <h6 class="mb-1">How to Secure Your PHP Application</h6>
              <small class="text-muted">1 week ago</small>
            </div>
            <small class="text-muted">by Admin</small>
            <p class="mb-1 mt-2">Best practices to avoid SQL injection, XSS, and other vulnerabilities...</p>
          </li>
        </ul>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>