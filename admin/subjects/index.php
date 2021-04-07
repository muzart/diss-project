<?php

$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
$message = "";
if($_POST) {
    $add = $connection->prepare("INSERT INTO subjects(name) VALUES(?)")
        ->execute([
            $_POST['name'],
        ]);
    if($add !== false) {
        $message = 'Fan muvaffaqiyatli qo\'shildi';
    }
}

$subjects = $connection->query('SELECT * FROM subjects')->fetchAll(PDO::FETCH_ASSOC);
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
                        <h2 class="text-center">Fanlar</h2>
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
                                        <label for="name">Fan nomi</label>
                                    </td>
                                    <td>
                                        <input name="name" type="text" id="name" class="form-control">
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
                                <th>Fan nomi</th>
                                <th>Amal</th>
                            </tr>
                            <?php $i = 0; foreach ($subjects as $subject): ?>
                                <tr>
                                    <th><?=++$i?></th>
                                    <td><?=$subject['name']?></td>
                                    <td>
                                        <a href="display.php?id=<?=$subject['id']?>" class="btn btn-primary">Ko'rish</a>
                                        <a href="edit.php?id=<?=$subject['id']?>" class="btn btn-warning">Tahrirlash</a>
                                        <a href="remove.php?id=<?=$subject['id']?>" class="btn btn-danger">O'chirish</a>
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