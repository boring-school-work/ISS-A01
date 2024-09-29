<?php

// Hash a given password string
function custom_hash_password($password) {
    $salt = "my_custom_salt"; // Static salt (can be improved by making it dynamic per user)
    $saltedPassword = $password . $salt;
    $hash = "";

    // Simple custom hashing using character manipulation
    for ($i = 0; $i < strlen($saltedPassword); $i++) {
        // XOR with salt length
        $char = ord($saltedPassword[$i]) ^ strlen($salt);

        // Bitwise shift to add more variation
        $char = (($char << 3) | ($char >> 5)) & 255;

        // Adding to final hash string
        $hash .= chr($char);
    }

    // Return base64 representation of hash for easier handling
    return custom_base64_encode($hash);
}

// Verify a given string against a hashed password
function custom_verify_hash($password, $hash) {
    // Rehash the input password
    $computedHash = custom_hash_password($password);

    // Compare hashes in a time-safe manner
    if (strlen($computedHash) !== strlen($hash)) {
        return false;
    }

    $isMatch = true;
    for ($i = 0; $i < strlen($computedHash); $i++) {
        if ($computedHash[$i] !== $hash[$i]) {
            $isMatch = false;
        }
    }

    return $isMatch;
}

// Custom base64 encoding function
function custom_base64_encode($input) {
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
    $output = "";
    $paddingChar = "=";
    $inputLength = strlen($input);

    // Loop through the input 3 bytes at a time
    for ($i = 0; $i < $inputLength; $i += 3) {
        $byte1 = ord($input[$i]);
        $byte2 = ($i + 1 < $inputLength) ? ord($input[$i + 1]) : 0;
        $byte3 = ($i + 2 < $inputLength) ? ord($input[$i + 2]) : 0;

        // Create the 4 segments of 6 bits each
        $enc1 = $byte1 >> 2;
        $enc2 = (($byte1 & 3) << 4) | ($byte2 >> 4);
        $enc3 = (($byte2 & 15) << 2) | ($byte3 >> 6);
        $enc4 = $byte3 & 63;

        // Add padding if necessary
        if ($i + 1 >= $inputLength) {
            $enc3 = 64;
        }
        if ($i + 2 >= $inputLength) {
            $enc4 = 64;
        }

        // Append encoded characters to output
        $output .= $chars[$enc1];
        $output .= $chars[$enc2];
        $output .= ($enc3 == 64) ? $paddingChar : $chars[$enc3];
        $output .= ($enc4 == 64) ? $paddingChar : $chars[$enc4];
    }

    return $output;
}

// Example usage
$password = "my_secure_password";
$hashedPassword = custom_hash_password($password);
echo "Hashed Password: " . $hashedPassword . "\n";

$isVerified = custom_verify_hash($password, $hashedPassword);
echo "Password Verified: " . ($isVerified ? "True" : "False") . "\n";

