<?php

    if(!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['project'])){
        header('Location: http://localhost/web/auth/auth.php');
        exit();
    }

	$email =  $_POST["email"];
    $password = $_POST["password"];

    if (!($database = mysqli_connect("localhost", "root", "", "web_dreamer"))) {
        echo "<form method=\"POST\" action=\"../auth/auth.php\">
        <input type=\"text\" value=\"Database Connection Error\" name=\"error_msg\">
        <button id=\"btn\"></button>
        </form>";
        echo "<script>document.querySelector('#btn').click();</script>";
        exit();
    }

    if (!($query = mysqli_query($database, 'SELECT email FROM account'))) {
        echo "<form method=\"POST\" action=\"../auth/auth.php\">
        <input type=\"text\" value=\"Database Connection Error\" name=\"error_msg\">
        <button id=\"btn\"></button>
        </form>";
        echo "<script>document.querySelector('#btn').click();</script>";
        exit();
    }

    
    if(strlen($email)==0){
        echo "<form method=\"POST\" action=\"../auth/auth.php\">
        <input type=\"text\" value=\"Enter The Email\" name=\"error_msg\">
        <button id=\"btn\"></button>
        </form>";
        echo "<script>document.querySelector('#btn').click();</script>";
        exit();
    }

    if(strlen($password)==0){
        echo "<form method=\"POST\" action=\"../auth/auth.php\">
        <input type=\"text\" value=\"Enter The Password\" name=\"error_msg\">
        <button id=\"btn\"></button>
        </form>";
        echo "<script>document.querySelector('#btn').click();</script>";
        exit();
    }

    $find = false;
    $sql = "SELECT email, password, image FROM account";
    $result = mysqli_query($database, $sql);

    while($row = mysqli_fetch_assoc($result)) {
        if($email == $row['email'] && $password == $row['password']){
            $find = true;   
            $image = $row['image'];
            break;
        }
    }

    if(!$find){
        echo "<form method=\"POST\" action=\"../auth/auth.php\">
        <input type=\"text\" value=\"Enter Right Email or Password\" name=\"error_msg\">
        <button id=\"btn\"></button>
        </form>";
        echo "<script>document.querySelector('#btn').click();</script>";
        exit();
    }

	$sql = "SELECT * FROM `" . $email . "` WHERE id=". $_POST['project'];
	if(!($query=mysqli_query($database, $sql))){
		echo "Error Occur";
		die();
	}

	$row = mysqli_fetch_assoc($query);
	$html = $row['html'];
	$size = $row['size'];

?>
<?php

$email =  $_POST["email"];
$password = $_POST["password"];

if (!($database = mysqli_connect("localhost", "root", "", "web_dreamer"))) {
    echo "<form method=\"POST\" action=\"../auth/auth.php\">
    <input type=\"text\" value=\"Database Connection Error\" name=\"error_msg\">
    <button id=\"btn\"></button>
    </form>";
    echo "<script>document.querySelector('#btn').click();</script>";
    exit();
}

if (!($query = mysqli_query($database, 'SELECT email FROM account'))) {
    echo "<form method=\"POST\" action=\"../auth/auth.php\">
    <input type=\"text\" value=\"Database Connection Error\" name=\"error_msg\">
    <button id=\"btn\"></button>
    </form>";
    echo "<script>document.querySelector('#btn').click();</script>";
    exit();
}


if(strlen($email)==0){
    echo "<form method=\"POST\" action=\"../auth/auth.php\">
    <input type=\"text\" value=\"Enter The Email\" name=\"error_msg\">
    <button id=\"btn\"></button>
    </form>";
    echo "<script>document.querySelector('#btn').click();</script>";
    exit();
}

if(strlen($password)==0){
    echo "<form method=\"POST\" action=\"../auth/auth.php\">
    <input type=\"text\" value=\"Enter The Password\" name=\"error_msg\">
    <button id=\"btn\"></button>
    </form>";
    echo "<script>document.querySelector('#btn').click();</script>";
    exit();
}

$find = false;
$sql = "SELECT email, password, image FROM account";
$result = mysqli_query($database, $sql);

while($row = mysqli_fetch_assoc($result)) {
    if($email == $row['email'] && $password == $row['password']){
        $find = true;   
        $image = $row['image'];
        break;
    }
}

if(!$find){
    echo "<form method=\"POST\" action=\"../auth/auth.php\">
    <input type=\"text\" value=\"Enter Right Email or Password\" name=\"error_msg\">
    <button id=\"btn\"></button>
    </form>";
    echo "<script>document.querySelector('#btn').click();</script>";
    exit();
}

$sql = "SELECT * FROM `" . $email . "` WHERE id=". $_POST['project'];
if(!($query=mysqli_query($database, $sql))){
    echo "Error Occur";
    die();
}

$row = mysqli_fetch_assoc($query);
$html = $row['html'];

?>
<!DOCTYPE html>
<html>
  <head>
    <title>
        (預覽) <?php echo $row['name']; ?>
    </title>
    <link rel="icon" href="../logo/icon.PNG">
    <link rel="stylesheet" href="../drag-and-drop/t3.css"/>
    <link rel="stylesheet" href="../logo/logo.css"/>
    <link rel="stylesheet" href="../drag-and-drop/top.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  </head>
  <body>
    <?php echo $html;?>
  </body>
  <script>
    window.onload = function(){
        document.querySelectorAll('.block').forEach((item)=>{
            item.setAttribute('style', 'background: white; border: 0px;');
            item.setAttribute('draggable', 'false');
            item.setAttribute('contenteditable', 'false');
        })

        document.querySelectorAll('.block_text').forEach((item)=>{
            item.setAttribute('style', 'background: white; border: 0px;');
            item.setAttribute('draggable', 'false');
            item.setAttribute('contenteditable', 'false');
        })
    }
    
  </script>
  </html>
