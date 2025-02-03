<?php
$referer = $_SERVER['HTTP_REFERER'];
$allowedReferer = 'https://jeux.arthurcuvillon.com';
if (strpos($referer, $allowedReferer) === false) {
    echo "Requête provenant d'une source non autorisée.";
    die();
}


$env = parse_ini_file('.env');

$host = $env['DB_HOST'];
$user = $env['DB_USERNAME'];
$password = $env['DB_PASSWORD'];
$dbname = $env['DB_DATABASE'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    var_dump($pseudo);
    $score = floatval($_POST['score']);
    $jeu = htmlspecialchars($_POST['jeu']);
    $unit = htmlspecialchars($_POST['unit']);

    if (empty($pseudo) OR $pseudo === "" OR $pseudo === "null" OR $pseudo === "undefined" OR $pseudo === "NaN") {
        echo "Pseudo vide !";
        die();
    }
    if (empty($score) OR $score === "" OR $score === "null" OR $score === "undefined" OR $score === "NaN") {
        echo "Score vide !";
        die();
    }
    if (empty($jeu) OR $jeu === "" OR $jeu === "null" OR $jeu === "undefined" OR $jeu === "NaN") {
        echo "Jeu vide !";
        die();
    }
    if (empty($unit) OR $unit === "" OR $unit === "null" OR $unit === "undefined" OR $unit === "NaN") {
        echo "Unit vide !";
        die();
    }
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("INSERT INTO scores (pseudo, score, jeu,unit,ip,date) VALUES (?, ?, ?,?, ?, ?)");
    if ($stmt->execute([$pseudo, $score, $jeu, $unit, $ip, $date])) {
        echo "Score enregistré !";
    } else {
        echo "Erreur lors de l'enregistrement.";
    }
}
?>
