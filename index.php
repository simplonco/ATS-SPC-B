<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!--
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.2.0/material.indigo-pink.min.css">
  <script defer src="https://code.getmdl.io/1.2.0/material.min.js"></script>
  -->
  <title>ATS App</title>
  <script>
$(document).ready(function(){
   $("#bienvenue").click(function(){
       $("#page").slideToggle("slow");
       $("#bienvenue").hide();
   });
});
</script>
</head>
<body>
    <?php
    if (isset($_POST['Validate'])) {
        $passcode = $_POST['passcode'];
        $errors = array();
        if (empty($passcode)) {
            $errors[] = 'All fields required';
        } else {
            // Connect to database
            include 'php/conn.php';
            // Retreive user form passcode
            $sql_user = "SELECT * FROM users WHERE passcode = '$passcode'";
            $stmt_user = $conn->query($sql_user);
            // Retreive user informations
            while ($row_user = $stmt_user->fetch(PDO::FETCH_ASSOC)) {
                $user_id = $row_user['id'];
                $name = $row_user['name'];
                $surname = $row_user['surname'];
            }
            // Check if user exist
            if (!isset($user_id)) {
                $errors[] = 'The user_id is wrong';
            } else {
                $sql_arrival_time = "SELECT arrival_time FROM checkins WHERE user_id = $user_id ORDER BY id";
                $stmt_arrival_time = $conn->query($sql_arrival_time);
                $PREVIOUS_ARRIVAL_TIME = new DateTime('@0'); // very old Datetime!
                // Retreive arrival time
                while ($row = $stmt_arrival_time->fetch(PDO::FETCH_ASSOC)) {
                    $PREVIOUS_ARRIVAL_TIME = new DateTime($row['arrival_time']);
                }
                //Check if there is already an entry of this user today
                $day = strtotime($PREVIOUS_ARRIVAL_TIME->format('Y-m-d H:i:s'));
                $day = date("Y-m-d", $day);
                $current_day = date("Y-m-d");
                if ($day != $current_day) {
                    // Get arrival time
                    $ARRIVAL_TIME = new DateTime(); // current DateTime!
                    $LATE_TIME = new DateTime('10:00:00');
                    $ABSENT_TIME = new DateTime('12:00:00');
                    // Add entry in checkin table
                    $sql_checkin = 'INSERT INTO checkins(user_id) VALUES (?)';
                    $stmt_checkin = $conn->prepare($sql_checkin);
                    $stmt_checkin->bindParam(1, $user_id, PDO::PARAM_STR);
                    $stmt_checkin->execute();
                    // Display user message
                    if ($ARRIVAL_TIME  > $LATE_TIME && $ARRIVAL_TIME < $ABSENT_TIME) {
                        $errors[] = "Welcome $name $surname but you are late for today:<br />".$ARRIVAL_TIME->format('Y-m-d H:i:s');
                    } elseif ($ARRIVAL_TIME > $ABSENT_TIME) {
                        $errors[] = "Welcome $name $surname but you will be considered as absent today:<br />".$ARRIVAL_TIME->format('Y-m-d H:i:s');
                    } else {
                        $success = "Welcome $name $surname and Thank you:<br />".$ARRIVAL_TIME->format('Y-m-d H:i:s');
                    }
                } else { // $day == $current_day
                    $errors[] = 'You have already checked in';
                }
            }
        }
    }
    ?>
    <img id="logo" src="image/logo-accenture.png">
    <?php // DEBUG: if (!$_GET["ft"]) { ?>
    <div id="welcome_page">
       <h1 id="bienvenue">Bienvenue </br> à </br> Accenture</h1>
     </div>
     <?php // DEBUG: } ?>
    <div id="page">
        <form class="form-horizontal" action="?ft=1" method="POST"> <!-- DEBUG -->
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
                <label class="control-label" for="textinput-1">Enter your passcode, please</label></br></br>
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
