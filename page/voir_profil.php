<?php
// Démarre la session
session_start();
// Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session



include_once('../controller/controller_users.php');
include_once('../controller/controller_competence_users.php');
include_once('../controller/controller_niveau_etude_experience.php');


if (isset($_POST['recherche'])) {

    // Récupération des données du formulaire
    $recherche = $_POST['search'];
    $categorie = $_POST['categorie'];
    $experience = $_POST['experience'];
    $etude = $_POST['etude'];

    // Requête SQL pour rechercher dans la base de données en fonction des critères
    $sql = "SELECT u.* FROM users u LEFT JOIN niveau_etude e ON u.id = e.users_id WHERE 1=1";
    if (!empty($recherche)) {
        $sql .= " AND (u.competences LIKE :recherche OR u.nom LIKE :recherche)";
    } else {
        $erreurs = ' Ce champ ne doit pas etre vide !';
    }
    if (!empty($categorie)) {
        $sql .= " AND u.categorie = :categorie";
    }
    if (!empty($experience)) {
        $sql .= " AND e.experience = :experience";
    }
    if (!empty($etude)) {
        $sql .= " AND e.etude = :etude";
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
    $_SESSION['resultats_recherche'] = $resulte;

    header('Location: search.php');

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
    <title>Explorer les profils</title>
    <link rel="icon" href="../image/logo.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="../css/aos.css" />
        <script src="../js/aos.js"></script>
    <link rel="stylesheet" href="../css/voir_profil.css">
    <link rel="stylesheet" href="../css/profil.css">
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
                    <img src="/image/recherche.png" alt="">
                    <img src="/image/profile1.jpg" alt="">
                    <img src="/image/profile2.jpg" alt="">
                </div>
                <div class="text">
                <h1 data-aos="fade-right" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
    data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">Explorez les
    profils qui conviennent à vos besoins</h1>
<p data-aos="fade-left" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
    data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
    Un large éventail de profils professionnels, toutes catégories confondues, pour satisfaire le
    moindre de vos besoins en main-d'œuvre et bien plus encore.
</p>

                    <form data-aos="fade-left" data-aos-delay="500" data-aos-duration="400"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-right" action="" method="post">
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
        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-right">
            <img src="/image/ingenieur.jpeg" alt="">
            <p>
                Vous cherchez des professionnels qualifiés en ingénierie et architecture pour mener à bien vos projets
                de construction ?
            </p>
            <a href="../profils/Ingénierie et architecture.php">Ingénierie et architecture</a>
        </div>



        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-right">
            <img src="/image/webdesign.jpg" alt="">
            <p>
                Vous avez besoin de professionnels créatifs pour donner vie à vos projets de design ?
            </p>
            <a href="../profils/Design et création.php">Design et création</a>
        </div>



        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-right">
            <img src="/image/Redaction.jpg" alt="">
            <p>
                Vous cherchez des rédacteurs et traducteurs qualifiés pour vos projets de communication ?
            </p>
            <a href="../profils/Rédaction et traduction.php">Rédaction et traduction</a>
        </div>


        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-right">
            <img src="/image/marketing.jpg" alt="">
            <p>
                Vous cherchez des professionnels du marketing et de la communication pour promouvoir votre entreprise et
                votre marque ?
            </p>

            <a href="../profils/Marketing et communication.php">Marketing et communication</a>
        </div>


        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-right">
            <img src="/image/gestion.png" alt="">
            <p>
                Vous cherchez des professionnels du conseil et de la gestion d'entreprise pour optimiser vos
                performances et votre rentabilité ?
            </p>

            <a href="../profils/Conseil et gestion d'entreprise.php">Conseil et gestion d'entreprise</a>
        </div>




        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-right">
            <img src="/image/juridique.jpg" alt="">
            <p>
                Vous cherchez des professionnels du droit pour vous conseiller et vous accompagner dans vos démarches
                juridiques ?
            </p>

            <a href="../profils/Juridique.php">Juridique</a>
        </div>


        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-right">
            <img src="/image/info.jpg" alt="">
            <p>
                Vous cherchez des professionnels de l'informatique et de la tech pour développer vos projets numériques
                ?
            </p>
            <a href="../profils/Informatique et tech.php">Informatique et tech</a>
        </div>



        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-right">
            <img src="/image/finance.png" alt="">
            <p>
                Vous cherchez des professionnels de la finance et de la comptabilité pour gérer vos finances et votre
                comptabilité ?
            </p>

            <a href="../profils/Finance et comptabilité.php">Finance et comptabilité</a>
        </div>




        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-right">
            <img src="/image/santé.png" alt="">
            <p>
                Vous cherchez des professionnels de la santé et du bien-être pour prendre soin de vos employés et de vos
                clients ?
            </p>

            <a href="../profils/Santé et bien-être.php">Santé et bien-être</a>
        </div>



        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-right">
            <img src="/image/education.png" alt="">
            <p>
                Vous cherchez des professionnels de l'éducation et de la formation pour former et développer les
                compétences de vos employés ?
            </p>

            <a href="../profils/Éducation et formation.php">Éducation et formation</a>
        </div>




        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-right">
            <img src="/image/tourisme.png" alt="">
            <p>
                Vous cherchez des professionnels du tourisme et de l'hôtellerie pour offrir des expériences inoubliables
                à vos clients ?
            </p>

            <a href="../profils/Tourisme et hôtellerie.php">Tourisme et hôtellerie</a>
        </div>




        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-right">
            <img src="/image/vente.png" alt="">
            <p>
                Vous cherchez des professionnels du commerce et de la vente pour développer vos ventes et votre chiffre
                d'affaires ?
            </p>

            <a href="../profils/Commerce et vente.php">Commerce et vente</a>
        </div>



        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-right">
            <img src="/image/transport.png" alt="">
            <p>
                ous cherchez des professionnels du transport et de la logistique pour optimiser vos chaînes
                d'approvisionnement et vos livraisons ?
            </p>

            <a href="../profils/Transport et logistique.php">Transport et logistique</a>
        </div>



        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-right">
            <img src="/image/agriculture.png" alt="">
            <p>
                ous cherchez des professionnels de l'agriculture et de l'agroalimentaire pour améliorer votre production
                et votre qualité ?
            </p>

            <a href="../profils/Agriculture et agroalimentaire.php">Agriculture et agroalimentaire</a>
        </div>




        <div class="box" data-aos="fade-left" data-aos-delay="500" data-aos-duration="400"
                        data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false"
                        data-aos-anchor-placement="top-right">
            <img src="/image/autre.png" alt="">
            <h1>Autre</h1>
            <p>
                Vous cherchez des profils professionnels pour répondre à des besoins spécifiques ?
            </p>

            <a href="../profils/Autre.php">Autre</a>
        </div>
    </section>




    <?php include('../footer.php') ?>






    <script src="/js/owl.carousel.min.js"></script>
    <script src="/js/owl.carousel.js"></script>
    <script src="/js/owl.animate.js"></script>
    <script src="/js/owl.autoplay.js"></script>
    <script src="/js/silder_offres.js"></script>

    <script>
        // ..
        AOS.init();
    </script>



    <script>

        $(document).ready(function () {


            $('.boot').owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 6000,
                animateOut: 'slideOutDown',
                animateIn: 'flipInX',
                stagePadding: 1,
                smartSpeed: 450,
                margin: 0,
                nav: true,
                navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
            });
            var carousel2 = $('.carousel2').owlCarousel();
            $('.owl-next2').click(function () {
                carousel2.trigger('next.owl.carousel');
            })
            $('.owl-prev2').click(function () {
                carousel2.trigger('prev.owl.carousel');
            })

        });


        $('.container_slider').owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            animateOut: 'slideOutDown',
            animateIn: 'flipInX',
            stagePadding: 1,
            smartSpeed: 1000,
            margin: 0,
            nav: true,
            navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
        });
    </script>

</body>

</html>