<?php
// Laden van functies uit 'functions.php'
session_start();
ob_start();
include("functions.php");
?>
<html>

<head>
  <title>WWI</title>
  <link rel="stylesheet" type="text/css" href="style/style_main.css">
  <link rel="stylesheet" type="text/css" href="style/navbar.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
.sorteerkolom{
  width:auto;
  margin-top: 20px;
  text-align: center;
  padding-top: 20px;
  border: 2px solid black;
}
</style>

<body>

<?php
laadCategorie();
?>
 <!-- Uitgelichte Producten -->
<br><br><br><br><br><br>
<div class="grid-container2">
  <?php
    laadDeals();
  ?>
<div class="uitgelichteproducten">
  <canvas id="canvas"></canvas>

  <p style="margin-top:-17%">De nieuwe website, grote aanbiedingen!</p>
<button style="z-index:5; position:relative; float:left;" onclick="plusDivs(-1)">&#10094;</button>
<button style="z-index:5; position:relative; float:right;" onclick="plusDivs(1)">&#10095;</button>
</div>


</div>

<div class="grid-container2">
<div class="sorteerkolom">
Sorteren op:


<form method='GET'>
  <label name="sorteer">
    <input type="radio" name="sortSelect" value="Naam_a" class="sorteerDing" <?php if(filter_input(INPUT_GET, 'sortSelect') == 'Naam_a'){echo "checked='checked'";} ?>>Naam A-Z
    <input type="radio" name="sortSelect" value="Naam_z" class="sorteerDing" <?php if(filter_input(INPUT_GET, 'sortSelect') == 'Naam_z'){echo "checked='checked'";} ?>>Naam Z-A
    <input type="radio" name="sortSelect" value="Prijs_hoog" class="sorteerDing" <?php if(filter_input(INPUT_GET, 'sortSelect') == 'Prijs_hoog'){echo "checked='checked'";} ?>>Prijs Hoog - Laag
    <input type="radio" name="sortSelect" value="Prijs_laag" class="sorteerDing" <?php if(filter_input(INPUT_GET, 'sortSelect') == 'Prijs_laag'){echo "checked='checked'";} ?>>Prijs Laag - Hoog
     <?php if(isset($_GET['categorie'])){ echo "<input type=\"hidden\" name=\"categorie\" value=\"". filter_input(INPUT_GET, 'categorie') . "\">";} ?>
     <?php if(isset($_GET['pageNr'])){echo "<input type=\"hidden\" name=\"pageNr\" value=\"". filter_input(INPUT_GET, 'pageNr') . "\">";}else{echo "<input type=\"hidden\" name=\"paginaNr\" value=\"0\">";} ?>
     <?php //if(!isset($_GET['aantalProducten'])){echo "<input type=\"hidden\" name=\"aantalProducten\" value=\"". filter_input(INPUT_GET, 'aantalProducten') . "\">";} ?>
    <select name='aantalProducten'>
        <option value="10" <?php if(filter_input(INPUT_GET, 'aantalProducten') == 10){echo "selected";} ?>>10</option>
        <option value="20" <?php if(filter_input(INPUT_GET, 'aantalProducten') == 20){echo "selected";} ?>>20</option>
        <option value="50" <?php if(filter_input(INPUT_GET, 'aantalProducten') == 50){echo "selected";} ?>>50</option>
    </select>
    <input type="submit" value="sorteer">
</label>


</form>
</div>
</div>
<?php

if(isset($_GET['sortSelect'])){
  sorteerAlgemeenIndex(filter_input(INPUT_GET, 'sortSelect'));
}else{
  laadProducten();
}

?>

<div class="footer">
  <p>© Groepje 1 2018/2019 | All Rights Reserved | Contact Us: +31658743610 | WWI@gmail.com</p>
</div>

<script>
let W = window.innerWidth;
let H = window.innerHeight;
const canvas = document.getElementById("canvas");
const context = canvas.getContext("2d");
const maxConfettis = 150;
const particles = [];

const possibleColors = [
  "SlateBlue",
  "LightBlue",
  "Gray"
];

function randomFromTo(from, to) {
  return Math.floor(Math.random() * (to - from + 1) + from);
}

function confettiParticle() {
  this.x = Math.random() * W; // x
  this.y = Math.random() * H - H; // y
  this.r = randomFromTo(11, 33); // radius
  this.d = Math.random() * maxConfettis + 11;
  this.color =
    possibleColors[Math.floor(Math.random() * possibleColors.length)];
  this.tilt = Math.floor(Math.random() * 33) - 11;
  this.tiltAngleIncremental = Math.random() * 0.07 + 0.05;
  this.tiltAngle = 0;

  this.draw = function() {
    context.beginPath();
    context.lineWidth = this.r / 2;
    context.strokeStyle = this.color;
    context.moveTo(this.x + this.tilt + this.r / 3, this.y);
    context.lineTo(this.x + this.tilt, this.y + this.tilt + this.r / 5);
    return context.stroke();
  };
}

function Draw() {
  const results = [];

  // Magical recursive functional love
  requestAnimationFrame(Draw);

  context.clearRect(0, 0, W, window.innerHeight);

  for (var i = 0; i < maxConfettis; i++) {
    results.push(particles[i].draw());
  }

  let particle = {};
  let remainingFlakes = 0;
  for (var i = 0; i < maxConfettis; i++) {
    particle = particles[i];

    particle.tiltAngle += particle.tiltAngleIncremental;
    particle.y += (Math.cos(particle.d) + 3 + particle.r / 2) / 2;
    particle.tilt = Math.sin(particle.tiltAngle - i / 3) * 15;

    if (particle.y <= H) remainingFlakes++;

    // If a confetti has fluttered out of view,
    // bring it back to above the viewport and let if re-fall.
    if (particle.x > W + 30 || particle.x < -30 || particle.y > H) {
      particle.x = Math.random() * W;
      particle.y = -30;
      particle.tilt = Math.floor(Math.random() * 10) - 20;
    }
  }

  return results;
}

window.addEventListener(
  "resize",
  function() {
    W = window.innerWidth;
    H = window.innerHeight;
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  },
  false
);

// Push new confetti objects to `particles[]`
for (var i = 0; i < maxConfettis; i++) {
  particles.push(new confettiParticle());
}

// Initialize
canvas.width = W;
canvas.height = H;
Draw();

</script>

<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("aanbieding-product");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";
  }
  x[slideIndex-1].style.display = "block";
}
</script>



</body>


<?php
include("header.php");
?>
</html>
