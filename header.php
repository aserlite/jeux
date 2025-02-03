<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Jeux'; ?></title>
    <link rel="stylesheet" href="assets/css/header.css?v=<?= date('Ymd') ?>">
    <link rel="stylesheet" href="assets/css/<?php echo $cssfile; ?>?v=<?= date('Ymd') ?>">
    <script src="assets/js/<?php echo $jsfile; ?>?v=<?= date('Ymd') ?>" defer></script>
    <script src="assets/js/main.js?v=<?= date('Ymd') ?>" defer></script>
    <meta http-equiv="Expires" content="Tue, 01 Jan 1995 12:12:12 GMT">
    <meta http-equiv="Pragma" content="no-cache">

</head>
<body class="body_effects">
<header>
    <nav>
        <a href="index.php">Accueil</a>
    </nav>
    <div class="check">
        <input id="toggleBg" type="checkbox">
        <label for="toggleBg">Disable effects</label>
    </div>
</header>
<main>
