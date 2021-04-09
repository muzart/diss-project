<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login'] != 1)
    header('Location: ../login.php');

$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
$message = "";
if($_POST) {
    $add = $connection->prepare("INSERT INTO questions(subject_id,question,a,b,c,d,answer) VALUES(?,?,?,?,?,?,?)")
        ->execute([
            $_POST['subject_id'],
            $_POST['question'],
            $_POST['a'],
            $_POST['b'],
            $_POST['c'],
            $_POST['d'],
            $_POST['answer'],
        ]);
    if($add !== false) {
        header('Location: index.php');
    }
}

$subjects = $connection->query('SELECT * FROM subjects')->fetchAll(PDO::FETCH_ASSOC);
$questions = $connection->query('SELECT q.*, s.name as subject_name FROM questions q LEFT JOIN subjects s ON q.subject_id=s.id')->fetchAll(PDO::FETCH_ASSOC);
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
                        <h2 class="text-center">Savollar</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <form action="" method="post" class="border-primary p-2">
                            <table class="table table-condensed">
                                <tr>
                                    <td>
                                        <label for="subject_id">Fanni tanlang</label>
                                    </td>
                                    <td>
                                        <select name="subject_id" id="subject_id" class="form-control">
                                            <?php foreach ($subjects as $subject): ?>
                                            <option value="<?=$subject['id']?>>"><?= $subject['name'] ?> </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="question">Savol</label>
                                    </td>
                                    <td>
                                        <textarea name="question" id="question" cols="30" rows="3" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="a">A</label>
                                    </td>
                                    <td>
                                        <input name="a" type="text" id="a" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="b">B</label>
                                    </td>
                                    <td>
                                        <input name="b" type="text" id="b" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="c">C</label>
                                    </td>
                                    <td>
                                        <input name="c" type="text" id="c" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="d">D</label>
                                    </td>
                                    <td>
                                        <input name="d" type="text" id="d" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="answer">To'g'ri javob</label>
                                    </td>
                                    <td>
                                        <select name="answer" id="answer" class="form-control">
                                            <option value="a">A</option>
                                            <option value="b">B</option>
                                            <option value="c">C</option>
                                            <option value="d">D</option>
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
                                <th>Fan</th>
                                <th>Savol</th>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th>D</th>
                                <th>Javob</th>
                                <th>Amal</th>
                            </tr>
                            <?php $i = 0; foreach ($questions as $question): ?>
                                <tr>
                                    <th><?=++$i?></th>
                                    <td><?=$question['subject_name']?></td>
                                    <td><?=$question['question']?></td>
                                    <td><?=$question['a']?></td>
                                    <td><?=$question['b']?></td>
                                    <td><?=$question['c']?></td>
                                    <td><?=$question['d']?></td>
                                    <td><?=$question['answer']?></td>
                                    <td>
                                        <a href="display.php?id=<?=$question['id']?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                        <a href="edit.php?id=<?=$question['id']?>" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                                        <a href="remove.php?id=<?=$question['id']?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
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