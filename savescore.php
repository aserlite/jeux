<?php
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
    $score = floatval($_POST['score']);
    $jeu = htmlspecialchars($_POST['jeu']);
    $unit = htmlspecialchars($_POST['unit']);

    $stmt = $pdo->prepare("INSERT INTO scores (pseudo, score, jeu,unit) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$pseudo, $score, $jeu, $unit])) {
        echo "Score enregistré !";
    } else {
        echo "Erreur lors de l'enregistrement.";
    }
}
?>
