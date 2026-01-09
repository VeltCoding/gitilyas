<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: pages/attivita1/login.php');
        exit;
        }
        ?>
        <!DOCTYPE html>
        <html lang="it">
        <head>
            <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Home Page</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
                            <link rel="stylesheet" href="css/styles.css">
                            </head>
                            <body>
                                <div class="container text-center mt-5">
                                        <h1>Home Page</h1>
                                                <p>Scegli una disciplina per vedere le attività:</p>
                                                        <div class="btn-group-vertical" role="group" aria-label="Discipline">
                                                                    <a href="pages/informatica.html" class="btn btn-primary">INFORMATICA</a>
                                                                                <a href="pages/tps.html" class="btn btn-secondary">TPS</a>
                                                                                            <a href="pages/gpo.html" class="btn btn-success">GPO</a>
                                                                                                    </div>
                                                                                                            <form action="pages/attivita1/logout.php" method="post" class="mt-4">
                                                                                                                        <button type="submit" class="btn btn-danger">Logout</button>
                                                                                                                                </form>
                                                                                                                                    </div>
                                                                                                                                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
                                                                                                                                            <script src="js/main.js"></script>
                                                                                                                                            </body>
                                                                                                                                            </html>
                                                                                                                                            