<?php
// users.php - Edit User Page
require_once(__DIR__ . "/../middlewares/Auth.php");
require_once(__DIR__ . "/../middlewares/Admin.php");
require_once(__DIR__ . "/../controllers/UserController.php");

if (isset($_GET["user_id"])) {
    $user_id = $_GET["user_id"];
    $user = (new UserController())->findById($user_id);

    if (!$user) {
        die("User Not Found!");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Draftly Admin</title>
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

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            margin-left: 240px;
            background-color: white;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25);
        }

        .section-title {
            border-bottom: 2px solid var(--primary);
            padding-bottom: 10px;
            margin-bottom: 20px;
            color: var(--text-primary);
            font-weight: 600;
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

        h2, h4 {
            color: var(--text-primary);
            font-weight: 600;
        }

        .navbar-brand {
            color: var(--text-primary) !important;
            font-weight: 600;
        }

        .form-check-input:checked {
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
                <button class="btn btn-outline-danger btn-sm">Logout</button>
            </div>
        </nav>

        <!-- Back Button -->
        <div class="mb-4">
            <a href="users.php" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Users
            </a>
        </div>

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-user-edit me-2"></i>Edit User</h2>
            <div>
                <button type="submit" form="userForm" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
            </div>
        </div>

        <div id="message"></div>

        <form id="userForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

            <div class="row">
                <!-- Left Column - Profile Picture -->
                <div class="col-md-4">
                    <div class="card p-4 mb-4">
                        <h4 class="section-title"><i class="fas fa-image me-2"></i>Profile Picture</h4>

                        <div class="text-center mb-4">
                            <?php if (!empty($user['profile_image'])): ?>
                                <img src="../public/<?= $user['profile_image'] ?>" class="profile-picture mb-3" alt="Profile Picture">
                            <?php else: ?>
                                <div class="profile-picture mb-3 bg-light d-flex align-items-center justify-content-center mx-auto">
                                    <i class="fas fa-user fa-3x text-secondary"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (!empty($user['profile_image'])): ?>
                            <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="deleteProfileImage(<?= $user['id'] ?>)">
                                <i class="fas fa-trash me-1"></i>Delete Current Picture
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right Column - User Details -->
                <div class="col-md-8">
                    <div class="card p-4 mb-4">
                        <h4 class="section-title"><i class="fas fa-info-circle me-2"></i>Account Information</h4>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="card p-4 mb-4">
                        <h4 class="section-title"><i class="fas fa-shield-alt me-2"></i>Security & Permissions</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">User Role</label>
                                <select class="form-select" id="role" name="role">
                                    <option value="user" <?= ($user['role'] ?? 'user') === 'user' ? 'selected' : '' ?>>User</option>
                                    <option value="author" <?= ($user['role'] ?? 'user') === 'author' ? 'selected' : '' ?>>Author</option>
                                    <option value="admin" <?= ($user['role'] ?? 'user') === 'admin' ? 'selected' : '' ?>>Administrator</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Account Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="active" <?= ($user['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="suspended" <?= ($user['status'] ?? 'active') === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                                    <option value="pending" <?= ($user['status'] ?? 'active') === 'pending' ? 'selected' : '' ?>>Pending</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="email_verified" name="email_verified" <?= $user['email_verified'] == "true" ? 'checked' : "" ?>>
                            <label class="form-check-label" for="email_verified">Email Verified (2FA Enabled)</label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let message = document.getElementById("message");

        function deleteProfileImage(id) {
            let formdata = new FormData();
            formdata.append("controller", "UserController");
            formdata.append("action", "deleteProfileImage");
            formdata.append("user_id", id);
            
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

                        setTimeout(() => {
                            window.location.reload();
                        }, 3000);
                    } else if (response && response.status == "error") {
                        message.innerHTML = `
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;
                    } else {
                        message.innerHTML = `
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Unknown Error!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;
                    }
                }
            }
            
            xhr.open("POST", "./handler.php", true);
            xhr.send(formdata);
        }

        let userForm = document.getElementById("userForm");

        function updateDetails() {
            let formdata = new FormData(userForm);
            formdata.append("controller", "UserController");
            formdata.append("action", "update");

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

                        setTimeout(() => {
                            window.location.reload();
                        }, 2500);
                    } else if (response && response.status == "error") {
                        message.innerHTML = `
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;
                    } else {
                        message.innerHTML = `
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Unknown Error During Update!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;
                    }
                
                
                    setTimeout(()=>{
                        message.innerHTML="";
                    },2000)
                
                }
            }

            xhr.open("POST", "./handler.php", true);
            xhr.send(formdata);
        }

        userForm.addEventListener("submit", (e) => {
            e.preventDefault();
            updateDetails();
        });
    </script>
</body>

</html>