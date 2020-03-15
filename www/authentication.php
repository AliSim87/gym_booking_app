<?php include("../dbconnect.php");

$username = $_POST['username'];
$password = $_POST['password'];

//Check form has data
if ( !isset($username, $password) ) {
    die ('Please fill both the username and password field!');
}

$stmt = $db->prepare("SELECT id, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $password);
    $stmt->fetch();
    if ($_POST['password'] === $password) {
        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $_POST['username'];
        $_SESSION['id'] = $id;
        echo 'Welcome ' . $_SESSION['name'] . '!';
    } else {
        echo 'Incorrect password!';
    }
} else {
    echo 'Incorrect username!';
}

$stmt->close();
