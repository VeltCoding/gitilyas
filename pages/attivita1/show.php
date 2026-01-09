<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
// Pagina per mostrare tutti gli articoli salvati nel file JSON

$jsonFile = __DIR__ . '/articoli.json';
$articoli = [];
if (file_exists($jsonFile)) {
    $json = file_get_contents($jsonFile);
    $articoli = json_decode($json, true) ?? [];
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Articoli salvati</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h1>Articoli salvati</h1>
    <div class="row">
    <?php foreach ($articoli as $articolo): ?>
        <div class="col-md-4 mb-4">
            <div class="card" style="width: 18rem;">
                <img src="/IMG/<?= htmlspecialchars($articolo['immagine']) ?>" class="card-img-top" alt="Immagine articolo">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($articolo['titolo']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($articolo['descrizione']) ?></p>
                    <p class="card-text"><strong>Prezzo: </strong><?= htmlspecialchars($articolo['prezzo']) ?> €</p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
    <a href="index.php" class="btn btn-secondary mt-3">Torna indietro</a>
</body>
</html>
