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
            <li role="presentation" class="active"><a href="../php/dashbord.php"><span class="glyphicon glyphicon-asterisk"></span>Tableau de bord</a></li>
            <li role="presentation" class="active"><a href="../php/addnew.php"><span class="glyphicon glyphicon-asterisk"></span>Ajouter collaborateur</a></li>
            <li role="presentation" class="active"><a href="../php/showall.php"><span class="glyphicon glyphicon-asterisk"></span>Rapport</a></li>
        </ul>
        <?php
        require 'conn.php';

        $sql = 'SELECT * FROM users ORDER BY id';
        $stmt = $conn->query($sql);
        $count = $stmt->rowcount();

        if ($count) {
        ?>
        <script>
                       $(document).ready(function(){$("tr:odd").addClass("odd");});
                       </script>
        <table class="table">
            <tr>
                <td>ID</td>
                <td>Prénom</td>
                <td>Nom</td>
                <td>Mail</td>
                <td>Mot de passe</td>
            </tr>
            <?php
            $id = 1;

            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
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
            // TODO: Display an error!
        }
        ?>
    </div>
</body>

</html>
