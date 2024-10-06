<?php
session_start();
require '../settings/connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use phpmailer\phpmailer\Exception;

require "../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $conn->real_escape_string($_POST['username']);
  $passwd = $conn->real_escape_string($_POST['passwd']);

  $query = "SELECT * FROM users WHERE username='$username'";
  $row = $conn->query($query);
  $result = $row->fetch_assoc();

  // check if there is a record matching the username or password is valid
  if ($result == null || !password_verify($passwd, $result['passwd'])) {
    header("Location: ../?error=" . urlencode("incorrect username or password"));
    exit();
  }

  // generate and send otp
  $otp = rand(10000, 99999);
  if (!sendOTP($result['email'], $otp)) {
    header("Location: ../?error=" . urlencode("unable to send otp verification, try again."));
    exit();
  }

  // create sessions
  $_SESSION['user_id'] = $result['id'];
  $_SESSION['username'] = $result['username'];
  $_SESSION['otp'] = $otp;
  $_SESSION['send_time'] = time();

  $conn->close();
  // route to verify otp page
  header("Location: ./../view/otp");
  exit();
}

function sendOTP($email, $otp)
{
  $mailer = new PHPMailer(true);
  try {
    $mailer->isSMTP();
    $mailer->Host = $_ENV['SMTP_CLIENT'];
    $mailer->SMTPAuth = true;
    $mailer->Username = $_ENV['SMTP_SENDER'];
    $mailer->Password = $_ENV['SMTP_PASS'];
    $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mailer->Port = $_ENV['SMTP_PORT'];

    $mailer->setFrom($_ENV['SMTP_SENDER'], "Gifter OTP");
    $mailer->addAddress($email);

    $mailer->isHTML(true);
    $mailer->Subject = "Gifter OTP Verification";
    $mailer->Body = "Your OTP verification code is " . $otp . ". It will expire in 3 minutes.";

    $mailer->send();
  } catch (Exception $e) {
    error_log($e->getMessage());
    return false;
  }

  return true;
}
