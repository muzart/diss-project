<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login'] != 1)
    header('Location: ../login.php');

if(!isset($_GET['id']))
    die("Noto'g'ri murojaat qilindi! ID parametri berilmadi!");

$id = (int) $_GET['id'];

$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
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
                    <div class="col-6 offset-3">
                        <table class="table table-bordered table-info">
                            <tr>
                                <th>ID</th>
                                <td><?=$subject['id'] ?></td>
                            </tr>
                            <tr>
                                <th>Guruh nomi</th>
                                <td><?=$subject['name'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /. PAGE INNER  -->

    </div>
    <!-- /. PAGE WRAPPER  -->
<?php include "../blocks/footer.php"; ?>