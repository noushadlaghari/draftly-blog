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
            --success: #1cc88a;
            --danger: #e74a3b;
            --warning: #f6c23e;
            --dark: #2e3a59;
            --light: #f8f9fc;
        }

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

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
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
            color: var(--dark);
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center mb-4">Draftly Admin</h4>
        <a href="index.php">📊 Dashboard</a>
        <a href="users.php" class="active">👥 Manage Users</a>
        <a href="blogs.php">📝 Manage Blogs</a>
        <a href="comments.php">💬 Comments</a>
        <a href="contact.php">📨 Contact Messages</a>
        <a href="profile.php">⚙️ My Profile</a>
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Navbar -->
        <!-- Navbar -->
        <nav class="navbar navbar-light bg-white shadow-sm mb-4 rounded">
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
            <h2 class="fw-bold">Edit User</h2>
            <div>
                <button type="submit" form="userForm" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
            </div>
        </div>


        <div id="message">

        </div>



        <form id="userForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

            <div class="row">
                <!-- Left Column - Profile Picture -->
                <div class="col-md-4">
                    <div class="card p-4 mb-4">
                        <h4 class="section-title">Profile Picture</h4>

                        <div class="text-center mb-4">
                            <?php if (!empty($user['profile_image'])): ?>
                                <img src="../public/<?= $user['profile_image'] ?>" class="profile-picture mb-3" alt="Profile Picture">
                            <?php else: ?>
                                <div class="profile-picture mb-3 bg-light d-flex align-items-center justify-content-center mx-auto">
                                    <i class="fas fa-user fa-3x text-secondary"></i>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="profile_image" class="form-label">Change Profile Picture</label>
                                <input class="form-control" type="file" id="profile_image" name="profile_image" accept="image/*">
                            </div>

                            <?php if (!empty($user['profile_image'])): ?>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteProfileImage(<?= $user['id'] ?>)">
                                    <i class="fas fa-trash me-1"></i>Delete Current Picture
                                </button>
                                <?php endif; ?>
                                
                        </div>
                    </div>
                </div>

                <!-- Right Column - User Details -->
                <div class="col-md-8">
                    <div class="card p-4 mb-4">
                        <h4 class="section-title">Account Information</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>">
                            </div>


                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="card p-4 mb-4">
                        <h4 class="section-title">Security & Permissions</h4>

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
                            <input class="form-check-input" type="checkbox" id="email_verified" name="email_verified" <?= !empty($user['email_verified_at']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="email_verified">Email Verified</label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="two_factor" name="two_factor" <?= !empty($user['two_factor_enabled']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="two_factor">Two-Factor Authentication Enabled</label>
                        </div>
                    </div>

                    <div class="card p-4">
                        <h4 class="section-title">Change Password</h4>
                        <p class="text-muted">Leave these fields blank if you don't want to change the password.</p>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        document.getElementById('userForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            if (password !== passwordConfirmation) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }

            if (password && password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long!');
                return false;
            }
        });

        // Preview image before upload
        document.getElementById('profile_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const profilePicElement = document.querySelector('.profile-picture') ||
                        document.querySelector('.fa-user').parentElement;

                    if (profilePicElement.tagName === 'IMG') {
                        profilePicElement.src = e.target.result;
                    } else {
                        // Replace placeholder with image
                        profilePicElement.innerHTML = `<img src="${e.target.result}" class="profile-picture" alt="Profile Preview">`;
                    }
                }
                reader.readAsDataURL(file);
            }
        });

        function deleteProfileImage(id) {

            let message =document.getElementById("message");
            let formdata = new FormData();
            formdata.append("controller", "UserController");
            formdata.append("action", "deleteProfileImage");
            formdata.append("user_id", id);
            let xhr = new XMLHttpRequest();

            xhr.onreadystatechange = () => {
                if (xhr.readyState == 4 && xhr.status == 200) {

                    let response = JSON.parse(xhr.responseText);

                    if(response&& response.status == "success"){
                        message.innerHTML = `
                        
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ${response.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>  
                        `;

                        setTimeout(()=>{

                            window.location.reload();
                        },3000);
                    }else if(response&&response.status == "error"){
                        message.innerHTML = `
                        
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ${response.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                        
                        
                        `;
                        
                    }else{
                        message.innerHTML = `
                        
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Unknown Error!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                        
                        
                        `;


                    }

                }

                setTimeout(()=>{
                    message.innerHTML = "";
                },3000)
            }
            xhr.open("POST", "./handler.php", true);
            xhr.send(formdata);
        }

        let userForm = document.getElementById("userForm");

        function updateDetails(){


            let formdata = new FormData(userForm);

            formdata.append("controller","UserController");
            formdata.append("action","update");

            let xhr = new XMLHttpRequest();

            xhr.onreadystatechange = ()=>{
                if(xhr.readyState==4 && xhr.status==200){

                    console.log()

                }
            }
            
            xhr.open("POST","./handler.php",true);
            xhr.send(formdata);



        }

        userForm.addEventListener("submit",(e)=>{
            e.preventDefault();
            updateDetails();
        })
    </script>
</body>

</html>