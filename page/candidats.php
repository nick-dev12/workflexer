<?php
session_start();
include '../conn/conn.php';


if (isset($_GET['id'])) {
    // Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session
    $users_id = $_GET['id'];


    $erreurs = '';

    $message = '';



    include_once('../controller/controller_users.php');
    include_once('../controller/controller_description_users.php');
    include_once('../controller/controller_metier_users.php');
    include_once('../controller/controller_competence_users.php');
    include_once('../controller/controller_formation_users.php');
    include_once('../controller/controller_diplome_users.php');
    include_once('../controller/controller_certificat_users.php');
    include_once('../controller/controller_outil_users.php');
    include_once('../controller/controller_langue_users.php');
    include_once('../controller/controller_projet_users.php');
    include_once('../controller/controller_appel_offre.php');
    include_once('../controller/controller_centre_interet.php');
    include_once('../controller/controller_niveau_etude_experience.php');
    include_once('../controller/controller_postulation.php');

}

?>






<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
    <!-- End Google Tag Manager -->

    <title>Profil</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/font-awesome.6.4.0.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>



    <link rel="stylesheet" href="/css/user_profil.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/section2.css">

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <style>
        #none {
            display: none;
        }
    </style>

</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>



    <section class="section2 ste" id="ste">
        <img src="../image/croix.png" alt="" class="img111" id="img24">
        <div class="container">
            <div class="box1">

                <script>
                    let statut = document.querySelector('.statut')
                    let div_statut = document.querySelector('.div_statut')
                    let imag = document.querySelector('.imag')
                    statut.addEventListener('click', () => {
                        div_statut.style.left = '0'
                    })
                    imag.addEventListener('click', () => {
                        div_statut.style.left = '-200%'
                    })

                    // Ajouter un gestionnaire au clic n'importe où sur la page
                    document.addEventListener('click', (e) => {
                        // Vérifier que le clic ne vient pas du bouton
                        if (e.target !== statut) {
                            // Masquer la div
                            div_statut.style.left = '-200%'
                        }
                    });
                </script>


                <img class="affiche" src="/upload/<?= $userss['images'] ?>" alt="">
                <span></span>
                <h2>
                    <?php echo $userss['nom']; ?>
                </h2>
            </div>

            <div class="box2">
                <h3>
                    <?php echo $userss['competences']; ?>
                </h3>
            </div>

            <div class="box3">
                <ul>
                    <a href="../page/candidats.php?id=<?php echo $userss['id']; ?>">
                        <li class="tr pcr"><img src="../image/mpc.png" alt=""> <span class="td">Mon parcour</span></li>
                    </a>

                </ul>

            </div>

        </div>


    </section>



    <section class="section2 menu" id="menu">
        <img class="img23" id="img23" src="../image/menu n.png" alt="">
        <div class="container">
            <div class="box1">

                <img class="affiche" src="/upload/<?= $userss['images'] ?>" alt="">
                <span></span>

            </div>


            <div class="box3">
                <ul>

                    <a href="../page/user_profil.php">
                        <li class="tr pcr"><img src="../image/mpc.png" alt=""> </li>
                    </a>

                </ul>

            </div>
        </div>



    </section>

    <script>
        // Sélectionne l'élément avec la classe 'img' et l'assigne à img222
        let cache = document.getElementById('img23');

        let section = document.querySelector('.section2')
        // Sélectionne l'élément avec la classe 'ste' et l'assigne à section2
        let section2 = document.getElementById('ste');

        // Sélectionne l'élément avec la classe 'menu' et l'assigne à menu
        let menu1 = document.getElementById('menu');

        // Sélectionne l'élément avec la classe 'img111' et l'assigne à img111
        let img111 = document.getElementById('img24');

        // Ajoute un événement de clic à img222
        cache.addEventListener('click', () => {
            // Lorsque img222 est cliqué, déplace section2 à gauche (visible) et cache menu
            section2.style.left = '0';
            menu1.style.left = '-400px';
        });

        // Ajoute un événement de clic à img111
        img111.addEventListener('click', () => {
            // Lorsque img111 est cliqué, cache section2 et montre menu
            section2.style.left = '-100%';
            menu1.style.left = '0';
        });

    </script>


    <section class="section3">


        <?php if (isset($_SESSION['compte_entreprise'])): ?>
            <?php $contGetAllpostulation_users = count($getAllPostulation_users); ?>
            <?php if ($contGetAllpostulation_users > 0): ?>
                <button class="contactes"> <strong> Alerte!</strong> ce candidat a déjà postulé à une de vos offres d'emploi
                </button>
            <?php else: ?>
                <?php if ($getappelOffre): ?>
                    <button class="contactes"> <strong> Alerte!</strong> Ce candidat a déjà été contacté par votre entreprise
                    </button>
                    </div>
                <?php else: ?>
                    <div class="contact">
                        <button class="contacte"><span></span> Contacter ce candidat</button>
                    </div>

                    <form action="" method="post" class="form_appel" enctype="multipart/form-data">
                        <h1>Formulaire d'Appel d'Offres</h1>
                        <img class="fermer" src="../image/croix.png" alt="">
                        <div class="div">
                            <label for="titre">Poste Disponible:</label>
                            <input class="input1" type="text" name="titre" id="titre" required>
                        </div>
                        <div class="div">
                            <label for="message">Description du poste:</label>
                            <textarea name="message" id="summernote" cols="30" rows="10" required></textarea>
                        </div>

                        <input class="input" type="submit" name="sende" value="Envoyer">
                    </form>

                    <script>
                        let contacte = document.querySelector('.contacte');
                        let form_appel = document.querySelector('.form_appel');
                        let fermer = document.querySelector('.fermer')



                        contacte.addEventListener('click', () => {
                            if (form_appel.style.left = '260%') {
                                form_appel.style.left = '60%'
                            } else {
                                form_appel.style.left = '260%'
                            }

                            contacte.style.opacity = '0';
                        })
                        fermer.addEventListener('click', () => {
                            if (form_appel.style.left = '60%') {
                                form_appel.style.left = '260%'
                            } else {
                                form_appel.style.left = '60%'
                            }

                            contacte.style.opacity = '1';
                        })


                        $(document).ready(function () {
                            $('#summernote').summernote({
                                placeholder: 'ajoute une description!!',
                                tabsize: 6,
                                height: 120,
                                toolbar: [
                                    ['style', ['style']],
                                    ['font', ['bold', 'underline', 'clear']],
                                    ['color', ['color']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['table', ['table']],
                                    ['insert', ['link', 'picture', 'video']],
                                    ['view', ['fullscreen', 'codeview', 'help']]
                                ]

                            });
                        });
                    </script>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>



        <div class="container_box1" data-aos="fade-up" data-aos-delay="0" data-aos-duration="500"
            data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
            data-aos-anchor-placement="top-bottom">
            <div class="box1">
                <h2>A propos de moi !</h2>

                <div class="description">
                    <?php
                    // Vérifier si la description de l'utilisateur est vide
                    if (empty($descriptions['description'])):

                        ?>
                    <?php else: ?>
                        <?php echo $descriptions['description']; ?>
                    <?php endif; ?>

                </div>

            </div>
        </div>





        <div class="container_box2" data-aos="fade-up" data-aos-delay="0" data-aos-duration="500"
            data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
            data-aos-anchor-placement="top-bottom">
            <div class="box1">
                <h1>Expertise et compétences</h1>
            </div>
            <div class="box2">
                <h2>Experience professionnel</h2>
                <?php
                foreach ($afficheMetier as $metiers):

                    ?>
                    <div class="metier" data-aos="fade-up" data-aos-delay="0" data-aos-duration="500"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-bottom">
                        <table>
                            <tr>
                                <th>
                                    <p>
                                        <?php echo $metiers['metier']; ?>
                                    </p>
                                </th>

                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td class="date">
                                    <em>
                                        <?php echo $metiers['moisDebut']; ?>/<?php echo $metiers['anneeDebut']; ?>
                                    </em>
                                </td>

                                <td class="date">
                                    <em>
                                        au
                                        <?php echo $metiers['moisFin']; ?>/<?php echo $metiers['anneeFin']; ?>
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


            </div>



            <div class="box3">
                <h2>Compétences</h2>
                <div class="container_comp">


                    <?php
                    foreach ($competencesUtilisateur as $competence):
                        ?>
                        <p class="comp">
                            <?php echo $competence['competence']; ?>
                        </p>
                        <?php
                    endforeach;
                    ?>
                </div>

            </div>


            <div class="box3">
                <h2>Niveau d'expérience et d'étude </h2>
                <div class="container_comp b2">

                    <?php if (empty($getNiveauEtude)): ?>
                        <p class="p">
                            Aucun niveau d'etude ajouter a votre profil
                        </p>
                    <?php else: ?>

                        <p data-aos="fade-up" data-aos-delay="0" data-aos-duration="500" data-aos-easing="ease-in-out"
                            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
                            <strong>Niveau D'etude:</strong> <?php echo $getNiveauEtude['etude'] ?>
                        </p>
                        <p data-aos="fade-up" data-aos-delay="0" data-aos-duration="500" data-aos-easing="ease-in-out"
                            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
                            <strong>Niveau d'expérience :</strong> <?php echo $getNiveauEtude['experience'] ?>
                        </p>

                    <?php endif; ?>

                </div>




            </div>
        </div>



        </div>


        </div>







        <div class="container_box3" data-aos="fade-up" data-aos-delay="0" data-aos-duration="500"
            data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
            data-aos-anchor-placement="top-bottom">

            <div class="box4">
                <h1>formation</h1>
            </div>
            <div class="box5">
                <table>

                    <tr>
                        <th>
                            Dates
                        </th>
                        <th>
                            filières
                        </th>
                        <th>
                            établissements
                        </th>

                        <th class="grade">Niveau</th>
                    </tr>

                </table>

                <?php foreach ($formationUsers as $formations): ?>
                    <table>

                        <tr data-aos="fade-up" data-aos-delay="0" data-aos-duration="500" data-aos-easing="ease-in-out"
                            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
                            <td class="pt">
                                <?php echo $formations['moisDebut']; ?>/<?php echo $formations['anneeDebut']; ?><br>
                                à <br>
                                <?php echo $formations['moisFin']; ?>/<?php echo $formations['anneeFin']; ?>

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

                        </tr>
                    </table>
                <?php endforeach; ?>
            </div>

        </div>


        <div class="container_box4" data-aos="fade-up" data-aos-delay="0" data-aos-duration="500"
            data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
            data-aos-anchor-placement="top-bottom">
            <div class="box1">
                <div class="div">
                    <table>
                        <tr>
                            <th>Diplôme</th>
                        </tr>
                    </table>
                    <div>
                        <?php foreach ($afficheDiplome as $diplomes): ?>

                            <table>
                                <tr>
                                    <td>
                                        <?php echo $diplomes['diplome']; ?>
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
                                    </td>
                                </tr>
                            </table>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>


        <div class="container_box7" data-aos="fade-up" data-aos-delay="0" data-aos-duration="500"
            data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
            data-aos-anchor-placement="top-bottom">

            <div class="box1">
                <h1>Projets et réalisations</h1>


            </div>

            <div class="box2">

                <?php foreach ($affichePojetUsers as $projets): ?>

                    <div class="info_projet">
                        <h2>
                            <?php echo $projets['titre'] ?>
                        </h2>
                        <p>
                            <?php echo $projets['projetdescription'] ?>
                        </p>

                        <a href="<?php echo $projets['liens'] ?>">Click sur ce lien</a>

                        <img src="../upload/<?php echo $projets['images'] ?>" alt="">
                    </div>

                <?php endforeach; ?>


            </div>
        </div>




        <div class="container_box5" data-aos="fade-up" data-aos-delay="0" data-aos-duration="500"
            data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
            data-aos-anchor-placement="top-bottom">
            <div class="box1">
                <h1>maîtrise des outils informatiques</h1>
            </div>

            <div class="box2">

                <table>
                    <?php foreach ($afficheOutil as $outils): ?>
                        <tr>
                            <td>
                                <?php echo $outils['outil'] ?>
                            </td>
                            <td class="niveau">
                                <?php echo $outils['niveau'] ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>


            </div>


        </div>








        <div class="container_box5" data-aos="fade-up" data-aos-delay="0" data-aos-duration="500"
            data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
            data-aos-anchor-placement="top-bottom">
            <div class="box1">
                <h1>maîtrise des langues</h1>
            </div>

            <div class="box2">
                <table>
                    <?php foreach ($afficheLangues as $langues): ?>
                        <tr>
                            <td>
                                <?php echo $langues['langue']; ?>
                            </td>
                            <td class="niveau">
                                <?php echo $langues['niveau']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>

            </div>


        </div>




        <div class="container_box8">
            <div class="box1">
                <h1>Centre d’intérêt</h1>
            </div>

            <div class="box2">


                <ul>
                    <?php foreach ($afficheCentreInteret as $centreInteret): ?>
                        <li>
                            <?= $centreInteret['interet'] ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

            </div>



        </div>




    </section>


    <script>
        // ..
        AOS.init();

        // You can also pass an optional settings object
        // below listed default settings
        AOS.init({
            // Global settings:
            disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
            startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
            initClassName: 'aos-init', // class applied after initialization
            animatedClassName: 'aos-animate', // class applied on animation
            useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
            disableMutationObserver: false, // disables automatic mutations' detections (advanced)
            debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
            throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)


            // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
            offset: 120, // offset (in px) from the original trigger point
            delay: 0, // values from 0 to 3000, with step 50ms
            duration: 400, // values from 0 to 3000, with step 50ms
            easing: 'ease', // default easing for AOS animations
            once: false, // whether animation should happen only once - while scrolling down
            mirror: false, // whether elements should animate out while scrolling past them
            anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation

        });
    </script>

    <script>




        $(document).ready(function () {
            $('#description').summernote({
                placeholder: 'ajoute une description!!',
                tabsize: 6,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        $(document).ready(function () {
            $('#projetdescription').summernote({
                placeholder: 'ajoute une description!!',
                tabsize: 6,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>

</body>

</html>