<?php
require_once(__DIR__ . "/../middlewares/Admin.php");
require_once(__DIR__ . "/../controllers/UserController.php");

if (!checkAdmin()) {
  die("Unauthorized Access!");
}

$id = $_SESSION["id"];

$user = (new UserController())->findById($id);


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

    h4 {
      color: var(--text-primary);
      font-weight: 600;
    }

    .navbar-brand {
      color: var(--text-primary) !important;
      font-weight: 600;
    }

    .profile-picture {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid white;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: white;
      padding: 2rem;
      border-radius: 12px 12px 0 0;
      margin: -1.5rem -1.5rem 2rem -1.5rem;
    }

    .stat-card {
      border-left: 4px solid var(--primary);
      transition: transform 0.2s;
    }

    .stat-card:hover {
      transform: translateY(-2px);
    }

    .stat-number {
      color: var(--primary);
      font-weight: 700;
      font-size: 1.5rem;
    }

    .stat-label {
      color: var(--text-secondary);
      font-size: 0.875rem;
    }

    .info-item {
      border-bottom: 1px solid #eee;
      padding: 1rem 0;
    }

    .info-item:last-child {
      border-bottom: none;
    }

    .info-label {
      color: var(--text-secondary);
      font-weight: 500;
      margin-bottom: 0.25rem;
    }

    .info-value {
      color: var(--text-primary);
      font-weight: 600;
    }

    .badge-status {
      background-color: rgba(40, 167, 69, 0.15);
      color: #28a745;
      padding: 0.35rem 0.65rem;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
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
    <a href="categories.php"><i class="fas fa-tags me-2"></i> Manage Categories</a>
    <a href="comments.php"><i class="fas fa-comments me-2"></i> Comments</a>
    <a href="contact.php"><i class="fas fa-envelope me-2"></i> Contact Messages</a>
    <a href="profile.php" class="active"><i class="fas fa-user-circle me-2"></i> My Profile</a>
  </div>

  <!-- Content -->
  <div class="content">
    <!-- Navbar -->
    <nav class="navbar navbar-light shadow-sm mb-4 rounded">
      <div class="container-fluid">
        <span class="navbar-brand mb-0 h5">Welcome, Admin</span>
        <a class="btn btn-outline-danger btn-sm" href="./../logout.php">Logout</a>
      </div>
    </nav>

    <!-- Profile -->
    <div id="profile" class="section">
      <div class="card p-0 overflow-hidden">
        <!-- Profile Header -->
        <div class="profile-header text-center">
          <div class="position-relative">
            <div class="profile-picture-container mx-auto">
              <img src="./../public/<?=$user["profile_image"]?>" class="profile-picture" alt="Admin Profile">
            </div>
            <span class="badge-status position-absolute top-0 end-0 mt-2 me-2">
              <i class="fas fa-shield-alt me-1"></i><?=$user["role"]?>
            </span>
          </div>
          <h3 class="mt-3 mb-1"><?=$user["name"]?></h3>
          <p class="mb-0 opacity-75"><?=$user["email"]?></p>
        </div>

        <div class="p-4">
          <!-- Statistics Cards -->
          <div class="row g-4 mb-5">
            <div class="col-md-3">
              <div class="card stat-card p-3">
                <div class="stat-number">1,248</div>
                <div class="stat-label"><i class="fas fa-eye me-1"></i>Total Views</div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card stat-card p-3">
                <div class="stat-number">156</div>
                <div class="stat-label"><i class="fas fa-file-alt me-1"></i>Blog Posts</div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card stat-card p-3">
                <div class="stat-number">2,847</div>
                <div class="stat-label"><i class="fas fa-comments me-1"></i>Comments</div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card stat-card p-3">
                <div class="stat-number">98%</div>
                <div class="stat-label"><i class="fas fa-chart-line me-1"></i>Engagement</div>
              </div>
            </div>
          </div>

          <!-- Profile Information -->
          <div class="row">
            <div class="col-lg-6">
              <h5 class="mb-4"><i class="fas fa-info-circle me-2"></i>Personal Information</h5>
              <div class="info-item">
                <div class="info-label">Full Name</div>
                <div class="info-value"><?=$user["name"]?></div>
              </div>
              <div class="info-item">
                <div class="info-label">Email Address</div>
                <div class="info-value"><?=$user["email"]?></div>
              </div>
              <div class="info-item">
                <div class="info-label">Username</div>
                <div class="info-value"><?=$user["username"]?></div>
              </div>
              <div class="info-item">
                <div class="info-label">Member Since</div>
                <div class="info-value"><?=$user["created_at"]?></div>
              </div>
            </div>

            <div class="col-lg-6">
              <h5 class="mb-4"><i class="fas fa-cog me-2"></i>Account Settings</h5>
              <div class="info-item">
                <div class="info-label">Account Status</div>
                <div class="info-value">
                  <span class="badge-status"><?=$user["status"]?></span>
                </div>
              </div>
              <div class="info-item">
                <div class="info-label">Email Verification</div>
                <div class="info-value">
                  <span class="badge-status"><?=$user["email_verified"]?"Verified":"Not Verified"?></span>
                </div>
              </div>
              <div class="info-item">
                <div class="info-label">Two-Factor Authentication</div>
                <div class="info-value">
                  <span class="badge-status"><?=$user["email_verified"]?"Verified":"Not Verified"?></span>
                </div>
              </div>
              <div class="info-item">
                <div class="info-label">Last Login</div>
                <div class="info-value"><?=$user["last_login"]?></div>
              </div>
            </div>
          </div>


          <!-- Quick Actions -->
          <div class="mt-5 pt-4 border-top">
            <h5 class="mb-4"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            <div class="d-flex gap-2 flex-wrap">
              <a class="btn btn-outline-warning" href="./edit-user.php?user_id=<?=$user["id"]?>">
                <i class="fas fa-gear me-2"></i>Settings
  </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>