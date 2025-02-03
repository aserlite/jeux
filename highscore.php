<?php
$pageTitle = 'Highscore';
include 'header.php';

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

$gamesStmt = $pdo->query("SELECT DISTINCT jeu FROM scores");
$games = $gamesStmt->fetchAll(PDO::FETCH_COLUMN);
?>
<h1 class="glitch">🏆 Meilleurs Scores 🏆</h1>

<?php foreach ($games as $game): ?>
    <h2 class="game-title"><?= htmlspecialchars($game) ?></h2>
    <table class="score-table">
        <tr><th>Pseudo</th><th>Score</th></tr>
        <?php
        if($game == "timer" || $game == "reaction"){
            $stmt = $pdo->prepare("SELECT pseudo, score, unit FROM scores WHERE jeu = ? ORDER BY score ASC LIMIT 5");
        } else {
            $stmt = $pdo->prepare("SELECT pseudo, score, unit FROM scores WHERE jeu = ? ORDER BY score DESC LIMIT 5");
        }
        $stmt->execute([$game]);
        $scores = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($scores as $row): ?>
            <tr>
                <td><?= urldecode($row['pseudo']) ?></td>
                <td><?= $row['score'] ?> <?= $row['unit'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endforeach; ?>

<?php include 'footer.php'; ?>

<style>

    @keyframes glitch {
        0% { transform: translate(0); }
        20% { transform: translate(-2px, 2px); }
        40% { transform: translate(2px, -2px); }
        60% { transform: translate(-2px, 2px); }
        80% { transform: translate(2px, -2px); }
        100% { transform: translate(0); }
    }

    h1.glitch {
        font-size: 24px;
        color: #ffcc00;
        text-shadow: 4px 4px 0px #ff0000, 2px 2px 0px #000;
        animation: glitch 1s infinite;
    }

    h2.game-title {
        font-size: 20px;
        text-shadow: 2px 2px 0px #000, 4px 4px 0px #ff0000;
        margin-top: 20px;
        color: #ffcc00;
        border-bottom: 3px solid #ffcc00;
        display: inline-block;
        padding: 5px 15px;
    }

    table.score-table {
        width: 80%;
        max-width: 600px;
        margin: 20px auto;
        border-collapse: collapse;
        background: #222;
        border: 3px solid #ffcc00;
        box-shadow: 5px 5px 0px #ff0000, 8px 8px 0px #000;
    }

    th, td {
        border: 2px solid #ffcc00;
        padding: 10px;
        text-align: center;
        font-size: 14px;
    }

    th {
        background: #ff0000;
        color: #fff;
        text-transform: uppercase;
    }

    td {
        background: #3891d0;
        color: #00ff00;
    }

    tr:nth-child(even) td {
        background: #1861D4;
    }

    tr:hover td {
        background: #12ADBD;
        color: #000;
    }

</style>