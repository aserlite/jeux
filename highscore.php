<?php
$pageTitle = 'Highscore';
include 'header.php';

$env = parse_ini_file('.env');

$host = $env['DB_HOST'];
$user = $env['DB_USERNAME'];
$password = $env['DB_PASSWORD'];
$dbname = $env['DB_DATABASE'];

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);

// Récupérer la liste des jeux distincts
$gamesStmt = $pdo->query("SELECT DISTINCT jeu FROM scores");
$games = $gamesStmt->fetchAll(PDO::FETCH_COLUMN);

?>

<h2>🏆 Meilleurs Scores 🏆</h2>

<?php foreach ($games as $game): ?>
    <h3><?= htmlspecialchars($game) ?></h3>
    <table>
        <tr><th>Pseudo</th><th>Score</th></tr>
        <?php
        $stmt = $pdo->prepare("SELECT pseudo, score, unit FROM scores WHERE jeu = ? ORDER BY score DESC LIMIT 5");
        $stmt->execute([$game]);
        $scores = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($scores as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['pseudo']) ?></td>
                <td><?= $row['score'] ?> <?= $row['unit'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endforeach; ?>

<?php include 'footer.php'; ?>
