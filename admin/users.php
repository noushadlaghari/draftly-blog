<?php
require_once(__DIR__ . "/../middlewares/Admin.php");
require_once(__DIR__ . "/../controllers/UserController.php");

$users = (new UserController())->findAll();
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

        .profile-picture {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
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
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center mb-4">Draftly Admin</h4>
        <a href="index.php"><i class="fas fa-chart-bar me-2"></i> Dashboard</a>
        <a href="users.php" class="active"><i class="fas fa-users me-2"></i> Manage Users</a>
        <a href="blogs.php"><i class="fas fa-blog me-2"></i> Manage Blogs</a>
        <a href="categories.php"><i class="fas fa-blog me-2"></i> Manage Categories</a>
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

        <!-- Manage Users -->
        <div id="users" class="section">
            <div class="card p-4">
                <h4 class="mb-3"><i class="fas fa-users me-2"></i> Manage Users</h4>
                <div id="message"></div>
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Profile Pic</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="users_table">
                    </tbody>
                </table>
                <nav aria-label="Categories pagination" class="d-flex justify-content-center">
          <ul class="pagination">
            <li class="page-item prev">
              <button class="page-link" id="previous" onclick="previous()">
                <i class="fas fa-chevron-left me-1"></i>Previous
              </button>
            </li>
            <li class="page-item next">
              <button class="page-link" id="next" onclick="next()">
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
        let limit = 8;
        let offset = 0;
        let totalUsers = 0;

        async function loadUsers() {
            let users_table = document.getElementById("users_table");
            let formdata = new FormData();
            formdata.append("controller", "UserController");
            formdata.append("action", "findAll");
            formdata.append("offset", offset);

            users_table.innerHTML = `<tr><td colspan="5" class="text-center">Loading...</td></tr>`;

            let response = await request("./handler.php", formdata);

            if (!response) {
                showMessage("danger", "Something Went Wrong!");
                return;
            }

            if (response.status && response.status == "success") {
                users_table.innerHTML = "";
                totalUsers = response.total;

                if (response.users.length === 0) {
                    users_table.innerHTML = `<tr><td colspan="5" class="text-center">No users found</td></tr>`;
                }
                response.users.forEach(user => {
                    users_table.innerHTML += `
                                <tr>
                                    <td>
                                        ${user.profile_image? 
                                            `<img src="./../public/${user.profile_image}" class="profile-picture">` : 
                                            `<div class="profile-picture bg-light d-flex align-items-center justify-content-center">
                                                <i class="fas fa-user text-secondary"></i>
                                            </div>`
                                        }
                                    </td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td><span class="badge bg-${user.role === 'admin' ? 'primary' : 'secondary'}">${user.role}</span></td>
                                    <td>
                                        <a class="btn btn-sm btn-info" href="edit-user.php?user_id=${user.id}">Edit</a>
                                        <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id})">Delete</button>
                                    </td>
                                </tr>
                            `;
                });


                document.getElementById('previous').disabled = offset === 0;
                document.getElementById('next').disabled = (offset + limit) >= totalUsers;

            } else if (response.status && response.status == "error") {
                showMessage("danger", response.message);
            } else {
                showMessage("danger", "Something Went Wrong!");
            }

        }

        function next() {
            if (offset + limit < totalUsers) {
                offset += limit;
                loadUsers();
            }
        }

        function previous() {
            if (offset - limit >= 0) {
                offset -= limit;
                loadUsers();
            }
        }

        async function deleteUser(user_id) {

            let approve = confirm("Do You want to Delete User?");
            if (!approve) {
                return;
            }

            let formdata = new FormData();
            formdata.append("user_id", user_id);
            formdata.append("controller", "UserController");
            formdata.append("action", "delete");

            let response = await request("./handler.php",formdata);
            if(!response){
                showMessage("danger","Something Went Wrong!");
                return;
            }
            
            if(response.status && response.status == "success"){

                showMessage("success",response.message);
                loadUsers();
                
            }else if(response.status && response.status == "error"){
                
                showMessage("danger",response.message);
            }else{
                
                showMessage("danger","Something Went Wrong!");
            }
        }

          // Initial load
        loadUsers();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>