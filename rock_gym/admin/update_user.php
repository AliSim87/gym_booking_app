<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE accounts SET username = ?, email = ? WHERE id = ?');
        $stmt->execute([$username, $email, $_GET['id']]);
        $msg = 'Updated Successfully!';
        //User is redirected back to the users page
        header('Location: viewusers.php');
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$account) {
        exit('Account doesn\'t exist with that ID!');
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
    <div class="content update">
        <h2>Update <?=$account['username']?>'s Account</h2>
        <form action="update_user.php?id=<?=$account['id']?>" method="post">
            <label for="username">Name</label>
            <input type="text" name="username" placeholder="username" value="<?=$account['username']?>" id="username">
            <label for="email">Email</label>
            <input type="text" name="email" placeholder="E-mail" value="<?=$account['email']?>" id="email">
            <input type="submit" value="Update">
        </form>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php endif; ?>
    </div>