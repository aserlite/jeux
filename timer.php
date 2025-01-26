<?php
$pageTitle = 'Comptez 10 secondes';
$cssfile = "timer.css";
$jsfile = "timer.js";
include 'header.php';
?>
<h1>Comptez jusqu'à 10 secondes</h1>
<div class="difficulty">
    <label for="difficulty">Choisissez un niveau de difficulté :</label>
    <select id="difficulty">
        <option value="5">Facile</option>
        <option value="2.5">Moyen</option>
        <option value="0">Difficile</option>
    </select>
</div>
<button id="start">Démarrer</button>
<button id="stop" style="display:none;">Stop</button>
<div class="timer" id="timer"></div>
<div class="result" id="result"></div>
<?php include 'footer.php' ?>
