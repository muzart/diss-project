<?php
if(!isset($_GET['id']))
    die("Noto'g'ri murojaat qilindi! ID parametri berilmadi!");

$id = (int) $_GET['id'];

$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
$result = $connection->prepare('DELETE FROM groups WHERE id=?')->execute([$id]);

if($result)
    header('Location: index.php');
else
    echo 'Guruh bazadan o\'chirilmadi';
