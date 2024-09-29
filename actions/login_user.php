<?php

session_start();
require '../settings/connection.php';

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

  // create sessions
  $_SESSION['user_id'] = $result['id'];
  $_SESSION['username'] = $result['username'];

  $conn->close();
  // route to dashboard
  header("Location: ./../view/home");
}
