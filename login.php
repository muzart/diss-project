<?php
session_start();
$error = '';
if($_POST) {
    $connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
    $username = $_POST['username'];
    $passwd = $_POST['passwd'];
    $student = $connection->prepare('SELECT * FROM students WHERE username=:username');
    $student->bindParam(':username',$username);
    $student->execute();
    $result = $student->fetch(PDO::FETCH_ASSOC);
    if($result !== false) {
        if($result['passwd'] == $passwd) {
            $_SESSION['st_login'] = 1;
            $_SESSION['student_id'] = $result['id'];
        } else {
            $error = 'Login yoki parol xato!';
        }
    } else {
        $error = 'Bunday loginda foydalanuvchi yo\'q!';
    }
}
if(isset($_SESSION['st_login']) && $_SESSION['st_login'] == 1)
    header('Location: index.php');
?>
<html lang="uz">
<head>
    <link rel="stylesheet" href="./admin/assets/css/bootstrap.css">
    <title>Login</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <h1 class="text-center">Testlash tizimiga kirish</h1>
            <?php if($error !== ''): ?>
                <div class="alert alert-danger">
                    <h5><?= $error ?></h5>
                </div>
            <?php endif;?>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="username">Login</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div class="form-group">
                    <label for="passwd">Parol</label>
                    <input type="password" class="form-control" name="passwd" id="passwd">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-block btn-primary" value="Kirish">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
