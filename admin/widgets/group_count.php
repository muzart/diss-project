<?php
$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
$object = $connection->query('SELECT COUNT(id) as gr_count FROM groups')->fetch(PDO::FETCH_ASSOC);
?>
<div class="panel panel-primary text-center no-boder bg-color-red red">
    <div class="panel-left pull-left red">
        <i class="fa fa fa-building-o fa-5x"></i>

    </div>
    <div class="panel-right pull-right">
        <h3><?= $object['gr_count'] ?> </h3>
        <strong> Guruhlar </strong>

    </div>
</div>