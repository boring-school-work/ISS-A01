<?php
//start session
session_start();

//for header redirection
ob_start();

//funtion to check for login
function is_logged_in()
{
  if ($_SESSION['logged_in'] == true) {
    return true;
  }
  return false;
}
