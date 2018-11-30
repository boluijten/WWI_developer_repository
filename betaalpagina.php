<?php
ob_start();
session_start();
include('connect.php');
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
            <button onclick="window.location.href=\'login_register.php?red\'">Inloggen
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
                  <option value="ING">ING</option>
                  <option value="Rabobank">Rabobank</option>
                  <option value="SNS">SNS</option>
                  <option value="Regiobank">Regiobank</option>
                  <option value="ABN AMRO">ABN AMRO</option>
                  <option value="ASN Bank">ASN Bank</option>
                  <option value="Bunq">Bunq</option>
                  <option value="Knab">Knab</option>
                  <option value="Moneyou">Moneyou</option>
                  <option value="Triodos Bank">Triodos Bank</option>
                  <option value="Van Lanschot">Van Lanschot</option>
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
