<?php
session_start();
session_destroy();
// Redirect to the login page:
header('Location:/gym_booking_app/rock_gym/index.html');
?>