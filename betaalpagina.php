<?php
session_start();
ob_start();
require("connect.php");
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

span.pricePP{
  text-align: center;
}




</style>
</head>
<body>

  <div class="col-75">
    <h2 style="width:100%; text-align:center;">Winkelwagentje</h2>
    <div class="col-25">
      <div class="container">
        <h4>Mandje <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i> <b><?php echo count($_SESSION['cart']); ?></b></span></h4>
        <?php
        $totaalprijs = 0;
        foreach ($_SESSION['cart'] as $product => $amount) {
          $sql = "SELECT * FROM stockitems JOIN stockitemstockgroups USING(StockItemID) WHERE StockItemID = $product";
          $resultiItem = mysqli_query($connect, $sql);
          $row = mysqli_fetch_assoc($resultiItem);
          echo "<p>".$amount."x <a href=\"artikel.php?artikel=".$row['StockItemID']."&group=".$row['StockGroupID']."\">".$row['StockItemName']."</a> (&euro;".$row['UnitPrice']."/<sub>piece</sub>) <span class=\"price\">&euro;". number_format($row['UnitPrice'] * $amount, 2, ',', '.') ."</span></p>";
          $totaalprijs += $row['UnitPrice'] * $amount;
        }
      
      ?>
        <hr>
        <p>Totaal <span class="price" style="color:black"><b>&euro;<?php echo number_format($totaalprijs, 2, ',', '.'); ?></b></span></p>
      </div>
    </div>
    <div class="container-naw">
      <?php
      if(!isset($_SESSION['userInfo'])){
        echo '
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
            
            </div>
          </div>
        </form>

        <div class="row">
          <div class="col-50">
            <h3>Of Inloggen</h3>
            <button onclick="window.location.href=\'login_register.php\'">Inloggen
          </div>
        </div>
        ';
      }else{
        echo "<h3>Factuurgegevens</h3><br>";
        echo "<strong>Factuur op naam van:</strong> ". $_SESSION['userInfo'][1]." ".$_SESSION['userInfo'][2]."<br>";
        echo "<strong>Email:</strong> ". $_SESSION['userInfo'][3]."<br>";
        echo "<strong>Telefoonnummer:</strong> ". $_SESSION['userInfo'][4]."<br>";
        echo "<strong>Straatnaam:</strong> ".$_SESSION['userInfo'][6]. "<br><strong>Huisnummer:</strong> " . $_SESSION['userInfo'][7]."<br><strong>Postcode:</strong> ".$_SESSION['userInfo'][8]."<br><strong>Plaats:</strong> ".$_SESSION['userInfo'][5]."<br>";
        //print_r($_SESSION['userInfo']);

      }
      
      ?>
      
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
<input type="radio" checked="checked"name="adres" id="yesCheck" required>Leveradres hetzelfde als factuuradres<br><br>


<input type="radio" name="adres" id="noCheck">leveradres:<br><br>
<div id="ifNo">
<label for="adr"><i class="fa fa-address-card-o"></i> Addres</label>
<input type="text" id="adr" name="address" placeholder="Dieperenweg 2"><br><br>
<label for="city"><i class="fa fa-institution"></i> Stad</label>
<input type="text" id="city" name="city" placeholder="Hasselt"><br><br>

    <label for="provincie">Provincie</label>
    <input type="text" id="provincie" name="provincie" placeholder="Overijssel"><br><br>

    <label for="postcode">Postcode</label>
    <input type="text" id="postcode" name="postcode" placeholder="8062PK"><br><br>


  </div>
  <button style="margin:auto; width:100%" onclick="window.location.href='confirmatie.php'">Afrekenen</button><br>



<?php include("header2.php"); ?>
</body>
</html>
