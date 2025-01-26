<?php
$pageTitle = 'Cercle parfait';
$cssfile= "cercle.css";
$jsfile= "cercle.js";
include 'header.php';
?>

<h1>Dessine un cercle parfait</h1>
<canvas id="drawingCanvas" width="500" height="500"></canvas>
<button onclick="resetCanvas()">Reset</button>
<p class="info" id="score">Score: N/A</p>

<?php include 'footer.php'?>