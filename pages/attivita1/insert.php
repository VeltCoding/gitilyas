<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
require_once 'articolo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titolo = $_POST['titolo'] ?? '';
    $descrizione = $_POST['descrizione'] ?? '';
    $prezzo = $_POST['prezzo'] ?? '';
    $immagine = '';

    // Gestione upload immagine
    if (isset($_FILES['immagine']) && $_FILES['immagine']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../IMG/';
        $fileName = basename($_FILES['immagine']['name']);
        $targetPath = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['immagine']['tmp_name'], $targetPath)) {
            $immagine = $fileName;
        }
    }

    $articolo = new Articolo($titolo, $descrizione, $prezzo, $immagine);

    // Salva l'articolo in un file JSON
    $jsonFile = __DIR__ . '/articoli.json';
    $articoli = [];
    if (file_exists($jsonFile)) {
        $json = file_get_contents($jsonFile);
        $articoli = json_decode($json, true) ?? [];
    }
    $articoli[] = [
        'titolo' => $titolo,
        'descrizione' => $descrizione,
        'prezzo' => $prezzo,
        'immagine' => $immagine
    ];
    file_put_contents($jsonFile, json_encode($articoli, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // Redirect automatico a show.php
    header('Location: show.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Articolo Inserito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h1>Articolo inserito</h1>
    <?php if (isset($articolo)) $articolo->show(); ?>
    <a href="index.php" class="btn btn-secondary mt-3">Torna indietro</a>
</body>
</html>
