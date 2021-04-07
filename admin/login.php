<?php
session_start();
$error = '';
if($_POST) {
    $connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
    $login = $_POST['login'];
    $passwd = $_POST['passwd'];
    $admin = $connection->prepare('SELECT * FROM admins WHERE login=:login');
    $admin->bindParam(':login',$login);
    $admin->execute();
    $result = $admin->fetch(PDO::FETCH_ASSOC);
    if($result !== false) {
        if($result['passwd'] == md5($passwd)) {
            $_SESSION['login'] = 1;
        } else {
            $error = 'Login yoki parol xato!';
        }
    } else {
        $error = 'Bunday loginda foydalanuvchi yo\'q!';
    }
}
if(isset($_SESSION['login']) && $_SESSION['login'] == 1)
    header('Location: /proekt/admin/dashboard/');
?>
<html>
<head>
    <link rel="stylesheet" href="./assets/css/bootstrap.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4">
                <h1 class="text-center">Administrator login</h1>
                <?php if($error !== ''): ?>
                <div class="alert alert-danger">
                    <h5><?= $error ?></h5>
                </div>
                <?php endif;?>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" class="form-control" name="login" id="login">
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
