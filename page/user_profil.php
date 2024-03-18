<?php
session_start();
include '../conn/conn.php';



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
<html lang="en">

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
    <link rel="icon" href="../image/logo.png" type="image/x-icon">

    <script src="../script/jquery-3.6.0.min.js"></script>

    <!-- <script src="../script/summernote@0.8.18.js"></script>
    <link rel="stylesheet" href="../style/summernote@0.8.18.css"> -->

    <link rel="stylesheet" href="/css/user_profil.css">
    <link rel="stylesheet" href="../css/navbare.css">

    <link rel="stylesheet" href="../css/aos.css" />
    <script src="../js/aos.js"></script>

    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">

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



        <?php if (empty($competencesUtilisateur)): ?>
            <?php if (isset($_SESSION['users_id'])): ?>

            <?php else: ?>
            <?php endif; ?>

        <?php endif; ?>

        <img src="../image/fleche.png" alt="" class="img222">
        <script>
            let img222 = document.querySelector('.img222');
            let section2 = document.querySelector('.section2');
            let img111 = document.querySelector('.img111');

            img222.addEventListener('click', () => {
                section2.style.marginLeft = '0px';
                img222.style.display = 'none';
            });

            img111.addEventListener('click', () => {
                section2.style.marginLeft = '-150%';
                img222.style.display = 'block';
            });
        </script>

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
                        <?php echo $getVueProfil; ?><img src="../image/vue.png" alt="">
                    </strong></h2>

                <div class="description">
                    <?php
                    // Vérifier si la description de l'utilisateur est vide
                    if (empty($descriptions['description'])):
                        ?>
                        <p class="p">Aucune description pour ce profil veuillez Ajouté une description pour votre profil</p>
                    <?php else: ?>
                        <?php echo $descriptions['description']; ?>
                    <?php endif; ?>

                </div>
                <?php
                // Vérifier si la description de l'utilisateur est vide
                if (empty($descriptions['description'])):
                    ?>
                    <?php if (isset($_SESSION['users_id'])): ?>
                        <button class="buton">Ajouter une description</button>
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
                            <textarea name="description" id="counte" placeholder="Ajoute une description ici"
                                maxlength="500"></textarea>
                            <p id="caracteres-restantes">500 caractères restants</p>
                            <input type="submit" value="ajouter" name="ajouter" id="ajoute">

                        </form>

                        <script>
                            const textareas = document.getElementById("counte");
                            const caracteresRestantes = document.getElementById("caracteres-restantes");

                            // Mise à jour du compteur de caractères en temps réel
                            textareas.addEventListener("keyup", () => {
                                const nombreCaracteress = textareas.value.length;
                                caracteresRestantes.textContent = `${500 - nombreCaracteress
                                    } caractères restants`;

                            });
                            // Limiter le nombre de caractères saisis en temps réel
                            textareas.addEventListener("input", () => {
                                if (textareas.value.length > 500) {
                                    textareas.value = textareas.value.substring(0, 500);
                                }
                            });
                        </script>
                    </div>

                <?php else: ?>
                    <?php if (isset($_SESSION['users_id'])): ?>
                        <button class="buton buttons">Modifier la description</button>
                    <?php else: ?>
                    <?php endif; ?>


                    <div class="form_box texte">
                        <form method="post" action="" enctype="multipart/form-data">
                            <img class="imgs" src="../image/croix.png" alt="">

                            <textarea name="nouvelleDescription" id="count" placeholder="Ajoute une description ici"
                                maxlength="500"> <?php echo $descriptions['description'] ?></textarea>
                            <p id="caracteres-restants">500 caractères restants</p>
                            <input type="submit" value="Modifier" name="Modifier" id="ajoute">

                        </form>
                    </div>

                <?php endif; ?>

                <script>
                    let buton = document.querySelector('.buton')
                    let form_box = document.querySelector('.form_box')
                    let imgs = document.querySelector('.imgs')

                    buton.addEventListener('click', function () {
                        form_box.style.display = 'block';
                    });
                    imgs.addEventListener('click', function () {
                        form_box.style.display = 'none';
                    });

                    let button = document.querySelector('.buttons')
                    let texte = document.querySelector('.texte')

                    button.addEventListener('click', function () {
                        texte.style.display = 'block';
                    });
                    imgs.addEventListener('click', function () {
                        texte.style.display = 'none';
                    });

                    const textarea = document.getElementById("count");
                    const caracteresRestants = document.getElementById("caracteres-restants");

                    // Mise à jour du compteur de caractères en temps réel
                    textarea.addEventListener("keyup", () => {
                        const nombreCaracteres = textarea.value.length;
                        caracteresRestants.textContent = `${500 - nombreCaracteres
                            } caractères restants`;

                    });
                    // Limiter le nombre de caractères saisis en temps réel
                    textarea.addEventListener("input", () => {
                        if (textarea.value.length > 500) {
                            textarea.value = textarea.value.substring(0, 500);
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
                <h2>Experience professionnel</h2>

                <?php if (empty($afficheMetier)): ?>
                    <p class="p">Aucune experience professionnel enregistrer!</p>

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
                    <button class="affiche_form">Ajouter une experience</button>
                <?php else: ?>
                <?php endif; ?>


                <form class="form" action="" method="post">
                    <img class="imgs1" src="../image/croix.png" alt="">

                    <div class="boxmetier">
                        <label for="metier">Titre de l'experience professionnel</label>
                        <input type="text" name="metier" id="metier">
                    </div>

                    <div class="boxmetier" id="dat">
                        <div>
                            <div class=" date">
                                <label for="date1">date de debut</label>
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
                        <div>

                            <div class=" date">
                                <label for="date2">date de fin</label>
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
                        <label for="metier">ajouter une courte description : Facultatif</label>
                        <textarea name="Metierdescription" id="description" maxlength="300"></textarea>
                        <p id="caractere">300 caracteres restants</p>
                    </div>
                    <input type="submit" value="Ajouter" name="Ajouter" id="Ajouter">
                </form>

                <script>
                    let affiche_form = document.querySelector('.affiche_form')
                    let form = document.querySelector('.form')
                    let imgs1 = document.querySelector('.imgs1')

                    affiche_form.addEventListener('click', function () {
                        form.style.display = 'block';
                    });
                    imgs1.addEventListener('click', function () {
                        form.style.display = 'none';
                    });

                    const textee = document.getElementById("description");
                    const caractere = document.getElementById("caractere");

                    // Mise à jour du compteur de caractères en temps réel
                    textee.addEventListener("keyup", () => {
                        const nombre = textee.value.length;
                        caractere.textContent = `${300 - nombre
                            } caractères restants`;

                    });
                    // Limiter le nombre de caractères saisis en temps réel
                    textee.addEventListener("input", () => {
                        if (textee.value.length > 300) {
                            textee.value = textee.value.substring(0, 300);
                        }
                    });
                </script>
            </div>

            <div class="box3">
                <h2>Compétences</h2>
                <div class="container_comp">

                    <?php if (empty($competencesUtilisateur)): ?>
                        <p class="p">
                            Aucune competence pour votre profil
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
                    <button class="affiche_forms">Ajouter une compétences</button>
                <?php else: ?>
                <?php endif; ?>

                <form class="forms" action="" method="post">
                    <img class="imgs2" src="../image/croix.png" alt="">
                    <input type="text" name="competence" id="competence">
                    <input type="submit" value="Ajouter" name="Ajouter1" id="Ajouter">
                </form>

                <script>
                    let affiche_forms = document.querySelector('.affiche_forms')
                    let forms = document.querySelector('.forms')
                    let imgs2 = document.querySelector('.imgs2')

                    affiche_forms.addEventListener('click', function () {
                        forms.style.display = 'block';
                    });
                    imgs2.addEventListener('click', function () {
                        forms.style.display = 'none';
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
                        <button class="affiche_formss">Ajouter un niveau d'etude et experience</button>
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
                            <option value="Bac+1an">Bac+1an</option>
                            <option value="Bac+2ans">Bac+2ans</option>
                            <option value="Bac+3ans">Bac+3ans</option>
                            <option value="Bac+4ans">Bac+4ans</option>
                            <option value="Bac+5ans">Bac+5ans</option>
                            <option value="Bac+6ans">Bac+6ans</option>
                            <option value="Bac+7ans">Bac+7ans</option>
                            <option value="Bac+8ans">Bac+8ans</option>
                            <option value="Bac+9ans">Bac+9ans</option>
                            <option value="Bac+10ans">Bac+10ans</option>
                        </select>
                    </div>
                    <div>
                        <label for="experience">Niveau d'expérience</label>
                        <select name="experience" id="experience">
                            <option value="">Choisissez un niveau d'expérience </option>
                            <option value="1an">1an</option>
                            <option value="2ans">2ans</option>
                            <option value="3ans">3ans</option>
                            <option value="4ans">4ans</option>
                            <option value="5ans">5ans</option>
                            <option value="6ans">6ans</option>
                            <option value="7ans">7ans</option>
                            <option value="8ans">8ans</option>
                            <option value="9ans">9ans</option>
                            <option value="10ans">10ans</option>
                        </select>
                    </div>
                    <?php if (isset($getNiveauEtude['etude'])): ?>
                        <input type="submit" value="Modifier" name="Ajouters1" id="Ajouter">
                    <?php else: ?>
                        <input type="submit" value="Ajouter" name="Ajouters" id="Ajouter">
                    <?php endif; ?>
                </form>

                <script>
                    let affiche_formss = document.querySelector('.affiche_formss')
                    let formss = document.querySelector('.formss')
                    let imgs22 = document.querySelector('.imgs22')

                    affiche_formss.addEventListener('click', function () {
                        formss.style.display = 'block';
                    });
                    imgs22.addEventListener('click', function () {
                        formss.style.display = 'none';
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
                    <button class="Ajouters">Ajouter une formation</button>
                <?php else: ?>
                <?php endif; ?>

            </div>

            <div class="containne">
                <form class="formee" action="" method="post">

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
                            <input type="submit" value="ajouter" name="ajouter2" id="ajouter">
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

                Ajoutes.addEventListener('click', function () {
                    if (formee.style.display === 'none' || formee.style.display === '') {
                        formee.style.display = 'block';
                    } else {
                        formee.style.display = 'none';
                    }
                });
            </script>
        </div>


        <div class="container_box4">
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
                    <button class="btn btn1"> ajouter un Diplôme</button>
                    <button class="btn btn2"> ajouter un certificat</button>
                <?php else: ?>
                <?php endif; ?>

            </div>


            <div class="box3 box31">
                <form action="" method="post">
                    <input class="input" type="text" name="diplome" id="diplome">
                    <input type="submit" value="ajouter" name="ajouteer1" id="ajouteer">
                </form>
            </div>
            <div class="box3 box32">
                <form action="" method="post">
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

        </div>





        <div class="container_box5">
            <div class="box1">
                <h1>maîtrise des outils informatiques</h1>
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
                        <button class="btn3"> Ajouter un outil</button>
                    <?php else: ?>
                    <?php endif; ?>

                </div>
            </div>

            <div class="box3 box34">
                <form action="" method="post" enctype="multipart/form-data">
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
                        <input type="submit" value="ajouter" name="ajouts" id="ajout">
                    </div>

                </form>
            </div>

            <script>
                let btn3 = document.querySelector('.btn3')
                let box34 = document.querySelector('.box34')

                btn3.addEventListener('click', function () {
                    if (box34.style.display === 'none' || box34.style.display === '') {
                        box34.style.display = 'block';
                    } else {
                        box34.style.display = 'none';
                    }
                });
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
                        <button class="btn4"> Ajouter une langue</button>
                    <?php else: ?>
                    <?php endif; ?>

                </div>
            </div>

            <div class="box3 box35">
                <form action="" method="post">
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
                        <input type="submit" value="ajouter" name="ajoutss" id="ajout">
                    </div>

                </form>
            </div>

            <script>
                let btn4 = document.querySelector('.btn4')
                let box35 = document.querySelector('.box35')

                btn4.addEventListener('click', function () {
                    if (box35.style.display === 'none' || box35.style.display === '') {
                        box35.style.display = 'block';
                    } else {
                        box35.style.display = 'none';
                    }
                });
            </script>
        </div>


        <div class="container_box7">

            <div class="box1">
                <h1>Projets et réalisations</h1>
            </div>
            <?php if (isset($_SESSION['users_id'])): ?>
                <button class="ajout">Ajouter un projet/réalisation</button>
            <?php else: ?>
            <?php endif; ?>
            <div class="form_projet">

                <form action="" method="post" enctype="multipart/form-data">
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
                    <input type="submit" name="valider" value="Ajouter" id="ajouter">
                </form>

            </div>

            <script>
                let ajout = document.querySelector('.ajout')
                let form_projet = document.querySelector('.form_projet')

                ajout.addEventListener('click', function () {
                    if (form_projet.style.display === 'none' || form_projet.style.display === '') {
                        form_projet.style.display = 'block';
                    } else {
                        form_projet.style.display = 'none';
                    }
                });
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

                <button class="btn_eteret">Ajouter un centre d’intérêt</button>

                <form class="form_btn" method="post" action="">
                    <?php if (isset($erreurs)): ?>
                        <div>
                            <?php echo $erreurs ?>
                        </div>
                    <?php endif; ?>
                    <input type="text" name="interet" id="interet">
                    <input type="submit" name="ajouter_interet" value="Ajouter" id="ajouter">
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

                    btn_i.addEventListener('click', () => {
                        if (form_btn.style.display == 'none') {
                            form_btn.style.display = 'block'
                        } else {
                            form_btn.style.display = 'none'
                        }
                    })
                </script>
            </div>



        </div>



        <?php if (isset($_SESSION['users_id'])): ?>
            <div class="container_box6">
                <style>
                    .container_box6 a {
                        display: flex;
                        align-items: center;
                        color: gray;
                    }

                    .container_box6 a img {
                        margin-right: 5px;
                    }

                    .container_box6 p {
                        font-size: 20px;
                        text-align: center;
                    }
                </style>
                <div class="box1">
                    <h1>assistance</h1>
                    <a href="tel:+221785303879"><img src="../image/whatsapp.png" alt=""> Phone : <strong>+221 78 530 38
                            79</strong></a>
                    <a href="mailto:youremail@example.com"><img src="../image/icons8-gmail-48.png" alt=""> Mail
                        :<strong>workflexer.service@gmail.com</strong></a>
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






        <div class="container_box10">
            <h2>Offres qui correspondes a votre profil </h2>

            <div class="box2">
                <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
                <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
            </div>
            <div class="slider owl-carousel carousel3">
                <?php if ($afficheAllOffre): ?>

                    <?php foreach ($afficheAllOffre as $affiches): ?>

                        <?php $info_entreprise = getEntreprise($db, $affiches['entreprise_id']); ?>

                        <?php if ($affiches['categorie'] === $users['categorie']): ?>

                            <div class="carousel">
                                <img src="../upload/<?= $info_entreprise['images'] ?>" alt="">
                                <p class="p">
                                    <strong>
                                        <?= $info_entreprise['entreprise'] ?>
                                    </strong>
                                </p>
                                <div class="vendu">
                                    <p><strong>Nous recherchons un(une) </strong>
                                        <?= $affiches['poste'] ?>
                                    </p>
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
                                <p id="nom">
                                    <?= $affiches['date'] ?>
                                </p>
                                <a
                                    href="../entreprise/voir_offre.php?offres_id=<?= $affiches['offre_id'] ?> & entreprise_id=<?= $affiches['entreprise_id'] ?>"><i
                                        class="fa-solid fa-eye"></i>Voir l\'offre</a>
                            </div>

                        <?php else: ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>



            </div>
        </div>


    </section>



    <script src="/js/owl.carousel.min.js"></script>
    <script src="/js/owl.carousel.js"></script>
    <script src="/js/owl.animate.js"></script>
    <script src="/js/owl.autoplay.js"></script>


    <script>



        $(document).ready(function () {
            // Carrousel 3  
            var carousel3 = $('.carousel3');
            var numItems2 = carousel3.find('.carousel').length;

            if (numItems2 > 3) {

                // Initialiser Owl carousel3 si il y a plus de 4 éléments
                carousel3.owlCarousel({
                    items: 3, // Limitez le nombre d'éléments à afficher à 5
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    animateOut: 'slideOutDown',
                    animateIn: 'flipInX',
                    stagePadding: 30,
                    smartSpeed: 650,
                    margin: 20,
                    nav: true,
                    responsive: {
                        0: {
                            items: 1,
                            margin: 0,
                        },
                        550: {
                            items: 1,
                        },
                        690: {
                            items: 2,

                        },
                        890: {
                            items: 3
                        },
                        1200: {
                            items: 3
                        },
                        1400: {
                            items: 3
                        }
                    }
                });

                var carousel3 = $('.carousel3').owlCarousel();
                $('.owl-next').click(function () {
                    carousel3.trigger('next.owl.carousel');
                })
                $('.owl-prev').click(function () {
                    carousel3.trigger('prev.owl.carousel');
                })



            } else {

                carousel3.trigger('destroy.owl.carousel');
                carousel3.removeClass('owl-carousel owl-loaded');
                carousel3.find('.owl-stage-outer').children().unwrap();

            }


        });
    </script>

</body>

</html>