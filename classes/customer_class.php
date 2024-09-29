<?php
require_once(__DIR__ . '/../settings/connection.php');
require '../settings/pwd_hasher.php';

class User
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    public function register($firstName, $lastName, $email, $contactNumber, $passwd, $country, $city, $userRole, $profilePicture)
    {
        try {
            $query = "INSERT INTO users (first_name, last_name, email, contact_number, passwd, country, city, user_role, profile_picture)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($query);
            $hashedPassword = password_hash($passwd, PASSWORD_DEFAULT);

            $stmt->bind_param("sssssssis", $firstName, $lastName, $email, $contactNumber, $hashedPassword, $country, $city, $userRole, $profilePicture);

            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error in User::register: " . $e->getMessage());
            return false;
        }
    }

    // public function login($email, $passwd)
    // {
    //     try {
    //         $query = "SELECT * FROM users WHERE email = ?";
    //         $stmt = $this->conn->prepare($query);
    //         $stmt->bind_param("s", $email);
    //         $stmt->execute();
    //         $result = $stmt->get_result();

            
    //         if ($result->num_rows > 0) {
    //             $user = $result->fetch_assoc();

    //             if (password_verify($passwd, $user['passwd'])) {
    //                 return $user;
    //             }else{
    //                 return "Password is incorrect";
    //             }
    //         }
    //         return "User not found";
    //     } catch (Exception $e) {
    //         error_log("Error in User::login: " . $e->getMessage());
    //         return false;
    //     }
    // }


    public function login($email, $passwd)
    {
        try {
            $query = "SELECT * FROM users WHERE email = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                if (password_verify($passwd, $user['passwd'])) {
                    // Password is correct, return user data without password
                    unset($user['passwd']);
                    return $user;
                } else {
                    return false; // Password is incorrect
                }
            }
            return false; // User not found
        } catch (Exception $e) {
            error_log("Error in User::login: " . $e->getMessage());
            return false;
        }
    }

}



