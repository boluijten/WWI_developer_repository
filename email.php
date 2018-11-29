
<?php
include('connect2.php');
function registerEmail($email){
    $to = $email;
$subject = "Accountbevestiging";
$headers = "From: noreplywwi@gmail.com";
$headers .= "MIME-Version:1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message = '<html><body>';
$message .=  '<p style="color: #4dbbff; font-size: 31px;">Uw account is bevestigd!</p><br>';
$message .= 'Uw account is succesvol geregistreerd.<br>';
$message .= '<br>';
$message .= '<br><br><br>';
$message .= '<p style="color: #4dbbff; font-size: 9px;"> Dit is een geautomatiseerde mail. Gelieve niet op deze mail reageren.<br>Contact met ons opzoeken kan op de website.</p>';
$message .= '</body></html>';



mail($to,$subject,$message,$headers);

}


function orderBevestiging($email){
  include('connect2.php');
  $totalePrijs = 0;
  $to = $email;
  $subject = "Bestellingsbevestiging";
  $headers = "From: noreplywwi@gmail.com";
  $headers .= "MIME-Version:1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

  $message = '<html><body>';
  $message .=  '<p style="color: #4dbbff; font-size: 31px;">Uw bestelling is verwerkt!</p><br>';
  $message .= 'Bij deze is uw bestelling succesvol verwerkt, de bestelde artikelen zijn: <br><hr><br>';

  foreach ($_SESSION['cart'] as $product => $amount) {

    $getProducts = $conn->prepare("SELECT * FROM stockitems LEFT JOIN discount USING(StockItemID) WHERE StockItemID = $product");
    $getProducts->execute();
    $productArray = $getProducts->fetchAll();
    $totalePrijs += $amount*$productArray[0]['UnitPrice'];
    $message .= $productArray[0]['StockItemName'].' <p style ="position: absolute; right:10px;">aantal: '.$amount. '<br>prijs per product: &euro;'.$productArray[0]['UnitPrice'].'</p>';
    $message .='<p style ="position: absolute; right:10px;">totaalprijs: &euro;'.$amount*$productArray[0]['UnitPrice'].'</p><br><hr><br>';
  }

  $message .= '<br>';
  $message .= '<p style ="position: absolute; right:10px;">De totale prijs van alle artikelen: &euro;'.$totalePrijs.'</p>';
  $message .= '<br><br><br>';
  $message .= '<p style="color: #4dbbff; font-size: 9px;"> Dit is een geautomatiseerde mail. Gelieve niet op deze mail reageren.<br>Contact met ons opzoeken kan op de website.</p>';
  $message .= '</body></html>';

  mail($to, $subject, $message, $headers);
}

?>
