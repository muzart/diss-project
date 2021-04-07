<?php
if(!isset($_GET['id']))
    die("Noto'g'ri murojaat qilindi! ID parametri berilmadi!");

$id = (int) $_GET['id'];

$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
$student = $connection->query("SELECT s.*, g.name as group_name FROM students s LEFT JOIN groups g ON s.group_id=g.id WHERE s.id=$id")
    ->fetch(PDO::FETCH_ASSOC);
if(!is_array($student)) {
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
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>ID</th>
                                <td><?=$student['id'] ?></td>
                            </tr>
                            <tr>
                                <th>Guruh</th>
                                <td><?=$student['group_name'] ?></td>
                            </tr>
                            <tr>
                                <th>Rasm</th>
                                <td><img src="../assets/img/<?=$student['image'] ?>" style="height: 100px; width: 100px;"></td>
                            </tr>
                            <tr>
                                <th>Familiyasi</th>
                                <td><?=$student['last_name'] ?></td>
                            </tr>
                            <tr>
                                <th>Ismi</th>
                                <td><?=$student['first_name'] ?></td>
                            </tr>
                            <tr>
                                <th>Otasining ismi</th>
                                <td><?=$student['patronymic'] ?></td>
                            </tr>
                            <tr>
                                <th>Login</th>
                                <td><?=$student['username'] ?></td>
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