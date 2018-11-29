<!DOCTYPE html>
<?php
ob_start();
session_start();

?>
<html>
<head>

<link rel="stylesheet" type="text/css" href="style/betaalpagina.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" type="text/css" href="style/navbar.css">
</head>

<style>
</style>
<body>

  <div class="col-75">
    <h2 style="width:100%; text-align:center;">Winkelwagentje</h2>
    <div class="col-25">
      <div class="container">
        <h4>Mandje <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i> <b>4</b></span></h4>
        <p><a style="color:black;" href="#">Product 1</a> <span class="price">15 Euro</span></p>
        <p><a style="color:black;" href="#">Product 2</a> <span class="price">5 Euro</span></p>
        <p><a style="color:black;" href="#">Product 3</a> <span class="price">8 Euro</span></p>
        <p><a style="color:black;" href="#">Product 4</a> <span class="price">2 Euro</span></p>
        <hr>
        <p>Totaal <span class="price" style="color:black"><b>30 Euro</b></span></p>
      </div>
    </div>
    <div class="container-naw">
      <form action="/action_page.php">

        <div class="row">
          <div class="col-50">
            <h3>NAW-gegevens</h3>
            <label for="fname"><i class="fa fa-user"></i> Volledige Naam</label>
            <input type="text" id="fname" name="firstname" placeholder="Pietje Bell"><br><br>
            <label for="email"><i class="fa fa-envelope"></i> Email</label>
            <input type="text" id="email" name="email" placeholder="PietjeBell@gmail.com"><br><br>
            <label for="adr"><i class="fa fa-address-card-o"></i> Addres</label>
            <input type="text" id="adr" name="address" placeholder="Dieperenweg 2"><br><br>
            <label for="city"><i class="fa fa-institution"></i> Stad</label>
            <input type="text" id="city" name="city" placeholder="Hasselt"><br><br>

                <label for="provincie">Provincie</label>
                <input type="text" id="provincie" name="provincie" placeholder="Overijssel"><br><br>

                <label for="postcode">Postcode</label>
                <input type="text" id="postcode" name="postcode" placeholder="8062PK"><br><br>
              </form>
          </div>
        </div>
        <div class="row">
          <div class="col-50">
        <h3>Of Inloggen</h3>
          <button onclick="window.location.href='login_register.php'">Inloggen</button>
          </div>
        </div>
      </div>
  </div>
            <br><br>
            <div class="container">
              <form>
            <h3>Betalingspagina</h3>
            <label for="fname">Betaaltype</label>
            <div class="icon-container">
              <img src="ideal.png" width="30.86" height="24" valign="middle">
              <select>
                  <option value="volvo">ING</option>
                  <option value="saab">Rabobank</option>
                  <option value="opel">SNS</option>
                  <option value="audi">Regiobank</option>
            </select>
            </div>
            </form>
            <hr>
            <br>
<input type="radio" checked="checked"name="adres" id="yesCheck" required>Leveradres hetzelfde als factuuradres<br><br>


<!-- Leveradres aanpassen. -->
<input type="radio" name="adres" id="noCheck">leveradres:<br><br>
<hr>
<div id="ifNo">
<label for="adr"><i class="fa fa-address-card-o"></i> Addres</label>
<input type="text" id="adr" name="address" placeholder="Dieperenweg 2"><br><br>
<label for="city"><i class="fa fa-institution"></i> Stad</label>
<input type="text" id="city" name="city" placeholder="Hasselt"><br><br>

    <label for="provincie">Provincie</label>
    <input type="text" id="provincie" name="provincie" placeholder="Overijssel"><br><br>

    <label for="postcode">Postcode</label>
    <input type="text" id="postcode" name="postcode" placeholder="8062PK"><br><br>
    <hr>


  </div>
<form action="confirmatie.php" method="GET">
  <p>Leverdatum: (minimaal vier dagen van nu.)</p>
  <input id="datefield" value='' name='date' type='date' min='' max='2019-03-11' required>
<br>
    <p>Kies een moment:</p>
<input type="radio" id="ochtend" checked="checked" name="tijdstip" value='tussen 8:00 & 12:00' required>'s ochtends (tussen 8:00 & 12:00)<br><br>
<input type="radio" id="middag" name="tijdstip" value='tussen 12:01 & 18:00' required>'s middags (tussen 12:01 & 18:00)<br><br>
<input type="radio" id="avond" name="tijdstip" value='tussen 18:01 & 20:00' required>'s avonds (tussen 18:01 & 20:00)

  <br><br><br>
  <button name='bestelling' type="submit" style="margin:auto; width:100%" value=1> Afrekenen<br></button>
</form>
</div>
    <SCRIPT>
    var today = new Date();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    var dd = today.getDay()+4;

     if(dd<10){
            dd='0'+dd;
        }
        if(mm<10){
            mm='0'+mm;
        }

    today = yyyy+'-'+mm+'-'+dd;
    document.getElementById("datefield").setAttribute("min", today);
    </SCRIPT>

</body>
<?php
include("header.php");
?>
</html>
