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
    <input type="radio" name="sortSelect" value="Naam_a" class="sorteerDing" <?php if(filter_input(INPUT_GET, 'sortSelect') == 'Naam_a'){echo "checked='checked'";} ?>>Naam A-Z
    <input type="radio" name="sortSelect" value="Naam_z" class="sorteerDing" <?php if(filter_input(INPUT_GET, 'sortSelect') == 'Naam_z'){echo "checked='checked'";} ?>>Naam Z-A
    <input type="radio" name="sortSelect" value="Prijs_hoog" class="sorteerDing" <?php if(filter_input(INPUT_GET, 'sortSelect') == 'Prijs_hoog'){echo "checked='checked'";} ?>>Prijs Hoog - Laag
    <input type="radio" name="sortSelect" value="Prijs_laag" class="sorteerDing" <?php if(filter_input(INPUT_GET, 'sortSelect') == 'Prijs_laag'){echo "checked='checked'";} ?>>Prijs Laag - Hoog
    <input type="hidden" name="search" value="<?php echo filter_input(INPUT_GET, 'search'); ?>">
    <?php if(isset($_GET['categorie'])){ echo "<input type=\"hidden\" name=\"categorie\" value=\"". filter_input(INPUT_GET, 'categorie') . "\">";} ?>
    <select name='aantalProducten'>
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="50">50</option>
        <option value="100">100</option>
        <option value="oneindig">∞</option>
    </select>
    <input type="submit" value="sorteer">
  </label>


</form>
</div>


<?php

$zoekterm = filter_input(INPUT_GET, 'search');
include("functions.php");
laadCategorieZoekpagina();

if(isset($_GET['sortSelect'])){
  sorteerAlgemeenZoekpagina(filter_input(INPUT_GET, 'sortSelect'));
}else{
  zoekProduct();
}
?>




</body>

</html>
