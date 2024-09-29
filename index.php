<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giftier Login</title>
  <link rel="stylesheet" href="./css/login_style.css">
</head>

<body>
  <div id=loginBox>
    <h1 id="loginTitle">Giftier</h1>
    <?php
    echo "<p style='color:red;'>" . $_GET['error'] . "</p>";
    ?>
    <form action="actions/login_user.php" method="post" id="loginForm">
      <input type="text" id="formUsername" name="username" placeholder="username">
      <input type="password" id="formPassword" name="passwd" placeholder="********">
      <button id="formSubmit" type="submit">Login</button>
    </form>
    <p id="loginSubtitle">Don't have an account? <a href="./register">Register</a></p>


  </div>

</body>

</html>
