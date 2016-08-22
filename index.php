<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
  <?php
  if (isset($_POST['Validate'])) {
      $passcode = $_POST["passcode"];
      $errors = array();
      if (empty($passcode)) {
          $errors[] = "All fields required";
      } else {
          // Connect to database
          include 'php/conn.php';

          // Retreive user form passcode
          $sql_user = "SELECT * FROM users WHERE passcode = $passcode";
          $stmt_user = $conn->query($sql_user);
          $user_id = 0;
          while($row_user = $stmt_user->fetch(PDO::FETCH_ASSOC)) {
            $user_id = $row_user["id"];
          }

          if ($user_id == 0) {
            $errors[] = "The user id is wrong";
          } else {

            // Add entry in checkin table
            // TODO: Check if there is already an entry of this user today
            $sql_checkin ="INSERT INTO checkins(user_id) VALUES (?)";
            $stmt_checkin = $conn->prepare($sql_checkin);
            $stmt_checkin->bindParam(1, $user_id, PDO::PARAM_STR);
            $stmt_checkin->execute();

            // Retreive arrival time
            $sql_arrival_time = "SELECT arrival_time FROM checkins WHERE user_id = $user_id ORDER BY id";
            $stmt_arrival_time = $conn->query($sql_arrival_time);

            while($row = $stmt_arrival_time->fetch(PDO::FETCH_ASSOC)) {
                $ARRIVAL_TIME = new DateTime($row["arrival_time"]);
            }

            $LATE_TIME = new DateTime('10:00:00');
            $ABSENT_TIME = new DateTime('12:00:00');

            if ($ARRIVAL_TIME  > $LATE_TIME && $ARRIVAL_TIME < $ABSENT_TIME) {
                $errors[] = "Welcome but you are late today:<br />".$ARRIVAL_TIME->format('Y-m-d H:i:s');
            } else if ($ARRIVAL_TIME > $ABSENT_TIME) {
                $errors[] = "Welcome but You will be considered as absent today:<br />".$ARRIVAL_TIME->format('Y-m-d H:i:s');
            } else {
                $success = "Welcome and Thank you:<br />".$ARRIVAL_TIME->format('Y-m-d H:i:s');
            }
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
      <li role="presentation"class="active"><a href="index.php"><span class="glyphicon glyphicon-asterisk"></span>checkin</a></li>
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
        <label class="control-label" for="textinput-1">passcode</label>
        <div class="controls">
          <input id="textinput-1" name="passcode" type="text" placeholder="passcode" class="input-xlarge">
        </div>
      </div>
      <br />

      <!-- Button -->
      <div class="control-group">
        <div class="controls">
          <button id="singlebutton-0" name="Validate" class="btn btn-primary" onclick="newDoc()">Validate</button>
        </div>
      </div>
    </form>

  </div>
</body>

</html>
