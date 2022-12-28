<?php

if(!isset($_POST['email']) || !isset($_POST['project'])|| !isset($_POST['block'])){
    echo 'get away';
    exit();
}

if(!($database = mysqli_connect("localhost", "root", "", "web_dreamer"))){
    die("connect error");
}

$sql = "SELECT * FROM `image_backup` WHERE project_id=". $_POST['project'] . " AND block_id=" . $_POST['block'] . " AND email='" . $_POST['email'] . "'";
$result = mysqli_query($database, $sql);

if($row = mysqli_fetch_assoc($result)) {
    header('Content-Type: image/jpeg');
    echo $row['image'];
}



?>