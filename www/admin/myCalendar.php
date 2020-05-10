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
$user_level = $_SESSION['user_level'];


if ($user_level == 'user') {
    $sql = "SELECT users.id,title, STR_TO_DATE(DATE,'%d/%m/%y') AS  DATE ,start_time,bookings.classid as classid FROM bookings JOIN users ON bookings.userid = users.id JOIN classes ON bookings.classid = classes.id WHERE userid = $user_id";
} else {
    $sql = "SELECT users.id,title, STR_TO_DATE(DATE,'%d/%m/%y') AS  DATE ,start_time,bookings.classid as classid FROM bookings JOIN users ON bookings.userid = users.id JOIN classes ON bookings.classid = classes.id ";
};

//echo  $sql;
try {
    if ($result = mysqli_query($db, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $data[] = array(
                    'title' => $row['title'], //Event title
                    'url' => 'calendarview.php?id=' . $row['classid'], //Event url
                    //Event start time
                    'start' =>  $row['DATE'] . 'T' . date('H:i', $row['start_time']),
                );
            }
            //Return json
            echo json_encode($data);
        }
    }
} catch (PDOException $ex) {
    echo 'error message：' . $ex->getMessage(), '<br>';
    echo 'error file' . $ex->getFile(), '<br>';
    echo 'Wrong line number:' . $ex->getLine();
}