<?php
$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
$object = $connection->query('SELECT COUNT(id) as qs_count FROM questions')->fetch(PDO::FETCH_ASSOC);
?>
<div class="panel panel-primary text-center no-boder bg-color-brown brown">
    <div class="panel-left pull-left brown">
        <i class="fa fa-question fa-5x"></i>

    </div>
    <div class="panel-right pull-right">
        <h3><?= $object['qs_count'] ?> </h3>
        <strong>Savollar</strong>

    </div>
</div>

