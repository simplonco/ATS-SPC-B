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
  if(isset($_POST['Validate'])){
    $passcode = $_POST["passcode"];
    $errors = array();
    if (empty($passcode)) {
      $errors[] = "ALL Fields requierd";
    } else {
      include 'conn.php';
      $sql = "SELECT * FROM users WHERE passcode = $passcode";
      $stmt = $conn->query($sql);
      $user_id = 0;
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user_id = $row["id"];
      }

      if ($user_id == 0) {
        $errors[] = "The user id is wrong";
      } else {
        $sqle ="INSERT INTO checkins(user_id) VALUES (?)";
    		$stmt=$conn->prepare($sqle);
    		$stmt->bindParam(1,$user_id,PDO::PARAM_STR);
    		$stmt->execute();
        $success = "the user id is ".$user_id;
      }
    }
  }
?>
<div id="page">
  <div id="page_header">
    <h1>Projet SPC</h1>
    <h2>(Suivi de Présence du Collaborateur)</h2>
  </div>

  <ul class="nav nav-pills">
    <li role="presentation" class="active"><a href="php/dashbord.php"><span class="glyphicon glyphicon-asterisk"></span>Dashbord</a></li>
    <li role="presentation"class="active"><a href="php/addnew.php"><span class="glyphicon glyphicon-asterisk"></span>Addnew</a></li>
    <li role="presentation"class="active"><a href="php/showall.php"><span class="glyphicon glyphicon-asterisk"></span>Showall</a></li>
  </ul>

  <form class="form-horizontal" action="" method="POST">
    <br />
    <?php
    if ($success) {
      echo '<div class="alert alert-success">'.$success.'</div>';
    }
    if (isset($errors)) {
      foreach ($errors as $error) {
        echo '<div class="alert alert-danger">'.$error.'</div>';
      }
    }
    ?>


    <div class="control-group">
      <ul class="nav nav-pills">
          <li role="presentation"class="active"><a href="index.php"><span class="glyphicon glyphicon-asterisk"></span>checkin</a></li>
          </ul>
      <label class="control-label" for="textinput-1">passcode</label>
      <div class="controls">
        <input id="textinput-1" name="passcode" type="text" placeholder="passcode" class="input-xlarge">
      </div>
    </div>

    <!-- Button -->
    <div class="control-group">
      <div class="controls">
        <button id="singlebutton-0" name="Validate" class="btn btn-primary">Validate</button>
      </div>
    </div>
  </form>

</div>

</body>
</html>
