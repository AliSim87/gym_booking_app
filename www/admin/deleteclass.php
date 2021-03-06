<?php
include '../../dbconnect.php';

try {
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

    $query = "DELETE FROM classes WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: classes.php?action=deleted');
    } else {
        die('Unable to delete record.');
    }
} catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
?>