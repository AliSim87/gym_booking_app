<?php
session_start();
session_destroy();

// edit by  luguangfu  Fix exit exception

header("location: ../index.html");