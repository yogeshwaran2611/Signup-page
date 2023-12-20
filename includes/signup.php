<?php

$info = ['errors' => [], 'success' => false];

// Validate firstname
if (empty($_POST['firstname'])) {
    $info['errors']['firstname'] = "A name is required";
} else if (!preg_match("/^[\p{L}\s]+$/u", $_POST['firstname'])) {
    $info['errors']['firstname'] = "Name can't have special characters or numbers";
}

// Validate email
if (empty($_POST['email'])) {
    $info['errors']['email'] = "An email is required";
} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $info['errors']['email'] = "Email is not valid";
}

// Validate password
if (empty($_POST['password'])) {
    $info['errors']['password'] = "A password is required";
} else if (strlen($_POST['password']) < 8) {
    $info['errors']['password'] = "Password must be at least 8 characters long";
}

if (empty($info['errors'])) {
    // Save to database
    $arr = [
        'firstname' => $_POST['firstname'],
        'email' => $_POST['email'],
        'gender' => '', // Provide a default value if not provided
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'dob' => '', // Leave the date of birth (dob) blank initially
    ];

    // Update database fields with NULL if value is not passed
    db_query("INSERT INTO users (firstname, email, gender, password, dob) VALUES (:firstname, :email, :gender, :password, :dob)", $arr);

    

    $info['success'] = true;
    
}

$jsonFilePath = './database/data.json';
    $existingData = json_decode(file_get_contents($jsonFilePath), true);
    $existingData[] = $arr;
    file_put_contents($jsonFilePath, json_encode($existingData, JSON_PRETTY_PRINT));

    $info['json_update_success'] = true;
