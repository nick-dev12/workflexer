<?php 

require '../vendor/autoload.php';

// // reference the Dompdf namespace
// use Dompdf\Dompdf;

// // instantiate and use the dompdf class
// $dompdf = new Dompdf();
// ob_start();
// require('../page/pdf_users.php');
// $html = ob_get_contents();

// $dompdf->loadHtml($html);
// ob_get_clean();
// // (Optional) Setup the paper size and orientation
// $dompdf->setPaper('A4', 'landscape');

// // Render the HTML as PDF
// $dompdf->render();

// // Output the generated PDF to Browser
// $dompdf->stream('printe details' , ['Attachment'=> false]);

$mpdf = new \Mpdf\Mpdf();
ob_start(); // Démarre la tampon de sortie
include('pdf_users.php'); // Inclut la page HTML à convertir en PDF
$html = ob_get_contents(); // Récupère le contenu du tampon de sortie
ob_end_clean(); // Vide le tampon de sortie

$mpdf->WriteHTML($html); // Écrit le contenu HTML dans le PDF
$mpdf->Output(); // Génère le PDF et l'envoie au navigateur


