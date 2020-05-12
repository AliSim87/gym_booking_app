<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Rockdale Gym | Profile Settings</title>
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
                    <div class="sidebar-brand-text mx-3">
                        <span>Rockdale Gym</span>
                    </div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="nav navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="dashboard.php">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="profile.php"><i
                                class="fas fa-user"></i><span>Profile</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="classes.php"><i
                                class="fas fa-table"></i><span>Classes</span></a></li>

                    <!-- eidt by  luguangfu Fix menu errors-->
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
                                <div class="nav-item dropdown no-arrow">
                                    <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false"
                                        href="#">
                                        <span
                                            class="d-none d-lg-inline mr-2 text-gray-600 small"><?= $_SESSION['name'] ?>
                                        </span>
                                        <img class="border rounded-circle img-profile"
                                            src="../assets/img/avatars/avatar1.jpeg">
                                    </a>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu">
                                        <a class="dropdown-item" role="presentation" href="profile.php">
                                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400">
                                            </i>&nbsp;Profile</a>
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
                    <h3 class="text-dark mb-4"><?= $_SESSION['name'] ?></h3>

                    <div class="form-group">
                        <a href="#" id="editButton" class="btn btn-info" data-toggle="modal" data-target="#editModal">
                            user Settings
                        </a>
                    </div>


                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body text-center shadow">
                                    <img class="rounded-circle mb-3 mt-4" src=".../assets/img/dogs/image2.jpeg"
                                        id="myPhoto" width="160" height="160">
                                </div>
                            </div>
                            <div class="card shadow mb-4"></div>
                        </div>



                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-body" style="height:240px">
                                            <form class="form-group">

                                                <div class="form-group">
                                                    <label for="username"><strong>Username</strong></label>
                                                    <input class="form-control" type="text" placeholder="username"
                                                        name="username" id="username">
                                                </div>
                                                <div class="form-group">
                                                    <label for="email"><strong>Email Address</strong></label>
                                                    <input class="form-control" type="email"
                                                        placeholder="user@example.com" name="email" id="email">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-5"></div>
                </div>
            </div>



            <!--   edit by   luguangfu  Modal page for user to modifyinformation -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <spanaria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="editModalLabel"></h4>
                        </div>
                        <div class="modal-body">
                            <form action="user.php?do=edit" method="POST" enctype="multipart/form-data">
                                <div class="form-group">

                                    <label>username</label>
                                    <input type="text" id="editModalusername" name="editModalusername"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" id="editModalemail" name="editModalemail" class="form-control">
                                </div>

                                <div class="form-group text-left">
                                    <label>upload the photo</label>
                                    <input type="file" id="editModalInputFile" name="editModalInputFile">
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="editModalButton" name="editModalButton"
                                        class="btn btn-info">submit</button>
                                </div>
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
        </div>
        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="../assets/js/theme.js"></script>
    <!--   edit by   luguangfu  Initialize user information page -->
    <script>
    var url = "user.php?do=initProfile";
    var data = {};
    $.getJSON(url, data, function(res) {
        $("#username").val(res.username);
        $("#email").val(res.email);
        $('#myPhoto').attr("src", res.photo);
    })
    </script>
</body>

</html>