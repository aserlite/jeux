<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Hub</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
<h1>Game Hub</h1>
<ul>
    <?php
    $directory = './';
    $files = scandir($directory);

    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'html') {
            $fileNameWithoutExtension = pathinfo($file, PATHINFO_FILENAME);
            echo "<li><a href='$file'>" . htmlspecialchars($fileNameWithoutExtension) . "</a></li>";
        }
    }
    ?>
</ul>
</body>
</html>
