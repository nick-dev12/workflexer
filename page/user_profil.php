<?php
session_start();
include '../conn/conn.php';
require '../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label;
use Endroid\QrCode\Logo;
use Endroid\QrCode\RoundBlockSizeMode;

function generateQRCode($userId)
{
    // Vérifier si l'ID utilisateur est défini
    if (!isset($_SESSION['users_id'])) {
        return '<p>Erreur : ID utilisateur non défini.</p>';
    }

    $userId = $_SESSION['users_id'];
    $url = 'https://www.work-flexer.com/page/candidats.php?id=' . $userId; // Lien vers le profil utilisateur

    // Chemin du répertoire des QR codes
    $qrCodeDir = __DIR__ . '/qrcodes';

    // Vérifier si le répertoire existe, sinon le créer
    if (!is_dir($qrCodeDir)) {
        mkdir($qrCodeDir, 0777, true);
    }

    // Générer le QR code
    $result = Builder::create()
        ->writer(new PngWriter())  // Choisir le format PNG
        ->data($url)               // Les données à inclure dans le QR code
        ->size(300)                // Taille du QR code
        ->margin(10)               // Marge autour du QR code
        ->build();                 // Construire le QR code

    // Enregistrer le QR code en tant qu'image
    $qrCodePath = $qrCodeDir . '/user_' . $userId . '.png';
    $result->saveToFile($qrCodePath);

    // Vérifier si le fichier a été créé
    if (!file_exists($qrCodePath)) {
        return '<p>Erreur : le QR code n\'a pas pu être généré.</p>';
    }

    // Retourner l'image du QR code dans un <img> HTML
    return '<img src="qrcodes/user_' . $userId . '.png" alt="QR Code" />';
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['users_id']) || empty($_SESSION['users_id'])) {
    // Rediriger vers la page de connexion ou une autre page appropriée
    header('Location: ../connection_compte.php');
    exit();
}

if (isset($_GET['id'])) {
    // Récupérez l'ID du commerçant à partir de la session
    // Récupérez l'ID de l'utilisateur depuis la variable de session
    $users_id = $_GET['id'];

    // Vous pouvez maintenant utiliser $commercant_id pour récupérer les informations de l'utilisateur depuis la base de données
    // Écrivez votre requête SQL pour récupérer les informations nécessaires
    $conn = "SELECT * FROM users WHERE id = :users_id";
    $stmt = $db->prepare($conn);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->execute();
    $users = $stmt->fetch(PDO::FETCH_ASSOC);

    $erreurs = '';

    $message = '';


    include_once('../controller/controller_description_users.php');
    include_once('../controller/controller_metier_users.php');
    include_once('../controller/controller_competence_users.php');
    include_once('../controller/controller_formation_users.php');
    include_once('../controller/controller_diplome_users.php');
    include_once('../controller/controller_certificat_users.php');
    include_once('../controller/controller_outil_users.php');
    include_once('../controller/controller_langue_users.php');
    include_once('../controller/controller_projet_users.php');
    include_once('../controller/controller_centre_interet.php');
    include_once('../controller/controller_niveau_etude_experience.php');
} else {




    $erreurs = '';

    $message = '';




    // Récupérez l'ID du commerçant à partir de la session
    // Récupérez l'ID de l'utilisateur depuis la variable de session

    // Récupérer l'id du métier à supprimer (via lien ou formulaire par exemple)

    include_once('../controller/controller_document_users.php');
    include_once('../controller/controller_description_users.php');
    include_once('../controller/controller_metier_users.php');
    include_once('../controller/controller_competence_users.php');
    include_once('../controller/controller_formation_users.php');
    include_once('../controller/controller_diplome_users.php');
    include_once('../controller/controller_certificat_users.php');
    include_once('../controller/controller_outil_users.php');
    include_once('../controller/controller_langue_users.php');
    include_once('../controller/controller_projet_users.php');
    include_once('../controller/controller_users.php');
    include_once('../controller/controller_centre_interet.php');
    include_once('../entreprise/app/controller/controllerOffre_emploi.php');
    include_once('../entreprise/app/controller/controllerEntreprise.php');
    include_once('../controller/controller_niveau_etude_experience.php');
}

?>






