<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$account) {
        exit('Account doesn\'t exist with that ID!');
    }
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM accounts WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the account!';
            //User is redirected back to the users page
            header('Location: viewusers.php');
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: viewusers.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="../css/crud.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<div class="content delete">
    <h2>Delete <?=$account['username']?></h2>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php else: ?>
        <p>Are you sure you want to delete <?=$account['username']?>?</p>
        <div class="yesno">
            <a href="delete.php?id=<?=$account['id']?>&confirm=yes">Yes</a>
            <a href="delete.php?id=<?=$account['id']?>&confirm=no">No</a>
        </div>
    <?php endif; ?>
</div>