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
    <title>Dashboard | Rockdale Gym</title>
    <meta name="description"
        content="Join Rockdale today to achieve your fitness goals! Everybody is Welcome - Join today!">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
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
                    <h3 class="text-dark mb-1">Welcome back <?= $_SESSION['name'] ?>!</h3>
                    <p> Thank so much for being a part of Rockdale Gym!</p>



                    <!-- edit by luguangfu -->

                    <!-- <p><img src="../img/thanks.jpg" height="650" width="800"></p> -->
                </div>

                <!-- edit by luguangfu -->

                <!-- <div class="container-fluid">
                <?php if ($_SESSION['user_level'] == 'user') {
                    echo "<h3 class='text-dark mb-1' > Upcoming Classes </h3>";

                    include '../../dbconnect.php';

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
                                echo "<a style='margin-right: 5px;' href='viewaclass.php?id={$classid}' class='btn btn-info m-r-1em'>More Information</a>";
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
                }
                ?>
            </div> -->



                <!-- edit by luguangfu -->

                <div class="container-fluid" id="calendarDiv">
                    <div id='calendar' height="400" width="600" id="calendarDev"></div>
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



    <link href='https://unpkg.com/@fullcalendar/core@4.4.0/main.min.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/daygrid@4.4.0/main.min.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/timegrid@4.4.0/main.min.css' rel='stylesheet' />
    <script src='https://unpkg.com/@fullcalendar/core@4.4.0/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/interaction@4.4.0/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/daygrid@4.4.0/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/timegrid@4.4.0/main.min.js'></script>
    <!-- edit by luguangfu -->

    <script>
    document.addEventListener('DOMContentLoaded', function() {

        initCalendar()

    });

    function initCalendar() {
        //Get current date
        var myDate = new Date();
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['interaction', 'dayGrid', 'timeGrid'],
            allDaySlot: false, //Whether to show all-day
            //The default view at initialization displays the week by default
            defaultView: 'timeGridWeek',
            //Display date by default
            defaultDate: myDate,
            minTime: '08:00:00', //The time on the left starts from
            maxTime: '22:00:00', //What time does the left end
            height: 500,
            //Information on top
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: 'myCalendar.php?do=initCalendar'
        });

        calendar.render();

    }
    </script>
</body>

</html>