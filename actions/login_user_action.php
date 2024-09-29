<?php
// require_once '../controllers/customer_controller.php';
// require '../settings/connection.php';


// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $controller = new UserController();
    
//     // Check if email and password are set
//     if(isset($_POST['email']) && isset($_POST['passwd'])) {
//         $email = $_POST['email'];
//         $passwd = $_POST['passwd'];
// ;
//         $result = $controller->login($email, $passwd);
        
//         if ($result === true) {
//             // Login successful
//             // Redirect based on user role - controller
//             header("Location: ../index.html?login=success");
//             exit();
//         } else {
//             // Login failed
//             header("Location: ../index.html?error=" . urlencode($result));
//             exit();
//         }
//     } else {
//         // Email or password not provided
//         header("Location: ../index.html?error=" . urlencode("Email and password are required."));
//         exit();
//     }
// } else {
//     // If accessed directly without POST data
//     header("Location: ../index.html");
//     exit();
// }





require_once '../controllers/customer_controller.php';
require '../settings/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller = new UserController();
    
    // Check if email and password are set
    if(isset($_POST['email']) && isset($_POST['passwd'])) {
        $email = $_POST['email'];
        $passwd = $_POST['passwd'];
        
        $result = $controller->login($email, $passwd);
        
        if ($result['success']) {
            // Login successful
            if ($result['user_role'] == 1) {
                header("Location: ../view/customers/home_customers.html");
            } else {
                header("Location: ../view/artist/home_artist.html");
            }
            exit();
        } else {
            // Login failed
            header("Location: ../index.html?error=" . urlencode($result['message']));
            exit();
        }
    } else {
        // Email or password not provided
        header("Location: ../index.html?error=" . urlencode("Email and password are required."));
        exit();
    }
} else {
    // If accessed directly without POST data
    header("Location: ../index.html");
    exit();
}

?>


