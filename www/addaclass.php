<?php
require_once ".../dbconnect.php";

$title = "";
$date = "";
$start_time = "";
$end_time = "";
$duration = "";
$cost = "";
$details = "";

$title_error = "";
$date_error = "";
$start_time_error = "";
$end_time_error = "";
$duration_error = "";
$cost_error = "";
$details_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate Title
    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Please enter a title.";
    } elseif(!filter_var($input_title, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $title_err = "Please enter a valid title.";
    } else{
        $title = $input_title;
    }

    // Validate Date
    $input_date = trim($_POST["date"]);
    $input_date_test = str.slice(0,8);
    if(empty($input_date)) {
        $date_err = "Please enter a date";
    } elseif(!checkdate($input_date_test[0], $input_date_test[1], $input_date_test[2])) {
        $date_err = "Please enter a valid date";
    } else {
        $date = $input_date;
    }

    // Validate Start Time
    $input_start_time = trim($_POST["start_time"]);
    $input_start_time_test = substr($input_start_time, 0, -2);
    if(empty($input_start_time)) {
        $start_time_err = "Please enter a time";
    } elseif(!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $input_start_time_test)) {
        $start_time_err = "Please enter a valid time";
    } else {
        $start_time = $input_start_time;
    }

    // Validate End Time
    $input_end_time = trim($_POST["end_time"]);
    $input_end_time_test = substr($input_start_time, 0, -2);
    if(empty($input_end_time)) {
        $end_time_err = "Please enter a time";
    } elseif(!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $input_end_time_test)) {
        $end_time_err = "Please enter a valid time";
    } else {
        $end_time = $input_end_time;
    }

    // Calculate Duration

    //Validate Details

    // Check input errors before inserting in database
    if(empty($title_error) && empty($date_error) && empty($start_time_error) && empty($end_time_error) && empty($duration_error) && empty($cost_error) && empty($date_error)){
        // Prepare an insert statement
        $sql = "INSERT INTO classes (title, date, start_time, end_time, duration, salary, cost) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_title, $param_date, $param_start_time);

            // Set parameters
            $param_title = $title;
            $param_address = $address;
            $param_salary = $salary;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker3').datetimepicker({
                format: 'LT'
            });
        });
    </script>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Create Class</h2>
                </div>
                <p>Please fill this form and submit to add employee record to the database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                        <span class="help-block"><?php echo $name_err;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($date_err)) ? 'has-error' : ''; ?>">
                        <label>Address</label>
                        <div class='input-group date' id='datetimepicker3'>
                            <input type="text" name="date" class="form-control" value="<?php echo $date; ?>">
                            <span class="help-block"><?php echo $date_err;?></span>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group <?php echo (!empty($start_time_err)) ? 'has-error' : ''; ?>">
                        <label>Start Time</label>
                        <div class='input-group date' id='datetimepicker3'>
                            <input type="text" name="start_time" class="form-control" value="<?php echo $start_time; ?>">
                            <span class="help-block"><?php echo $start_time_err;?></span>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group <?php echo (!empty($end_time_err)) ? 'has-error' : ''; ?>">
                        <label>Start Time</label>
                        <div class='input-group date' id='datetimepicker3'>
                            <input type="text" name="end_time" class="form-control" value="<?php echo $end_time; ?>">
                            <span class="help-block"><?php echo $end_time_err;?></span>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                        <label>Salary</label>
                        <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                        <span class="help-block"><?php echo $salary_err;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="index.php" class="btn btn-default">Cancel</a>
                </form>


