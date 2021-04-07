<?php
$connection = new PDO('mysql:host=localhost;dbname=php_baza','root','');
$object = $connection->query('SELECT COUNT(id) as st_count FROM students')->fetch(PDO::FETCH_ASSOC);
?>
<div class="panel panel-primary text-center no-boder bg-color-green green">
    <div class="panel-left pull-left green">
        <i class="fa fa-users fa-5x"></i>

    </div>
    <div class="panel-right pull-right">
        <h3><?=$object['st_count']?></h3>
        <strong> Studentlar</strong>
    </div>
</div>