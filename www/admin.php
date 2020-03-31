<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Rockdale Gym | Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/nifty.min.css" rel="stylesheet">
    <link href="css/demo/nifty-demo-icons.min.css" rel="stylesheet">
    <link href="plugins/pace/pace.min.css" rel="stylesheet">
    <script src="plugins/pace/pace.min.js"></script>
    <link href="css/themes/type-d/theme-navy.min.css" rel="stylesheet">
    <link href="plugins/morris-js/morris.min.css" rel="stylesheet">

    <script type='text/javascript'>
        // confirm record deletion
        function cancel_class(id) {

            var answer = confirm('Are you sure?');
            if (answer) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'cancelclass.php?id=' + id;
            }
        }
    </script>
</head>

<body class="pace-done">
<div class="pace  pace-inactive">
    <div class="pace-progress" data-progress-text="100%" data-progress="99" style="width: 100%;">
        <div class="pace-progress-inner">
        </div>
    </div>
    <div class="pace-activity">
    </div>
</div>
<div id="container" class="effect aside-float aside-bright mainnav-out slide">
    <!--NAVBAR-->
    <!--===================================================-->
    <header id="navbar">
        <div id="navbar-container" class="boxed">
            <!--Brand logo & name-->
            <!--================================-->
            <div class="navbar-header">
                <a href="admin.php" class="navbar-brand">
                    <img src="img/logo.png" alt="Nifty Logo" class="brand-icon">
                    <div class="brand-title">
                        <span class="brand-text">Rockdale Gym</span>
                    </div>
                </a>
            </div>
            <!--================================-->
            <!--End brand logo & name-->
            <!--Navbar Dropdown-->
            <!--================================-->
            <div class="navbar-content">
                <ul class="nav navbar-top-links">

                    <!--Navigation toogle button-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <li class="tgl-menu-btn">
                        <a class="mainnav-toggle slide" href="#">
                            <i class="demo-pli-list-view"></i>
                        </a>
                    </li>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End Navigation toogle button-->
                    <!--Search-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <li>
                        <div class="custom-search-form">
                            <label class="btn btn-trans" for="search-input" data-toggle="collapse"
                                   data-target="#nav-searchbox">
                                <i class="demo-pli-magnifi-glass"></i>
                            </label>
                            <form>
                                <div class="search-container collapse" id="nav-searchbox">
                                    <input id="search-input" type="text" class="form-control"
                                           placeholder="Type for search...">
                                </div>
                            </form>
                        </div>
                    </li>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End Search-->
                </ul>
                <ul class="nav navbar-top-links">
                    <!--User dropdown-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <li id="dropdown-user" class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                                <span class="ic-user pull-right">
                                    <i class="demo-pli-male"></i>
                                </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right panel-default">
                            <ul class="head-list">
                                <li>
                                    <a href="profile.php"><i class="demo-pli-male icon-lg icon-fw"></i> Profile</a>
                                </li>
                                <li>
                                    <a href="logout.php"><i class="demo-pli-unlock icon-lg icon-fw"></i>
                                        Logout</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <div class="username hidden-xs"><?= $_SESSION['name'] ?></div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End user dropdown-->
                </ul>
            </div>
            <!--================================-->
            <!--End Navbar Dropdown-->
        </div>
    </header>
    <!--===================================================-->
    <!--END NAVBAR-->
    <div class="boxed">
        <!--CONTENT CONTAINER-->
        <!--===================================================-->
        <div id="content-container">
            <div id="page-head">
                <hr class="new-section-sm bord-no">
                <div class="text-center">
                    <h3>Welcome back <?= $_SESSION['name'] ?>!</h3>
                    <p>What would you like to do today?</p>
                </div>
            </div>
            <!--Page content-->
            <!--===================================================-->
            <div id="page-content">
                <div class="row">
                    <div class="col-md-2 col-md-offset-3">
                        <div class="panel">
                            <div class="panel-body text-center">
                                <div class="pad-ver mar-top text-main"><i
                                            class="demo-pli-data-settings icon-4x"></i></div>
                                <p class="text-lg text-semibold mar-no text-main">View Classes</p>
                                <p class="text-sm">View available classes here</p>
                                <button onclick="window.location.href = 'viewclasses.php';"
                                        class="btn btn-primary mar-ver">View Classes
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                    </div>
                    <?php
                    if ($_SESSION['user_level'] != 'user') {
                        echo '<div class="col-md-2">
                       <div class="panel">
                            <div class="panel-body text-center">
                                <div class="pad-ver mar-top text-main"><i class="demo-pli-consulting icon-4x"></i>
                                </div>
                                <p class="text-lg text-semibold mar-no text-main">Manage Classes</p>
                                <p class="text-sm">Add, edit, remove classes here</p>
                                <button onclick=window.location.href="manageclasses.php" class="btn btn-primary mar-ver">Manage Classes
                                </button>
                            </div>
                        </div>
                   </div>';
                    }?>
                </div>
                <div class="row">

                        <div id="page-head">
                            <hr class="new-section-sm bord-no">
                            <div class="text-center">
                                <h1>Booked Classes</h1>
                            </div>
                        </div>
                    <?php
                    include '../dbconnect.php';

                    $action = isset($_GET['action']) ? $_GET['action'] : "";

                    if ($action == 'cancelled') {
                        echo "<div class='alert alert-success'>Class was cancelled.</div>";
                    }

                    $user_id = $_SESSION['id'];

                    $sql = "SELECT * FROM bookings JOIN users ON bookings.userid = users.id JOIN classes ON bookings.classid = classes.id WHERE userid = $user_id";
                    if ($result = mysqli_query($db, $sql)) {
                        if (mysqli_num_rows($result) > 0) {

                            echo "<table class='table table-hover table-responsive table-bordered'>";

                            echo "<tr>";
                            echo "<th>Title</th>";
                            echo "<th>Date</th>";
                            echo "<th>Start Time</th>";
                            echo "<th>Duration</th>";
                            echo "<th>Instructor</th>";
                            echo "<th>Cost</th>";
                            echo "</tr>";


                            while ($row = mysqli_fetch_array($result)) {
                                extract($row);

                                echo "<tr>";
                                echo "<td>{$title}</td>";
                                echo "<td>{$date}</td>";
                                echo "<td>{$start_time}</td>";
                                echo "<td>{$duration}</td>";
                                echo "<td>{$instructor}</td>";
                                echo "<td>&#163;{$cost}</td>";
                                echo "<td>";
                                echo "<a href='viewaclass.php?id={$classid}' class='btn btn-info m-r-1em'>More Information</a>";
                                echo "<a href='#' onclick='cancel_class({$bookingnumber})' class='btn btn-info m-r-1em'>Cancel</a>";
                                echo "</td>";
                                echo "</tr>";
                            }

// end table
                            echo "</table>";

                            mysqli_free_result($result);
                        } else {
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else {
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
                    }

                    mysqli_close($db);
                    ?>
                </div>
            <!--===================================================-->
            <!--End page content-->
        </div>
        <!--===================================================-->
        <!--END CONTENT CONTAINER-->
        <!--MAIN NAVIGATION-->
        <!--===================================================-->
        <nav id="mainnav-container">
            <div id="mainnav">
                <!--Menu-->
                <!--================================-->
                <div id="mainnav-menu-wrap">
                    <div class="nano">
                        <div class="nano-content">
                            <!--Profile Widget-->
                            <!--================================-->
                            <div id="mainnav-profile" class="mainnav-profile">
                                <div class="profile-wrap text-center">
                                    <div class="pad-btm">
                                        <img class="img-circle img-md" src="img/profile-photos/1.png"
                                             alt="Profile Picture">
                                    </div>
                                    <a href="#profile-nav" class="box-block" data-toggle="collapse"
                                       aria-expanded="false">
                                            <span class="pull-right dropdown-toggle">
                                            </span>
                                        <p class="mnp-name"><?= $_SESSION['name'] ?></p>
                                    </a>
                                </div>
                            </div>
                            <ul id="mainnav-menu" class="list-group">
                                <!--Menu list item-->
                                <li class="active-sub">
                                    <a href="admin.php">
                                        <i class="demo-pli-home"></i>
                                        <span class="menu-title">Dashboard</span>
                                    </a>
                                    <!--Menu list item-->
                                <li>
                                    <a href="classes.php">
                                        <i class="demo-pli-split-vertical-2"></i>
                                        <span class="menu-title">Classes</span>
                                        <i class="arrow"></i>
                                    </a>
                                    <!--Submenu-->
                                    <ul class="collapse">
                                        <li><a href="layouts-collapsed-navigation.html">Class Calendar</a></li>
                                    </ul>
                                </li>
                                <!--Menu list item-->
                                <li>
                                    <a href="#">
                                        <i class="demo-pli-warning-window"></i>
                                        <span class="menu-title">Instructors</span>
                                        <i class="arrow"></i>
                                    </a>
                                    <!--Submenu-->
                                    <ul class="collapse">
                                        <li><a href="grid-bootstrap.html">View Instructors</a></li>
                                    </ul>
                                </li>
                                <!--Menu list item-->
                                <li>
                                    <a href="#">
                                        <i class="demo-pli-warning-window"></i>
                                        <span class="menu-title">Member</span>
                                        <i class="arrow"></i>
                                    </a>
                                    <!--Submenu-->
                                    <ul class="collapse">
                                        <li><a href="grid-bootstrap.html">View Members</a></li>
                                    </ul>
                                </li>
                        </div>
                    </div>
                </div>
                <!--================================-->
                <!--End menu-->
            </div>
        </nav>
        <!--===================================================-->
        <!--END MAIN NAVIGATION-->
    </div>
    <!-- FOOTER -->
    <!--===================================================-->
    <footer id="footer">
        <div class="hide-fixed pull-right pad-rgt">
            <p>All Rights Reserved</p>
        </div>
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- Remove the class "show-fixed" and "hide-fixed" to make the content always appears. -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <p class="pad-lft">© 2020 Rockdale Gym</p>
    </footer>
    <!--===================================================-->
    <!-- END FOOTER -->
    <!-- SCROLL PAGE BUTTON -->
    <!--===================================================-->
    <button class="scroll-top btn">
        <i class="pci-chevron chevron-up"></i>
    </button>
    <!--===================================================-->
    <div class="mainnav-backdrop"></div>
</div>
<!--===================================================-->
<!-- END OF CONTAINER -->
<!--JAVASCRIPT-->
<!--=================================================-->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/nifty.min.js"></script>
<!--=================================================-->
<script src="plugins/morris-js/morris.min.js"></script>
<script src="plugins/morris-js/raphael-js/raphael.min.js"></script>
</body>
</html>