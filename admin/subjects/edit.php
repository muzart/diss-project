<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login'] != 1)
    header('Location: ../login.php');

if(!isset($_GET['id']))
    die("Noto'g'ri murojaat qilindi! ID parametri berilmadi!");

$id = (int) $_GET['id'];

$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');

if($_POST) {
    $result = $connection->prepare('UPDATE subjects SET name=? WHERE id=?')
        ->execute([
            $_POST['name'],
            $id
        ]);
    if($result) {
        header('Location: index.php');
    }
    else
        $error_message = "So'rovni bajarishda xatolik ro'y berdi...";
}

$subject = $connection->query("SELECT * FROM subjects WHERE id=$id")->fetch(PDO::FETCH_ASSOC);
if(!is_array($subject)) {
    die('Bunday fan bazada mavjud emas!');
}
?>

<?php include "../blocks/header.php" ?>

    <!--/. NAV TOP  -->
<?php include "../blocks/menu.php" ?>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
        <div class="page-inner">
            <div class="container">
                <div class="row">
                    <div class="col-4 offset-4">
                        <form action="" method="post" class="border-primary p-2">
                            <table class="table table-condensed">
                                <tr>
                                    <td>
                                        <label for="name">Fan nomi</label>
                                    </td>
                                    <td>
                                        <input name="name" type="text" id="name" class="form-control" value="<?=$subject['name']?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="submit" class="btn btn-primary">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /. PAGE INNER  -->

    </div>
    <!-- /. PAGE WRAPPER  -->
<?php include "../blocks/footer.php"; ?>