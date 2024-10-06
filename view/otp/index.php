<?php
session_start();
if (!isset($_SESSION['otp'])) {
  header("Location: ./../..");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giftier OTP Verification</title>
  <link rel="stylesheet" href="../../css/login_style.css">
</head>

<body>
  <div id=loginBox>
    <h1 id="loginTitle">Giftier OTP</h1>
    <p style='color:black; padding-bottom: 5px;'>Enter the otp sent to your email</p>
    <?php
    echo "<p style='color:black; padding-bottom: 20px;'>" . $_GET['error'] . "</p>";
    ?>
    <form action="../../actions/verify_otp.php" method="post" id="otpForm">
      <input style="display: flex; margin-bottom: 10px;" type="number" id="otp" name="otp" placeholder="Enter OTP">
      <button id="formSubmit" type="submit">Verify</button>
    </form>
  </div>
</body>

</html>
