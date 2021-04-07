<?php
if(!isset($_GET['id']))
    die("Noto'g'ri murojaat qilindi! ID parametri berilmadi!");

$id = (int) $_GET['id'];

$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
$student = $connection->query("SELECT * FROM students WHERE id=$id")->fetch(PDO::FETCH_ASSOC);

if($_POST) {
    $image = $student['image'];
    if($_FILES['image']['name'] !== '') {
        $img = $_FILES['image'];
        $image = uniqid() . $img['name'];
        move_uploaded_file($img['tmp_name'], __DIR__ . '/../assets/img/' . $image);
        if($student['image'] !== '') {
            if(file_exists(__DIR__.'/../assets/img/'.$student['image']))
                unlink(__DIR__.'/../assets/img/'.$student['image']);
        }
    }
    $result = $connection->prepare('
                    UPDATE students SET last_name=?, first_name=?, patronymic=?, 
                    group_id=?, image=?, username=?, passwd=? WHERE id=?')
        ->execute([
            $_POST['last_name'],
            $_POST['first_name'],
            $_POST['patronymic'],
            $_POST['group_id'],
            $image,
            $_POST['username'],
            $_POST['passwd'],
            $id
        ]);
    if($result !== false) {
        header('Location: index.php');
    }
    else
        var_dump($connection->errorInfo());
}

if(!is_array($student)) {
    die('Bunday talaba bazada mavjud emas!');
}
$groups = $connection->query("SELECT * FROM groups")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include "../blocks/header.php"?>

    <!--/. NAV TOP  -->
<?php include "../blocks/menu.php"?>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
        <div class="page-inner">
            <div class="container">
                <div class="row">
                    <div class="col-6 offset-3">
                        <form action="" method="post" class="border-primary p-2" enctype="multipart/form-data">
                            <table class="table table-condensed">
                                <tr>
                                    <td>
                                        <label for="last_name">Familiya</label>
                                    </td>
                                    <td>
                                        <input name="last_name" type="text" id="last_name" class="form-control" value="<?= $student['last_name'] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="first_name">Ism</label>
                                    </td>
                                    <td>
                                        <input name="first_name" type="text" id="first_name" class="form-control" value="<?= $student['first_name'] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="patronymic">Otasining ismi</label>
                                    </td>
                                    <td>
                                        <input name="patronymic" type="text" id="patronymic" class="form-control" value="<?= $student['patronymic'] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="group_id">Guruh</label>
                                    </td>
                                    <td>
                                        <select name="group_id" id="group_id" class="form-control">
                                        <?php foreach ($groups as $group): ?>
                                            <option value="<?= $group['id'] ?>" <?= ($student['group_id'] == $group['id']) ? "selected" : "" ;?> ><?= $group['name'] ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="image">Rasm</label>
                                    </td>
                                    <td>
                                        <?php if($student['image'] !== ''): ?>
                                            <img src="../assets/img/<?= $student['image'] ?>" alt="rasm" style="max-width: 200px;">
                                        <?php endif;?>
                                        <input type="file" name="image" id="image">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="username">Login</label>
                                    </td>
                                    <td>
                                        <input name="username" type="text" id="username" class="form-control"  value="<?= $student['username'] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="passwd">Parol</label>
                                    </td>
                                    <td>
                                        <input name="passwd" type="password" id="passwd" class="form-control"  value="<?= $student['passwd'] ?>">
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