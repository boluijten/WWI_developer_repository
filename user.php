<?php
ob_start();
include("connect.php");
include("loginFunctions.php");
?>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="style/style_main.css">
  <link rel="stylesheet" type="text/css" href="style/navbar.css">
  <link rel="stylesheet" type="text/css" href="style/style_user.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
</style>

<body>
<div class="form-grid">
  <div class="userspecifics">
    <?php
    echo "<p style=\"text-decoration: none; \">Voornaam: ".$_SESSION['userInfo'][1]."</p>";
    echo "<p style=\"text-decoration: none; \" href=\"user.php\">Achternaam: ".$_SESSION['userInfo'][2]."</p>";
    echo "<p style=\"text-decoration: none; \" href=\"user.php\">E-mail: ".$_SESSION['userInfo'][3]."</p>";
    echo "<p style=\"text-decoration: none; \" href=\"user.php\">Adres: ".$_SESSION['userInfo'][6]." ".$_SESSION['userInfo'][7]." ".$_SESSION['userInfo'][5]."</p>";
    ?>
      <br><a href="destroy.php"><button type="button" href="destroy.php" >Uitloggen</button></a>
  </div>
</div>

<div class="footer2">
  <p>© Groepje 1 2018/2019 | All Rights Reserved | Contact Us: +31658743610 | WWI@gmail.com</p>
</div>

</body>
<?php
include("header.php");
?>

</html>
