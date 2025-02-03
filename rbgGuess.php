<?php
$pageTitle = 'Guess RGB color';
$cssfile = "rgbGuess.css";
include 'header.php';

// Génération d'une couleur cible aléatoire
$targetRed = rand(0, 255);
$targetGreen = rand(0, 255);
$targetBlue = rand(0, 255);
?>

<h1>Retrouvez la couleur cible !</h1>

<div id="targetColor"
     style="background-color: rgb(<?= $targetRed ?>, <?= $targetGreen ?>, <?= $targetBlue ?>);">
</div>

<p>Ajustez les sliders pour retrouver la couleur.</p>

<div class="sliders">
    <label>Rouge: <input type="range" id="red" min="0" max="255" value="0"></label>
    <label>Vert: <input type="range" id="green" min="0" max="255" value="0"></label>
    <label>Bleu: <input type="range" id="blue" min="0" max="255" value="0"></label>
</div>

<div id="userColor"></div>

<!-- Boutons -->
<button onclick="checkMatch()">Vérifier</button>
<button onclick="resetGame()">Réinitialiser</button>

<p id="result"></p>

<script>
    let targetRed = <?= $targetRed ?>;
    let targetGreen = <?= $targetGreen ?>;
    let targetBlue = <?= $targetBlue ?>;
    let tries = 0;
    function updateColor() {
        let r = document.getElementById('red').value;
        let g = document.getElementById('green').value;
        let b = document.getElementById('blue').value;

        document.getElementById('userColor').style.backgroundColor = `rgb(${r}, ${g}, ${b})`;
    }

    function checkMatch() {
        let r = document.getElementById('red').value;
        let g = document.getElementById('green').value;
        let b = document.getElementById('blue').value;

        let diffR = Math.abs(targetRed - r);
        let diffG = Math.abs(targetGreen - g);
        let diffB = Math.abs(targetBlue - b);

        let score = 100 - ((diffR + diffG + diffB) / (3 * 255)) * 100;
        if(tries === 0){
            saveScore(score, "RGB Guess","%");
        }
        score = Math.max(0, score.toFixed(2));
        tries++;
        document.getElementById('result').innerText = `Ressemblance : ${score}%`;
    }

    function resetGame() {
        let r = document.getElementById('red').value;
        let g = document.getElementById('green').value;
        let b = document.getElementById('blue').value;
        let diffR = Math.abs(targetRed - r);
        let diffG = Math.abs(targetGreen - g);
        let diffB = Math.abs(targetBlue - b);
        tries = 0;
        let score = 100 - ((diffR + diffG + diffB) / (3 * 255)) * 100;
        score = Math.max(0, score.toFixed(2));
        alert(`Couleur cible: rgb(${targetRed}, ${targetGreen}, ${targetBlue})\n` +
            `Ta couleur: rgb(${r}, ${g}, ${b})\n` +
            `Ressemblance: ${score}%`);

        document.getElementById('red').value = 0;
        document.getElementById('green').value = 0;
        document.getElementById('blue').value = 0;

        targetRed = Math.floor(Math.random() * 256);
        targetGreen = Math.floor(Math.random() * 256);
        targetBlue = Math.floor(Math.random() * 256);

        document.getElementById('targetColor').style.backgroundColor = `rgb(${targetRed}, ${targetGreen}, ${targetBlue})`;
        document.getElementById('result').innerText = "";

        updateColor();
    }

    document.querySelectorAll('input[type="range"]').forEach(input => {
        input.addEventListener('input', updateColor);
    });

    updateColor();
</script>

<?php include 'footer.php' ?>
