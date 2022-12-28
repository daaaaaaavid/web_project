<?php

    if(!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['image']) || !isset($_POST['project'])){
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
<!DOCTYPE html>
<html>
  <head>
    <title>
        drag and drop
    </title>
    <link rel="stylesheet" href="t3.css"/>
    <link rel="stylesheet" href="../logo/logo.css"/>
    <link rel="stylesheet" href="top.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="tool.js"></script>
  	<script src="t3.js"></script>
    <script src="top.js"></script>
    <script>tool.set_item_to_int("block_id", <?php echo $row['size']+1 ?>);</script>
  </head>
  <body>
    <div class="top">
      
        <div class="div-logo">
			<form method="POST" action="../creation_project/index.php">
                <input type="text" style="display: none" value="<?php echo $_POST['email'] ?>" name="email">
                <input type="text" style="display: none" value="<?php echo $_POST['password'] ?>" name="password">
                <button style="border: 0px; background-color: transparent; display: flex; cursor:pointer;">
                    <img src="../logo/icon.PNG" class="logo">
                </button>
            </form>
            <input type="text" value="<?php echo $row['name'] ?>" id="project-name">
            <p id="store-message" class="message">未有任何動態</p>
        </div>
      
      <div class="user">
          <img src="../selfie_img/<?php echo $_POST['image'];?>.png" class="selfie" id="user">
          <ul class="user-list">
              <li>Hi <strong><?php $email = explode('@', $_POST['email']); echo $email[0] ?></strong></li>
              <li class="need-hover">LOG OUT</li>
          </ul>
      </div>
    </div>
    <hr>
    <div class="tool-bar" id="tool-bar">
      
    </div>
    <hr>
    <img id="temp">
    <div class="middle">
      <div class="left" id="sortlist">
			<?php echo $html; ?>
      </div>
      <div class="right" id="addlist">
        <div>
          <p style="text-align: center; font-size: larger;">模板</p>
        </div>
        <div>
          <div class="template" id="text-only" style="width: 30%; margin: 30px 35%;">
            <span></span><img class="text-icon"src="text-block.PNG" width:538px height:348px>
          </div>
          <div class="template" id="image-only" style="width: 30%; margin: 30px 35%;">
            <span></span><img class="camera-icon"src="img-block.png" width:537px height:349px>
          </div>
          <div class="template" id="image-text">
            <span></span><img class="camera-icon"src="img-block.png" width:676px height:514px>
            <img class="text-icon"src="text-block.PNG" width:832px height:290px>
          </div>
          <div class="template" id="text-image">
            <span></span><img class="text-icon"src="text-block.PNG" width:832px height:290px>
            <img class="camera-icon"src="img-block.png" width:676px height:514px>
          </div>
        </div>
      </div>
    </div>
	<script>
		document.querySelectorAll('.block').forEach((item) =>{
			item.addEventListener('click', function(){
				if(this.id.includes('textonly')){
					initial_btn_function_textonly(this.id);
				}
				else if(this.id.includes('imageonly') && document.getElementById(this.id).children.length <= 1){
					initial_btn_function_imgonly(this.id);
				}
			})
		});
    
  </script>
	
	<script>
		const save_html = function(){
      console.log(tool.list['block_id']['value'])
			$.post('update.php', {email: '<?php echo $_POST['email'] ?>', project: <?php echo $_POST['project'] ?>, html: $('.left').html().trim().replace('\n',''),size: tool.list['block_id']['value']},function(text){
				if(text.includes('xampp')){
					alert(text);
					return;
				}
				else{
					if(text.length != 0)
					$('#store-message').text(text);
				}
			});
			
		}
		const save_name = function(){
			$.post('modify_name.php', {email: '<?php echo $_POST['email'] ?>', project: <?php echo $_POST['project'] ?>, name: $('#project-name').val()},function(text){
				if(text.includes('xampp')){
					alert(text);
					return;
				}
				else{
					if(text.length != 0)
					$('#store-message').text(text);
				}
			});
			
		}
		window.onload = function(){
			document.getElementById('project-name').addEventListener('change', function(){
				save_name();
			})
		}
	setTimeout(save_html, 1000);
	setInterval(save_html, 60000);
  </script>
  </body>
  
</html>