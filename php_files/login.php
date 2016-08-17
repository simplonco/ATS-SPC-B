<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/custom.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</head>
<body>
  <?php
	if(isset($_POST['login'])){
		$user_id=$_POST["user_id"];
        $errors =array();
		if (empty($user_id)) {
			$errors[]="ALL Fields requierd";
		}
		else{
		include 'conn.php';
		$sql ="INSERT INTO checkins(user_id) VALUES (?)";
		$stmt=$conn->prepare($sql);
		$stmt->bindParam(1,$user_id,PDO::PARAM_STR);
		$stmt->execute();
		$success = "the user is add";
		}
	}
?>
  <div id="page">
  <div id="page_header">
    <h1>Projet SPC</h1>
<h2>(Suivi de Présence du Collaborateur)</h2>
</div>
<ul class="nav nav-pills">
  <li role="presentation" class="active"><a href="dashbord.php"><span class="glyphicon glyphicon-asterisk"></span>Dashbord</a></li>
  <li role="presentation"><a href="addnew.php"><span class="glyphicon glyphicon-asterisk"></span>Addnew</a></li>
  <li role="presentation"><a href="showall.php"><span class="glyphicon glyphicon-asterisk"></span>Showall</a></li>
  <li role="presentation"><a href="login.php"><span class="glyphicon glyphicon-asterisk"></span>login</a></li>
</ul>
<form class="form-horizontal" action="" method="POST">
  <br/>
  <?php
  if($success){
  	echo '<div class="alert alert-success">'.$success.'</div>';
  }
  if(isset($errors))
  {
  	foreach ($errors as $error) {
  		echo '<div class="alert alert-danger">'.$error.'</div>';
  	}
  }
  ?>


  <div class="control-group">
    <label class="control-label" for="textinput-1">User_id</label>
    <div class="controls">
      <input id="textinput-1" name="username" type="text" placeholder="user_id" class="input-xlarge">
    </div>
  </div>

  <!-- Text input-->

<!-- Button -->
<div class="control-group">
  <div class="controls">
    <button id="singlebutton-0" name="login" class="btn btn-primary">Validate</button>
  </div>
</div>
</fieldset>
</form>



  </div>

</body>
</html>
