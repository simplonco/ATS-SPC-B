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

    <div id="page">
        <div id="page_header">
            <h1>Projet SPC</h1>
            <h2>(Suivi de Présence du Collaborateur)</h2>
        </div>
        <ul class="nav nav-pills">
          <li role="presentation" class="active"><a href="../php/dashbord.php"><span class="glyphicon glyphicon-asterisk"></span>Dashbord</a></li>
          <li role="presentation"class="active"><a href="../php/addnew.php"><span class="glyphicon glyphicon-asterisk"></span>Addnew</a></li>
          <li role="presentation"class="active"><a href="../php/showall.php"><span class="glyphicon glyphicon-asterisk"></span>Report</a></li>
          <li role="presentation"class="active"><a href="../index.php"><span class="glyphicon glyphicon-asterisk"></span>checkin</a></li>
        </ul>
        <?php
        if(isset($_POST['Validate'])){
          $user_id = $_POST["user_id"];
          $errors = array();
          if (empty($user_id)) {
            $errors[] = "ALL Fields requierd";
          } else {
        require 'conn.php';

        $sql="SELECT * FROM checkins WHERE user_id = $user_id ";
        $stmt =$conn->query($sql);
        $count=$stmt->rowcount();
        if ($user_id == NULL) {
          $errors[] = "The user id is wrong";
        }
        $id=1;
        $LATE_TIME = new DateTime('15:10:00');
        $ABSENT_TIME = new DateTime('17:00:00');
        $bad="late time";
        $good="at the time";
        if($count){


        ?>

        <table class="table">
        	<tr>
            <td></td>
          <td>user_id</td>
          <td>ARRIVAL_TIME</td>
        </tr>
        <?php
        while ( $row=$stmt->fetch(PDO::FETCH_OBJ)) {
$ARRIVAL_TIME = new DateTime($row->arrival_time);
if ($ARRIVAL_TIME < $LATE_TIME ) {

        		echo"
        		<tr>
        		<td>".$id++."</td>
            <td>{$row->user_id}</td>
        		<td>".$ARRIVAL_TIME->format('Y-m-d H:i:s')."</td>
        		</tr>
        		";

        }
      else {
                		echo"

                		<tr>
                		<td>".$id++."</td>
                    <td>{$row->user_id}</td>
                		<td>".$ARRIVAL_TIME->format('Y-m-d H:i:s')."</td>
                		</tr>
                		";

                }
}
        ?>
        </table>
        <?php
        } else {

        }
      }
    }
        ?>
        <?php
        if (isset($errors)) {
          foreach ($errors as $error) {
            echo '<div class="alert alert-danger">'.$error.'</div>';
          }
        }
        ?>
<form class="form-horizontal" action="" method="POST">

  <div class="control-group">
    <label class="control-label" for="textinput-1">user_id</label>
    <div class="controls">
      <input id="textinput-1" name="user_id" type="text" placeholder="user_id" class="input-xlarge">
    </div>
  </div>
  <br />
  <div class="control-group">
    <div class="controls">
      <button id="singlebutton-0" name="Validate" class="btn btn-primary" onclick="newDoc()">Validate</button>
    </div>
      </form>
    </div>
</body>

</html>
