<?php
session_start();

include_once('../entreprise/app/controller/controllerOffre_emploi.php');
include_once('../entreprise/app/controller/controllerEntreprise.php');

if (isset($_POST['recherche'])) {

    // Récupération des données du formulaire
    $recherche = $_POST['search'];
    $categorie = $_POST['categorie'];
    $experience = $_POST['experience'];
    $etude = $_POST['etude'];

    // Requête SQL pour rechercher dans la base de données en fonction des critères
    $sql = "SELECT u.* FROM offre_emploi u LEFT JOIN compte_entreprise e ON u.entreprise_id = e.id WHERE 1=1";
    if (!empty($recherche)) {
        $sql .= " AND (u.poste LIKE :recherche OR e.entreprise LIKE :recherche)";
    } else {
        $erreurs = ' Ce champ ne doit pas etre vide !';
    }
    if (!empty($categorie)) {
        $sql .= " AND u.categorie = :categorie";
    }
    if (!empty($experience)) {
        $sql .= " AND u.experience = :experience";
    }
    if (!empty($etude)) {
        $sql .= " AND u.etudes = :etude";
    }

    $stmt = $db->prepare($sql);
    if (!empty($recherche)) {
        $stmt->bindValue(':recherche', "%$recherche%", PDO::PARAM_STR);
    }
    if (!empty($categorie)) {
        $stmt->bindValue(':categorie', $categorie, PDO::PARAM_STR);
    }
    if (!empty($experience)) {
        $stmt->bindValue(':experience', $experience, PDO::PARAM_STR);
    }
    if (!empty($etude)) {
        $stmt->bindValue(':etude', $etude, PDO::PARAM_STR);
    }
    $stmt->execute();

    $resulte = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Stocker les résultats de la recherche dans une session
    $_SESSION['resultats'] = $resulte;

    header('Location: search_offre.php');

    exit();

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

    <title>Offres D'emploi</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/aos.css" />
    <script src="../js/aos.js"></script>
    <link rel="stylesheet" href="../css/offre_d'emploit.css">
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/emploi.css">

</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>

    <section class="section2">
        <div class="slider">
            <div class="box">
                <div class="img owl-carousel boot">
                    <img src="/image/offre1.jpg" alt="">
                    <img src="/image/offre-emploi-quebec.jpg" alt="">
                    <img src="/image/offre3.jpg" alt="">
                    <img src="/image/offre4.jpeg" alt="">
                </div>
                <div class="text">
                    <h1>Explorez les offres d'emploi répondant à vos critères</h1>
                    <p>Un large éventail d'offres d'emploi, toutes catégories confondues, pour satisfaire le moindre de
                        vos besoins.</p>


                    <form action="" method="post">
                        <div class="search">
                            <input type="search" name="search" id="search">
                            <label for="recherche"><i class="fa-solid fa-magnifying-glass fa-xs"></i></label>
                            <input type="submit" name="recherche" value="recherche" id="recherche">
                        </div>

                        <div class="filtre">
                            <select id="categorie" name="categorie">
                                <option value="">Sélectionnez une catégorie</option>
                                <option value="Informatique et tech">Informatique et tech</option>
                                <option value="Design et création">Design et création</option>
                                <option value="Rédaction et traduction">Rédaction et traduction</option>
                                <option value="Marketing et communication">Marketing et communication</option>
                                <option value="Conseil et gestion d'entreprise">Conseil et gestion d'entreprise</option>
                                <option value="Juridique">Juridique</option>
                                <option value="Ingénierie et architecture">Ingénierie et architecture</option>
                                <option value="Finance et comptabilité">Finance et comptabilité</option>
                                <option value="Santé et bien-être">Santé et bien-être</option>
                                <option value="Éducation et formation">Éducation et formation</option>
                                <option value="Tourisme et hôtellerie">Tourisme et hôtellerie</option>
                                <option value="Commerce et vente">Commerce et vente</option>
                                <option value="Transport et logistique">Transport et logistique</option>
                                <option value="Agriculture et agroalimentaire">Agriculture et agroalimentaire</option>
                                <option value="Autre">Autre</option>
                            </select>

                            <select name="experience" id="experience">
                                <option value="">-- Niveau d'expérience --</option>
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


                            <select name="etude" id="etude">
                                <option value="">-- Niveau d'étude --</option>
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
                    </form>
                </div>
            </div>

        </div>

    </section>



    <section class="emploi">
        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
            <img src="/image/ingénieur.png" alt="">
            <p> Trouvez parmi
                nos offres le métier qui vous correspond :
                <strong>ingénieur,
                    architecte, technicien, commercial, etc.</strong> Participez à des projets concrets et durables.
            </p>

            <a href="../offres/Ingénierie et architecture.php">Ingénierie et architecture</a>
        </div>



        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
            <img src="/image/webdesign.jpg" alt="">
            <p>
                Trouvez parmi nos offres le métier qui vous correspond <strong>: designer produit,
                    graphiste, directeur artistique, etc.</strong> Participez à des projets créatifs et stimulants.
            </p>
            <a href="../offres/Design et création.php">Design et création</a>
        </div>



        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
            <img src="/image/Redaction.jpg" alt="">
            <p>
                Trouvez parmi nos offres le métier qui vous correspond <strong>: rédacteur, traducteur, correcteur,
                    etc.</strong> Participez à des projets variés allant de la rédaction d'articles à la traduction de
                documents.
            </p>
            <a href="../offres/Rédaction et traduction.php">Rédaction et traduction</a>
        </div>


        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
            <img src="/image/marketing.jpg" alt="">
            <p>
                Trouvez votre voie parmi nos offres de métiers tels que <strong>chef de produit, chargé de
                    communication, community manager, etc</strong> . Participez à des projets variés.
            </p>

            <a href="../offres/Marketing et communication.php">Marketing et communication</a>
        </div>


        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
            <img src="/image/gestion.png" alt="">
            <p>
                Trouvez votre voie parmi nos offres de métiers tels que <strong>consultant, gestionnaire de projet,
                    analyste
                    financier, etc.</strong> Participez à des projets variés.
            </p>

            <a href="../offres/Conseil et gestion d'entreprise.php">Conseil et gestion d'entreprise</a>
        </div>




        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
            <img src="/image/juridique.jpg" alt="">
            <p>
                Trouvez votre voie parmi nos offres de métiers tels <strong>qu'avocat, juriste, notaire, etc.</strong>
                Participez à des projets variés.
            </p>

            <a href="../offres/Juridique.php">Juridique</a>
        </div>


        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
            <img src="/image/info.jpg" alt="">
            <p>
                Trouvez parmi nos offres le métier qui vous correspond : <strong>développeur, ingénieur réseau, data
                    scientist, etc.</strong> Participez à des projets variés.
            </p>

            <a href="../offres/Informatique et tech.php">Informatique et tech</a>
        </div>



        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
            <img src="/image/finance.png" alt="">
            <p>
                Trouvez parmi nos offres le métier qui vous correspond : <strong> expert-comptable, contrôleur de
                    gestion,
                    analyste financier, etc.</strong> Participez à des projets variés.
            </p>

            <a href="../offres/Finance et comptabilité.php">Finance et comptabilité</a>
        </div>




        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
            <img src="/image/santé.png" alt="">
            <p>
                Trouvez parmi nos offres le métier qui vous correspond : <strong>médecin, infirmier, kinésithérapeute,
                    nutritionniste, etc.</strong> Participez à des projets variés.
            </p>

            <a href="../offres/Santé et bien-être.php">Santé et bien-être</a>
        </div>



        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
            <img src="/image/education.png" alt="">
            <p>
                Trouvez parmi nos offres le métier qui vous correspond :<strong> enseignant, formateur, conseiller en
                    orientation, etc.</strong> Participez à des projets variés.
            </p>

            <a href="../offres/Éducation et formation.php">Éducation et formation</a>
        </div>




        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
            <img src="/image/tourisme.png" alt="">
            <p>
                Trouvez parmi nos offres le métier qui vous correspond : <strong>réceptionniste, guide touristique, chef
                    cuisinier, etc.</strong> Participez à des projets variés
            </p>

            <a href="../offres/Tourisme et hôtellerie.php">Tourisme et hôtellerie</a>
        </div>




        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
            <img src="/image/vente.png" alt="">
            <p>
                Trouvez parmi nos offres le métier qui vous correspond : <strong>commercial, responsable de magasin,
                    vendeur, etc.</strong> Participez à des projets variés
            </p>

            <a href="../offres/Commerce et vente.php">Commerce et vente</a>
        </div>



        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
            <img src="/image/transport.png" alt="">
            <p>
                Trouvez parmi nos offres le métier qui vous correspond :<strong> logisticien, chauffeur-livreur,
                    responsable d'entrepôt, etc.</strong> Participez à des projets variés.
            </p>

            <a href="../offres/Transport et logistique.php">Transport et logistique</a>
        </div>



        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
            <img src="/image/agriculture.png" alt="">
            <p>
                Trouvez parmi nos offres le métier qui vous correspond :<strong> agriculteur, ingénieur agronome,
                    technicien de laboratoire, etc.</strong> Participez à des projets variés.
            </p>

            <a href="../offres/Agriculture et agroalimentaire.php">Agriculture et agroalimentaire</a>
        </div>




        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
            <img src="/image/autre.png" alt="">
            <p>
                Trouvez parmi nos offres le métier qui vous correspond, qu'il s'agisse de métiers émergents ou de
                professions plus traditionnelles. Participez à des projets variés.
            </p>

            <a href="../offres/Autre.php">Autre</a>
        </div>
    </section>



    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/owl.carousel.js"></script>
    <script src="../js/owl.animate.js"></script>
    <script src="../js/owl.autoplay.js"></script>
    <script src="../js/silder_offres.js"></script>


    <script>
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

</body>

</html>