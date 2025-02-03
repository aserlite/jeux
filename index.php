<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Hub</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <script>
        function savePseudo() {
            let pseudo = document.getElementById("pseudo").value;
            if (pseudo.trim() !== "") {
                document.cookie = "pseudo=" + encodeURIComponent(pseudo) + "; path=/; max-age=" + (60 * 60 * 24 * 30);
                alert("Pseudo enregistré !");
            }
        }

        function getCookie(name) {
            let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? decodeURIComponent(match[2]) : "";
        }

        window.onload = function () {
            let savedPseudo = getCookie("pseudo");
            if (savedPseudo) {
                document.getElementById("pseudo").value = savedPseudo;
            }
        };
    </script>
</head>
<body>
<h1>Les jeux la</h1>

<label for="pseudo">Votre pseudo :</label>
<input type="text" id="pseudo" placeholder="Entrez votre pseudo">
<button onclick="savePseudo()">Enregistrer</button>

<ul>
    <?php
    $directory = './';
    $files = scandir($directory);
    $excludedFiles = ["index.php", "header.php", "footer.php", "highscore.php","savescore.php"];

    foreach ($excludedFiles as $file) {
        if (($key = array_search($file, $files)) !== false) {
            unset($files[$key]);
        }
    }

    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            $fileNameWithoutExtension = pathinfo($file, PATHINFO_FILENAME);
            echo "<li><a href='$file'>" . htmlspecialchars($fileNameWithoutExtension) . "</a></li>";
        }
    }
    ?>
    <li class="highscore">
        <a href="highscore.php" >🏆Highscore</a>
    </li>
</ul>

</body>
</html>
