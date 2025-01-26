<?php
$pageTitle = 'Color Guess ';
$cssfile= "couleurs.css";
$jsfile= "couleurs.js";
include 'header.php';
?>

    <div class="game-container">
        <h1 id="color-code">#FFFFFF</h1>
        <div class="controls">
            <label for="difficulty">Niveau de difficulté :</label>
            <select id="difficulty">
                <option value="50">Facile</option>
                <option value="30">Moyen</option>
                <option value="10">Difficile</option>
            </select>
            <button onclick="startGame()" id="replay">Rejouer</button>
        </div>
        <div class="score" id="score">Score: 0</div>
        <div class="color-buttons" id="color-buttons"></div>
    </div>
<?php include 'footer.php'?>