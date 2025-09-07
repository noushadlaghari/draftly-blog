  <?php
  require_once(__DIR__ ."/../middlewares/Admin.php");

  ?>
  <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Draftly Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
      box-shadow: 0 4px 6px rgba(0,0,0,0.08);
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
  </style>
</head>
<body>


  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center mb-4">Draftly Admin</h4>
    <a href="index.php" class="active">📊 Dashboard</a>
    <a href="users.php" >👥 Manage Users</a>
    <a href="blogs.php">📝 Manage Blogs</a>
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
        <button class="btn btn-outline-danger btn-sm">Logout</button>
      </div>
    </nav>

  <!-- Dashboard -->
    <div id="dashboard" class="section">
      <div class="row g-4 mb-4">
        <div class="col-md-3">
          <div class="card p-3 text-center">
            <h5>Users</h5>
            <p class="display-6">120</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3 text-center">
            <h5>Blogs</h5>
            <p class="display-6">450</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3 text-center">
            <h5>Comments</h5>
            <p class="display-6">1.2k</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3 text-center">
            <h5>Messages</h5>
            <p class="display-6">35</p>
          </div>
        </div>
      </div>

      <!-- Latest Blogs -->
      <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>🆕 Latest Blogs</h4>
          <button class="btn btn-primary btn-sm">➕ Add New Blog</button>
        </div>
        <ul class="list-group">
          <li class="list-group-item">
            <h6>Understanding PHP OOP Concepts</h6>
            <small class="text-muted">by John Doe • 2 days ago</small>
            <p class="mb-1">An introductory guide to PHP OOP concepts with examples...</p>
          </li>
          <li class="list-group-item">
            <h6>Bootstrap 5 Tips for Responsive Design</h6>
            <small class="text-muted">by Jane Smith • 4 days ago</small>
            <p class="mb-1">Some lesser-known tricks to make Bootstrap responsive design easier...</p>
          </li>
          <li class="list-group-item">
            <h6>How to Secure Your PHP Application</h6>
            <small class="text-muted">by Admin • 1 week ago</small>
            <p class="mb-1">Best practices to avoid SQL injection, XSS, and other vulnerabilities...</p>
          </li>
        </ul>
      </div>
    </div>

    </div>
    
</body>
</html>
