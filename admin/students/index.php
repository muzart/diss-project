<?php

$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
$message = "";
if($_POST) {
    $image = '';
    if(isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $img = $_FILES['image'];
        $image = uniqid() . $img['name'];
        move_uploaded_file($img['tmp_name'], __DIR__ . '/../assets/img/' . $image);
    }
    $add = $connection->prepare("INSERT INTO students(last_name, first_name, patronymic, image, username, passwd, group_id) 
                                        VALUES(?, ?, ?, ?, ?, ?, ?)")
        ->execute([
                $_POST['last_name'],
                $_POST['first_name'],
                $_POST['patronymic'],
                $image,
                $_POST['username'],
                $_POST['passwd'],
                $_POST['group_id'],
        ]);
    if($add !== false) {
        header('Location: index.php');
        $message = 'Talaba muvaffaqiyatli qo\'shildi';
    }
}

$groups = $connection->query('SELECT * FROM groups')->fetchAll(PDO::FETCH_ASSOC);
$students = $connection->query(
        'SELECT s.*, g.name as group_name FROM students s 
                   LEFT JOIN groups g ON s.group_id=g.id ORDER BY s.id'
)->fetchAll(PDO::FETCH_ASSOC);
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
                        <h2 class="text-center">Talabalar</h2>
                    </div>
                    <?php if($message != ''): ?>
                        <div class="alert alert-success">
                            <?= $message ?>
                        </div>
                    <?php endif;?>
                </div>
                <div class="row">
                    <div class="col-4">
                        <form action="" method="post" class="border-primary p-2" enctype="multipart/form-data">
                            <table class="table table-condensed">
                                <tr>
                                    <td>
                                        <label for="last_name">Familiya</label>
                                    </td>
                                    <td>
                                        <input name="last_name" type="text" id="last_name" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="first_name">Ism</label>
                                    </td>
                                    <td>
                                        <input name="first_name" type="text" id="first_name" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="patronymic">Otasining ismi</label>
                                    </td>
                                    <td>
                                        <input name="patronymic" type="text" id="patronymic" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="group_id">Guruh</label>
                                    </td>
                                    <td>
                                        <select name="group_id" id="group_id" class="form-control">
                                        <?php foreach ($groups as $group): ?>
                                            <option value="<?= $group['id'] ?>"><?= $group['name'] ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="image">Rasm</label>
                                    </td>
                                    <td>
                                        <input type="file" name="image" id="image">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="username">Login</label>
                                    </td>
                                    <td>
                                        <input name="username" type="text" id="username" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="passwd">Parol</label>
                                    </td>
                                    <td>
                                        <input name="passwd" type="password" id="passwd" class="form-control">
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
                                <th>Rasm</th>
                                <th>Guruh</th>
                                <th>ID</th>
                                <th>Familiyasi</th>
                                <th>Ismi</th>
                                <th>Login</th>
                                <th>Amal</th>
                            </tr>
                            <?php foreach ($students as $student): ?>
                            <tr>
                                <th>
                                    <?php if($student['image'] != ''): ?>
                                    <img src="../assets/img/<?= $student['image'] ?>" class="img-circle img-thumbnail" style="height: 50px; width: 50px">
                                    <?php endif;?>
                                </th>
                                <td><?= $student['group_name'] ?></td>
                                <td><?= $student['id'] ?></td>
                                <td><?= $student['last_name'] ?></td>
                                <td><?= $student['first_name'] ?></td>
                                <td><?= $student['username'] ?></td>
                                <td>
                                    <a href="display.php?id=<?=$student['id']?>" class="btn btn-primary">Ko'rish</a>
                                    <a href="edit.php?id=<?=$student['id']?>" class="btn btn-warning">Tahrirlash</a>
                                    <a href="remove.php?id=<?=$student['id']?>" class="btn btn-danger">O'chirish</a>
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