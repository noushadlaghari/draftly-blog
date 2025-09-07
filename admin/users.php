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
          <a href="users.php" class="active">👥 Manage Users</a>
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

          <!-- Manage Users -->
          <div id="users" class="section">
              <div class="card p-4">
                  <h4 class="mb-3">Manage Users</h4>
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
              </div>
          </div>


      </div>


      <script>
          let limit = 6;
          let offset = 0;

          function loadUsers(){
          let users_table = document.getElementById("users_table");
          let formdata = new FormData();
          formdata.append("controller", "UserController");
          formdata.append("action", "findAll");
          formdata.append("offset", offset);
          formdata.append("limit", limit);

          let xhr = new XMLHttpRequest();
          xhr.onreadystatechange = () => {
              if (xhr.status == 200 && xhr.readyState == 4) {

                  let response = JSON.parse(xhr.responseText);


                  if (response && response.status == "success") {
                      users_table.innerHTML = "";
                      response.users.forEach(user => {


                          users_table.innerHTML += `
                        
                              <tr>
              <td><img src="../public/${user.profile_image}" height="50" width="50" style="object-fit:cover; border-radius:50%"></td>
              <td>${user.name}</td>
              <td>${user.email}</td>
              <td>${user.role}</td>
              <td>
                <a class="btn btn-sm btn-info" href="edit-user.php?user_id=${user.id}">Edit</a>
                <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id})">Delete</button>
              </td>
            </tr>


                        `;

                      });
                  }

              }
          }

          xhr.open("POST", "./handler.php", true);
          xhr.send(formdata);

        }

        loadUsers();

          function deleteUser(user_id) {



            let approve = confirm("Do You want to Delete User?");
            if(!approve){
                return;
            }
              let message = document.getElementById("message");
              let formdata = new FormData();
              formdata.append("user_id", user_id);
              formdata.append("controller", "UserController");
              formdata.append("action", "delete");

              let xhr = new XMLHttpRequest();

              xhr.onreadystatechange = () => {
                  if (xhr.readyState == 4 && xhr.status == 200) {
                      let response = JSON.parse(xhr.responseText);
                      if (response && response.status) {
                          if (response.status == "success") {

                              message.innerHTML = `
                                
                                    <div class="alert alert-success" role="alert">
                          ${response.message}
                                            </div>
                                
                                
                                `;

                                
                                loadUsers();
                            
                          } else {

                              
                                  message.innerHTML = `
                                    
                                        <div class="alert alert-danger" role="alert">
                              ${response.message}
                                                </div>
                                    
                                    
                                    `;


                          }

                          setTimeout(()=>{
                            message.innerHTML = "";
                          },3000);
                      }
                  }
              }

              xhr.open("POST", "./handler.php", true)
              xhr.send(formdata);

          }
      </script>
  </body>

  </html>