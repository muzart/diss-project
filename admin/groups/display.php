<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login'] != 1)
    header('Location: ../login.php');

if(!isset($_GET['id']))
    die("Noto'g'ri murojaat qilindi! ID parametri berilmadi!");

$id = (int) $_GET['id'];

$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
$group = $connection->query("SELECT * FROM groups WHERE id=$id")->fetch(PDO::FETCH_ASSOC);
if(!is_array($group)) {
    die('Bunday guruh bazada mavjud emas!');
}
$students = $connection->query("SELECT * FROM students WHERE group_id=$id")->fetchAll(PDO::FETCH_ASSOC);

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
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>ID</th>
                                <td><?=$group['id'] ?></td>
                            </tr>
                            <tr>
                                <th>Guruh nomi</th>
                                <td><?=$group['name'] ?></td>
                            </tr>
                            <tr>
                                <th>Kurs</th>
                                <td><?=$group['course'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8 offset-2">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Rasm</th>
                                <th>ID</th>
                                <th>Familiyasi</th>
                                <th>Ismi</th>
                                <th>Login</th>
                                <th>Amal</th>
                            </tr>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <th>
                                        <img src="../assets/img/<?= $student['image'] ?>" class="img-circle img-thumbnail" style="height: 50px; width: 50px">
                                    </th>
                                    <td><?= $student['id'] ?></td>
                                    <td><?= $student['last_name'] ?></td>
                                    <td><?= $student['first_name'] ?></td>
                                    <td><?= $student['username'] ?></td>
                                    <td>
                                        <a href="../students/display.php?id=<?=$student['id']?>" class="btn btn-primary">Ko'rish</a>
                                        <a href="../students/edit.php?id=<?=$student['id']?>" class="btn btn-warning">Tahrirlash</a>
                                        <a href="../students/remove.php?id=<?=$student['id']?>" class="btn btn-danger">O'chirish</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /. PAGE INNER  -->

    </div>
    <!-- /. PAGE WRAPPER  -->
<?php include "../blocks/footer.php"; ?>