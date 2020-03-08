<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Sriracha&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One&display=swap" rel="stylesheet">
    <title>Rockdale Gym | Scheduling and Booking Website</title>
</head>
<body>
<header>
    <nav class="menu-navigation">
        <a href="index.html">Home</a>
        <a href="membership.html">Memberships</a>
        <a href="reviews.html">Reviews</a>
        <div class="dropdown">
            <button class="dropbtn">More
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <a href="locations.html">Locations</a>
                <a href="activity.html">Activities</a>
                <a href="photos.html">Photos</a>
            </div>
        </div>
        <span id="login"><a href="login.html">Login</a></span>
    </nav>
</header>
<main>
    <div class="wrapper">
        <h1>Class List</h1>
        <a href="addaclass.php">Add New Class</a>
        <?php
        require_once "../dbconnect.php";

        $sql = "SELECT * FROM classes";
        if($result = mysqli_query($db, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Title</th>";
                echo "<th>Class Type</th>";
                echo "<th>Date</th>";
                echo "<th>Duration</th>";
                echo "<th>Cost</th>";;
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['classtype'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['duration'] . "</td>";
                    echo "<td>" . $row['cost'] . "</td>";
                    echo "<td>";
                    echo "<a href='moreinformation.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                    echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                    echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                mysqli_free_result($result);
            } else{
                echo "<p class='lead'><em>No records were found.</em></p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }

        mysqli_close($db);
        ?>

    </div>
</main>