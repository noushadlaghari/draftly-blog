  <?php
  require_once(__DIR__ . "/../middlewares/Admin.php");



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
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08);
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
      <a href="users.php">👥 Manage Users</a>
      <a href="blogs.php" class="active">📝 Manage Blogs</a>
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
          <a href="../logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
      </nav>

      <!-- Manage Blogs -->
      <div id="blogs" class="section">
        <div class="card p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Manage Blogs</h4>
            <a class="btn btn-primary btn-sm" href="./../add-new-blog.php">➕ Add New Blog</a>
          </div>
          <div id="message"></div>
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="blogs_container">

            </tbody>

          </table>
          <div class="d-flex justify-content-center">
            <nav aria-label="...">
              <ul class="pagination">
                <li class="page-item"><a href="#" class="page-link" onclick="previous()">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#" onclick="next()">Next</a></li>
              </ul>
            </nav>
          </div>
        </div>
      </div>

    </div>

    <script>
      let offset = 0;
      let limit = 6;
      let disable_next = false;
      let blogs_container = document.getElementById("blogs_container");
      let message = document.getElementById("message");
      function loadBlogs() {

        let formdata = new FormData();
        formdata.append("controller", "BlogController");
        formdata.append("action", "findAll");
        formdata.append("offset", offset);
        formdata.append("limit", limit);
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = () => {
          if (xhr.status == 200 && xhr.readyState == 4) {

            console.log(xhr.responseText)
            let response = JSON.parse(xhr.responseText);
            if (response && response["status"] == "success") {

              blogs_container.innerHTML = "";
              let blogs = response.blogs;

              blogs.forEach(blog => {

                blogs_container.innerHTML += `           
                <tr>
              <td>${blog.id}</td>
              <td>${blog.title}</td>
              <td>${blog.author}</td>
              <td><span class="badge ${blog.status=="published"?"bg-success":"bg-warning text-black"}">${blog.status}</span></td>
              <td>
                <a class="btn btn-sm btn-primary" href="../single-post.php?id=${blog.id}">View</a>
                <a class="btn btn-sm btn-warning" href="./edit-blog.php?blog_id=${blog.id}">Edit</a>
                <button class="btn btn-sm btn-danger" onclick="deleteBlog(${blog.id})">Delete</button>
              </td>
            </tr>
            `;

              });

            } else {
              disable_next = true;
            }
          }
        }
        xhr.open("POST", "./handler.php", true);
        xhr.send(formdata);


      }

      loadBlogs();

      function deleteBlog(id) {
        let formdata = new FormData();
        formdata.append("controller", "BlogController");
        formdata.append("action", "delete");
        formdata.append("blog_id", id);
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = () => {

          if (xhr.readyState == 4 && xhr.status == 200) {

            let response = JSON.parse(xhr.responseText);

            if (response && response.status == "success") {
              message.innerHTML = `
                <div class="alert alert-success" role="alert">
                  ${response.message}
                </div>
              `;
            } else {
              message.innerHTML = `
                <div class="alert alert-danger" role="alert">
                  ${response.message}
                </div>
              `;

            }

            setTimeout(()=>{

              message.innerHTML = "";

            },3000)

          }
        }

        xhr.open("POST","./handler.php",true);
        xhr.send(formdata);
      }

      function next() {
        if (!disable_next) {
          offset += limit;
          loadBlogs();
        }
      }

      function previous() {
        if (offset - limit >= 0) {
          offset -= limit;
          loadBlogs();
        }
      }
    </script>

  </body>

  </html>