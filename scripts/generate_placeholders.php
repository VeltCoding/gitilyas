<?php
// Genera immagini PNG placeholder per ER, Casi d'uso e Gantt
$outDir = __DIR__ . '/../IMG';
if (!is_dir($outDir)) mkdir($outDir, 0755, true);

function makeImage($file, $title, $lines = []){
    $w = 1000; $h = 600;
    $img = imagecreatetruecolor($w, $h);
    $bg = imagecolorallocate($img, 250, 250, 250);
    $border = imagecolorallocate($img, 60, 60, 60);
    $textcol = imagecolorallocate($img, 20, 20, 20);
    $accent = imagecolorallocate($img, 100, 150, 200);

    imagefilledrectangle($img, 0, 0, $w, $h, $bg);
    // header
    imagefilledrectangle($img, 0, 0, $w, 70, $accent);
    imagestring($img, 5, 20, 20, $title, $bg);
    // body text
    $y = 110;
    foreach ($lines as $ln){
        imagestring($img, 4, 30, $y, $ln, $textcol);
        $y += 28;
    }
    // border
    imagerectangle($img, 0, 0, $w-1, $h-1, $border);
    imagepng($img, $file);
    imagedestroy($img);
}

makeImage($outDir.'/ER.png', 'Diagramma ER', ['Entità: Utente, Officina, Prodotto', 'Relazioni: prenota, offre', 'Attributi: id, nome, prezzo']);
makeImage($outDir.'/CasiUso.png', 'Diagramma dei casi d\'uso', ['Attori: Cliente, Officina', 'Use cases: Cerca, Prenota, Ordina, Negoziazione, Gestione shop']);
makeImage($outDir.'/Gantt.png', 'Gantt - Piano di progetto', ['Analisi (W1-W2)', 'Progettazione (W2-W4)', 'Sviluppo (W4-W10)', 'Test (W10-W12)', 'Rilascio (W12)']);

echo "Generated PNGs in $outDir\n";
