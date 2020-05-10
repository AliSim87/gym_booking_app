<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../login.html');
    exit;
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Rockdale Gym | Classes</title>
    <meta name="description"
        content="Join Rockdale today to achieve your fitness goals! Everybody is Welcome - Join today!">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">

    <script type='text/javascript'>
    // confirm record cancel
    function cancel_class(id) {
        var answer = confirm('Are you sure?');
        if (answer) {
            window.location = 'cancelclass.php?id=' + id;
        }
    }
    </script>
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
                        <button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop"
                            type="button"><i class="fas fa-bars"></i></button>
                        <ul class="nav navbar-nav flex-nowrap ml-auto">
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow" role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link"
                                        data-toggle="dropdown" aria-expanded="false" href="#"><span
                                            class="d-none d-lg-inline mr-2 text-gray-600 small"><?= $_SESSION['name'] ?></span><img
                                            class="border rounded-circle img-profile"
                                            src="../assets/img/avatars/avatar1.jpeg"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu">
                                        <a class="dropdown-item" role="presentation" href="profile.php"><i
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
                        $classid = $row['id'];

                        // echo " $classid=====" . $classid;
                    } catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                    ?>

                    <table class='table table-hover table-responsive table-bordered'>
                        <tr>
                            <td>Title</td>
                            <td><?php echo htmlspecialchars($row['title'], ENT_QUOTES); ?></td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td><?php echo htmlspecialchars($row['date'], ENT_QUOTES); ?></td>
                        </tr>
                        <tr>
                            <td>Start Time</td>
                            <td><?php echo htmlspecialchars($row['start_time'], ENT_QUOTES); ?></td>
                        </tr>
                        <tr>
                            <td>Duration</td>
                            <td><?php echo htmlspecialchars($row['duration'], ENT_QUOTES); ?></td>
                        </tr>
                        <tr>
                            <td>Instructor</td>
                            <td><?php echo htmlspecialchars($row['instructor'], ENT_QUOTES); ?></td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td><?php echo htmlspecialchars($row['cost'], ENT_QUOTES); ?></td>
                        </tr>
                        <tr>
                            <td>Details</td>
                            <td><?php echo htmlspecialchars($row['details'], ENT_QUOTES); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <a href='#' id="cancelclass" class='btn btn-info m-r-1em'>Cancel</a>
                            </td>
                        </tr>
                    </table>
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

    <script>
    var user_level = "<?php echo $_SESSION['user_level']; ?>";

    //If not a user, hide the cancel function
    if (user_level != "user")
        $('#cancelclass').hide();

    $('#cancelclass').on('click', function() {

        var id = "<?php echo $classid; ?>";

        cancel_class(id);
    })
    </script>

</body>

</html>