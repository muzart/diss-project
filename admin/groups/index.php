<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login'] != 1)
    header('Location: ../login.php');

$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
$message = "";
if($_POST) {
    $add = $connection->prepare("INSERT INTO groups(name,course) VALUES(?,?)")
        ->execute([
            $_POST['name'],
            $_POST['course']
        ]);
    if($add !== false) {
        $message = 'Guruh muvaffaqiyatli qo\'shildi';
    }
}

$groups = $connection->query('SELECT * FROM groups')->fetchAll(PDO::FETCH_ASSOC);
?>
    <?php include "../blocks/header.php" ?>

    <!--/. NAV TOP  -->
    <?php include "../blocks/menu.php" ?>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
        <div class="page-inner">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="text-center">Guruhlar</h2>
                    </div>
                    <?php if($message != ''): ?>
                        <div class="alert alert-success">
                            <?= $message ?>
                        </div>
                    <?php endif;?>
                </div>
                <div class="row">
                    <div class="col-4">
                        <form action="" method="post" class="border-primary p-2">
                            <table class="table table-condensed">
                                <tr>
                                    <td>
                                        <label for="name">Guruh nomi</label>
                                    </td>
                                    <td>
                                        <input name="name" type="text" id="name" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="course">Kurs</label>
                                    </td>
                                    <td>
                                        <select name="course" id="course" class="form-control">
                                            <option value="1">1-kurs</option>
                                            <option value="2">2-kurs</option>
                                            <option value="3">3-kurs</option>
                                            <option value="4">4-kurs</option>
                                        </select>
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
                    <div class="col-8">
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th>ID</th>
                                <th>Guruh nomi</th>
                                <th>Kurs</th>
                                <th>Amal</th>
                            </tr>
                            <?php $i = 0; foreach ($groups as $group): ?>
                                <tr>
                                    <th><?=++$i?></th>
                                    <td><?=$group['name']?></td>
                                    <td><?=$group['course']?></td>
                                    <td>
                                        <a href="display.php?id=<?=$group['id']?>" class="btn btn-primary">Ko'rish</a>
                                        <a href="edit.php?id=<?=$group['id']?>" class="btn btn-warning">Tahrirlash</a>
                                        <a href="remove.php?id=<?=$group['id']?>" class="btn btn-danger">O'chirish</a>
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