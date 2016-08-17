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
	if(isset($_POST['add-new'])){
		$username=$_POST["username"];
		$password=$_POST["password"];
		$email=$_POST["email"];
        $errors =array();
		if (empty($username) || empty($password)) {
			$errors[]="ALL Fields requierd";
		}
		else{
		include 'conn.php';
		$sql ="INSERT INTO users(name,passcode) VALUES (?,?)";
		$stmt=$conn->prepare($sql);
		$stmt->bindParam(1,$username,PDO::PARAM_STR);
		$stmt->bindParam(2,$password,PDO::PARAM_STR);
		$stmt->execute();
		$success = "the table is add";
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
  <li role="presentation"><a href="showall.php"><span class="glyphicon glyphicon-asterisk"></span>Report</a></li>
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
    <label class="control-label" for="textinput-1">username</label>
    <div class="controls">
      <input id="textinput-1" name="username" type="text" placeholder="username" class="input-xlarge">
    </div>
  </div>

  <!-- Text input-->
  <div class="control-group">
    <label class="control-label" for="textinput-1">password</label>
    <div class="controls">
      <input id="textinput-1" name="password" type="text" placeholder="password" class="password">
    </div>
  </div>
<!-- Button -->
<div class="control-group">
  <div class="controls">
    <button id="singlebutton-0" name="add-new" class="btn btn-primary">Add</button>
  </div>
</div>
</fieldset>
</form>





  </div>

</body>
</html>