<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');
    </script>
    <!-- End Google Tag Manager -->

    <title>Profil</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">

    <script src="../script/jquery-3.6.0.min.js"></script>

    <!-- <script src="../script/summernote@0.8.18.js"></script>
    <link rel="stylesheet" href="../style/summernote@0.8.18.css"> -->

    <link rel="stylesheet" href="/css/user_profil.css">
    <link rel="stylesheet" href="../css/navbare.css">

    <link rel="stylesheet" href="../css/aos.css" />
    <script src="../js/aos.js"></script>

    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">

    <script src="../js/html5Qrcode.js"></script>
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <?php include('../navbare.php') ?>

    <?php include('../include/header_users.php') ?>

    <section class="section3">
        <?php if (isset($_SESSION['compte_entreprise'])): ?>
            <button class="contacte">Contacter ce candidat</button>

            <form action="" class="form_appel">
                <img class="fermer" src="../image/croix.png" alt="">
                <label for="message">Écrivez votre message ici</label>
                <textarea name="message" id="message"></textarea>
                <input type="submit" name="envoie" value="Envoyer">
            </form>

            <script>
                let contacte = document.querySelector('.contacte');
                let form_appel = document.querySelector('.form_appel');
                let fermer = document.querySelector('.fermer')

                contacte.addEventListener('click', () => {
                    if (form_appel.style.left = '160%') {
                        form_appel.style.left = '60%'
                    } else {
                        form_appel.style.left = '160%'
                    }

                    contacte.style.opacity = '0';
                })
                fermer.addEventListener('click', () => {
                    if (form_appel.style.left = '60%') {
                        form_appel.style.left = '160%'
                    } else {
                        form_appel.style.left = '60%'
                    }

                    contacte.style.opacity = '1';
                })
            </script>

        <?php endif; ?>



        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="message">
                <p>
                    <span></span>
                    <?php echo $_SESSION['success_message']; ?>
                    <?php unset($_SESSION['success_message']); ?>
                </p>
            </div>
        <?php else: ?>
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="erreurs" id="messageErreur">
                    <span></span>
                    <?php echo $_SESSION['error_message']; ?>
                    <?php unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <script>
            let success = document.querySelector('.message')
            setTimeout(() => {
                success.classList.add('visible');
            }, 200);
            setTimeout(() => {
                success.classList.remove('visible');
            }, 6000);

            // Sélectionnez l'élément contenant le message d'erreur
            var messageErreur = document.getElementById('messageErreur');

            // Fonction pour afficher le message avec une transition de fondu
            setTimeout(function () {
                messageErreur.classList.add('visible');
            }, 200); // 1000 millisecondes équivalent à 1 seconde

            // Fonction pour masquer le message avec une transition de fondu
            setTimeout(function () {
                messageErreur.classList.remove('visible');
            }, 6000); // 6000 millisecondes équivalent à 6 secondes
        </script>

        <!-- Afficher le QR code -->
        <div class="qr-code">
            <button class="mon_qrcode">Mon QR Code <?php echo generateQRCode($_SESSION['users_id']); ?></button>
            <span> ou </span>
            <!-- Bouton pour ouvrir le scanner de QR code -->
            <button id="open-scanner">Scanner un QR Code <img src="../image/scanner.png" alt=""></button>
            <div class="qr_code">
                <?php echo generateQRCode($_SESSION['users_id']); ?>
                <a href="qrcodes/user_<?php echo $_SESSION['users_id']; ?>.png"> Telecharger mon code QR </a>
            </div>
        </div>


        <!-- Conteneur pour le scanner de QR code -->
        <div id="qr-reader"></div>

        <script>

            let mon_qrcode = document.querySelector('.mon_qrcode')
            let qr_code = document.querySelector('.qr_code')

            mon_qrcode.addEventListener('click', () => {
                qr_code.classList.toggle('active')
            })



            let scannerActive = false;
            const html5QrCode = new Html5Qrcode("qr-reader");

            document.getElementById('open-scanner').addEventListener('click', function () {
                if (scannerActive) {
                    html5QrCode.stop().then(ignore => {
                        document.getElementById('qr-reader').style.display = 'none';
                        scannerActive = false;
                        console.log("Scanner arrêté.");
                    }).catch(err => {
                        console.log(`Erreur lors de l'arrêt du scanner: ${err}`);
                    });
                } else {
                    document.getElementById('qr-reader').style.display = 'block';
                    html5QrCode.start(
                        { facingMode: "environment" }, // Utiliser la caméra arrière
                        {
                            fps: 10,    // Fréquence d'images par seconde
                            qrbox: 250  // Taille de la boîte de scan
                        },
                        qrCodeMessage => {
                            // Ouvrir le lien scanné dans un nouvel onglet
                            window.open(qrCodeMessage, '_blank');
                            // Arrêter le scanner
                            html5QrCode.stop().then(ignore => {
                                document.getElementById('qr-reader').style.display = 'none';
                                scannerActive = false;
                                console.log("Scanner arrêté.");
                            }).catch(err => {
                                console.log(`Erreur lors de l'arrêt du scanner: ${err}`);
                            });
                        },
                        errorMessage => {
                            console.log(`Erreur de scan: ${errorMessage}`);
                        }
                    ).catch(err => {
                        console.log(`Erreur de démarrage du scanner: ${err}`);
                    });
                    scannerActive = true;
                }
            });
        </script>


        <?php if (empty($competencesUtilisateur)): ?>
            <?php if (isset($_SESSION['users_id'])): ?>

            <?php else: ?>
            <?php endif; ?>

        <?php endif; ?>



        <div class="fille">
            <!-- <strong class="btn_f"><img src="../image/fichier.png" alt="">+</strong> -->
            <form action="" method="post" class="form-btn" enctype="multipart/form-data">
                <div class="box">
                    <label for="file"><img src="../image/fichier.png" alt=""></label>
                    <input type="file" name="document" id="file"
                        accept="application/pdf,.pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                    <input type="submit" name="téléverser" value="Téléverser" id="tele">
                </div>
                <div id="documentName"></div>
            </form>
            <div class="boxe">
                <p class="p">documents<img src="../image/fichier1.png" alt=""> <span>
                        <?php echo $rowCount ?>
                    </span></p>
                <ul>
                    <img class="img" src="../image/croix.png" alt="">
                    <?php foreach ($GetDocumentUsers as $documents): ?>
                        <li>
                            <a href="?document_id=<?= $documents['document_id'] ?>"><img class="img2"
                                    src="../image/croix.png" alt="">
                            </a>
                            <img class="img3" src="../image/document.png" alt="">
                            <span>
                                <?= $documents['document'] ?>
                            </span>
                            <a class="a" href="../document/<?= $documents['document'] ?>">
                                <img class="img4" src="../image/telechargement.png" alt="">
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <script>
                let boxe = document.querySelector('.boxe')
                let p = document.querySelector('.p')
                let img = document.querySelector('.img')
                p.addEventListener('click', () => {
                    boxe.style.height = 'auto'
                })
                img.addEventListener('click', () => {
                    boxe.style.height = '40px'
                })


                document.getElementById('file').addEventListener('change', function () {
                    var fileName = this.value.split('\\').pop(); // Obtenir le nom du fichier
                    document.getElementById('documentName').innerText = fileName;
                });
            </script>
        </div>


        <div class="container_box1">
            <div class="box1">
                <h2>A propos de moi ! <strong>
                        <?php echo $getVueProfil; ?><img src="../image/vue2.png" alt="">
                    </strong></h2>

                <div class="description">
                    <?php
                    // Vérifier si la description de l'utilisateur est vide
                    if (empty($descriptions['description'])):
                        ?>
                        <p class="p">Veuillez ajouter une description pour votre profil</p>
                    <?php else: ?>
                        <?php echo $descriptions['description']; ?>
                    <?php endif; ?>

                </div>
                <?php
                // Vérifier si la description de l'utilisateur est vide
                if (empty($descriptions['description'])):
                    ?>
                    <?php if (isset($_SESSION['users_id'])): ?>
                        <img class="buton" src="../image/edite.png" alt="">
                    <?php else: ?>
                    <?php endif; ?>


                    <div class="form_box">
                        <form method="post" action="" enctype="multipart/form-data">
                            <img class="imgs" src="../image/croix.png" alt="">

                            <?php if (isset($erreurs)): ?>
                                <div class="erreur">
                                    <?php echo $erreurs; ?>
                                </div>
                            <?php endif; ?>
                            <textarea name="description" id="counte" placeholder="Ajoutez une description ici"
                                maxlength="400"></textarea>
                            <p id="caracteres-restantes">400 caractères restants</p>
                            <input type="submit" value="Enregistrer" name="ajouter" id="ajoute">

                        </form>

                        <script>
                            const textareas = document.getElementById("counte");
                            const caracteresRestantes = document.getElementById("caracteres-restantes");

                            // Mise à jour du compteur de caractères en temps réel
                            textareas.addEventListener("keyup", () => {
                                const nombreCaracteress = textareas.value.length;
                                caracteresRestantes.textContent = `${400 - nombreCaracteress
                                    } caractères restants`;

                            });
                            // Limiter le nombre de caractères saisis en temps réel
                            textareas.addEventListener("input", () => {
                                if (textareas.value.length > 400) {
                                    textareas.value = textareas.value.substring(0, 400);
                                }
                            });
                        </script>
                    </div>

                <?php else: ?>
                    <?php if (isset($_SESSION['users_id'])): ?>
                        <img class="buton buttons" src="../image/edite.png" alt="">
                    <?php else: ?>
                    <?php endif; ?>


                    <div class="form_box texte">
                        <form method="post" action="" enctype="multipart/form-data">
                            <img class="imgs" src="../image/croix.png" alt="">

                            <textarea name="nouvelleDescription" id="count" placeholder="Ajoutez une description ici"
                                maxlength="400"> <?php echo $descriptions['description'] ?></textarea>
                            <p id="caracteres-restants">400 caractères restants</p>
                            <input type="submit" value="Enregistrer" name="Modifier" id="ajoute">

                        </form>
                    </div>

                <?php endif; ?>

                <script>
                    let buton = document.querySelector('.buton')
                    let form_box = document.querySelector('.form_box')
                    let imgs = document.querySelector('.imgs')

                    buton.addEventListener('click', function () {
                        form_box.style.display = 'block';
                        buton.style.display = 'none'
                    });
                    imgs.addEventListener('click', function () {
                        form_box.style.display = 'none';
                        buton.style.display = 'block'
                    });

                    let button = document.querySelector('.buttons')
                    let texte = document.querySelector('.texte')

                    button.addEventListener('click', function () {
                        texte.style.display = 'block';
                        button.style.display = 'none'
                    });
                    imgs.addEventListener('click', function () {
                        texte.style.display = 'none';
                        button.style.display = 'block'
                    });

                    const textarea = document.getElementById("count");
                    const caracteresRestants = document.getElementById("caracteres-restants");

                    // Mise à jour du compteur de caractères en temps réel
                    textarea.addEventListener("keyup", () => {
                        const nombreCaracteres = textarea.value.length;
                        caracteresRestants.textContent = `${400 - nombreCaracteres
                            } caractères restants`;

                    });
                    // Limiter le nombre de caractères saisis en temps réel
                    textarea.addEventListener("input", () => {
                        if (textarea.value.length > 400) {
                            textarea.value = textarea.value.substring(0, 400);
                        }
                    });

                </script>
            </div>
        </div>





        <div class="container_box2">
            <div class="box1">
                <h1>Expertise et compétences</h1>
            </div>
            <div class="box2">
                <h2>Expérience professionnelle</h2>

                <?php if (empty($afficheMetier)): ?>
                    <p class="p">Aucune expérience professionnelle enregistrée !</p>

                <?php else: ?>
                    <?php
                    foreach ($afficheMetier as $metiers):

                        ?>
                        <div class="metier">
                            <table>
                                <tr>
                                    <th>
                                        <p>
                                            <?php echo $metiers['metier']; ?>
                                        </p>
                                    </th>
                                    <td class="sup">
                                        <?php if (isset($_SESSION['users_id'])): ?>
                                            <!-- Ajouter un lien de suppression -->
                                            <a class="delete" href="?supprimer=<?php echo $metiers['id']; ?>"><img
                                                    src="../image/croix.png" alt=""></a>
                                        <?php else: ?>
                                        <?php endif; ?>

                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td class="date">
                                        <em>
                                            <?php echo $metiers['moisDebut']; ?>/
                                            <?php echo $metiers['anneeDebut']; ?>
                                        </em>
                                    </td>

                                    <td class="date">
                                        <em>
                                            <?php echo $metiers['moisFin']; ?>/
                                            <?php echo $metiers['anneeFin']; ?>
                                        </em>
                                    </td>

                                </tr>
                            </table>

                            <table>
                                <tr>
                                    <td id="td">
                                        <span>
                                            <?php echo $metiers['description']; ?>
                                        </span>
                                    </td>

                                </tr>
                            </table>

                        </div>
                        <?php
                    endforeach;
                    ?>
                <?php endif; ?>


                <?php if (isset($_SESSION['users_id'])): ?>
                    <button class="affiche_form"><img src="../image/edite.png" alt=""></button>
                <?php else: ?>
                <?php endif; ?>


                <form class="form" action="" method="post">
                    <img class="imgs1" src="../image/croix.png" alt="">

                    <div class="boxmetier">
                        <label for="metier">Titre de l'expérience professionnelle</label>
                        <input type="text" name="metier" id="metier">
                    </div>

                    <div class="boxmetier" id="dat">
                        <div>
                            <div class=" date">
                                <label for="date1">Date de début</label>
                                <div class="mois">
                                    <span for="mois">Mois :</span>
                                    <select id="mois" name="moisDebut">
                                        <option value="janvier">Janvier</option>
                                        <option value="février">Février</option>
                                        <option value="mars">Mars</option>
                                        <option value="avril">Avril</option>
                                        <option value="mai">Mai</option>
                                        <option value="juin">Juin</option>
                                        <option value="juillet">Juillet</option>
                                        <option value="août">Août</option>
                                        <option value="septembre">Septembre</option>
                                        <option value="octobre">Octobre</option>
                                        <option value="novembre">Novembre</option>
                                        <option value="décembre">Décembre</option>
                                    </select>
                                </div>

                                <div class="annee">
                                    <span>Année</span>
                                    <select id="annee" name="anneeDebut">
                                        <?php
                                        for ($annee = 1980; $annee <= 2030; $annee++) {
                                            echo "<option value='$annee'>$annee</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>

                            <div class=" date">
                                <label for="date2">Date de fin</label>
                                <div class="mois">
                                    <span for="mois">Mois :</span>
                                    <select id="mois" name="moisFin">
                                        <option value="janvier">Janvier</option>
                                        <option value="février">Février</option>
                                        <option value="mars">Mars</option>
                                        <option value="avril">Avril</option>
                                        <option value="mai">Mai</option>
                                        <option value="juin">Juin</option>
                                        <option value="juillet">Juillet</option>
                                        <option value="août">Août</option>
                                        <option value="septembre">Septembre</option>
                                        <option value="octobre">Octobre</option>
                                        <option value="novembre">Novembre</option>
                                        <option value="décembre">Décembre</option>
                                    </select>
                                </div>

                                <div class="annee">
                                    <span>Année</span>
                                    <select id="annee" name="anneeFin">
                                        <?php
                                        for ($annee = 1980; $annee <= 2030; $annee++) {
                                            echo "<option value='$annee'>$annee</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <script>
                            $(document).ready(function () {
                                $('#datee').datepicker({
                                    format: 'dd/mm/yyyy', // Format de la date
                                    autoclose: true, // Fermer automatiquement le sélecteur après la sélection
                                    todayHighlight: true, // Mettre en surbrillance la date actuelle
                                    startDate: '01/01/2000', // Date de début
                                    endDate: '31/12/2030', // Date de fin
                                    language: 'fr' // Langue (français)
                                });
                            });
                            $(document).ready(function () {
                                $('#datees').datepicker({
                                    format: 'dd/mm/yyyy', // Format de la date
                                    autoclose: true, // Fermer automatiquement le sélecteur après la sélection
                                    todayHighlight: true, // Mettre en surbrillance la date actuelle
                                    startDate: '01/01/2000', // Date de début
                                    endDate: '31/12/2030', // Date de fin
                                    language: 'fr' // Langue (français)
                                });
                            });
                        </script>
                    </div>

                    <div class="boxmetier">
                        <label for="metier">Ajouter une courte description : Facultatif</label>
                        <textarea name="Metierdescription" id="description" maxlength="200"></textarea>
                        <p id="caractere">200 caractères restants</p>
                    </div>
                    <input type="submit" value="Enregistrer" name="Ajouter" id="Ajouter">
                </form>

                <script>
                    let affiche_form = document.querySelector('.affiche_form')
                    let form = document.querySelector('.form')
                    let imgs1 = document.querySelector('.imgs1')

                    affiche_form.addEventListener('click', function () {
                        form.style.display = 'block';
                        affiche_form.style.display = 'none';
                    });
                    imgs1.addEventListener('click', function () {
                        form.style.display = 'none';
                        affiche_form.style.display = 'block';
                    });

                    const textee = document.getElementById("description");
                    const caractere = document.getElementById("caractere");

                    // Mise à jour du compteur de caractères en temps réel
                    textee.addEventListener("keyup", () => {
                        const nombre = textee.value.length;
                        caractere.textContent = `${200 - nombre
                            } caractères restants`;

                    });
                    // Limiter le nombre de caractères saisis en temps réel
                    textee.addEventListener("input", () => {
                        if (textee.value.length > 200) {
                            textee.value = textee.value.substring(0, 200);
                        }
                    });
                </script>
            </div>

            <div class="box3">
                <h2>Compétences</h2>
                <div class="container_comp">

                    <?php if (empty($competencesUtilisateur)): ?>
                        <p class="p">
                            Aucune compétence pour votre profil
                        </p>
                    <?php else: ?>
                        <?php
                        foreach ($competencesUtilisateur as $competence):
                            ?>
                            <p class="comp">
                                <?php echo $competence['competence']; ?>
                                <a href="?supprime=<?php echo $competence['id']; ?>"><img src="../image/croix.png" alt=""></a>
                            </p>




                            <?php
                        endforeach;
                        ?>
                    <?php endif; ?>

                </div>

                <?php if (isset($_SESSION['users_id'])): ?>
                    <button class="affiche_forms"><img src="../image/edite.png" alt=""></button>
                <?php else: ?>
                <?php endif; ?>

                <form class="forms" action="" method="post">
                    <img class="imgs2" src="../image/croix.png" alt="">
                    <input type="text" name="competence" id="competence">
                    <input type="submit" value="Enregistrer" name="Ajouter1" id="Ajouter">
                </form>

                <script>
                    let affiche_forms = document.querySelector('.affiche_forms')
                    let forms = document.querySelector('.forms')
                    let imgs2 = document.querySelector('.imgs2')

                    affiche_forms.addEventListener('click', function () {
                        forms.style.display = 'block';
                        affiche_forms.style.display = 'none';
                    });
                    imgs2.addEventListener('click', function () {
                        forms.style.display = 'none';
                        affiche_forms.style.display = 'block';
                    });
                </script>

            </div>

            <div class="box3">
                <h2>Niveau d'expérience et d'étude </h2>
                <div class="container_comp b2">

                    <?php if (empty($getNiveauEtude)): ?>
                        <p class="p">
                            Aucun niveau d'etude ajouter a votre profil
                        </p>
                    <?php else: ?>

                        <p>
                            <strong>Niveau D'etude:</strong>
                            <?php echo $getNiveauEtude['etude'] ?>
                        </p>
                        <p>
                            <strong>Niveau d'expérience :</strong>
                            <?php echo $getNiveauEtude['experience'] ?>
                        </p>

                    <?php endif; ?>

                </div>

                <?php if (isset($_SESSION['users_id'])): ?>
                    <?php if (isset($getNiveauEtude['etude'])): ?>
                        <button class="affiche_formss">Modifier</button>
                    <?php else: ?>
                        <button class="affiche_formss"><img src="../image/edite.png" alt=""></button>
                    <?php endif; ?>
                <?php endif; ?>

                <form class="formss" action="" method="post">
                    <img class="imgs22" src="../image/croix.png" alt="">
                    <?php if (isset($erreurs)): ?>
                        <p>
                            <?php echo $erreurs; ?>
                        </p>
                    <?php endif; ?>

                    <div>
                        <label for="etude">Niveau D'etude</label>
                        <select name="etude" id="etude">
                            <option value="">Choisissez un niveau d'études </option>
                            <option value="Bac+1an">Bac+1 an</option>
                            <option value="Bac+2ans">Bac+2 ans</option>
                            <option value="Bac+3ans">Bac+3 ans</option>
                            <option value="Bac+4ans">Bac+4 ans</option>
                            <option value="Bac+5ans">Bac+5 ans</option>
                            <option value="Bac+6ans">Bac+6 ans</option>
                            <option value="Bac+7ans">Bac+7 ans</option>
                            <option value="Bac+8ans">Bac+8 ans</option>
                            <option value="Bac+9ans">Bac+9 ans</option>
                            <option value="Bac+10ans">Bac+10 ans</option>
                            <option value="Aucun">Aucun</option>
                        </select>
                    </div>
                    <div>
                        <label for="experience">Niveau d'expérience</label>
                        <select name="experience" id="experience">
                            <option value="">Choisissez un niveau d'expérience </option>
                            <option value="1an">1 an</option>
                            <option value="2ans">2 ans</option>
                            <option value="3ans">3 ans</option>
                            <option value="4ans">4 ans</option>
                            <option value="5ans">5 ans</option>
                            <option value="6ans">6 ans</option>
                            <option value="7ans">7 ans</option>
                            <option value="8ans">8 ans</option>
                            <option value="9ans">9 ans</option>
                            <option value="10ans">10 ans</option>
                            <option value="Aucun">Aucun</option>
                        </select>
                    </div>
                    <?php if (isset($getNiveauEtude['etude'])): ?>
                        <input type="submit" value="Enregistrer" name="Ajouters1" id="Ajouter">
                    <?php else: ?>
                        <input type="submit" value="Enregistrer" name="Ajouters" id="Ajouter">
                    <?php endif; ?>
                </form>

                <script>
                    let affiche_formss = document.querySelector('.affiche_formss')
                    let formss = document.querySelector('.formss')
                    let imgs22 = document.querySelector('.imgs22')

                    affiche_formss.addEventListener('click', function () {
                        formss.style.display = 'block';
                        affiche_formss.style.display = 'none';
                    });
                    imgs22.addEventListener('click', function () {
                        formss.style.display = 'none';
                        affiche_formss.style.display = 'block';
                    });
                </script>

            </div>
        </div>



        </div>



        <div class="container_box3">

            <div class="box4">
                <h1>formation</h1>
            </div>
            <div class="box5">
                <table>

                    <tr>
                        <th>
                            Date
                        </th>
                        <th>
                            Filière / Classe
                        </th>
                        <th>
                            Établissement
                        </th>

                        <th class="grade">Niveau</th>
                        <th class="supr">supr</th>
                    </tr>

                    <?php if (empty($formationUsers)): ?>
                        <p class="p">Aucune formation enregistrer pour votre profil!</p>
                    <?php else: ?>

                    <?php endif ?>
                    <?php foreach ($formationUsers as $formations): ?>


                        <tr>
                            <td class="pt">
                                <?php echo $formations['moisDebut']; ?>/
                                <?php echo $formations['anneeDebut']; ?><br>
                                à <br>
                                <?php echo $formations['moisFin']; ?>/
                                <?php echo $formations['anneeFin']; ?>

                            </td>

                            <td>
                                <?php echo $formations['Filiere']; ?>
                            </td>

                            <td>
                                <?php echo $formations['etablissement']; ?>
                            </td>

                            <td class="grade">
                                <?php echo $formations['niveau']; ?>
                            </td>
                            <td class="supr">
                                <?php if (isset($_SESSION['users_id'])): ?>
                                    <a href="?supprimes=<?php echo $formations['id']; ?>"><img src="../image/croix.png"
                                            alt=""></a>
                                <?php else: ?>
                                <?php endif; ?>

                            </td>
                        </tr>

                    <?php endforeach; ?>

                </table>


            </div>

            <div class="fa-formation">
                <?php if (isset($_SESSION['users_id'])): ?>
                    <button class="Ajouters"><img src="../image/edite.png" alt=""></button>
                <?php else: ?>
                <?php endif; ?>

            </div>

            <div class="containne">
                <form class="formee" action="" method="post">

                    <img class="imgFormee" src="../image/croix.png" alt="">

                    <div class="container_box">

                        <div class="box1">
                            <label for="annee">Année du debut </label>
                            <div class="date">
                                <div class="mois">
                                    <span for="mois">Mois :</span>
                                    <select id="mois" name="moisDebut">
                                        <option value="janvier">Janvier</option>
                                        <option value="février">Février</option>
                                        <option value="mars">Mars</option>
                                        <option value="avril">Avril</option>
                                        <option value="mai">Mai</option>
                                        <option value="juin">Juin</option>
                                        <option value="juillet">Juillet</option>
                                        <option value="août">Août</option>
                                        <option value="septembre">Septembre</option>
                                        <option value="octobre">Octobre</option>
                                        <option value="novembre">Novembre</option>
                                        <option value="décembre">Décembre</option>
                                    </select>
                                </div>

                                <div class="annee">
                                    <span>Annees</span>
                                    <select id="annee" name="anneeDebut">
                                        <?php
                                        for ($annee = 1980; $annee <= 2030; $annee++) {
                                            echo "<option value='$annee'>$annee</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="box1">
                            <label for="annees">Année de la fin </label>
                            <div class="date">

                                <div class="mois">
                                    <span for="mois">Mois :</span>
                                    <select id="mois" name="moisFin">
                                        <option value="janvier">Janvier</option>
                                        <option value="février">Février</option>
                                        <option value="mars">Mars</option>
                                        <option value="avril">Avril</option>
                                        <option value="mai">Mai</option>
                                        <option value="juin">Juin</option>
                                        <option value="juillet">Juillet</option>
                                        <option value="août">Août</option>
                                        <option value="septembre">Septembre</option>
                                        <option value="octobre">Octobre</option>
                                        <option value="novembre">Novembre</option>
                                        <option value="décembre">Décembre</option>
                                    </select>
                                </div>

                                <div class="annee">
                                    <span>Annees</span>
                                    <select id="annee" name="anneeFin">
                                        <?php
                                        for ($annee = 1980; $annee <= 2030; $annee++) {
                                            echo "<option value='$annee'>$annee</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container_box">
                        <div class="box1">
                            <label for="Filiere">Filière/classe</label>
                            <input type="text" name="Filiere" id="Filiere">
                        </div>
                        <div class="box1">
                            <label for="etablissement">Établissement</label>
                            <input type="text" name="etablissement" id="etablissement">
                        </div>
                    </div>
                    <div class="container_box">
                        <div class="box1">
                            <label for="niveau">Niveau</label>
                            <select name="niveau" id="niveau_etude">
                                <option value="Secondaire">Secondaire</option>
                                <option value="Licence1">Licence 1</option>
                                <option value="Licence2">Licence 2</option>
                                <option value="Licence3">Licence 3</option>
                                <option value="Master1">Master 1</option>
                                <option value="Master2">Master 2</option>
                                <option value="Doctorat">Doctorat</option>
                            </select>
                        </div>
                        <div class="box1">
                            <input type="submit" value="Enregistrer" name="ajouter2" id="ajouter">
                        </div>
                    </div>

                </form>
            </div>
            <script>
                $(document).ready(function () {
                    $('#date1').datepicker({
                        format: 'dd/mm/yyyy', // Format de la date
                        autoclose: true, // Fermer automatiquement le sélecteur après la sélection
                        todayHighlight: true, // Mettre en surbrillance la date actuelle
                        startDate: '01/01/2000', // Date de début
                        endDate: '31/12/2030', // Date de fin
                        language: 'fr' // Langue (français)
                    });
                });
                $(document).ready(function () {
                    $('#date2').datepicker({
                        format: 'dd/mm/yyyy', // Format de la date
                        autoclose: true, // Fermer automatiquement le sélecteur après la sélection
                        todayHighlight: true, // Mettre en surbrillance la date actuelle
                        startDate: '01/01/2000', // Date de début
                        endDate: '31/12/2030', // Date de fin
                        language: 'fr' // Langue (français)
                    });
                });
            </script>

            <script>
                let Ajoutes = document.querySelector('.Ajouters')
                let formee = document.querySelector('.containne')
                let imgFormee = document.querySelector('.imgFormee')

                Ajoutes.addEventListener('click', function () {
                    formee.style.display = 'block';
                    Ajoutes.style.display = 'none'
                });
                imgFormee.addEventListener('click', function () {
                    formee.style.display = 'none';
                    Ajoutes.style.display = 'block'

                });
            </script>
        </div>


        <!-- <div class="container_box4">
            <div class="box1">
                <div class="div">
                    <table>
                        <tr>
                            <th>Diplomes</th>
                        </tr>
                    </table>
                    <div>
                        <?php foreach ($afficheDiplome as $diplomes): ?>

                            <table>
                                <tr>
                                    <td>
                                        <?php echo $diplomes['diplome']; ?>
                                        <a href="?diplomes=<?= $diplomes['id']; ?>"><img src="../image/croix.png"
                                                alt=""></a>
                                    </td>
                                </tr>
                            </table>
                        <?php endforeach; ?>
                    </div>

                </div>

                <div class="div">
                    <table>
                        <tr>
                            <th>Certificats</th>
                        </tr>
                    </table>
                    <div>
                        <?php foreach ($afficheCertificat as $certificats): ?>
                            <table>
                                <tr>
                                    <td>
                                        <?php echo $certificats['certificat'] ?>
                                        <a href="?certificats=<?= $certificats['id']; ?>"><img src="../image/croix.png"
                                                alt=""></a>
                                    </td>
                                </tr>
                            </table>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="box2">
                <?php if (isset($_SESSION['users_id'])): ?>
                    <button class="btn btn1"> <img src="../image/edite.png" alt=""> Diplôme</button>
                    <button class="btn btn2"> <img src="../image/edite.png" alt=""> Certificat</button>
                <?php else: ?>
                <?php endif; ?>

            </div>


            <div class="box3 box31">
                <form action="" method="post">
                    <img src="../image/croix.png" alt="">
                    <input class="input" type="text" name="diplome" id="diplome">
                    <input type="submit" value="ajouter" name="ajouteer1" id="ajouteer">
                </form>
            </div>
            <div class="box3 box32">
                <form action="" method="post">
                <img src="../image/croix.png" alt="">
                    <input class="input" type="text" name="certificat" id="diplome">
                    <input type="submit" value="ajouter" name="ajouteer2" id="ajouteer">
                </form>
            </div>


            <script>
                let btn1 = document.querySelector('.btn1')
                let box31 = document.querySelector('.box31')

                btn1.addEventListener('click', function () {
                    if (box31.style.display === 'none' || box31.style.display === '') {
                        box31.style.display = 'block';
                    } else {
                        box31.style.display = 'none';
                    }
                });

                let btn2 = document.querySelector('.btn2')
                let box32 = document.querySelector('.box32')

                btn2.addEventListener('click', function () {
                    if (box32.style.display === 'none' || box32.style.display === '') {
                        box32.style.display = 'block';
                    } else {
                        box32.style.display = 'none';
                    }
                });
            </script>

        </div> -->





        <div class="container_box5">
            <div class="box1">
                <h1>Maîtrise des outils informatiques</h1>
            </div>

            <div class="box2">

                <?php if (empty($afficheOutil)): ?>
                    <p class="p">Aucun outils informatique ajouter a votre profil</p>
                <?php else: ?>
                    <table>
                        <?php foreach ($afficheOutil as $outils): ?>
                            <tr>
                                <td>
                                    <?php echo $outils['outil'] ?>
                                </td>
                                <td class="niveau">
                                    <?php echo $outils['niveau'] ?>
                                </td>
                                <td class="sup">
                                    <a href="?suprimerOutils=<?= $outils['id'] ?>"> <img src="../image/croix.png" alt=""></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>



                <div class="outil">
                    <?php if (isset($_SESSION['users_id'])): ?>
                        <button class="btn3"> <img src="../image/edite.png" alt=""></button>
                    <?php else: ?>
                    <?php endif; ?>

                </div>
            </div>

            <div class="box3 box34">
                <form action="" method="post" enctype="multipart/form-data">
                    <img class="croixx" src="../image/croix.png" alt="">
                    <div class="tcp">
                        <label for="outil">Ajouter un outil informatique</label>
                        <input type="text" name="outil" id="outil">
                    </div>

                    <div class="tcp">
                        <label for="niveau">Ajouter un niveau</label>
                        <select name="niveau" id="niveau">
                            <option value="Debutant">Debutant</option>
                            <option value="Intermediaire">Intermédiaire</option>
                            <option value="professionel">Professionnel</option>
                            <option value="Avencer">Avancer</option>
                        </select>
                        <input type="submit" value="Enregister" name="ajouts" id="ajout">
                    </div>

                </form>
            </div>

            <script>
                let btn3 = document.querySelector('.btn3')
                let box34 = document.querySelector('.box34')
                let croixx = document.querySelector('.croixx')

                btn3.addEventListener('click', function () {
                    box34.style.display = 'block';
                    btn3.style.display = 'none'
                });
                croixx.addEventListener('click', () => {
                    box34.style.display = 'none';
                    btn3.style.display = 'block'
                })
            </script>
        </div>








        <div class="container_box5">
            <div class="box1">
                <h1>maitrise des langues</h1>
            </div>

            <div class="box2">
                <?php if (empty($afficheLangue)): ?>
                    <p class="p">Aucune langue ajouter a votre profil</p>
                <?php else: ?>
                    <table>
                        <?php foreach ($afficheLangue as $langues): ?>
                            <tr>
                                <td>
                                    <?php echo $langues['langue']; ?>
                                </td>
                                <td class="niveau">
                                    <?php echo $langues['niveau']; ?>
                                </td>
                                <td class="sup">
                                    <a href="?suprimer=<?= $langues['id'] ?>"> <img src="../image/croix.png" alt=""></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>

                <div class="outil">
                    <?php if (isset($_SESSION['users_id'])): ?>
                        <button class="btn4"> <img src="../image/edite.png" alt=""></button>
                    <?php else: ?>
                    <?php endif; ?>

                </div>
            </div>

            <div class="box3 box35">
                <form action="" method="post">
                    <img class="croixxx" src="../image/croix.png" alt="">
                    <div class="tcp">
                        <label for="tangue">Ajouter une langue</label>
                        <input type="text" name="langue" id="langue">
                    </div>

                    <div class="tcp">
                        <label for="niveau">Ajouter un niveau</label>
                        <select name="niveau" id="niveau">
                            <option value="Debutant">Debutant</option>
                            <option value="Intermediaire">Intermédiaire</option>
                            <option value="professionel">Professionnel</option>
                            <option value="Avencer">Avancer</option>
                        </select>
                        <input type="submit" value="Enregister" name="ajoutss" id="ajout">
                    </div>

                </form>
            </div>

            <script>
                let btn4 = document.querySelector('.btn4')
                let box35 = document.querySelector('.box35')
                let croixxx = document.querySelector('.croixxx')

                btn4.addEventListener('click', function () {
                    box35.style.display = 'block'
                    btn4.style.display = 'none'
                });
                croixxx.addEventListener('click', () => {
                    box35.style.display = 'none';
                    btn4.style.display = 'block'
                })
            </script>
        </div>


        <div class="container_box7">

            <div class="box1">
                <h1>Projets et réalisations</h1>
            </div>
            <?php if (isset($_SESSION['users_id'])): ?>
                <button class="ajout"><img src="../image/edite.png" alt=""></button>
            <?php else: ?>
            <?php endif; ?>
            <div class="form_projet">

                <form action="" method="post" enctype="multipart/form-data">
                    <img class="im" src="../image/croix.png" alt="">
                    <div class="box">
                        <label for="titre">Titre</label>
                        <input type="text" name="titre" id="titre">
                    </div>

                    <div class="box">
                        <label for="liens">Ajoute un lien </label>
                        <input type="text" name="liens" id="liens" value="https://">
                    </div>

                    <div class="box">
                        <label for="projetdescription">Description</label>
                        <textarea name="projetdescription" id="projetdescription"></textarea>
                    </div>

                    <div class="box">
                        <p>Ajoute une image de ton projet</p>
                        <div class="imageView">
                            <label class="label" for="images"> <img src="/image/galerie.jpg" alt=""></label>
                            <input type="file" name="images" id="images"
                                accept="image/jpeg, image/jpg, image/png, image/gif">
                            <img id="imagePreview" src="" alt="view">

                            <script>
                                // Récupérer l'élément input type file
                                const inputImage = document.getElementById('images');

                                // Écouter le changement de fichier sélectionné
                                inputImage.addEventListener('change', () => {

                                    // Récupérer le premier fichier sélectionné
                                    const file = inputImage.files[0];

                                    // Afficher l'aperçu dans l'élément img
                                    const previewImg = document.getElementById('imagePreview');
                                    previewImg.src = URL.createObjectURL(file);

                                });
                            </script>
                        </div>

                    </div>
                    <input type="submit" name="valider" value="Enregister" id="ajouter">
                </form>

            </div>

            <script>
                let ajout = document.querySelector('.ajout')
                let form_projet = document.querySelector('.form_projet')
                let im = document.querySelector('.im')

                ajout.addEventListener('click', function () {
                    form_projet.style.display = 'block';
                    ajout.style.display = 'none';

                });
                im.addEventListener('click', () => {
                    form_projet.style.display = 'none';
                    ajout.style.display = 'block';
                })
            </script>
            <div class="box2">

                <?php if (empty($affichePojetUsers)): ?>
                    <p class="p"> Aucun projet ajouter pour votre profil !</p>
                <?php else: ?>
                <?php endif; ?>

                <?php foreach ($affichePojetUsers as $projets): ?>

                    <div class="info_projet">

                        <a href="?projets=<?php echo $projets['id'] ?>"><img class="supp" src="../image/croix.png"
                                alt=""></a>
                        <h2>
                            <?php echo $projets['titre'] ?>
                        </h2>
                        <p>
                            <?php echo $projets['projetdescription'] ?>
                        </p>

                        <a href="<?php echo $projets['liens'] ?>">Click sur ce lien :
                            <?php echo $projets['liens'] ?>
                        </a>

                        <img src="../upload/<?php echo $projets['images'] ?>" alt="">
                    </div>

                <?php endforeach; ?>


            </div>
        </div>






        <div class="container_box8">
            <div class="box1">
                <h1>Centre d’intérêt</h1>
            </div>

            <div class="box2">

                <button class="btn_eteret"><img class="im" src="../image/edite.png" alt=""></button>

                <form class="form_btn" method="post" action="">
                    <img class="ims" src="../image/croix.png" alt="">
                    <?php if (isset($erreurs)): ?>
                        <div>
                            <?php echo $erreurs ?>
                        </div>
                    <?php endif; ?>
                    <input type="text" name="interet" id="interet">
                    <input type="submit" name="ajouter_interet" value="Enregister" id="ajouter">
                </form>

                <?php if (empty($afficheCentreInteret)): ?>
                    <p class="p">Aucun centre d’intérêt ajouter a votre profil</p>
                <?php else: ?>

                    <ul>
                        <?php foreach ($afficheCentreInteret as $centreInteret): ?>
                            <li>
                                <?= $centreInteret['interet'] ?> <a
                                    href="?centreinteret=<?= $centreInteret['interet_id'] ?>"><img src="../image/croix.png"
                                        alt=""></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <script>
                    let btn_i = document.querySelector('.btn_eteret');
                    let form_btn = document.querySelector('.form_btn');
                    let ims = document.querySelector('.ims')

                    btn_i.addEventListener('click', () => {
                        form_btn.style.display = 'block'
                        btn_i.style.display = 'none';
                    })
                    ims.addEventListener('click', () => {
                        form_btn.style.display = 'none';
                        btn_i.style.display = 'block';
                    })
                </script>
            </div>



        </div>

        <div class="box_assistance">
            <div>
                <a href="#container_box6"><button id="contacte"><img src="../image/service.png" alt=""></button></a>
                <a class="whatsapp" href="https://api.whatsapp.com/send?phone=785303879" target="_blank"><img
                        src="../image/whatsapp.png" alt=""></a>
                <a class="mail" href="mailto:workflexer.service@gmail.com"><img src="../image/icons8-gmail-48.png"
                        alt=""> </a>
            </div>
        </div>

        <?php if (isset($_SESSION['users_id'])): ?>
            <div class="container_box6" id="container_box6">
                <div class="box1">
                    <!-- <img src="../image/croix.png" alt="" id="img"> -->
                    <h1>assistance</h1>
                    <br>
                    <p>Ou écrivez nous ici !</p>
                </div>

                <div class="box2">
                    <form action="" method="post">
                        <textarea name="message" class="form-control" id=""></textarea>
                        <button type="submit" name="send">Envoyer</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
        <?php endif; ?>







        <div class="container_box10" id="container_box10">
            <h2>Offres qui correspondes a votre profil </h2>

            <div class="slider owl-carousel carousel3">
                <?php if ($afficheAllOffre): ?>

                    <?php foreach ($afficheAllOffre as $affiches): ?>

                        <?php
                        $info_entreprise = getEntreprise($db, $affiches['entreprise_id']);
                        $niveau_etude = gettNiveau($db, $_SESSION['users_id']);
                        ?>

                        <?php if ($affiches['categorie'] === $users['categorie'] && ($niveau_etude['n_etude'] >= $affiches['n_etudes']) && $niveau_etude['n_experience'] >= $affiches['n_experience']): ?>

                            <div class="carousel">
                                <img src="../upload/<?= $info_entreprise['images'] ?>" alt="">

                                <div class="info-box">

                                    <p class="p">
                                        <strong>
                                            <?= $info_entreprise['entreprise'] ?>
                                        </strong>
                                    </p>
                                    <p class="poste"><strong>Nous recherchons un(une) </strong>
                                        <?= $affiches['poste'] ?>
                                    </p>
                                    <div class="box_vendu">
                                        <div class="vendu">

                                            <p><strong>Niveau : </strong>
                                                <?= $affiches['etudes'] ?>
                                            </p>
                                            <p><strong>Experience : </strong>
                                                <?= $affiches['experience'] ?>
                                            </p>

                                            <p><strong>Contrat : </strong>
                                                <?= $affiches['contrat'] ?>
                                            </p>
                                            <p><strong>Ville : </strong>
                                                <?= $affiches['localite'] ?>
                                            </p>
                                        </div>
                                    </div>
                                    <p id="nom">
                                        <?= $affiches['date'] ?>
                                    </p>
                                    <a
                                        href="../entreprise/voir_offre.php?offres_id=<?= $affiches['offre_id'] ?> & entreprise_id=<?= $affiches['entreprise_id'] ?>"><i
                                            class="fa-solid fa-eye"></i>Voir l\'offre</a>

                                </div>
                            </div>

                        <?php else: ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>



            </div>
        </div>


    </section>



    <script>
        let assistance = document.getElementById('contacte');
        let cache = document.getElementById('img');
        let container_box6 = document.querySelector('.container_box6');

        assistance.addEventListener('click', () => {

        });

        cache.addEventListener('click', () => {
            container_box6.style.transform = 'translateX(0px)';
        });
    </script>

</body>

</html>