<?php
if(!isset($_GET['id']))
    die("Noto'g'ri murojaat qilindi! ID parametri berilmadi!");

$id = (int) $_GET['id'];

$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');

if($_POST) {
    $result = $connection->prepare('UPDATE groups SET name=?, course=? WHERE id=?')
        ->execute([
            $_POST['name'],
            $_POST['course'],
            $id
        ]);
    if($result) {
        header('Location: index.php');
    }
    else
        $error_message = "So'rovni bajarishda xatolik ro'y berdi...";
}

$group = $connection->query("SELECT * FROM groups WHERE id=$id")->fetch(PDO::FETCH_ASSOC);
if(!is_array($group)) {
    die('Bunday guruh bazada mavjud emas!');
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
                                        <label for="name">Guruh nomi</label>
                                    </td>
                                    <td>
                                        <input name="name" type="text" id="name" class="form-control" value="<?=$group['name']?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="course">Kurs</label>
                                    </td>
                                    <td>
                                        <select name="course" id="course" class="form-control">
                                            <option value="1" <?=($group['course'] == 1) ? "selected" : ""; ?>>1-kurs</option>
                                            <option value="2" <?=($group['course'] == 2) ? "selected" : ""; ?>>2-kurs</option>
                                            <option value="3" <?=($group['course'] == 3) ? "selected" : ""; ?>>3-kurs</option>
                                            <option value="4" <?=($group['course'] == 4) ? "selected" : ""; ?>>4-kurs</option>
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
                </div>
            </div>
        </div>
        <!-- /. PAGE INNER  -->

    </div>
    <!-- /. PAGE WRAPPER  -->
<?php include "../blocks/footer.php"; ?>