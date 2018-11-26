
<?php
function registerEmail($email, $voornaam){
    $to = $email;
$subject = "Accountbevestiging";
$headers = "From: noreplywwi@gmail.com";
$headers .= "MIME-Version:1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message = '<html><body>';
$message .=  '<p style="color: #4dbbff; font-size: 31px;">Welkom $voornaam!</p><br>';
$message .= 'U bent succesvol geregistreerd bij WideWorldImporters!<br>';
$message .= '<br>';
$message .= '<br><br><br>';
$message .= '<p style="color: #4dbbff; font-size: 9px;"> Dit is een geautomatiseerde mail. Gelieve niet op deze mail reageren.<br>Contact met ons opzoeken kan op de website.</p>';
$message .= '</body></html>';

    
    
    
mail($to,$subject,$message,$headers);
}

?>