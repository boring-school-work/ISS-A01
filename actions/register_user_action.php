<?php
require '../controllers/customer_controller.php';
require '../settings/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller = new UserController();
    
    $result = $controller->register($_POST);
    
    if ($result === true) {
        // Registration successful
        header("Location: ../index.html?registration=success");
        exit();
    } else {
        // Registration failed
        header("Location: ../view/register.html?error=" . urlencode($result));
        exit();
    }
} else {
    // If accessed directly without POST data
    header("Location: ../view/register.html");
    exit();
}

?>