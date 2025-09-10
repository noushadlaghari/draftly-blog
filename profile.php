<?php
require_once("./middlewares/Auth.php");
require_once(__DIR__ . "/controllers/UserController.php");

if (!auth()) {
  header("location: index.php");
}

$controller = new UserController();
$user = $controller->findById($_SESSION["id"]);

if (!$user) {
  header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile - Draftly</title>
  <link rel="icon" type="image/png" href="./assets/images/favicon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #6f42c1;
      --primary-dark: #5a32a3;
      --secondary: #6c757d;
      --light: #f8f9fa;
      --dark: #343a40;
      --success: #28a745;
      --danger: #dc3545;
      --warning: #ffc107;
      --info: #17a2b8;
      --light-bg: #f8f9fa;
    }

    body {
      background-color: var(--light-bg);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .profile-header {
      background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
      color: white;
      padding: 3rem 1rem;
      border-radius: 0.5rem;
      margin-bottom: 2rem;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      position: relative;
      overflow: hidden;
    }

    .profile-header::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23ffffff' fill-opacity='0.1' d='M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,213.3C672,192,768,128,864,128C960,128,1056,192,1152,192C1248,192,1344,128,1392,96L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E");
      background-size: cover;
      background-position: center;
    }

    .profile-img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      border: 5px solid rgba(255, 255, 255, 0.3);
      object-fit: cover;
      position: relative;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
    }

    .nav-pills .nav-link {
      color: var(--dark);
      border-radius: 0.5rem;
      margin: 0 0.25rem;
      font-weight: 500;
      transition: all 0.3s;
    }

    .nav-pills .nav-link.active {
      background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
      color: white;
      box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
    }

    .card {
      border: none;
      border-radius: 0.5rem;
      box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
      transition: transform 0.3s, box-shadow 0.3s;
      margin-bottom: 1.5rem;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
      border: none;
      border-radius: 0.5rem;
      padding: 0.5rem 1.5rem;
      transition: all 0.3s;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      transform: translateY(-2px);
      box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.15);
    }

    .btn-outline-primary {
      color: var(--primary);
      border-color: var(--primary);
    }

    .btn-outline-primary:hover {
      background-color: var(--primary);
      border-color: var(--primary);
    }

    .btn-outline-danger {
      border-radius: 0.5rem;
    }

    .form-control,
    .form-select {
      border-radius: 0.5rem;
      padding: 0.75rem 1rem;
      border: 1px solid #ced4da;
      transition: all 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
      box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25);
      border-color: var(--primary);
    }

    .section-title {
      position: relative;
      padding-bottom: 0.75rem;
      margin-bottom: 1.5rem;
      font-weight: 600;
      color: var(--primary-dark);
    }

    .section-title::after {
      content: "";
      position: absolute;
      bottom: 0;
      left: 0;
      width: 50px;
      height: 3px;
      background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
      border-radius: 3px;
    }

    .error {
      color: var(--danger);
      font-size: 0.875rem;
      margin-top: 0.25rem;
    }

    .blog-content-preview {
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    @media (max-width: 768px) {
      .profile-img {
        width: 120px;
        height: 120px;
      }

      .profile-header {
        padding: 2rem 1rem;
      }
    }
    .profile-picture {
         width: 150px;
         height: 150px;
         border-radius: 50%;
         object-fit: cover;
         border: 4px solid #fff;
         box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
     }
  </style>
</head>

<body>

  <header>
    <?php require_once("partials/header.php"); ?>
  </header>

  <div class="container py-4">
    <!-- Profile Header -->
    <div class="profile-header text-center">
      <div class="position-relative">
        <?php if ($user["profile_image"]): ?>
          <img src="public/<?= $user["profile_image"] ?>" class="profile-img mb-3" alt="User Profile">
        <?php else: ?>
          <div class="profile-picture mb-3 bg-light d-flex align-items-center justify-content-center mx-auto">
            <i class="fas fa-user fa-3x text-secondary"></i>
          </div>
        <?php endif; ?>
      </div>
      <h2 class="position-relative"><?= $user["username"] ?></h2>
      <p class="position-relative mb-0"><?= $user["bio"] ? $user["bio"] : "No bio yet" ?></p>
    </div>

    <!-- Tabs Navigation -->
    <ul class="nav nav-pills mb-4 justify-content-center" id="profileTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="blogs-tab" data-bs-toggle="pill" data-bs-target="#blogs" type="button" role="tab">
          <i class="fas fa-blog me-2"></i>My Blogs
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="pill" data-bs-target="#profile" type="button" role="tab">
          <i class="fas fa-user me-2"></i>Profile Details
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="settings-tab" data-bs-toggle="pill" data-bs-target="#settings" type="button" role="tab">
          <i class="fas fa-cog me-2"></i>Settings
        </button>
      </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content" id="profileTabsContent">
      <!-- My Blogs Section -->
      <div class="tab-pane fade show active" id="blogs" role="tabpanel">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="section-title">My Blogs</h4>
          <a href="add-new-blog.php" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Add New
          </a>
        </div>
        <div id="blog_message"></div>
        <div class="row blog-container"></div>
      </div>

      <!-- Profile Details -->
      <div class="tab-pane fade" id="profile" role="tabpanel">
        <div class="card">
          <div class="card-body">
            <h4 class="section-title">Profile Details</h4>
            <div id="details_message"></div>
            <form id="details_form">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Username</label>
                  <input type="text" class="form-control" name="username" value="<?= $user["username"] ?>">
                  <div id="username_error" class="error"></div>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Full Name</label>
                  <input type="text" class="form-control" name="name" value="<?= $user["name"] ?>">
                  <div id="name_error" class="error"></div>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?= $user["email"] ?>">
                <div id="email_error" class="error"></div>
              </div>
              <div class="mb-3">
                <label class="form-label">Bio</label>
                <textarea class="form-control" name="bio" rows="3" placeholder="Tell us about yourself"><?= $user["bio"] ?></textarea>
                <div id="bio_error" class="error"></div>
              </div>
              <div class="mb-4">
                <label class="form-label">Profile Picture</label>
                <input class="form-control" name="profile_image" type="file" accept="image/*">
                <div id="profile_image_error" class="error"></div>
              </div>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-check-circle me-2"></i>Save Changes
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Settings -->
      <div class="tab-pane fade" id="settings" role="tabpanel">
        <div class="card">
          <div class="card-body">
            <h4 class="section-title">Change Password</h4>
            <div id="password_message"></div>
            <form id="password_form" class="mb-4">
              <div class="mb-3">
                <label class="form-label">Current Password</label>
                <input type="password" name="current_password" class="form-control" placeholder="Enter current password">
                <div id="current_password_error" class="error"></div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">New Password</label>
                  <input type="password" name="new_password" class="form-control" placeholder="Enter new password">
                  <div id="new_password_error" class="error"></div>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Confirm Password</label>
                  <input type="password" name="confirm_password" class="form-control" placeholder="Confirm new password">
                  <div id="confirm_password_error" class="error"></div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-key me-2"></i>Update Password
              </button>
            </form>

            <hr>

            <h4 class="section-title">Danger Zone</h4>
            <p class="text-muted mb-3">Once you delete your account, there is no going back. Please be certain.</p>
            <button class="btn btn-outline-danger" id="delete_account">
              <i class="fas fa-trash me-2"></i>Delete Account
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>


  <footer>
    <?php
    require_once("././partials/footer.php");
    ?>
  </footer>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    let delete_account = document.getElementById("delete_account");
    delete_account.addEventListener("click", (e) => {

      let confirmed = confirm("Do You want to Delete Your Account Permanently??");

      if (confirmed) {

        let formdata = new FormData();
        formdata.append("controller", "UserController");
        formdata.append("action", "delete");

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = () => {
          if (xhr.readyState == 4 && xhr.status == 200) {
            response = JSON.parse(xhr.responseText);

            if (response.status = "success") {
              window.location.href = "index.php";
            } else {

            }
          }
        }
        xhr.open("POST", "./handler/handler.php", true)
        xhr.send(formdata);
      }

    });

    function loadBlogs() {
      let blog_container = document.querySelector(".blog-container");
      let xhr = new XMLHttpRequest();
      let formdata = new FormData();
      formdata.append("action", "FindMyBlogs");
      formdata.append("controller", "BlogController");

      xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {

          let response = JSON.parse(xhr.responseText);

          if (response.status!="error") {
            
            let blogs = response.blogs;
            blog_container.innerHTML = "";

            if (blogs.length === 0) {
              blog_container.innerHTML = `
                <div class="col-12">
                  <div class="card">
                    <div class="card-body text-center py-5">
                      <i class="fas fa-blog display-4 text-muted"></i>
                      <h5 class="mt-3">No blogs yet</h5>
                      <p class="text-muted">Start writing your first blog post!</p>
                      <a href="#" class="btn btn-primary mt-2">
                        <i class="fas fa-plus-circle me-2"></i>Create Your First Blog
                      </a>
                    </div>
                  </div>
                </div>
              `;
              return;
            }

            blogs.forEach(blog => {
              let plainText = blog.content.replace(/<\/?[^>]+(>|$)/g, "");
              let preview = plainText.substring(0, 150);
              let date = new Date(blog.created_at).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
              });

              blog_container.innerHTML += `
                <div class="col-md-6 col-lg-4 my-2">
                  <div class="card h-100">
                    <div class="card-body">
                      <h5 class="card-title">${blog.title}</h5>
                      <p class="card-text text-muted small">${date}</p>
                      <p class="card-text blog-content-preview">${preview}...</p>
                    </div>
                    <div class="card-footer bg-transparent">
                      <div class="d-flex justify-content-between">
                        <a class="btn btn-sm btn-outline-primary" href="edit-blog.php?id=${blog.id}">
                          <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <button class="btn btn-sm btn-outline-danger" onclick="delete_blog(${blog.id})">
                          <i class="fas fa-trash me-1"></i>Delete
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              `;
            });
          }
        }
      }

      xhr.open("POST", "./handler/handler.php", true);
      xhr.send(formdata);
    }

    function delete_blog(id) {
      let blog_message = document.getElementById("blog_message");
      let formdata = new FormData();

      formdata.append("id", id);
      formdata.append("controller", "BlogController");
      formdata.append("action", "delete");

      let xhr = new XMLHttpRequest();

      xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
          let response = JSON.parse(xhr.responseText);


          blog_message.innerHTML = `
            <div class="alert alert-${response.status === 'success' ? 'success' : 'danger'} alert-dismissible fade show" role="alert">
              ${response.message}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          `;

          if (response.status === "success") {
            loadBlogs();
          }
        }
      }

      xhr.open("POST", "./handler/handler.php", true);
      xhr.send(formdata);
    }

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
      loadBlogs();

      // Form submission handlers
      let details_form = document.getElementById("details_form");
      if (details_form) {
        details_form.addEventListener("submit", (e) => {
          e.preventDefault();
          submitDetailsForm();
        });
      }

      let password_form = document.getElementById("password_form");
      if (password_form) {
        password_form.addEventListener("submit", (e) => {
          e.preventDefault();
          submitPasswordForm();
        });
      }
    });

    function submitDetailsForm() {
      let details_message = document.getElementById("details_message");
      let name_error = document.getElementById("name_error");
      let username_error = document.getElementById("username_error");
      let email_error = document.getElementById("email_error");
      let bio_error = document.getElementById("bio_error");
      let profile_image_error = document.getElementById("profile_image_error");

      let formdata = new FormData(details_form);
      formdata.append("controller", "UserController");
      formdata.append("action", "update_details");

      let xhr = new XMLHttpRequest();
      xhr.onreadystatechange = () => {
        if (xhr.readyState === 4 && xhr.status === 200) {

        
          let response = JSON.parse(xhr.responseText);

          if (response.status === "error") {
            let errors = response.errors || {};

            username_error.innerText = errors.username || "";
            name_error.innerText = errors.name || "";
            email_error.innerText = errors.email || "";
            bio_error.innerText = errors.bio || "";
            profile_image_error.innerText = errors.profile_image || "";

            details_message.innerHTML = response.message ? `
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${response.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            ` : '';
          } else if (response.status === "success") {
            details_message.innerHTML = `
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                ${response.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            `;

            setTimeout(()=>{

              window.location.reload();
            },2000)
          }
        }
      }

      xhr.open("POST", "./handler/handler.php", true);
      xhr.send(formdata);
    }

    function submitPasswordForm() {
      let password_message = document.getElementById("password_message");
      let current_password_error = document.getElementById("current_password_error");
      let new_password_error = document.getElementById("new_password_error");
      let confirm_password_error = document.getElementById("confirm_password_error");

      // Reset error messages
      [current_password_error, new_password_error, confirm_password_error].forEach(el => el.innerText = '');

      let formdata = new FormData(password_form);
      formdata.append("controller", "UserController");
      formdata.append("action", "update_password");

      let xhr = new XMLHttpRequest();
      xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
          let response = JSON.parse(xhr.responseText);

          if (response.status == "error") {
            let errors = response.errors || {};

            current_password_error.innerText = errors.current_password || "";
            new_password_error.innerText = errors.new_password || "";
            confirm_password_error.innerText = errors.confirm_password || "";

            password_message.innerHTML = response.message ? `
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${response.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            ` : '';
          } else if (response.status == "success") {
            password_message.innerHTML = `
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                ${response.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            `;

            // Clear the form
            password_form.reset();
          }
        }
      }
      xhr.open("POST", "./handler/handler.php", true);
      xhr.send(formdata);
    }
  </script>
</body>

</html>