<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login'] != 1)
    header('Location: ../login.php');

if(!isset($_GET['id']))
    die("Noto'g'ri murojaat qilindi! ID parametri berilmadi!");

$id = (int) $_GET['id'];

$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
$question = $connection->query("SELECT q.*, s.name as subject_name FROM questions q LEFT JOIN subjects s ON q.subject_id=s.id WHERE q.id=$id")->fetch(PDO::FETCH_ASSOC);
if(!is_array($question)) {
    die('Bunday savol bazada mavjud emas!');
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
                                <td><?=$question['id'] ?></td>
                            </tr>
                            <tr>
                                <th>Fan</th>
                                <td><?=$question['subject_name'] ?></td>
                            </tr>
                            <tr>
                                <th>Savol</th>
                                <td><?=$question['question'] ?></td>
                            </tr>
                            <tr>
                                <th>A</th>
                                <td><?=$question['a'] ?></td>
                            </tr>
                            <tr>
                                <th>B</th>
                                <td><?=$question['b'] ?></td>
                            </tr>
                            <tr>
                                <th>C</th>
                                <td><?=$question['c'] ?></td>
                            </tr>
                            <tr>
                                <th>D</th>
                                <td><?=$question['d'] ?></td>
                            </tr>
                            <tr>
                                <th>Javob</th>
                                <td><?=$question['answer'] ?></td>
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