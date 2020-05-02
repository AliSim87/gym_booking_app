<?php
session_start();
include '../../dbconnect.php';

try {
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
    $user_id = $_SESSION['id'];

    $query = "INSERT INTO bookings (userid, classid) VALUES (?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $user_id, $id);

    if ($stmt->execute()) {
        header('Location: classes.php?action=booked');
    } else {
        die('Unable to book class.');
    }
} catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
?>