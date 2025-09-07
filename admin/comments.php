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
    <a href="index.php">📊 Dashboard</a>
    <a href="users.php" >👥 Manage Users</a>
    <a href="blogs.php">📝 Manage Blogs</a>
    <a href="comments.php" class="active">💬 Comments</a>
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
   
    <!-- Comments -->
    <div id="comments" class="section">
      <div class="card p-4">
        <h4 class="mb-3">Manage Comments</h4>
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Comment</th>
              <th>User</th>
              <th>Blog</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Great article!</td>
              <td>Mike</td>
              <td>How to Learn PHP</td>
              <td>
                <button class="btn btn-sm btn-success">Approve</button>
                <button class="btn btn-sm btn-danger">Delete</button>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>Needs more details.</td>
              <td>Sara</td>
              <td>Top 10 CSS Tricks</td>
              <td>
                <button class="btn btn-sm btn-success">Approve</button>
                <button class="btn btn-sm btn-danger">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    
        </div>
    
</body>
</html>
