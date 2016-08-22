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
    if (isset($_POST['add-new'])) {
        $username = $_POST['name'];
        $surname = $_POST['surname'];
        $password = $_POST['passcode'];
        $mail = $_POST['mail'];

        $errors = array();
        if (empty($username) || empty($password)) {
            $errors[] = 'ALL Fields requierd';
        } else {
            include 'conn.php';
            $sql = 'INSERT INTO users(name,surname,mail,passcode) VALUES (?,?,?,?)';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $username, PDO::PARAM_STR);
            $stmt->bindParam(2, $surname, PDO::PARAM_STR);
            $stmt->bindParam(3, $mail, PDO::PARAM_STR);
            $stmt->bindParam(4, $password, PDO::PARAM_STR);
            $stmt->execute();
            $success = 'the table is add';
        }
    }
    ?>
    <div id="page">
        <div id="page_header">
            <h1>Projet SPC</h1>
            <h2>(Suivi de Présence du Collaborateur)</h2>
        </div>
        <ul class="nav nav-pills">
            <li role="presentation" class="active"><a href="../php/dashbord.php"><span class="glyphicon glyphicon-asterisk"></span>Dashbord</a></li>
            <li role="presentation" class="active"><a href="../php/addnew.php"><span class="glyphicon glyphicon-asterisk"></span>Addnew</a></li>
            <li role="presentation" class="active"><a href="../php/showall.php"><span class="glyphicon glyphicon-asterisk"></span>Report</a></li>
            <li role="presentation" class="active"><a href="../index.php"><span class="glyphicon glyphicon-asterisk"></span>checkin</a></li>
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
                <label class="control-label" for="textinput-1">username</label>
                <div class="controls">
                    <input id="textinput-1" name="name" type="text" placeholder="username" class="input-xlarge">
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="textinput-1">surname</label>
                <div class="controls">
                    <input id="textinput-1" name="surname" type="text" placeholder="surname" class="input-xlarge">
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="textinput-1">email</label>
                <div class="controls">
                    <input id="textinput-1" name="mail" type="text" placeholder="mail" class="input-xlarge">
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="textinput-1">passcode</label>
                <div class="controls">
                    <input id="textinput-1" name="passcode" type="text" placeholder="passcode" class="input-xlarge">
                </div>
            </div>

            <!-- Button -->
            <div class="control-group">
                <div class="controls">
                    <button id="singlebutton-0" name="add-new" class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
