<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-2 shadow">
  <div class="container">
    <!-- Brand/Logo -->
    <a class="navbar-brand fw-bold fs-3 d-flex align-items-center" href="index.php">
      <span class="text-gradient"><img src="./assets/images/logo.png" height="40px"  alt="Draftly Logo"></span>
    </a>
    
    <!-- Mobile Toggle Button -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <!-- Navbar Content -->
    <div class="collapse navbar-collapse" id="navbarContent">
      <!-- Navigation Links -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center" href="index.php">
           
            Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center" href="blogs.php">
            
            Blogs
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center" href="categories.php">
            
            Categories
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center" href="about-us.php">
           
            About
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center" href="contact-us.php">
          
            Contact
          </a>
        </li>
      </ul>
      
      <!-- Right-side Actions -->
      <div class="d-flex align-items-center gap-3">
    
        <!-- User Actions -->
        <?php if(isset($_SESSION['id'])): ?>
          <!-- User is logged in -->
          <div class="dropdown">
            <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" type="button" 
                    id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-circle me-1"></i>
              Profile
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li>
                <a class="dropdown-item d-flex align-items-center" href="profile.php">
                  <i class="fas fa-user me-2 fa-fw"></i>
                  My Profile
                </a>
              </li>
              
              <li>
                <a class="dropdown-item d-flex align-items-center" href="add-new-blog.php">
                  <i class="fas fa-plus-circle me-2 fa-fw"></i>
                  Write New
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item d-flex align-items-center text-danger" href="logout.php">
                  <i class="fas fa-sign-out-alt me-2 fa-fw"></i>
                  Logout
                </a>
              </li>
            </ul>
          </div>
        <?php else: ?>
          <!-- User is not logged in -->
          <div class="d-flex gap-2">
            <a class="btn btn-outline-light btn-sm d-flex align-items-center" href="login.php">
              <i class="fas fa-sign-in-alt me-1"></i>
              Login
            </a>
            <a class="btn btn-primary btn-sm d-flex align-items-center" href="signup.php">
              <i class="fas fa-user-plus me-1"></i>
              Sign Up
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
    
</nav>

<!-- Optional: Success/Error Message Display -->
<?php if(isset($_SESSION['message'])): ?>
<div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show mb-0 rounded-0" role="alert">
  <div class="container d-flex align-items-center">
    <i class="fas <?php 
      echo $_SESSION['message_type'] == 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; 
    ?> me-2"></i>
    <?php echo $_SESSION['message']; ?>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>
<?php 
  unset($_SESSION['message']);
  unset($_SESSION['message_type']);
endif; 
?>