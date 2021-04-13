<?php
session_start();
unset($_SESSION['st_login']);
unset($_SESSION['student_id']);
unset($_SESSION['subject']);
session_destroy();
header('Location: login.php');