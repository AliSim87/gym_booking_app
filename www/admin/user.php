<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../login.html');
    exit;
}
include '../../dbconnect.php';

$user_id = $_SESSION['id'];

$do = $_GET['do'];

switch ($do) {
        // User login
    case "initProfile":
        try {
            $sql = "SELECT username,email,photo FROM users  WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            // echo        $sql;
            echo json_encode($row);
        } catch (PDOException $ex) {
            echo 'error message：' . $ex->getMessage(), '<br>';
            echo 'error file' . $ex->getFile(), '<br>';
            echo 'Wrong line number:' . $ex->getLine();
        }
        break;
        //User Register
    case "edit":
        try {

            $updatesql = "update users  set username=? ,email= ? ,photo= ?  where   id = ?";
            $stmt = $db->prepare($updatesql);
            $stmt->bind_param("sssi", $editModalusername, $editModalemail,  $new_filename, $user_id);

            $filename = $_FILES['editModalInputFile']['name'];
            //Get file temporary path
            $temp_name = $_FILES['editModalInputFile']['tmp_name'];
            //Check whether the path to store the uploaded file exists. If not, create a new directory
            if (!file_exists('uploads')) {
                mkdir('uploads');
            }
            //Create a new name for the uploaded file to ensure more security
            $new_filename = "uploads/" . date('YmdHis', time()) . rand(100, 1000) . $filename;
            //Move files from temporary path to disk
            $flag = move_uploaded_file($temp_name, $new_filename);
            //echo   $flag . "<br/>";
            $editModalusername = $_POST['editModalusername'];
            $editModalemail = $_POST['editModalemail'];

            $stmt->execute();
            header('Location: profile.php');
        } catch (PDOException $ex) {
            echo 'error message：' . $ex->getMessage(), '<br>';
            echo 'error file' . $ex->getFile(), '<br>';
            echo 'Wrong line number:' . $ex->getLine();
        }

        break;
}