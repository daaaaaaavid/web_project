<?php 

    if(!isset($_POST['email']) || !isset($_POST['project'])|| !isset($_POST['block']) || !isset($_FILES['file'])){
        echo 'get away';
        exit();
    }

    if(!($database = mysqli_connect("localhost", "root", "", "web_dreamer"))){
        die("connect error");
    }

    $filename=$_FILES['file']['name'];
    $tempname=$_FILES['file']['tmp_name'];
    $filetype=$_FILES['file']['type'];
    $filesize=$_FILES['file']['size'];
    $file = NULL;
    
    if(isset($_FILES['file']['error'])){    
        if($_FILES['file']['error']==0){                                    
            $instr = fopen($tempname,"rb" );
            $file = addslashes(fread($instr,filesize($tempname)));        
        }
    }

    $sql = "SELECT * FROM `image_backup` WHERE project_id=". $_POST['project'] . " AND block_id=" . $_POST['block'] . " AND email='" . $_POST['email'] . "'";
    $result = mysqli_query($database, $sql);

    if($row = mysqli_fetch_assoc($result)) {
        $sql = "UPDATE image_backup SET image='" . $file ."'WHERE project_id=". $_POST['project'] . " AND block_id=" . $_POST['block'] . " AND email='" . $_POST['email'] . "'";
        mysqli_query($database, $sql);
    }
    else{

        $sql = "INSERT INTO `image_backup` (email, project_id, block_id, image, type) VALUES ('" . $_POST['email']."', " . $_POST['project'].", " . $_POST['block'].", '" . $file ."', '" . end(explode('.',$filename)) ."')";
        mysqli_query($database, $sql);

    }


?>