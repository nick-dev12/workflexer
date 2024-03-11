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
    <link rel="icon" href="../image/logo.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/aos.css" />
    <script src="../js/aos.js"></script>
    <link rel="stylesheet" href="../css/voir_profil.css">
    <link rel="stylesheet" href="/css/owl.theme.default.css">
    <link rel="stylesheet" href="/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/css/animate.min.css">
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
                        data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">Exploré les
                        profils qui conviennent à vos besoins</h1>
                    <p data-aos="fade-left" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
                        data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
                        Un large éventail de profiles professionnels toute catégorie confondu pour satisfaire le
                        moindres de vos besoins en main d'œuvre et bien plus encore
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

    <section class="produit_vedete">
        <div class="box1">
            <span></span>
            <h1>Rédaction et traduction</h1>
            <span></span>
            <div class="affiche">
                <img src="/image/Redaction.jpg" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel3">
            <?php if (empty($UsersRédaction)): ?>

                <h1 class="message">Aucun profil disponible pour cette catégorie</h1>

            <?php else: ?>

                <?php foreach ($UsersRédaction as $Redaction): ?>
                    <?php
                    $nombreCompetences = countCompetences($db, $Redaction['id']);
                    $niveauEtude = gettNiveau($db, $Redaction['id']);
                    ?>
                    <?php if ($nombreCompetences < 4): ?>
                    <?php else: ?>
                        <?php if ($Redaction['statut'] == 'Occuper'): ?>

                        <?php else: ?>
                            <div class="carousel">

                                <?php if ($Redaction['statut'] == 'Disponible'): ?>
                                    <p class="statut"><span></span>
                                        <?= $Redaction['statut'] ?>
                                    </p>
                                <?php else: ?>
                                    <?php if ($Redaction['statut'] == 'Occuper'): ?>
                                        <p class="statut2"><span></span>
                                            <?= $Redaction['statut'] ?>
                                        </p>

                                    <?php endif; ?>
                                <?php endif; ?>

                                <img src="../upload/<?php echo $Redaction['images'] ?>" alt="">

                                <div class="info-box">
                                    <h4>
                                        <?php echo $Redaction['competences']; ?>
                                    </h4>

                                    <div class="vendu">
                                        <?php $afficheCompetences = getCompetences($db, $Redaction['id']) ?>
                                        <?php if (empty($afficheCompetences)): ?>
                                            <span>Competences indisponibles</span>
                                        <?php else: ?>
                                            <?php
                                            $competencesAffichees = 0; // Initialiser le compteur de compétences affichées
                                            foreach ($afficheCompetences as $compe):
                                                if ($competencesAffichees < 4):
                                                    ?>
                                                    <span>
                                                        <?= $compe['competence'] ?>
                                                    </span>
                                                    <?php
                                                    $competencesAffichees++;
                                                endif;
                                            endforeach;
                                            ?>
                                        <?php endif; ?>

                                    </div>

                                    <p class="nom">
                                        <?php
                                        $fullName = $Redaction['nom'];
                                        // Utilisez la fonction explode pour diviser le nom en mots
                                        $words = explode(' ', $fullName);
                                        // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                        $nameUsers = $words[0] . ' ' . $words[1];
                                        ?>
                                        <?php echo $nameUsers ?>
                                    </p>

                                    <p class="ville">
                                        <?php echo $Redaction['ville']; ?>
                                    </p>

                                    <div class="divpp"></div>
                                    <p class="pp"><strong>Niveau :</strong>
                                        <?php if (empty($niveauEtude['etude'])): ?>
                                            indisponibles
                                        <?php else: ?>
                                            <?php echo $niveauEtude['etude'] ?>
                                        <?php endif; ?>
                                    </p>
                                    <p class="pp"><strong>Experience :</strong>
                                        <?php if (empty($niveauEtude['etude'])): ?>
                                            indisponibles
                                        <?php else: ?>
                                            <?php echo $niveauEtude['experience'] ?>
                                        <?php endif; ?>
                                    </p>
                                </div>

                                <a href="/page/candidats.php?id=<?php echo $Redaction['id']; ?>">
                                    <i class="fa-solid fa-eye"></i>Profil
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach ?>



            <?php endif; ?>
        </article>
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