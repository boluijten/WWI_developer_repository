<?php
ob_start();
include("header.php");
?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style/style_main.css">
  <link rel="stylesheet" type="text/css" href="style/navbar.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
</style>


<body>



  <?php
include("functions.php");
laadCategorieZoekpagina();
zoekProduct();



?>


<div class="footer">
  <p>© Groepje 1 2018/2019 | All Rights Reserved | Contact Us: +31658743610 | WWI@gmail.com</p>
</div>


</body>

</html>
