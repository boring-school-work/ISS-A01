<?php


require '../settings/connection.php'; 
require '../classes/customer_class.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        global $conn;
        $this->userModel = new User($conn);
    }

    public function register($userData)
    {
        // Validate input
        $validationError = $this->validateRegistrationData($userData);
        if ($validationError !== true) {
            return $validationError;
        }

        // Handle file upload
        $profilePicture = $this->handleFileUpload($_FILES['profilePicture']);
        if ($profilePicture === false) {
            return "Error uploading profile picture.";
        }

        // Register user
        $result = $this->userModel->register(
            $userData['firstName'],
            $userData['lastName'],
            $userData['email'],
            $userData['contactNumber'],
            $userData['passwd'],
            $userData['country'],
            $userData['city'],
            $userData['userRole'],
            $profilePicture
        );

        if ($result) {
            // Registration successful
            return true;
        } else {
            return "Error: Registration failed. Please try again.";
        }
    }
// login function 
    // public function login($email, $passwd)
    // {
    //     if(empty($email) || empty($passwd)) {
    //         return "Email and password are required.";
    //     }

    //     $user = $this->userModel->login($email, $passwd);
    //     return $user;

    //     if ($user) {
    //         // Login successful
    //         session_start();
    //         $_SESSION['user_id'] = $user['user_id'];
    //         $_SESSION['user_role'] = $user['user_role'];

    //         if ($user['user_role'] == 1) {
    //             header("Location: ../view/customers/home_customers.html");
    //         } else {
    //             header("Location: ../view/artist/home_artist.html");
    //         }
    //         exit();
    //     }else{
    //         // Login failed
    //         return "Invalid email or password.";
    //     }
        
    // }



    public function login($email, $passwd)
    {
        if (empty($email) || empty($passwd)) {
            return "Email and password are required.";
        }

        $user = $this->userModel->login($email, $passwd);

        if ($user) {
            // Login successful
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_role'] = $user['user_role'];

            return [
                'success' => true,
                'user_role' => $user['user_role']
            ];
        } else {
            // Login failed
            return [
                'success' => false,
                'message' => "Invalid email or password."
            ];
        }
    }


    private function validateRegistrationData($data)
    {
        if (empty($data['firstName']) || empty($data['lastName']) || empty($data['email']) || empty($data['passwd'])) {
            return "All fields are required.";
        }
        if ($data['passwd'] !== $data['repassword']) {
            return "Passwords do not match.";
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format.";
        }
        // Add more validation as needed
        return true;
    }

    private function handleFileUpload($file)
    {
        $target_dir = "../uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if($check === false) {
            return false;
        }
        
        // Check file size
        if ($file["size"] > 500000) { // 500KB limit
            return false;
        }
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            return false;
        }
        
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $target_file;
        } else {
            return false;
        }
    }
}

?>