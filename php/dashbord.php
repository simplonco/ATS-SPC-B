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
            <li role="presentation" class="active"><a href="../index.php"><span class="glyphicon glyphicon-asterisk"></span>checkin</a></li>
        </ul>
        <?php
        require 'conn.php';

        $sql = 'SELECT * FROM users ORDER BY id';
        $stmt = $conn->query($sql);
        $count = $stmt->rowcount();

        if ($count) {
        ?>
        <table class="table">
            <tr>
                <td>id</td>
                <td>name</td>
                <td>surname</td>
                <td>email</td>
                <td>passcode</td>
            </tr>
            <?php
            $id = 1;

            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                echo'
                    <tr>
                    <td>'.$id++."</td>
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
            // TODO: Display an error!
        }
        ?>
    </div>
</body>

</html>
