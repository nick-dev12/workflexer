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

    header('Location: ../page/search_offre.php');

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

    <title>Informatique et tech</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/offre_d'emploit.css">
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



    <section class="produit_vedete">
        <div class="box1">
            <span></span>
            <h1>Informatique et tech </h1>
            <span></span>
            <div class="affiche">
                <img src="/image/info.jpg" alt="">
            </div>
        </div>
       

        <article class="articles owl-carousel carousel8">

            <?php foreach ($afficheAllOffre as $Information): ?>
            <?php if($Information['statut'] === 'publiee' or $Information['statut'] === ''): ?>
                <?php $infoEntreprise = getEntreprise($db, $Information['entreprise_id']) ?>

                <?php if ($Information['categorie'] === 'Informatique et tech'): ?>


                    <div class="carousel">
                        <img src="../upload/<?php echo $infoEntreprise['images'] ?>" alt="">
                        <div class="info-box">

                            <p class="p">
                                <strong>
                                    <?php echo $infoEntreprise['entreprise']; ?>
                                </strong>
                            </p>
                            <p class="poste" >
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($Information['poste']); ?>
                                    </p>
                            <div class="box_vendu">
                                <div class="vendu">
                                    <p>
                                        <strong>Contrat :</strong>
                                        <?php echo ($Information['contrat']); ?>
                                    </p>
                                    <p>
                                        <strong>Niveau :</strong>
                                        <?php echo ($Information['etudes']); ?>
                                    </p>
                                    <p>
                                        <strong>Experience :</strong>
                                        <?php echo ($Information['experience']); ?>
                                    </p>

                                    <p class="ville">
                                        <strong>Ville :</strong>
                                        <?php echo ($Information['localite']); ?>
                                    </p>
                                </div>

                            </div>
                           

                            <p id="nom">
                                <?php echo $Information['date']; ?>
                            </p>

                            <a
                                href="../entreprise/voir_offre.php?offres_id=<?= $Information['offre_id']; ?>&entreprise_id=<?= $Information['entreprise_id']; ?>">
                                <i class="fa-solid fa-eye"></i>Voir l'offre
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                <?php endif; ?>
                <?php endif; ?>
            <?php endforeach ?>
        </article>
    </section>






    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/owl.carousel.js"></script>
    <script src="../js/owl.animate.js"></script>
    <script src="../js/owl.autoplay.js"></script>
    <script src="../js/silder_offres.js"></script>



</body>

</html>