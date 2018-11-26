<?php 
	ob_start();
	session_start();
	require("connect.php");
	$aantal = filter_input(INPUT_POST, 'aantal');
	$artikelID = filter_input(INPUT_POST, 'artikelID');

	$query = "SELECT * FROM stockitemholdings WHERE StockItemID = $artikelID";
	$resultQuantity = mysqli_query($connect, $query);
        if(mysqli_num_rows($resultQuantity) > 0){
            $row = mysqli_fetch_assoc($resultQuantity);
			if(empty($_SESSION['cart'])){
				$_SESSION['cart'] = array();
			}

			if(array_key_exists($artikelID, $_SESSION['cart'])){
				$nieuwAantal = $_SESSION['cart'][$artikelID] + $aantal;
				if($nieuwAantal <= $row['QuantityOnHand']){
					$_SESSION['cart'][$artikelID] += $aantal;
					header("location: winkelwagen.php");
				}else{
					echo "<h1>We're sorry but there are only ".number_format($row['QuantityOnHand'], 0, ',', '.')." in stock!<br>";
					echo "<button onclick='goBack()'>Go back</button>";
				}
			}else{
				if($aantal <= $row['QuantityOnHand']){
					$_SESSION['cart'][$artikelID] = $aantal;
					header("location: winkelwagen.php");
				}else{
					echo "<h1>We're sorry but there are only ".number_format($row['QuantityOnHand'], 0, ',', '.')." in stock!<br>";
					echo "<button onclick='goBack()'>Go back</button>";
				}
				
			}
        }

	
	
	
	
?>
<script>
function goBack() {
    window.history.back();
}
</script>