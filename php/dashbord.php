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
  <li role="presentation" class="active"><a href="php/dashbord.php"><span class="glyphicon glyphicon-asterisk"></span>Dashbord</a></li>
  <li role="presentation"class="active"><a href="../php/addnew.php"><span class="glyphicon glyphicon-asterisk"></span>Addnew</a></li>
  <li role="presentation"class="active"><a href="../php/showall.php"><span class="glyphicon glyphicon-asterisk"></span>Showall</a></li>
  <li role="presentation"class="active"><a href="../index.php"><span class="glyphicon glyphicon-asterisk"></span>checkin</a></li>
</ul>
<?php
error_reporting("E_ALL & ~E_NOTIC");
require 'conn.php';
$sql="SELECT * FROM users ORDER BY id";
$stmt =$conn->query($sql);
$count=$stmt->rowcount();
$id=1;
if($count){


?>
<table class="table">
	<tr>
  <td>id</td>
  <td>name</td>
  <td>surname</td>
  <td>email</time></td>
  <td>passcode</td>
</tr>
<?php
while ( $row=$stmt->fetch(PDO::FETCH_OBJ)) {

		echo"
		<tr>
		<td>".$id++."</td>
		<td>{$row->name}</td>
		<td>{$row->surname}</td>
		<td>{$row->mail}</td>
    <td>{$row->passcode}</td>
		</tr>
		";

}

?>
</table>
<?php
} else {
	// TODO
}
?>
</div>

</body>
</html>
