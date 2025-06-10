<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Skenaver Login</title>
  <link rel="stylesheet" href="login.css" />
</head>
<body>
  <div class="background"></div>

  <div class="logo">
    <img src="asset/Skenaaver.png" alt="">
  </div>

  <div class="login-box">
    <h2>Login</h2>
    <form method="POST" action="">
      <div class="input-container">
      <input type="email" name="email" placeholder="Enter Email" required />
      </div>

      <div class="input-container">
        <input type="password" name="password" placeholder="Enter Password" required />
      </div>

      <div class="forgot-password">
        <a href="lupa-pass.php">Forgot Password?</a>
      </div>

      <input type="submit" value="Login" />
    </form>

    <p class="bottom-text">
      Don't have an account? <a href="register.php">Register</a>
    </p>
  </div>

  <?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $password = $_POST["password"]; 

  // tanpa hash, cocokkan langsung
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();

      if ($user['role'] === 'admin') {
        echo "<p style='color:green; text-align:center;'>Login Berhasil Admin</p>";
        echo "<script>
                setTimeout(function() {
                  window.location.href = 'admin_dashboard.php';
                }, 2000);
              </script>";
        exit;
      } else {
        echo "<p style='color:green; text-align:center;'>Login Berhasil </p>";
        echo "<script>
                setTimeout(function() {
                  window.location.href = 'user_dashboard.php';
                }, 2000);
              </script>";
        exit;
      }
  } else {
      echo "<p style='color:red; text-align:center;'>Login gagal. Username atau password salah.</p>";
  }
}
?>

  <script src="script.js"></script>
</body>
</html>
