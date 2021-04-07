<?php
$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
$object = $connection->query('SELECT COUNT(id) as sb_count FROM subjects')->fetch(PDO::FETCH_ASSOC);
?>
<div class="panel panel-primary text-center no-boder bg-color-blue blue">
    <div class="panel-left pull-left blue">
        <i class="fa fa-book fa-5x"></i>
    </div>

    <div class="panel-right pull-right">
        <h3><?= $object['sb_count'] ?></h3>
        <strong> Fanlar</strong>

    </div>
</div>
