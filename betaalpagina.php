<!DOCTYPE html>
<?php
ob_start();
session_start();
include("header2.php");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style/navbar.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>

a {

}

body {
  font-family: Arial;
  font-size: 17px;
}

* {
  box-sizing: border-box;
}

#yesCheck:checked ~ #ifNo {display: none;}
#noCheck:checked ~ #ifNo {display: block;}

.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
  margin: auto;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
  margin-top: 20vh;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 3px solid rgba(0, 174, 239, 0.8);
  border-radius: 3px;
  width: 70vw;
  margin: auto;
}

.container-naw {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 3px solid rgba(0, 174, 239, 0.8);
  grid-template-columns: auto auto;
  border-radius: 3px;
  width: 70vw;
  display: grid;
  margin: auto;
  grid-gap: 10px;
}

.input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #4DBBFF;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: #45a049;
}

a {
  color: #2196F3;
}

hr {
  border: 1px solid lightgrey;
}

span.price {
  float: right;
  color: grey;
}

  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}




</style>
</head>
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
          <button onclick="window.location.href='login_register.php'">Inloggen
          </div>
        </div>
      </div>
  </div>
            <br><br>
            <div class="container">
              <form>
            <h3>Betalingspagina</h3>
            <label for="fname">Betaaltypen</label>
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

  <p>Leverdatum: (minimaal 1 week van nu.)</p>
  <input id="datefield" type='date' min='2018-11-20' max='2019-03-11'> tussen 8:00 en 12:00</input>
  <br><br><br>
  <button style="margin:auto; width:100%" onclick="window.location.href='confirmatie.php'">Afrekenen<br>

<script>
var today = new Date();
var dd = today.getDate()+7;
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
 if(dd<10){
        dd='0'+dd
    }
    if(mm<10){
        mm='0'+mm
    }

today = yyyy+'-'+mm+'-'+dd;
document.getElementById("datefield").setAttribute("min", today);
</script>

</body>
</html>
