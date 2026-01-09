<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
// Lista immagini disponibili nella cartella IMG
$immagini = array('fiore.jpg', 'onda.jpg');
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Nuovo Articolo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Inserisci un nuovo articolo</h1>
        <form action="logout.php" method="post" style="display:inline;">
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
    <form action="insert.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="titolo" class="form-label">Titolo</label>
            <input type="text" class="form-control" id="titolo" name="titolo" required>
        </div>
        <div class="mb-3">
            <label for="descrizione" class="form-label">Descrizione</label>
            <textarea class="form-control" id="descrizione" name="descrizione" required></textarea>
        </div>
        <div class="mb-3">
            <label for="prezzo" class="form-label">Prezzo (€)</label>
            <input type="number" step="0.01" class="form-control" id="prezzo" name="prezzo" required>
        </div>
        <div class="mb-3">
            <label for="immagine" class="form-label">Carica immagine</label>
            <input type="file" class="form-control" id="immagine" name="immagine" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Inserisci</button>
    </form>
</body>
</html>
