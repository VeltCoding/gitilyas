<?php
session_start();

$pendingFile = __DIR__ . '/users_pending.json';
$usersFile = __DIR__ . '/users.json';

$pending = file_exists($pendingFile) ? json_decode(file_get_contents($pendingFile), true) : [];
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

$username = $_SESSION['pending_user'] ?? null;
if (!$username || !isset($pending[$username])) {
    header('Location: register.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code'] ?? '');
    if ($code === (string)$pending[$username]['code']) {
        // Sposta da pending a utenti confermati
        $users[$username] = [
            'email' => $pending[$username]['email'],
            'password' => $pending[$username]['password'],
            'salt' => $pending[$username]['salt']
        ];
        unset($pending[$username]);
        file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        file_put_contents($pendingFile, json_encode($pending, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $_SESSION['user'] = $username;
        unset($_SESSION['pending_user']);
        header('Location: index.php');
        exit;
    } else {
        $error = 'Codice errato. Riprova.';
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Verifica Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h1>Verifica la tua email</h1>
    <p>Abbiamo inviato un codice di conferma all’indirizzo associato al tuo account.</p>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label for="code" class="form-label">Codice di conferma</label>
            <input type="text" class="form-control" id="code" name="code" required>
        </div>
        <button type="submit" class="btn btn-success">Conferma</button>
    </form>
</body>
</html>
