<?php
if(!isset($_GET['id']))
    die("Noto'g'ri murojaat qilindi! ID parametri berilmadi!");

$id = (int) $_GET['id'];

$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');

if($_POST) {
    $result = $connection->prepare('UPDATE questions SET subject_id=?, question=?, a=?, b=?, c=?, d=?, answer=? WHERE id=?')
        ->execute([
            $_POST['subject_id'],
            $_POST['question'],
            $_POST['a'],
            $_POST['b'],
            $_POST['c'],
            $_POST['d'],
            $_POST['answer'],
            $id
        ]);
    if($result) {
        header('Location: index.php');
    }
    else
        $error_message = "So'rovni bajarishda xatolik ro'y berdi...";
}
$subjects = $connection->query('SELECT * FROM subjects')->fetchAll(PDO::FETCH_ASSOC);
$question = $connection->query("SELECT * FROM questions WHERE id=$id")->fetch(PDO::FETCH_ASSOC);
if(!is_array($question)) {
    die('Bunday savol bazada mavjud emas!');
}
?>

<?php include "../blocks/header.php"?>

    <!--/. NAV TOP  -->
<?php include "../blocks/menu.php"?>
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
                                        <label for="subject_id">Fanni tanlang</label>
                                    </td>
                                    <td>
                                        <select name="subject_id" id="subject_id" class="form-control">
                                            <?php foreach ($subjects as $subject): ?>
                                                <option value="<?=$subject['id']?>>" <?= ($question['subject_id'] == $subject['id']) ? "selected" : "" ; ?>><?= $subject['name'] ?> </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="question">Savol</label>
                                    </td>
                                    <td>
                                        <textarea name="question" id="question" cols="30" rows="3" class="form-control"><?= $question['question'] ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="a">A</label>
                                    </td>
                                    <td>
                                        <input name="a" type="text" id="a" class="form-control" value="<?=$question['a']?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="b">B</label>
                                    </td>
                                    <td>
                                        <input name="b" type="text" id="b" class="form-control" value="<?=$question['b']?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="c">C</label>
                                    </td>
                                    <td>
                                        <input name="c" type="text" id="c" class="form-control" value="<?=$question['c']?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="d">D</label>
                                    </td>
                                    <td>
                                        <input name="d" type="text" id="d" class="form-control" value="<?=$question['d']?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="answer">To'g'ri javob</label>
                                    </td>
                                    <td>
                                        <select name="answer" id="answer" class="form-control">
                                            <option value="a" <?=($question['answer'] == 'a') ? "selected" : ""; ?>>A</option>
                                            <option value="b" <?=($question['answer'] == 'b') ? "selected" : ""; ?>>B</option>
                                            <option value="c" <?=($question['answer'] == 'c') ? "selected" : ""; ?>>C</option>
                                            <option value="d" <?=($question['answer'] == 'd') ? "selected" : ""; ?>>D</option>
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