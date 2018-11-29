<?php
  // Laden van functies uit 'functions.php'
  session_start();
ob_start();
 include("functions.php");


 require("connect2.php");

 $getProducts = $conn->prepare("SELECT UnitPrice, discountPercentage, S.StockItemName, S.StockItemID, A.StockGroupID FROM discount LEFT JOIN stockitems AS S USING(StockItemID) LEFT JOIN stockitemstockgroups AS A USING(StockItemID) ORDER BY StockItemID ASC");
 $getProducts->execute();
 $products = $getProducts->fetchAll();

 $getLink = $conn->prepare("SELECT * FROM stockitems ORDER BY StockItemID ASC");
 $getLink->execute();
 $link = $getLink->fetchAll();

?>
<html>

<head>
  <title>WWI</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="style/style_main.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" type="text/css" href="style/navbar.css">

</head>

<style>
.sorteerkolom{
  width:auto;
  margin-top: 20px;
  text-align: center;
  padding-top: 20px;
  border: 2px solid black;
}

.carousel-item{
  border-radius: 10px;
  border: 2px solid #4DBBFF;
  width: 100%;
  height: auto;

}
.carousel{
  margin-top: 9vh;
  margin-bottom: 10px;
  width: 100%;
  height: auto;

}
.carousel-control-next-icon{
  color: #4DBBFF;
  background-image: none;
  font-weight: bold;
  font-size: 40px;
}
.carousel-control-prev-icon{
  color: #4DBBFF;
  background-image: none;
  font-weight: bold;
  font-size: 40px;
}
.oldPrice{
  text-decoration: line-through;
}

.discountProduct{

}



</style>

<body>
<div class="page-wrap">
<?php
laadCategorie();
?>
 <!-- Uitgelichte Producten -->

<div class="grid-container2">

  <center>
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

		  <div class="carousel-inner">
		  	<?php
		  		$first = true;
		  		foreach ($products as $product) {
		  			$newPrice = number_format($product['UnitPrice']*(1 - $product['discountPercentage']/100),2,',','.');
		  			$oldPrice = number_format($product['UnitPrice'],2,',','.');
		  			if($first == true){
			  			echo "
			  			<div class=\"carousel-item active\">";
			    			$first = false;
		    		}else{
		    			echo "

			  				<div class=\"carousel-item\">
			    			";

		    		}
		    		echo "
            <a href='artikel.php?artikel=".$product['StockItemID']."&group=".$product['StockGroupID']."'>
		    				<div class='discountProduct'>
									<h3>".$product['StockItemName']."</h3>
				     				<sub class='oldPrice'>&euro;".$oldPrice."</sub>
				     				<h4>&euro;".$newPrice."</h4>
				     				<p data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Opening sale!\">".$product['discountPercentage']."% discount</p>
			    			</div>
                </a>
			    		</div>

			    			";

		  		}

		  	?>
		  </div>
		  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
		    <span class="carousel-control-prev-icon" aria-hidden="true">&lt;</span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
		    <span class="carousel-control-next-icon" aria-hidden="true">&gt;</span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>


</div>

<div class="grid-container2">
<div class="sorteerkolom">
Sorteren op:


  <form method='GET'>
<label name="sorteer">
  <input type="radio" name="sortSelect" value="AZ_homepage">Naam A-Z  &nbsp |  &nbsp
  <input type="radio" name="sortSelect" value="ZA_homepage">Naam Z-A  &nbsp |  &nbsp
  <input type="radio" name="sortSelect" value="PHL_homepage">Prijs Hoog - Laag  &nbsp | &nbsp
  <input type="radio" name="sortSelect" value="PLH_homepage">Prijs Laag - Hoog  &nbsp | &nbsp
  <select>
      <option value="10">10</option>
      <option value="20">20</option>
      <option value="50">50</option>
      <option value="100">100</option>
      <option value="oneindig">∞</option>
</select>
    <input type="submit" value="resultaten">
</label>


</form>
</div>
</div>
<?php

// Later een terugfunctie door op de geselecteerde categorie te klikken?
laadProducten();
?>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


<script>
  $('.carousel').carousel({
      interval: 4000
  })
  $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();

      $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#row #item").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
  });
  </script>




</body>


<?php
include("header.php");
?>
</html>
