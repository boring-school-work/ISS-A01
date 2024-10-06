<?php
session_start();

if (isExpired()) {
  header("Location: ../?error=" . urlencode("Your otp has expired, try again."));
  exit();
}

if ($_SESSION['otp'] == $_POST['otp']) {
  $_SESSION['logged_in'] = true;
  header("Location: ./../view/home");
  exit();
}

function isExpired()
{
  if (isset($_SESSION['send_time'])) {
    $current_time = time();
    $time_elapsed = $current_time - $_SESSION['send_time'];

    if ($time_elapsed > (60 * 3)) {
      session_destroy();
      return true;
    }
  } else {
    return true;
  }

  return false;
}
