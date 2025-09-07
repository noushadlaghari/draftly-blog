
<?php 
require_once(__DIR__ ."/middlewares/Auth.php");
if(auth()){
  header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Draftly - Login</title>
    <link rel="icon" type="image/png" href="./assets/images/favicon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .login-box {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    .login-box h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
      font-weight: bold;
    }

    .form-control {
      border-radius: 8px;
    }

    .btn-primary {
      width: 100%;
      border-radius: 8px;
      background: #007bff;
      border: none;
      font-weight: 500;
    }

    .btn-primary:hover {
      background: #0056b3;
    }

    .text-muted a {
      text-decoration: none;
    }

    .text-muted a:hover {
      text-decoration: underline;
    }

    .error {
      color: red;
      text-align: center;
    }
  </style>
</head>

<body>

  <div class="login-container">
    <div class="login-box">
      <h2>Login to Draftly</h2>

      <div id="message"></div>

      <form id="form">
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>

        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>

        </div>
        <button type="submit" id="submit" class="btn btn-primary">Login</button>
      </form>
      <p class="text-center mt-3 text-muted">
        Don’t have an account? <a href="signup.php">Sign Up</a>
      </p>
      <p class="text-center text-muted">
        <a href="forgot-password.php">Forgot Password?</a>
      </p>
    </div>
  </div>

  <script>
    let form = document.getElementById("form");
    let email = document.getElementById("email");
    let password = document.getElementById("password");
    let message = document.getElementById("message");

    form.addEventListener("submit", (e) => {
      e.preventDefault();

      let formdata = new FormData(form);
      formdata.append("action", "login");
      formdata.append("controller", "UserController");

      let xhr = new XMLHttpRequest();


      xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
          let response = JSON.parse(xhr.responseText);

          if (response.status == "error") {
            
            message.innerHTML = `

                          <div class="alert alert-danger" role="alert">
          ${response.message}
                            </div>
                          
              `;
          } else if(response.status == "success") {
            message.innerHTML = `
              <div class="alert alert-success" role="alert">
          ${response.message}
</div>
            `;
            
            setTimeout(()=>{
              
              window.location.href = "index.php";
              
            },2000)
          }else{
            
            message.innerHTML = `
              <div class="alert alert-success" role="alert">
          Unknown Error!
  </div>
            `;
          }

        }


      }

      xhr.open("POST", "./handler/handler.php", true);
      xhr.send(formdata);


    })
  </script>
</body>

</html>