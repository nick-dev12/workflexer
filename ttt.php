<?php

session_start();

// Vérifier si les résul


require 'vendor/autoload.php';

// reference the Dompdf namespace
$mpdf = new \Mpdf\Mpdf();

// instantiate and use the dompdf class

$mpdf->WriteHTML("<!DOCTYPE html>
<html lang='fr'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>CV - Laura Dubois</title>
  <script src=
'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'>
	</script>
	<script src=
'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js'>
	</script>
  <script src=
  'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js'>
     </script>

     <script src='https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js'></script>
  <style>

</head>
<body>
  <button onclick='generatePDF()'>Télécharger en PDF</button>


 <div id='container' class='container'>
  <img class='img' src='/image/Chef-de-projet-indispensable-850x560.png' alt=''>
  <header>
    <h1>LAURA DUBOIS</h1>
    <h2>Étudiante</h2>
  </header>

  <div class='container-box'>

    <div class='box1'>
      <div>
        <h1>Profil</h1>
        <div class='bb'>
          <img src='/image/address.png' alt=''>
          <p>
            <strong>
              ADDRESSE
            </strong>
            <span>Dakar</span>
          </p>
        </div>
  
        <div class='bb'>
          <img src='/image/icons8-gmail-48.png' alt=''>
          <p>
            <strong>
              E-mail
            </strong>
            <span>Dakar</span>
          </p>
        </div>
  
        <div class='bb'>
          <img src='/image/phone.png' alt=''>
          <p>
            <strong>
              TELEPHONE
            </strong>
            <span>Dakar</span>
          </p>
        </div>
  
        <div class='bb'>
          <img src='/image/nationaliet.png' alt=''>
          <p>
            <strong>
              NATIONALITE
            </strong>
            <span>Dakar</span>
          </p>
        </div>
      </div>
  
      <div>
        <h1><img src='../image/diplome.png' alt=''> Diplômes</h1>
        <ul>
          <li>diplome de bacalorea</li>
          <li>diplome de bacalorea</li>
          <li>diplome de bacalorea</li>
        </ul>
      </div>
  
      <div>
        <h1><img src='../image/diplome.png' alt=''> Certificates</h1>
        <ul>
          <li>diplome de bacalorea</li>
          <li>diplome de bacalorea</li>
          <li>diplome de bacalorea</li>
         
        </ul>
      </div>
  
      <div>
        <h1><img src='../image/langue.png' alt=''> Langues</h1>
        <ul>
          <li>diplome de bacalorea</li>
          <li>diplome de bacalorea</li>
        </ul>
      </div>
  
      <div>
        <h1><img src='../image/loisir.png' alt=''> Loisir</h1>
        <ul>
          <li>diplome de bacalorea</li>
          <li>diplome de bacalorea</li>
        </ul>
      </div>
  
      <div>
        <h1><img src='../image/social.png' alt=''> Reseaux </h1>
        <div class='reseaux'>
            <img src='../image/facebook.png' alt=''>
            <img src='../image/linkedin.png' alt=''>
            <img src='../image/tweeter.png' alt=''>
            <img src='../image/whatsapp.png' alt=''>
        </div>
    </div>
    </div>

    <div class='box2'>

      <div>
        <h1>A PROPOS</h1>
        <p>
          Un autodidacte soucieux du détail qui travaille pour obtenir un master en lettres. Désireux de rejoindre votre société en tant que spécialiste SEO junior. Je contribuerai à l'exécution de vos campagnes basées sur les données, au développement du contenu et l'optimisation du taux de conversion. J'ai une solide expérience en statistiques et en langues. J'ai également effectué un stage en SEO et en marketing basé sur les données.
        </p>
      </div>

      <div class='experiences'>
        <h1>EXPÉRIENCES PROFESSIONNELLES</h1>

       <div class='div'>
        <strong></strong>
        <span><em>Sept 2019</em> à  <em> Déc 2019</em></span>
       <div>
        <h4>STAGIAIRE SITE WEB MONSITEDEVENTE.FR</h4>
        <p>
          Soutien au responsable du commerce électronique pour l'optimisation des catégories (produit et section) et la refonte du contenu du site.
          Collaboration avec le responsable du commerce électronique et l'agence de référencement locale pour optimiser le contenu du site.
        </p>
       </div>
       </div>

       <div class='div'>
        <strong></strong>
        <span><em>Sept 2019</em> à  <em> Déc 2019</em></span>
       <div>
        <h4>STAGIAIRE SITE WEB MONSITEDEVENTE.FR</h4>
        <p>
          Soutien au responsable du commerce électronique pour l'optimisation des catégories (produit et section) et la refonte du contenu du site.
          Collaboration avec le responsable du commerce électronique et l'agence de référencement locale pour optimiser le contenu du site.
        </p>
       </div>
       </div>
      </div>


      <div class='experiences'>
        <h1>FORMATIONS</h1>

       <div class='div'>
        <strong></strong>
        <span><em>Sept 2019</em> à  <em> Déc 2019</em></span>
       <div>
        <h4>STAGIAIRE SITE WEB MONSITEDEVENTE.FR</h4>
        <p>
          Soutien au responsable du commerce électronique pour nt locale pour optimiser le contenu du site.
        </p>
       </div>
       </div>

       <div class='div'>
        <strong></strong>
        <span><em>Sept 2019</em> à  <em> Déc 2019</em></span>
       <div>
        <h4>STAGIAIRE SITE WEB MONSITEDEVENTE.FR</h4>
        <p>
          Soutien au responsable du commerce électronique pour 
        </p>
       </div>
       </div>
      </div>

      <div class='experiences'>
        <h1>Competences</h1>
        <div class='div-comp'>
          <span class='comp'> je suis ce que </span> <span class='comp'> je suis ce que </span>
          <span class='comp'> je suis ce que </span>
          <span class='comp'> je suis ce que </span>
        </div>
       
      </div>

      <div class='experiences'>
        <h1>outils informatique</h1>
       <ul>
        <li>World</li>
        <li>World</li>
        <li>World</li>
        <li>World</li>
        <li>World</li>
       </ul>
      </div>
  </div>
  </div>
 </div>

 <button onclick='generatePDF()'>Télécharger mon CV</button>
 <input type='button' value='Convert HTML to PDF'			
				onclick='convertHTMLtoPDF()'>

 <script>
  // Importez la bibliothèque jsPDF
  function generatePDF() {
    const element = document.querySelector('.container');
   
    html2pdf().from(element).save('cv.pdf');
}
  </script>
</body>
</html>
");

$mpdf->Output();

?>
