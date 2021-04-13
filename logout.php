<?php
session_start();
unset($_SESSION['st_login']);
session_destroy();
header('Location: login.php');