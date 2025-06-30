<?php
require_once 'vendor/autoload.php';

ob_start();
require 'teste.php';
$html = ob_get_clean();



$pdf = new mikehaertl\wkhtmlto\Pdf($html);

$pdf->send()



?>