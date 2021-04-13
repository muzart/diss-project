<?php
session_start();

if (!isset($_SESSION['st_login']) || $_SESSION['st_login'] !== 1) {
    header('Location: login.php');
    exit(0);
}

if (!isset($_SESSION['subject']))
    header('Location: index.php');

$subject_id = $_SESSION['subject'];
$connection = new PDO('mysql:host=localhost;dbname=php_baza', 'root', '');
$questions = $connection->query('SELECT * FROM questions WHERE subject_id=' . $subject_id)
    ->fetchAll(PDO::FETCH_ASSOC);

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
    <form action="" method="post">

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <?php for ($i = 1; $i <= count($questions); $i++): ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($i == 1) ? "active" : "" ?>" id="q<?= $i ?>-tab" data-toggle="pill"
                       href="#q<?= $i ?>" role="tab" aria-controls="q<?= $i ?>"><?= $i ?> - savol</a>
                </li>
            <?php endfor; ?>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <?php
            $c = 0;
            foreach ($questions as $question):
                $c++
                ?>
                <div class="tab-pane fade <?= ($c == 1) ? "show active" : "" ?>" id="q<?= $c ?>" role="tabpanel"
                     aria-labelledby="q<?= $c ?>-tab">
                    <p>
                        Savol: <?= $question['question'] ?>
                    </p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question[<?= $c ?>]" id="q<?= $c ?>A"
                               value="A">
                        <label class="form-check-label" for="q<?= $c ?>A">
                            <?= $question['a'] ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question[<?= $c ?>]" id="q<?= $c ?>B"
                               value="B">
                        <label class="form-check-label" for="q<?= $c ?>B">
                            <?= $question['b'] ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question[<?= $c ?>]" id="q<?= $c ?>C"
                               value="C">
                        <label class="form-check-label" for="q<?= $c ?>C">
                            <?= $question['c'] ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question[<?= $c ?>]" id="q<?= $c ?>D"
                               value="D">
                        <label class="form-check-label" for="q<?= $c ?>D">
                            <?= $question['d'] ?>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <input type="submit" value="Yakunlash" class="btn btn-primary">
    </form>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
