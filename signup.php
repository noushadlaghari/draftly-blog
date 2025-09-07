<?php
session_start();
if (isset($_SESSION["id"])) {
  header("location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Draftly - Sign Up</title>
    <link rel="icon" type="image/png" href="./assets/images/favicon.png">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      color: #333;
    }

    header {
      background: #2c3e50;
      padding: 15px 30px;
      color: white;
      text-align: center;
    }

    header h1 {
      margin: 0;
      font-size: 26px;
      letter-spacing: 1px;
    }

    .signup-container {
      max-width: 400px;
      margin: 60px auto;
      padding: 25px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .signup-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #2c3e50;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-size: 14px;
      margin-bottom: 5px;
      color: #444;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
    }

    .form-group input:focus {
      border-color: #2c3e50;
      outline: none;
    }

    .btn {
      width: 100%;
      padding: 12px;
      background: #2c3e50;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
    }

    .btn:hover {
      background: #34495e;
    }

    .link {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
    }

    .link a {
      color: #2c3e50;
      text-decoration: none;
      font-weight: bold;
    }

    .link a:hover {
      text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 500px) {
      .signup-container {
        margin: 30px 15px;
        padding: 20px;
      }
    }

    .error {
      color: red;
    }
  </style>
</head>

<body>

  <header>
    <h1>Draftly Blog</h1>
  </header>

  <div class="signup-container">
    <div id="message"></div>
    <h2>Create an Account</h2>
    <form id="form">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
        <div class="error"></div>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
        <div class="error"></div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <div class="error"></div>
      </div>

      <div class="form-group">
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <div class="error"></div>
      </div>

      <button type="submit" class="btn" id="submit">Sign Up</button>

      <div class="link">
        Already have an account? <a href="login.php">Login</a>
      </div>
    </form>
  </div>

  <script>
    let form = document.getElementById("form");
    let submit = document.getElementById("submit");
    let message_container = document.getElementById("message");
    let username = document.getElementById("username");
    let email = document.getElementById("email");
    let password = document.getElementById("password");
    let confirm_password = document.getElementById("confirm_password");


    submit.addEventListener("click", (e) => {
      e.preventDefault();

      let formdata = new FormData(form);
      formdata.append("action", "register");
      formdata.append("controller", "UserController");

      let xhr = new XMLHttpRequest();

      xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {

          let response = JSON.parse(xhr.responseText);


          if (response.errors) {

            let errors = response.errors;

              username.nextElementSibling.innerHTML = errors.username ||"";
           
         
              email.nextElementSibling.innerHTML = errors.email || "";
         
              password.nextElementSibling.innerHTML = errors.password || "";
        
 
              confirm_password.nextElementSibling.innerHTML = errors.confirm_password || "";
          

          } else {

            username.nextElementSibling.innerHTML = "";
            password.nextElementSibling.innerHTML = "";
            email.nextElementSibling.innerHTML = "";
            confirm_password.nextElementSibling.innerHTML = "";


          }


          if (response.status) {
            if (response.status == "success") {

              message_container.innerHTML = `<div class="alert alert-success" role="alert">
            ${response.message}
</div>`;
              setTimeout(() => {

                window.location.href = "login.php";
              }, 2000)
            } else {
              message_container.innerHTML = `
              

                <div class="alert alert-danger" role="alert">
            ${response.message}
</div>
              
              `;
            }
          }

        }
      }
      xhr.open("POST", "./handler/handler.php", true);
      xhr.send(formdata);

    });
  </script>
</body>

</html>