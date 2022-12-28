<?php 
    
    if(!isset($_POST['email']) || !isset($_POST['project']) || !isset($_POST['html']) || !isset($_POST['size'])){
        echo 'get away';
        die();
    }  

    if (!($database = mysqli_connect("localhost", "admin", "WEB#dreamer$1104&1126", "web_dreamer"))) {
        die("Connection failed.");
    }

    $sql = "SELECT * FROM `" . $_POST['email'] . "` WHERE id=". $_POST['project'];
	if(!($query=mysqli_query($database, $sql))){
		echo "Error Occur";
		die();
	}
    $row = mysqli_fetch_assoc($query);

    $before = $row['modify_time'];

    $sql = "UPDATE `" . $_POST['email'] . "` SET `html` = '" . $_POST['html'] . "', `size` =" . $_POST['size'] ." WHERE `" . $_POST['email'] . "`.`id` = " . $_POST['project'];
    if (!($query = mysqli_query($database, $sql))) {
        die("INSERTION failed.");
    }

    $sql = "SELECT * FROM `" . $_POST['email'] . "` WHERE id=". $_POST['project'];
	if(!($query=mysqli_query($database, $sql))){
		echo "Error Occur";
		die();
	}
    $row = mysqli_fetch_assoc($query);

    if($before != $row['modify_time'])
        echo "已儲存於 " . $row['modify_time']; 

?>