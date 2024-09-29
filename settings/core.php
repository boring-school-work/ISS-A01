<?php
//start session
session_start(); 

//for header redirection
ob_start();

//funtion to check for login
function is_logged_in(){
    if(isset($_SESSION['user_id'])){
        return true;
    }else{
        header('Location: ../index.html');
    }
}


//function to get user ID
function get_user_id(){
    return $_SESSION['user_id'];
}

//function to check for role (admin, customer, etc)
function get_user_role(){
    return $_SESSION['user_role'];
}



?>