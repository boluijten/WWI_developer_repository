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
  margin-top: 30vh;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
  width: 70vw;
  margin: auto;
}

.container-naw {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
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

    <div class="col-25">
      <div class="container">
        <p>Beste [$naam_hier], bedankt voor uw bestelling bij Wide World Importers. Uw bestelling wordt op [$bezorgdatum] geleverd op het adres: [$adres].</p>
        <hr>
        <p>Bestelde artikelen:<p>
        <p>product 1</p>
          <p>product 1</p>
            <p>product 1</p>
        <hr>
          <button style="margin:auto; width:100%" onclick="window.location.href='index.php'">Verder Winkelen<br>
      </div>
    </div>

</body>
</html>
