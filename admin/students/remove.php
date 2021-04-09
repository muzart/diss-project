<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login'] != 1)
    header('Location: ../login.php');

if(!isset($_GET['id']))
    die("Noto'g'ri murojaat qilindi! ID parametri berilmadi!");

$id = (int) $_GET['id'];

$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
$result = $connection->prepare('DELETE FROM students WHERE id=?')->execute([$id]);

if($result)
    header('Location: index.php');
else
    echo 'Talaba bazadan o\'chirilmadi';
