<?php
$pageTitle = 'Devinez l\'angle';
$cssfile= "angle.css";
$jsfile= "angle.js";
include 'header.php';
?>

    <h1>Devinez l'angle</h1>
    <canvas id="angleCanvas" width="300" height="300"></canvas>
    <div>
        <input type="number" id="guessInput" placeholder="Entrez votre guess"/>
        <button id="submitGuess">Valider</button>
    </div>
    <p class="message" id="resultMessage"></p>
<?php include 'footer.php'?>