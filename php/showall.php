<!DOCTYPE html>
<html>

<?php include '../header.inc.php'; ?>

<body>
    <div id="page">
        <div id="page_header">
            <h1>Projet SPC</h1>
            <h2>(Suivi de Présence du Collaborateur)</h2>
        </div>
        <ul class="nav nav-pills">
            <li role="presentation" class="active"><a href="../php/dashbord.php"><span class="glyphicon glyphicon-asterisk"></span>Dashbord</a></li>
            <li role="presentation" class="active"><a href="../php/addnew.php"><span class="glyphicon glyphicon-asterisk"></span>Addnew</a></li>
            <li role="presentation" class="active"><a href="../php/showall.php"><span class="glyphicon glyphicon-asterisk"></span>Report</a></li>
        </ul>
        <?php
        if (isset($_POST['Validate'])) {
            $user_id = $_POST['user_id'];
            $Month_in = $_POST['Month_in'];
            $errors = array();
            if (empty($user_id) || empty($Month_in)) {
                $errors[] = 'All fields are requierd';
            } else {
                require 'conn.php';

                $sql = "SELECT * FROM checkins WHERE user_id = '$user_id'";

                $stmt=$conn->prepare($sql);
	             	$stmt->bindParam(1,$user_id,PDO::PARAM_INT);
		            $stmt->execute();
                $count = $stmt->rowcount();

                if ($user_id==0) {
                    $errors[] = 'The user_id is wrong';
                }
                else {
                $id = 1;$j=1;$k=1;$l=1;
                $late = 'late time';
                $in_time = 'in the time';
                $absent="you considered absent";

                      if ($count) {
                ?>
                <script>
                $(document).ready(function(){$("tr:odd").addClass("odd");});
                </script>
                <table class="table">
                     <tr>
                        <td></td>
                        <td>user_id</td>
                        <td>name</td>
                        <td>ARRIVAL_TIME</td>
                     </tr>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                        $ARRIVAL_TIME = $row['arrival_time'];
                        $user=$row['user_id'];
                        $name=$row['name'];
                        $Hour = strtotime($ARRIVAL_TIME);
                        $Hour = date("H", $Hour);
                        $month = strtotime($ARRIVAL_TIME);
                        $month = date("m", $month);

                        if ($month==$Month_in){
                              if ($Hour <10){
                                  echo"
                                      <tr>
                                      <td>".$id++."</td>
                                      <td>$user</td>
                                      <td>$name</td>
                                      <td>$ARRIVAL_TIME</td>
                                      <td>$in_time</td>
                                      </tr>
                                      ";
                             }
                             elseif ($Hour<12){

                             echo"
                                <tr>
                                <td>".$id++."</td>
                                <td>$user</td>
                                <td>$name</td>
                                <td>$ARRIVAL_TIME</td>
                                <td>$late</td>
                                </tr>
                                ";
                            }
                            else {
                            echo"
                          <tr>
                          <td>".$id++."</td>
                          <td>$user</td>
                          <td>$name</td>
                          <td>$ARRIVAL_TIME</td>
                          <td>$absent</td>
                          </tr>
                          ";
                                }
                        }
                 }
                ?>
                </table>
                <?php
                 }
               else {
                    $errors[] = 'There is no user in table';
                }
              }
            }
        }

        if (isset($errors)) {
            foreach ($errors as $error) {
                echo '<div class="alert alert-danger">'.$error.'</div>';
            }
        }
        ?>
        <?php
        if (isset($_POST['Validate1'])) {


                require 'conn.php';

                $sql = "SELECT * FROM checkins ORDER BY 'id'";

                $stmt=$conn->prepare($sql);
	             	$stmt->bindParam(1,$user_id,PDO::PARAM_INT);
		            $stmt->execute();
                $count = $stmt->rowcount();

$id=1;
$j=0;
                $late = 'late time';
                $in_time = 'in the time';
                $absent="you considered absent";

                      if ($count) {
                ?>
                <script>
                $(document).ready(function(){$("tr:odd").addClass("odd");});
                </script>
                <table class="table">
                     <tr>
                        <td></td>
                        <td>user_id</td>
                        <td>name</td>
                        <td>ARRIVAL_TIME</td>
                     </tr>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                        $ARRIVAL_TIME = $row['arrival_time'];
                        $user=$row['user_id'];
                        $name=$row['name'];
                        $Hour = strtotime($ARRIVAL_TIME);
                        $Hour = date("H", $Hour);
                        $month = strtotime($ARRIVAL_TIME);
                        $month = date("m", $month);
                        $day = strtotime($ARRIVAL_TIME);
                        $day = date('Y-m-d', $day);
                        $current_day = date('Y-m-d');
                        if ($day==$current_day){
                              if ($Hour <10){
                                  echo"
                                      <tr>
                                      <td>".$id++."</td>
                                      <td>$user</td>
                                      <td>$name</td>
                                      <td>$ARRIVAL_TIME</td>
                                      <td>$in_time</td>
                                      </tr>
                                      ";
                             }
                             elseif ($Hour<12){

                             echo"
                                <tr>
                                <td>".$id++."</td>
                                <td>$user</td>
                                <td>$name</td>
                                <td>$ARRIVAL_TIME</td>
                                <td>$late</td>
                                </tr>
                                ";
                            }
                            else {
                            echo"
                          <tr>
                          <td>".$id++."</td>
                          <td>$user</td>
                          <td>$name</td>
                          <td>$ARRIVAL_TIME</td>
                          <td>$absent</td>
                          </tr>
                          ";
                                }
                              }
                                else {
                                  $j=$j+1;
                                }
                        }

                ?>
                </table>
                <?php
                 }
               else {
                    $errors[] = 'There is no user in table';
                }
}
if ($j==0) {
$errors[] = 'There is not report today';
}
        if (isset($errors)) {
            foreach ($errors as $error) {
                echo '<div class="alert alert-danger">'.$error.'</div>';
            }
        }
        ?>
        <form class="form-horizontal" action="" method="POST">
              <div class="control-group">
                  <div class="controls">
                      <button id="singlebutton-0" name="Validate1" class="btn btn-primary" onclick="newDoc()">Validate</button>
                  </div>
              </div>
            <div class="control-group">
                <label class="control-label" for="textinput-1">user_id</label>
                <div class="controls">
                    <input id="textinput-1" name="user_id" type="text" placeholder="user_id" class="input-xlarge">
                </div>
            </div>
            <br />
            <div class="control-group">
  <label class="control-label" for="selectmultiple-0">Select Month</label>
  <div class="controls">
    <select id="selectmultiple-0" name="Month_in" class="input-xlarge" multiple="multiple">
      <option value="01">01</option>
      <option value="02">02</option>
      <option value="03">03</option>
      <option value="04">04</option>
      <option value="05">05</option>
      <option value="06">06</option>
      <option value="07">07</option>
      <option value="08">08</option>
      <option value="09">09</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
    </select>
  </div>
</div>
            <div class="control-group">
                <div class="controls">
                    <button id="singlebutton-0" name="Validate" class="btn btn-primary" onclick="newDoc()">Validate</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
