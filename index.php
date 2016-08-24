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
    <img id="logo" src="image/logo-accenture.png">
    <div id="welcome_page">
       <h1 id="bienvenue">Bienvenue </br> à </br> Accenture</h1>
     </div>
     <script>
     $(document).ready(function(){
        $("#bienvenue").click(function(){
            $("#page").slideToggle(500);
            $("#bienvenue").hide(500);
            setTimeout(function () {
              window.location = "checkin.php";
            }, 500);
        });
     });
     </script>
</body>
</html>
