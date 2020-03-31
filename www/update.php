<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin']) && $_SESSION['user_level'] != 'instructor') {
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

                <?php
                $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

                include '../dbconnect.php';

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