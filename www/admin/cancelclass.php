<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../login.html');
    exit;
}
include '../../dbconnect.php';

try {
    $classid = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

    $user_id = $_SESSION['id'];

    //edit   by  luguangfu   

    //Delete a reservation by userid and classid

    $query = "DELETE FROM bookings WHERE classid = ?  and  userid=?";
    $stmt = $db->prepare($query);
    // $stmt->bind_param("i", $id);
    $stmt->bind_param("ii", $classid, $user_id);


    if ($stmt->execute()) {
        header('Location: dashboard.php?action=cancelled');
    } else {
        die('Unable to delete record.');
    }
} catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}