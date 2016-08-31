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
        <img id="logo" src="image/logo-accenture.png">
    </div>
    <div id="welcome-page">
       <h1>Bienvenue sur notre outil de gestion de présence <br /><strong>Accenture</strong></h1>
       <p>Touchez ici !</p>
     </div>
     <script>
     $(document).ready(function(){
        $("#welcome-page").click(function(){
            $("#welcome-page").fadeOut(1000);
            setTimeout(function () {
                window.location = "checkin.php";
            }, 1000);
        });
     });
     </script>
</body>
</html>
