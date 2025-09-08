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
            <div id="message"></div>
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
              <tbody id="comments_container">


              </tbody>

            </table>
            <nav aria-label="..." class="d-flex justify-content-center">
              <ul class="pagination">
                <li class="page-item prev"><button class="page-link" onclick="previous()">Previous</button></li>
                <li class="page-item next"><button class="page-link" onclick="next()">Next</button></li>
              </ul>

            </nav>
          </div>
        </div>


      </div>


      <script>
        async function request(url, data) {
          try {
            const response = await fetch(url, {
              method: "POST",
              body: data
            });

            const raw = await response.text();

            if (!response.ok) {
              throw new Error(`HTTP ${response.status}`);
            }

            try {
              return JSON.parse(raw);
            } catch {
              return raw;
            }

          } catch (e) {
            console.error("Request Error:", e.message);
            return null;
          }
        }

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
          <td>${comment.content}</td>
          <td>${comment.author}</td>
          <td>${comment.blog_title}</td>
          <td>

            ${comment.status!="approved"?
            `<button class="btn btn-sm btn-success" onclick="approveComment(${comment.id})">Approve</button>`
            : ``}
          
            <button class="btn btn-sm btn-danger" onclick = "deleteComment(${comment.id})">Delete</button>
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
            }, 3000)

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
            }, 3000)

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


        function showMessage(type, message) {
          let message_container = document.getElementById("message");
          message_container.innerHTML = `
         <div class="alert alert-${type} alert-dismissible fade show" role="alert">
             ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
          setTimeout(() => {
            message_container.innerHTML = "";
          }, 2500)
        }
      </script>

    </body>

    </html>