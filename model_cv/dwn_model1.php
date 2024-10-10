<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '256M');
// Inclure l'autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Créer une nouvelle instance de Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Capturer le contenu de ttt.php

// Charger le HTML dans Dompdf
$dompdf->loadHtml('<h1>Hello world!</h1>');

// Définir le format du papier
$dompdf->setPaper('A4', 'portrait');

// Rendre le PDF
$dompdf->render();

// Générer le PDF
$dompdf->stream('cv.pdf', ['Attachment' => 0]);