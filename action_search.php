<?php
ob_start();
session_start();
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
.sorteerkolom{
  margin-top: 10%;
  margin-left: 20vw;
  height:12vh;
  text-align: center;
  border: 2px solid black;
  width: 75vw;
  padding: 10px;

}
</style>


<body>



<div class="sorteerkolom">
Sorteren op:


  <form method='GET'>
<label name="sorteer">
  <input type="radio" name="sortSelect" value="Naam_a">Naam A-Z
  <input type="radio" name="sortSelect" value="Naam_z">Naam Z-A
  <input type="radio" name="sortSelect" value="Prijs_hoog">Prijs Hoog - Laag
  <input type="radio" name="sortSelect" value="Prijs_laag">Prijs Laag - Hoog

  <input type="hidden" name="search" value="<?php echo filter_input(INPUT_GET, 'search'); ?>">
  <input type="submit" value="sorteer">
</label>


</form>
</div>


<?php

$zoekterm = filter_input(INPUT_GET, 'search');
include("functions.php");
laadCategorieZoekpagina();

if (filter_input(INPUT_GET, 'sortSelect') == "Naam_a"){
  SorteerProductenAZ();
} elseif (filter_input(INPUT_GET, 'sortSelect') == "Naam_z"){
  SorteerProductenZA();
} elseif (filter_input(INPUT_GET, 'sortSelect') == "Prijs_hoog"){
  SorteerProductenDESC();
} elseif (filter_input(INPUT_GET, 'sortSelect') == "Prijs_laag"){
  SorteerProductenASC();
}else{
  zoekProduct();
}
?>


<div class="footer">
  <p>© Groepje 1 2018/2019 | All Rights Reserved | Contact Us: +31658743610 | WWI@gmail.com</p>
</div>


</body>

</html>
