<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $email = trim($_POST['email'] ?? '');

    $usersFile = __DIR__ . '/users.json';
    $pendingFile = __DIR__ . '/users_pending.json';

    $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];
    $pending = file_exists($pendingFile) ? json_decode(file_get_contents($pendingFile), true) : [];

    if (isset($users[$username]) || isset($pending[$username])) {
        $error = 'Username già esistente.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email non valida.';
    } else {
        $code = random_int(100000, 999999);
        $salt = bin2hex(random_bytes(16));
        $hash = hash('sha256', $salt . $password);

        // Salva temporaneamente
        $pending[$username] = [
            'email' => $email,
            'password' => $hash,
            'salt' => $salt,
            'code' => $code
        ];
        file_put_contents($pendingFile, json_encode($pending, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Manda email con codice
        $subject = "Codice di verifica - Il tuo sito";
        $message = "Ciao $username,\n\nIl tuo codice di conferma è: $code\n\nInseriscilo per completare la registrazione.";
        $headers = "From: no-reply@tuosito.it\r\n";

        if (mail($email, $subject, $message, $headers)) {
            $_SESSION['pending_user'] = $username;
            header('Location: verify.php');
            exit;
        } else {
            $error = 'Errore nell’invio dell’email. Contatta l’amministratore.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrati</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h1>Registrati</h1>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrati</button>
    </form>
    <a href="login.php" class="btn btn-link mt-3">Login</a>
</body>
</html>
