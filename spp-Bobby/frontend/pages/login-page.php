<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Login & Registration Form</title>
    <link rel="stylesheet" href="../styles/styles.css" />
  </head>
  <<body>
    <?php
      require '../../backend/conn.php';
      

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query the database to retrieve user information
        $query = "SELECT * FROM data_akun WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
          $row = $result->fetch_assoc();
          $role = $row['level'];

          if ($role == 'admin') {
            // Redirect to the admin dashboard
            header('Location: ./dashboard_admin.html');
          } elseif ($role == 'user') {
            // Redirect to the user dashboard
            header('Location: user_dashboard.php');
          }
        } else {
          // Invalid login credentials, set the flag
          $invalidCredentials = true;
          
        }
      }
      $conn->close();
    ?>
    <div class="container">
      <input type="checkbox" id="check" />
      <div class="login form">
        <header>Login</header>
        <form method="post" action="">
          <input name="username" type="text" placeholder="Username" />
          <input name="password" type="password" placeholder="Password" />
          <input type="submit" class="button" value="Login" />
        </form>
        <script>
          // JavaScript to display an alert if there are invalid credentials
          <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($invalidCredentials) && $invalidCredentials) { ?>
            alert("Invalid login credentials. Please try again.");
            $invalidCredentials = false;
          <?php } ?>
        </script>
      </div>
    </div>
  </body>
</html>
