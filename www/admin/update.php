<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.html');
    exit;
} elseif ($_SESSION['user_level'] != 'instructor' && $_SESSION['user_level'] != 'admin') {
    header('Location: ../index.html');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard | Rockdale Gym</title>
    <meta name="description"
          content="Join Rockdale today to achieve your fitness goals! Everybody is Welcome - Join today!">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">

</head>
<style>
    .bg-gradient-primary {
        background-image: linear-gradient(180deg, #ce493de3 10%, #336ad0a6) !important;
        background-size: cover;
    }

    .bg-white {
        background-color: #e2e2e285 !important;
    }
</style>
<body id="page-top">
<div id="wrapper">
    <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
        <div class="container-fluid d-flex flex-column p-0">
            <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0"
               href="dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15"></div>
                <div class="sidebar-brand-text mx-3"><span>Rockdale Gym</span></div>
            </a>
            <hr class="sidebar-divider my-0">
            <ul class="nav navbar-nav text-light" id="accordionSidebar">
                <li class="nav-item" role="presentation"><a class="nav-link active" href="dashboard.php"><i
                            class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="profile.php"><i
                            class="fas fa-user"></i><span>Profile</span></a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="classes.php"><i
                            class="fas fa-table"></i><span>Classes</span></a></li>
                <?php if ($_SESSION['user_level'] == 'admin') {
                    echo '<li class="nav-item" role="presentation"><a class="nav-link" data-toggle="collapse" href="#collapse1">User Management</a></li><div id="collapse1" class="panel-collapse collapse">
<ul class="list-group">
<li class="nav-item" role="presentation"><a class="nav-link" href="userman/viewusers.php"><i
                                class="fas fa-user"></i><span>See All Users</span></a></li>
        <li class="nav-item" role="presentation"><a class="nav-link" href="userman/adduser.php"><i
                                class="fas fa-user"></i><span>Add User</span></a></li>
      </ul>';
                }; ?>
            </ul>
            <div class="text-center d-none d-md-inline">
                <button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button>
            </div>
        </div>
    </nav>
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                <div class="container-fluid">
                    <button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i
                                class="fas fa-bars"></i></button>
                    <ul class="nav navbar-nav flex-nowrap ml-auto">
                        <div class="d-none d-sm-block topbar-divider"></div>
                        <li class="nav-item dropdown no-arrow" role="presentation">
                            <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link"
                                                                       data-toggle="dropdown" aria-expanded="false"
                                                                       href="#"><span
                                            class="d-none d-lg-inline mr-2 text-gray-600 small"><?= $_SESSION['name'] ?></span><img
                                            class="border rounded-circle img-profile"
                                            src="../assets/img/avatars/avatar1.jpeg"></a>
                                <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu"><a
                                            class="dropdown-item" role="presentation" href="profile.php"><i
                                                class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" role="presentation" href="logout.php"><i
                                                class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container-fluid">
                <?php
                $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

                include '../../dbconnect.php';

                try {
                    $sql = "SELECT * FROM classes WHERE id = ? LIMIT 0,1";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();

                    $title = $row['title'];
                    $date = $row['date'];
                    $start_time = $row['start_time'];
                    $duration = $row['duration'];
                    $instructor = $row['instructor'];
                    $cost = $row['cost'];
                    $details = $row['details'];
                } catch (PDOException $exception) {
                    die('ERROR: ' . $exception->getMessage());
                }

                if ($_POST) {

                    try {

                        $sql = "UPDATE classes SET title=?, date=?, start_time=?, duration=?, cost=?, details=? WHERE id = $id";

                        if ($stmt = mysqli_prepare($db, $sql)) {
                            mysqli_stmt_bind_param($stmt, "sssiis", $param_title, $param_date, $param_start_time, $param_duration, $param_cost, $param_details);
                            $param_title = htmlspecialchars(strip_tags($_POST['title']));
                            $param_date = htmlspecialchars(strip_tags($_POST['date']));
                            $param_start_time = htmlspecialchars(strip_tags($_POST['start_time']));
                            $param_duration = htmlspecialchars(strip_tags($_POST['duration']));
                            $param_cost = htmlspecialchars(strip_tags($_POST['cost']));
                            $param_details = htmlspecialchars(strip_tags($_POST['details']));

                            if (mysqli_stmt_execute($stmt)) {
                                echo "<div class='alert alert-success'>Record was update.</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Unable to update record.</div>";
                            }
                        }


                    } catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
                ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
                    <table class='table table-hover table-responsive table-bordered'>
                        <tr>
                            <td>Title</td>
                            <td><input type='text' name='title'
                                       value="<?php echo htmlspecialchars($row['title'], ENT_QUOTES); ?>"
                                       class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Date (Please Use Format DD/MM/YYYY)</td>
                            <td><input type='text' name='date'
                                       value="<?php echo htmlspecialchars($row['date'], ENT_QUOTES); ?>"
                                       class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Start Time (Please use 24H)</td>
                            <td><input type='text' name='start_time'
                                       value="<?php echo htmlspecialchars($row['start_time'], ENT_QUOTES); ?>"
                                       class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Duration</td>
                            <td><input type='number' name='duration'
                                       value="<?php echo htmlspecialchars($row['duration'], ENT_QUOTES); ?>"
                                       class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Instructor</td>
                            <td><?php echo htmlspecialchars($row['instructor'], ENT_QUOTES); ?></td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td>&#163;<input type='number' name='cost'
                                             value="<?php echo htmlspecialchars($row['cost'], ENT_QUOTES); ?>"
                                             class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Details</td>
                            <td><input type='text' name='details'
                                       value="<?php echo htmlspecialchars($row['details'], ENT_QUOTES); ?>"
                                       class="form-control"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type='submit' value='Save Changes' class='btn btn-primary'/>
                                <a href='manageclasses.php' class='btn btn-danger'>Back to classes</a>
                            </td>
                        </tr>
                    </table>
                </form>

            </div>

        </div>
    </div>
</div>
<footer class="bg-white sticky-footer">
    <div class="container my-auto">
        <div class="text-center my-auto copyright"><span>Copyright © Rockdale Gym 2020</span></div>
    </div>
</footer>
</div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="../assets/js/theme.js"></script>
</body>
</html>
