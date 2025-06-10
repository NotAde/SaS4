<?php
session_start(); // ⛔ WAJIB di baris pertama sebelum ada output HTML

include 'koneksi.php';

$loginError = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $password = $_POST["password"]; 

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['user_id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['role'] = $user['role'];

      $redirect = ($user['role'] === 'admin') ? 'server.php' : 'server.php'; // Bisa beda halaman
      header("Location: $redirect");
      exit;
    } else {
      $loginError = "Password salah.";
    }
  } else {
    $loginError = "Email tidak ditemukan.";
  }
}
?>

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

    <?php if (!empty($loginError)) : ?>
      <p style="color: red; text-align:center;"><?= $loginError ?></p>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="input-container">
        <label for="Email">Email</label>
        <input type="email" name="email" placeholder="Enter Email" required />
      </div>

      <div class="input-container">
        <label for="Password">Password</label>
        <input type="password" name="password" placeholder="Enter Password" required />
      </div>

      <div class="forgot-password">
        <a href="lupa-pass.php">Forgot Password?</a>
      </div>

      <input type="submit" value="Login" />
    </form>

    <p class="bottom-text">
      Don't have an account? <a href="Reg.php">Register</a>
    </p>
  </div>

  <script src="script.js"></script>
</body>
</html>
