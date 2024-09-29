<?php
require '../settings/connection.php';

$username = $conn->real_escape_string($_POST['username']);

// check if username exists in database
$query = "SELECT count(username) as value FROM users WHERE username= '$username'";
$result = $conn->query($query)->fetch_assoc();
if ($result['value'] == 1) {
  header("Location: ../register?error=" .
    urlencode("username already exists, try again!"));
  exit();
}

$email = $conn->real_escape_string($_POST['email']);

// check if email exists in database
$query = "SELECT count(email) as value FROM users WHERE email= '$email'";
$result = $conn->query($query)->fetch_assoc();
if ($result['value'] == 1) {
  header("Location: ../register?error=" .
    urlencode("email already exists, try again!"));
  exit();
}

$passwd = $_POST['passwd'];
$repasswd = $_POST['repassword'];

if ($passwd != $repasswd) {
  header("Location: ../register?error=" .
    urlencode("Passwords do not match."));
  exit();
}

// hash password
$passwd = password_hash($passwd, PASSWORD_BCRYPT);
$passwd = $conn->real_escape_string($passwd);

// start transaction
mysqli_begin_transaction($conn);

// insert values into users table
try {
  // prepare the query
  $query = mysqli_prepare(
    $conn,
    "INSERT INTO users(username, email, passwd) VALUES(?, ?, ?)"
  );

  // bind the parameters
  mysqli_stmt_bind_param($query, "sss", $username, $email, $passwd);

  // execute the query
  mysqli_stmt_execute($query);

  // commit the transaction
  mysqli_commit($conn);
} catch (mysqli_sql_exception $e) {
  mysqli_rollback($conn);
  exit();
}

$conn->close();

// redirect to login page after registration
echo "Registration successful!" . "<br>";
echo "Redirecting to login page in 3 seconds...";
header("refresh:3; url=../");
