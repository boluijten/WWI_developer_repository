<?php
$to = "t.notkamp@gmail.com";
$subject = "Bestellingsbevestiging";
$headers = "From: noreplywwi@gmail.com";
$headers .= "MIME-Version:1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message = '<html><body>';
$message .=  '<p style="color: #4dbbff; font-size: 31px;">Uw bestelling is verwerkt!</p><br>';
$message .= 'Bij deze is uw bestelling succesvol verwerkt, de bestelde artikelen zijn: <br><br>';
$message .= 'Artikel 1 <p style ="position: absolute; right:10px;">aantal: 12</p><br><br>';

$message .= 'Artikel 3 <p style ="position: absolute; right:10px;">aantal: 3</p><br><br>';

$message .= 'Artikel 2 <p style ="position: absolute; right:10px;">aantal: 1</p><br>';
$message .= '<br>';
$message .= '<br><br><br>';
$message .= '<p style="color: #4dbbff; font-size: 9px;"> Dit is een geautomatiseerde mail. Gelieve niet op deze mail reageren.<br>Contact met ons opzoeken kan op de website.</p>';
$message .= '</body></html>';

mail($to, $subject, $message, $headers);


?>
