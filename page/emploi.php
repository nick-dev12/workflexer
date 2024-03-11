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
        $sql .= " AND u.etude = :etude";
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
<html lang="en">

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/offre_d'emploit.css">
    <link rel="stylesheet" href="../css/emploi.css">
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/navbare.css">
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
                    <h1>Explorer les offres d'emploi répondant à vos critère</h1>
                    <p>Un large éventail d'offres d'emplois toute catégorie confondu pour satisfaire le moindres
                        de vos besoins </p>

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
        <div class="box">
            <img src="/image/ingenieur.jpeg" alt="">
            <h1>Ingénierie et architecture</h1>
            <p>
                Vous cherchez des professionnels qualifiés en ingénierie et architecture pour mener à bien vos projets
                de construction ?
            </p>
            <p>
                Découvrez notre sélection de profils expérimentés et compétents pour répondre à vos besoins.
            </p>
            <a href="../offres/Ingénierie et architecture.php">Explorer les offres</a>
        </div>



        <div class="box">
            <img src="/image/webdesign.jpg" alt="">
            <h1>Design et création</h1>
            <p>
                Vous avez besoin de professionnels créatifs pour donner vie à vos projets de design ?
            </p>
            <p>
                Découvrez notre sélection de profils talentueux et innovants pour répondre à vos attentes.
            </p>
            <a href="../offres/Design et création.php">Explorer les offres</a>
        </div>



        <div class="box">
            <img src="/image/Redaction.jpg" alt="">
            <h1>Rédaction et traduction</h1>
            <p>
                Vous cherchez des rédacteurs et traducteurs qualifiés pour vos projets de communication ?
            </p>
            <p>
                Découvrez notre sélection de profils expérimentés et polyvalents pour répondre à vos besoins
                linguistiques.
            </p>
            <a href="../offres/Rédaction et traduction.php">Explorer les offres</a>
        </div>


        <div class="box">
            <img src="/image/marketing.jpg" alt="">
            <h1>Marketing et communication</h1>
            <p>
                Vous cherchez des professionnels du marketing et de la communication pour promouvoir votre entreprise et
                votre marque ?
            </p>
            <p>
                Découvrez notre sélection de profils créatifs et stratégiques pour répondre à vos besoins de
                communication.
            </p>

            <a href="../offres/Marketing et communication.php">Explorer les offres</a>
        </div>


        <div class="box">
            <img src="/image/gestion.jpg" alt="">
            <h1>Conseil et gestion d'entreprise</h1>
            <p>
                Vous cherchez des professionnels du conseil et de la gestion d'entreprise pour optimiser vos
                performances et votre rentabilité ?
            </p>
            <p>
                Découvrez notre sélection de profils expérimentés et compétents pour répondre à vos besoins de gestion.
            </p>

            <a href="../offres/Conseil et gestion d'entreprise.php">Explorer les offres</a>
        </div>




        <div class="box">
            <img src="/image/juridique.jpg" alt="">
            <h1>Juridique</h1>
            <p>
                Vous cherchez des professionnels du droit pour vous conseiller et vous accompagner dans vos démarches
                juridiques ?
            </p>
            <p>
                Découvrez notre sélection de profils expérimentés et compétents pour répondre à vos besoins juridiques.
            </p>

            <a href="../offres/Juridique.php">Explorer les offres</a>
        </div>


        <div class="box">
            <img src="/image/info.jpg" alt="">
            <h1>Informatique et tech</h1>
            <p>
                Vous cherchez des professionnels de l'informatique et de la tech pour développer vos projets numériques
                ?
            </p>
            <p>
                Découvrez notre sélection de profils expérimentés et compétents pour répondre à vos besoins
                technologiques.
            </p>

            <a href="../offres/Informatique et tech.php">Explorer les offres</a>
        </div>



        <div class="box">
            <img src="/image/finance.png" alt="">
            <h1>Finance et comptabilité</h1>
            <p>
                Vous cherchez des professionnels de la finance et de la comptabilité pour gérer vos finances et votre
                comptabilité ?
            </p>
            <p>
                Découvrez notre sélection de profils expérimentés et compétents pour répondre à vos besoins financiers.
            </p>

            <a href="../offres/Finance et comptabilité.php">Explorer les offres</a>
        </div>




        <div class="box">
            <img src="/image/santé.png" alt="">
            <h1>Santé et bien-être</h1>
            <p>
                Vous cherchez des professionnels de la santé et du bien-être pour prendre soin de vos employés et de vos
                clients ?
            </p>
            <p>
                Découvrez notre sélection de profils expérimentés et compétents pour répondre à vos besoins de santé et
                de bien-être.
            </p>

            <a href="../offres/Santé et bien-être.php">Explorer les offres</a>
        </div>



        <div class="box">
            <img src="/image/education.png" alt="">
            <h1>Éducation et formation</h1>
            <p>
                Vous cherchez des professionnels de l'éducation et de la formation pour former et développer les
                compétences de vos employés ?
            </p>
            <p>
                Découvrez notre sélection de profils expérimentés et compétents pour répondre à vos besoins de
                formation.
            </p>

            <a href="../offres/Éducation et formation.php">Explorer les offres</a>
        </div>




        <div class="box">
            <img src="/image/tourisme.png" alt="">
            <h1>Tourisme et hôtellerie</h1>
            <p>
                Vous cherchez des professionnels du tourisme et de l'hôtellerie pour offrir des expériences inoubliables
                à vos clients ?
            </p>
            <p>
                Découvrez notre sélection de profils expérimentés et compétents pour répondre à vos besoins en matière
                d'hospitalité.
            </p>

            <a href="../offres/Tourisme et hôtellerie.php">Explorer les offres</a>
        </div>




        <div class="box">
            <img src="/image/vente.png" alt="">
            <h1>Commerce et vente</h1>
            <p>
                Vous cherchez des professionnels du commerce et de la vente pour développer vos ventes et votre chiffre
                d'affaires ?
            </p>
            <p>
                Découvrez notre sélection de profils expérimentés et compétents pour répondre à vos besoins commerciaux.
            </p>

            <a href="../offres/Commerce et vente.php">Explorer les offres</a>
        </div>



        <div class="box">
            <img src="/image/transport.png" alt="">
            <h1>Transport et logistique</h1>
            <p>
                ous cherchez des professionnels du transport et de la logistique pour optimiser vos chaînes
                d'approvisionnement et vos livraisons ?
            </p>
            <p>
                Découvrez notre sélection de profils expérimentés et compétents pour répondre à vos besoins logistiques.
            </p>

            <a href="../offres/Transport et logistique.php">Explorer les offres</a>
        </div>



        <div class="box">
            <img src="/image/agriculture.png" alt="">
            <h1>Agriculture et agroalimentaire</h1>
            <p>
                ous cherchez des professionnels de l'agriculture et de l'agroalimentaire pour améliorer votre production
                et votre qualité ?
            </p>
            <p>
                Découvrez notre sélection de profils expérimentés et compétents pour répondre à vos besoins agricoles et
                agroalimentaires.
            </p>

            <a href="../offres/Agriculture et agroalimentaire.php">Explorer les offres</a>
        </div>




        <div class="box">
            <img src="/image/autre.png" alt="">
            <h1>Autre</h1>
            <p>
                Vous cherchez des profils professionnels pour répondre à des besoins spécifiques ?
            </p>
            <p>
                Découvrez notre sélection de profils variés et polyvalents pour répondre à vos besoins particuliers.
            </p>

            <a href="../offres/Autre.php">Explorer les offres</a>
        </div>
    </section>




    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/owl.carousel.js"></script>
    <script src="../js/owl.animate.js"></script>
    <script src="../js/owl.autoplay.js"></script>
    <script src="../js/silder_offres.js"></script>



</body>

</html>