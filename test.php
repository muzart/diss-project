<?php
session_start();

if (!isset($_SESSION['st_login']) || $_SESSION['st_login'] !== 1) {
    header('Location: login.php');
    exit(0);
}

if (!isset($_SESSION['subject']))
    header('Location: index.php');

$subject_id = $_SESSION['subject'];
$message = '';
$connection = new PDO('mysql:host=localhost;dbname=php_baza', 'root', '');

$questions = $connection->query('SELECT * FROM questions WHERE subject_id=' . $subject_id)
    ->fetchAll(PDO::FETCH_ASSOC);
$invalid = false;
$type = 'info';
if ($_POST) {
    $true_answers_count = 0;
    $questions_count = count($questions);
    $sent_questions_count = count($_POST['question']);
    if ($sent_questions_count < $questions_count) {
        $message = "Hamma savolga javob berilmadi!";
        $type = 'danger';
        $invalid = true;
    }
    if (!$invalid) {
        $answers = $_POST['question'];
        foreach ($answers as $qid => $answer) {
            $current_answer = $connection->query('SELECT answer FROM questions WHERE id=' . $qid)->fetch(PDO::FETCH_ASSOC);
            if (strtoupper($current_answer['answer']) === strtoupper($answer))
                ++$true_answers_count;
        }
        $stmt = $connection->prepare('INSERT INTO results(student_id,subject_id,question_count,answer_count,created_at) 
                                        VALUES(?,?,?,?,?)');
        $result = $stmt->execute([
            $_SESSION['student_id'],
            $_SESSION['subject'],
            $questions_count,
            $true_answers_count,
            time()
        ]);
        if ($result !== false) {
            unset($_SESSION['subject']);
            $message = "Siz berilgan $questions_count savoldan $true_answers_count tasiga to'g'ri javob berdingiz! Natijangiz " . round($true_answers_count / $questions_count * 100) . "%";
            $type = 'success';
        }
    }
}


?>
<!doctype html>
<html lang="uz">
<head>
    <title>Test oluvchi tizim</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Test oluvchi tizim</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav pull-right">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Chiqish</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php if ($message != '' && $type == 'success'): ?>

        <div class="alert alert-<?= $type ?>">
            <?= $message ?>
        </div>

        <div class="row">
            <div class="col-12">
                <p class="text-center">
                    <a href="index.php" class="btn btn-primary"> Fan tanlashga qaytish </a>
                </p>
            </div>
        </div>
    <?php else: ?>

        <?php if($type == 'danger'): ?>
            <div class="alert alert-danger">
                <?= $message ?>
            </div>
        <?php endif;?>
        <form action="" method="post">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <?php
                $i = 0;
                foreach ($questions as $question):
                    $i++;
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($i == 1) ? "active" : "" ?>" id="q<?= $question['id'] ?>-tab"
                           data-toggle="pill"
                           href="#q<?= $question['id'] ?>" role="tab" aria-controls="q<?= $question['id'] ?>"><?= $i ?>
                            - savol</a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <?php
                $c = 0;
                foreach ($questions as $question):
                    $c++
                    ?>
                    <div class="tab-pane fade <?= ($c == 1) ? "show active" : "" ?>" id="q<?= $question['id'] ?>"
                         role="tabpanel"
                         aria-labelledby="q<?= $c ?>-tab">
                        <p>
                            Savol: <?= $question['question'] ?>
                        </p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question[<?= $question['id'] ?>]"
                                   id="q<?= $question['id'] ?>A"
                                   value="A">
                            <label class="form-check-label" for="q<?= $question['id'] ?>A">
                                <?= $question['a'] ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question[<?= $question['id'] ?>]"
                                   id="q<?= $question['id'] ?>B"
                                   value="B">
                            <label class="form-check-label" for="q<?= $question['id'] ?>B">
                                <?= $question['b'] ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question[<?= $question['id'] ?>]"
                                   id="q<?= $question['id'] ?>C"
                                   value="C">
                            <label class="form-check-label" for="q<?= $question['id'] ?>C">
                                <?= $question['c'] ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question[<?= $question['id'] ?>]"
                                   id="q<?= $question['id'] ?>D"
                                   value="D">
                            <label class="form-check-label" for="q<?= $question['id'] ?>D">
                                <?= $question['d'] ?>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <input type="submit" value="Yakunlash" class="btn btn-primary">
            </div>
        </form>

    <?php endif; ?>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
