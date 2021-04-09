<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login'] != 1)
    header('Location: ../login.php');

$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
if($_POST) {
    if(isset($_POST['name']) && isset($_POST['login'])) {
        $result = $connection->prepare('UPDATE admins SET name=?, login=?')
                    ->execute([
                         $_POST['name'],
                         $_POST['login'],
                    ]);
        if($result !== false) {
            $_SESSION['message'] = 'Ma\'lumotlar muvaffaqiyatli saqlandi!';
            $_SESSION['message_type'] = 'success';
            header('Location: profile.php');
            exit(0);
        }
    }
    if(isset($_POST['passwd']) && isset($_POST['passwd2'])) {
        if($_POST['passwd'] == $_POST['passwd2']) {
            $result = $connection->prepare('UPDATE admins SET passwd=?')
                ->execute([
                    md5($_POST['passwd']),
                ]);
            if($result !== false) {
                $_SESSION['message'] = 'Parol muvaffaqiyatli o\'zgartirildi!';
                $_SESSION['message_type'] = 'success';
                header('Location: profile.php');
                exit(0);
            }
        } else {
            $_SESSION['message'] = 'Parollar mos emas!';
            $_SESSION['message_type'] = 'danger';
            header('Location: profile.php');
            exit(0);
        }
    }
}


$admin = $connection->query("SELECT * FROM admins")->fetch(PDO::FETCH_ASSOC);

?>

<?php include "../blocks/header.php" ?>

    <!--/. NAV TOP  -->
<?php include "../blocks/menu.php" ?>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
        <div class="page-inner">
            <div class="container">
                <?php if(isset($_SESSION['message'])): ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-<?=$_SESSION['message_type']?>">
                            <?php
                                echo $_SESSION['message'];
                                unset($_SESSION['message']);
                                unset($_SESSION['message_type']);
                            ?>
                        </div>
                    </div>
                </div>
                <?php endif;?>
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Administrator profili
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="name">F.I.Sh.</label>
                                <input class="form-control" name="name" id="name" type="text" value="<?=$admin['name'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="login">Login</label>
                                <input class="form-control" name="login" id="login" type="text" value="<?=$admin['login'] ?>">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Saqlash">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Parolni o'zgartirish
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="passwd">Yangi parol</label>
                                <input class="form-control" name="passwd" id="passwd" type="password">
                            </div>
                            <div class="form-group">
                                <label for="passwd2">Parolni takrorlang</label>
                                <input class="form-control" name="passwd2" id="passwd2" type="password">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="O'zgartirish">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /. PAGE INNER  -->

    </div>
    <!-- /. PAGE WRAPPER  -->
<?php include "../blocks/footer.php"; ?>