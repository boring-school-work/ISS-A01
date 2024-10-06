<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - GIFTIER</title>
  <link rel="stylesheet" href="../css/register_style.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
  <div id="registerBox">
    <div id="titlehead">
      <p>Get started with</p>
      <h1>Giftier</h1>
      <?php
      echo "<p style='color:red;'>" . $_GET['error'] . "</p>";
      ?>
    </div>
    <form id="registerForm" action="../actions/register_user.php" method="POST">
      <div class="group">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required placeholder="Richard">
        </div>
        <div class="form-group">
          <label for="email">Email </label>
          <input type="email" id="email" name="email" pattern="^[a-z._\-0-9]*[@][a-z]*.(?:...com)$" required
            placeholder="you@giftier.com">
        </div>
      </div>

      <div class="group">
        <div class="form-group">
          <label for="password">Password</label>
          <input
            type="password"
            id="password"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            name="passwd"
            required
            placeholder="********">
        </div>
        <div class="form-group">
          <label for="password">Confirm Password</label>
          <input
            type="password"
            id="repassword"
            name="repassword"
            required
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            placeholder="********">
        </div>
      </div>

      <div id="terms" class="form-group">
        <input type="checkbox" id="terms-checkbox" name="terms" required>
        <label for="terms-checkbox">I agree to the terms and conditions</label>
      </div>
      <div id="submitRegister">
        <button type="submit">Register</button>
      </div>
    </form>
    <p>Already have an account? <a href="../">Login</a></p>
  </div>

  <script src="../js/registration-validation-script.js"></script>
</body>

</html>
