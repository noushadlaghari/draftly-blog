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

    .btn-primary {
      background-color: var(--primary);
      border-color: var(--primary);
    }

    .btn-primary:hover {
      background-color: var(--primary-dark);
      border-color: var(--primary-dark);
    }

    .btn-success {
      background-color: #28a745;
      border-color: #28a745;
    }

    .btn-success:hover {
      background-color: #218838;
      border-color: #1e7e34;
    }

    .btn-danger {
      background-color: #dc3545;
      border-color: #dc3545;
    }

    .btn-danger:hover {
      background-color: #c82333;
      border-color: #bd2130;
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

    .page-link {
      color: var(--primary);
    }

    .page-item.disabled .page-link {
      color: var(--secondary);
    }

    .comment-content {
      max-width: 200px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .modal-header {
      background-color: var(--light);
      border-bottom: 2px solid var(--primary);
    }

    .modal-title {
      color: var(--text-primary);
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
    <a href="categories.php"><i class="fas fa-blog me-2"></i> Manage Categories</a>
    <a href="comments.php"><i class="fas fa-comments me-2"></i> Comments</a>
    <a href="contact.php" class="active"><i class="fas fa-envelope me-2"></i> Contact Messages</a>
    <a href="profile.php"><i class="fas fa-cog me-2"></i> My Profile</a>
  </div>


  <!-- Content -->
  <div class="content">
    <!-- Navbar -->
    <nav class="navbar navbar-light shadow-sm mb-4 rounded">
      <div class="container-fluid">
        <span class="navbar-brand mb-0 h5">Welcome, Admin</span>
        <a class="btn btn-outline-danger btn-sm" href="./../logout.php">
          <i class="fas fa-sign-out-alt me-1"></i>Logout
        </a>
      </div>
    </nav>

    <!-- Contact Messages -->
    <div id="contacts" class="section">
      <div class="card p-4">
        <div id="message"></div>
        <h4 class="mb-3"><i class="fas fa-envelope me-2"></i>Contact Messages</h4>
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Subject</th>
              <th>Message</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="contact_container"></tbody>
        </table>

        <nav aria-label="Contact messages pagination" class="d-flex justify-content-center mt-4">
          <ul class="pagination">
            <li class="page-item prev">
              <button class="page-link" onclick="previous()">
                <i class="fas fa-chevron-left me-1"></i>Previous
              </button>
            </li>
            <li class="page-item next">
              <button class="page-link" onclick="next()">
                Next<i class="fas fa-chevron-right ms-1"></i>
              </button>
            </li>
          </ul>
        </nav>

        <!-- Modal -->
        <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Contact Message Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body"></div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>


        
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    async function request(url, data) {
      try {
        let response = await fetch(url, {
          method: "POST",
          body: data
        });

        let raw = await response.text();

        if (!response.ok) {
          throw new Error(`HTTP ${response.status}`);
        }

        try {
          return JSON.parse(raw);
        } catch {
          return raw;
        }

      } catch (e) {
        console.log("Request Error: ", e.message);
        return null;
      }
    }

    let offset = 0;
    const limit = 8;
    let total = 0;

    async function loadContactEntries() {
      let contact_container = document.getElementById("contact_container");
      let formdata = new FormData();
      formdata.append("controller", "ContactsController");
      formdata.append("action", "findAll");
      formdata.append("offset", offset);

      let response = await request("./handler.php", formdata);

      if (!response) {
        showMessage("danger", "Something Went Wrong!");
        return;
      }

      if (response.status && response.status == "success") {
        let data = response.data;
        total = response.total;

        contact_container.innerHTML = "";

        if (data.length === 0) {
          contact_container.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-muted">No contact messages found</td></tr>`;
          return;
        }

        data.forEach(contact => {
          contact_container.innerHTML += `
            <tr>
              <td>${contact.id}</td>
              <td>${contact.name}</td>
              <td>${contact.email}</td>
              <td class="comment-content" title="${contact.subject}">${contact.subject}</td>
              <td class="comment-content" title="${contact.message}">${contact.message}</td>
              <td>
                <span class="badge bg-${contact.status === 'resolved' ? 'success' : 'warning'}">
                  ${contact.status}
                </span>
              </td>
              <td>
                <div class="btn-group" role="group">
                  ${contact.status != "resolved" ? 
                    `<button class="btn btn-sm btn-success me-1" onclick="resolveEntry(${contact.id})" title="Mark as resolved">
                      <i class="fas fa-check"></i>
                    </button>` : 
                    ``
                  }
                  <button class="btn btn-sm btn-info me-1" onclick="showDetails(${contact.id})" title="View details">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="btn btn-sm btn-danger" onclick="deleteEntry(${contact.id})" title="Delete message">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>      
          `;
        });

        updatePagination();

      } else if (response.status && response.status == "error") {
        showMessage("danger", response.message);
      } else {
        showMessage("danger", "Something Went Wrong!");
      }
    }

    loadContactEntries();

    async function deleteEntry(id) {
      if (!confirm("Are you sure you want to delete this contact message?")) {
        return;
      }

      let formdata = new FormData();
      formdata.append("controller", "ContactsController");
      formdata.append("action", "delete");
      formdata.append("id", id);
      let response = await request("./handler.php", formdata);

      if (!response) {
        showMessage("danger", "Something Went Wrong!");
        return;
      }

      if (response.status && response.status == "success") {
        showMessage("success", response.message);
        setTimeout(() => {
          loadContactEntries();
        }, 3000);
      } else if (response.status && response.status == "error") {
        showMessage("danger", response.message);
      } else {
        showMessage("danger", "Something Went Wrong!");
      }
    }

    async function resolveEntry(id) {
      let formdata = new FormData();
      formdata.append("controller", "ContactsController");
      formdata.append("action", "approve");
      formdata.append("status", "resolved");
      formdata.append("id", id);

      let response = await request("./handler.php", formdata);

      if (!response) {
        showMessage("danger", "Something Went Wrong!");
        return;
      }

      if (response.status && response.status == "success") {
        showMessage("success", response.message);
        setTimeout(() => {
          loadContactEntries();
        }, 3000);
      } else if (response.status && response.status == "error") {
        showMessage("danger", response.message);
      } else {
        showMessage("danger", "Something Went Wrong!");
      }
    }

    function next() {
      if ((offset + limit) < total) {
        offset += limit;
        loadContactEntries();
      }
    }

    function previous() {
      if ((offset - limit) >= 0) {
        offset -= limit;
        loadContactEntries();
      }
    }

    function updatePagination() {
      document.querySelector(".pagination .prev button").disabled = (offset === 0);
      document.querySelector(".pagination .next button").disabled = (offset + limit >= total);
    }

    async function showDetails(id) {
      let modal_body = document.querySelector(".modal-body");
      let modal_title = document.querySelector(".modal-title");
      let modal = new bootstrap.Modal(document.getElementById("detailsModal"));
      let formdata = new FormData();
      formdata.append("controller", "ContactsController");
      formdata.append("action", "findById");
      formdata.append("id", id);

      let response = await request("./handler.php", formdata);

      if (response.status && response.status == "success") {
        let details = response.data;
        modal_title.textContent = `Message: ${details.subject}`;
        modal_body.innerHTML = `
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label fw-bold">Name:</label>
                <p class="form-control-static">${details.name}</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label fw-bold">Email:</label>
                <p class="form-control-static">${details.email}</p>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Subject:</label>
            <p class="form-control-static">${details.subject}</p>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Message:</label>
            <div class="border p-3 rounded bg-light">
              ${details.message}
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label fw-bold">Status:</label>
                <p><span class="badge bg-${details.status=="resolved"?"success":"warning"}">${details.status}</span></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label fw-bold">Date:</label>
                <p class="form-control-static">
  ${new Date(details.created_at).toLocaleString("en-US", { dateStyle: "medium", timeStyle: "short" })}
</p>

              </div>
            </div>
          </div>
        `;
        modal.show();
      }
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
      }, 2500);
    }
  </script>
</body>

</html>