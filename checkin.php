
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
</head>
<body>
    <div id="header">
        <img id="logo" alt="accenture" src="image/logo-accenture.png">
    </div>
    <?php

    if (isset($_POST['Validate'])) {
        $passcode = $_POST['passcode'];
        $user_name = $_POST['user_name'];
        $errors = array();
        if (empty($passcode)||empty($user_name)) {
            $errors[] = 'Tous les champs sont obligatoires';
        } else {
            // Connect to database
            include 'php/conn.php';

            // Retreive user form passcode
            $sql_user = "SELECT * FROM users WHERE passcode = '$passcode'&& surname = '$user_name'";
            $stmt_user=$conn->prepare($sql_user);
            $stmt_user->bindParam(1,$passcode,PDO::PARAM_INT);
            $stmt_user->execute();

            // Retreive user informations
            while ($row_user = $stmt_user->fetch(PDO::FETCH_ASSOC)) {
                $user_id = $row_user['id'];
                $name = $row_user['name'];
                $surname = $row_user['surname'];
                $email = $row_user['mail'];
            }

            // Check if user exist
            if (!isset($user_id)) {
                $errors[] = 'Mot de passe incorrect';
            } else {
                $sql_arrival_time = "SELECT arrival_time FROM checkins WHERE user_id = $user_id ORDER BY id";
                $stmt_arrival_time = $conn->query($sql_arrival_time);
                $PREVIOUS_ARRIVAL_TIME = new DateTime('@0'); // very old Datetime!

                // Retreive arrival time
                while ($row = $stmt_arrival_time->fetch(PDO::FETCH_ASSOC)) {
                    $PREVIOUS_ARRIVAL_TIME = new DateTime($row['arrival_time']);
                }

                // Check if there is already an entry of this user today
                $day = strtotime($PREVIOUS_ARRIVAL_TIME->format('Y-m-d H:i:s'));
                $day = date('Y-m-d', $day);
                $current_day = date('Y-m-d');

                if ($day != $current_day) {

                    // Get arrival time
                    $ARRIVAL_TIME = new DateTime(); // current DateTime!
                    $LATE_TIME = new DateTime('10:00:00');
                    $ABSENT_TIME = new DateTime('12:00:00');

                    // Add entry in checkin table
                    $sql_checkin = 'INSERT INTO checkins(user_id,surname) VALUES (?,?)';
                    $stmt_checkin = $conn->prepare($sql_checkin);
                    $stmt_checkin->bindParam(1, $user_id, PDO::PARAM_STR);
                    $stmt_checkin->bindParam(2, $surname, PDO::PARAM_STR);
                    $stmt_checkin->execute();

                    // Display user message
                    if ($ARRIVAL_TIME > $LATE_TIME && $ARRIVAL_TIME < $ABSENT_TIME) {
                        $success = "Bienvenue $name $surname mais vous êtes en retard aujourd'hui <br />".$ARRIVAL_TIME->format('Y-m-d H:i:s');
                    } elseif ($ARRIVAL_TIME > $ABSENT_TIME) {
                        $success = "Bienvenue $name $surname mais vous serez considéré comme absent aujourd'hui <br />".$ARRIVAL_TIME->format('Y-m-d H:i:s');
                    } else {
                        $success = "Bienvenue $name $surname merci d'être à l'heure <br />".$ARRIVAL_TIME->format('Y-m-d H:i:s');
                    }

      //send email
                    function send_email($email,$success)
                        {
                          require_once 'phpmailer/class.phpmailer.php';
                          $mail = new PHPMailer();
                          $mail->IsSMTP();
                          $mail->SMTPDebug = 0;
                          $mail->SMTPAuth = true;
                          $mail->SMTPSecure = 'ssl';
                          $mail->Host = 'smtp.gmail.com';
                          $mail->Port = 465;
                          $mail->AddAddress($email);
                          $mail->Username = 'emailforaccenture@gmail.com';
                          $mail->Password = 'ACCENTURE123';
                          $mail->Subject = 'confirmation de presence' ;
                          $mail->MsgHTML($success);
                          $mail->Send();
                        }
                        send_email($email,$success);
                } else { // $day == $current_day
                    $success = 'Vous avez déjà été enregistré';
                }

            }
        }
    }
    ?>
    <div id="page">
        <form id="checkin-form" class="form-horizontal" action="" method="POST">
            <?php
            if (isset($success)) {
            ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
                <script>
                setTimeout(function () {
                    window.location = "index.php";
                }, 20000);
                </script>
            <?php
            }
            if (isset($errors)) {
                foreach ($errors as $error) {
                    echo '<div class="alert alert-danger">'.$error.'</div>';
                }
            }
            ?>
            <div class="control-group">
              <label class="control-label" for="textinput-1">Nom d'utilisateur</label>
              <div class="controls">
                  <input name="user_name" type="text" placeholder="Nom d'utilisateur" class="input-xlarge" />
              </div>
                <label class="control-label" for="textinput-1">Mot de passe</label>
                <div class="controls">
                    <input name="passcode" type="Password" placeholder="Mot de passe" class="input-xlarge" />
                </div>
                <div class="controls">
                    <button name="Validate" class="btn btn-primary" onclick="newDoc()">Valider</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
