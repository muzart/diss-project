<?php
    session_start();
    $connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');

    if(!isset($_SESSION['st_login']) || $_SESSION['st_login'] !== 1) {
        header('Location: login.php');
        exit(0);
    }

    if(isset($_SESSION['subject'])) {
        header('Location: test.php');
        exit(0);
    }

    if($_POST) {
        $subject = (int) $_POST['subject'];
        $_SESSION['subject'] = $subject;
        header('Location: test.php');
        exit(0);
    }

    $subjects = $connection->query('SELECT * FROM subjects')->fetchAll(PDO::FETCH_ASSOC);
?>
<html lang="uz">
    <head>
        <title>Fanni tanlash</title>
        <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h1 class="text-center">Testni boshlash uchun fanni tanlang</h1>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="subject">Fanlar</label>
                            <select name="subject" id="subject" class="form-control">
                                <?php foreach ($subjects as $subject): ?>
                                <option value="<?= $subject['id'] ?>"> <?= $subject['name'] ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <p class="text-center">
                                <input type="submit" value="Boshlash" class="btn btn-primary">
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>