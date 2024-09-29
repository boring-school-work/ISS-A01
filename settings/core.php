<?php
//start session
session_start();

//for header redirection
ob_start();

//funtion to check for login
function is_logged_in()
{
  if (isset($_SESSION['user_id'])) {
    return true;
  }

  return false;
}
