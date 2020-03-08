<?php include("...\dbconnect.php");

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

//Check form has data
if (!isset($username, $password, $email)) {
    die ('Please complete the registration form');
}

//Check a valid email address has been submitted
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die ('Please enter a valid email address');
}

//Check for invalid characters in username
if (preg_match('/[A-Za-z0-9]', $username) == 0) {
    die ('Username is not valid');
}

//Check password length
if (strlen($password) < 8) {
    die ('Password must more than 8 characters');
}

//Check if account exists using prepared statement
if ($stmt = $db->prepare("SELECT id, password FROM users WHERE username = ?")) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo 'Username already exists';
    } else {
        if ($stmt = $db->prepare("INSERT INTO users (username, password, email)")) {
            $stmt->bind_param("sss", $username, $password, $email);
            $stmt->execute();
            echo 'Registration Successful';
        } else {
            echo 'Something has gone very wrong';
        }
    }
    $stmt->close();
} else {
    echo 'Something has gone very wrong';
}
$stmt->close();

