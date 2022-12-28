<?php 

    if(!isset($_POST['email']) || !isset($_POST['project'])|| !isset($_POST['block']) || !isset($_POST['image'])){
        echo 'get away';
        die();
    }


    $filename = $_POST['image']["name"];
	$tempname = $_POST['image']["tmp_name"];
	$folder = "../image/" . $filename;
	
	
    if(!$database = mysqli_connect("localhost", "root", "", "web_dreamer")){
        die('No connection: ' . mysqli_connect_error());
    }

    $sql = "SELECT * FROM `image_backup` WHERE project_id=". $_POST['project'] . "AND block_id=" . $_POST['block'] . "AND email='" . $_POST['email'] . "'";
    $result = mysqli_query($database, $sql);

    if($row = mysqli_fetch_assoc($result)) {
        $sql = "UPDATE image SET `filename`='" . $filename ."' WHERE projectid=". $_POST['project'] . "AND blockid=" . $_POST['block'] . "AND email='" . $_POST['email'] . "'";
        mysqli_query($database, $sql);
    }
    else{
        $sql = "INSERT INTO image (email,filename,projectid,blockid) VALUES ('" . $_POST['email'] . "','$filename'," . $_POST['project'] . "," . $_POST['block'] . ")";
        mysqli_query($database, $sql);
    }

    if (move_uploaded_file($tempname, $folder)) {
		echo "<h3> Image uploaded successfully!</h3>";
	} else {
		echo "<h3> Failed to upload image!</h3>";
	}
?>