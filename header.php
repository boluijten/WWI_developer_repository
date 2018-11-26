
<?php
$productIndicator = 0;
if(isset($_SESSION['cart'])){
	$productIndicator = array_sum($_SESSION['cart']);
}

echo "
<!-- Top Navigatie Balk -->
  <div class=\"navbar\">
 <a href=\"index.php\"><img style=\"width:auto; height:80px;\" src=\"assets/logo.png\"></a>

 <!-- Winkelwagentje + Aantal artikelen -->
 <a href=\"winkelwagen.php\">
  <div class = navbar-text>
	<img style=\"width:auto; height:25px;\" src=\"assets/winkelmandje.png\"><span class=\"badge\">$productIndicator</span></a></li>
</div></a>
  <div class = navbar-text>";

if(isset($_SESSION['userInfo'])){
  echo "<a style=\"text-decoration: none;\" href=\"user.php\">Hallo, ".$_SESSION['userInfo'][1]."</a>";
}else{
  echo "<a style=\"text-decoration: none;\" href=\"login_register.php\">Inloggen</a>";
}




echo "
</div>

    <!-- De zoekbalk-->
  <div class = navbar-text>
  <div class=\"search-container\">
  <form action=\"action_search.php\" method=\"GET\">
    <input type=\"text\" style=\"height:60px;\" placeholder=\"Search..\" name=\"search\">
    <button type=\"submit\"><i style=\"height:25px; width:auto;\" class=\"fa fa-search\"></i></button>
  </form>
  </div>
</div>
</div>



";

?>
