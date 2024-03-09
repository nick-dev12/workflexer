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

    <title>bienvenu</title>
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
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>

    <section class="section2" data-aos="zoom-in">
        <div class="slider">
            <div class="box">
                <div class="img owl-carousel boot">
                    <img src="/image/offre1.jpg" alt="">
                    <img src="/image/offre-emploi-quebec.jpg" alt="">
                    <img src="/image/offre3.jpg" alt="">
                    <img src="/image/offre4.jpeg" alt="">
                </div>
                <div class="text">
                    <h1>Exploré les profils qui conviennent à vos besoins</h1>
                    <p>Un large éventail de profiles professionnels toute catégorie confondu pour satisfaire le moindres
                        de vos besoins en main d'œuvre et bien plus encore </p>

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
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">

            <h1>Ingénierie et architecture</h1>
            <div class="affiche">
                <img src="/image/ingenieur.jpeg" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel1">
            <?php if (empty($offreIngenierie)): ?>

                <h1 class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</h1>

            <?php else: ?>
                <?php foreach ($offreIngenierie as $ingenieurs): ?>
                    <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                        data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                        <img src="../upload/<?php echo $ingenieurs['images'] ?>" alt="">
                        <div class="info-box">
                            <p class="p">
                                <strong>
                                    <?php echo $ingenieurs['entreprise']; ?>
                                </strong>

                            </p>

                            <div class="box_vendu">
                                <div class="vendu">

                                    <p>
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($ingenieurs['poste']); ?>
                                    </p>
                                    <p>
                                        <strong>Contrat :</strong>
                                        <?php echo ($ingenieurs['contrat']); ?>
                                    </p>
                                    <p>
                                        <strong>Niveau :</strong>
                                        <?php echo ($ingenieurs['etudes']); ?>
                                    </p>
                                    <p>
                                        <strong>Experience :</strong>
                                        <?php echo ($ingenieurs['experience']); ?>
                                    </p>

                                </div>

                            </div>

                            <div class="box_vendu">
                                <div class="vendu">

                                    <p class="ville">
                                        <strong>Ville :</strong>
                                        <?php echo ($ingenieurs['ville']); ?>
                                    </p>
                                </div>

                            </div>

                            <p id="nom">
                                <?php echo $ingenieurs['date']; ?>
                            </p>
                            <a
                                href="../entreprise/voir_offre.php?offres_id=<?= $ingenieurs['offre_id']; ?>&entreprise_id=<?= $ingenieurs['entreprise_id']; ?>">
                                <i class="fa-solid fa-eye"></i>Voir l'offre
                            </a>
                        </div>
                    </div>


                <?php endforeach ?>
            <?php endif; ?>
        </article>

    </section>




    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1> Design et création</h1>
            <span></span>
            <div class="affiche">
                <!-- <img src="/image/info.jpg" alt=""> -->
                <img src="/image/webdesign.jpg" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel2">
            <?php if (empty($offreDesing)): ?>

                <h1 class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</h1>

            <?php else: ?>

                <?php foreach ($offreDesing as $Designs): ?>

                    <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                        data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                        <img src="../upload/<?php echo $Designs['images'] ?>" alt="">
                        <div class="info-box">
                            <p class="p">
                                <strong>
                                    <?php echo $Designs['entreprise']; ?>
                                </strong>
                            </p>

                            <div class="box_vendu">
                                <div class="vendu">

                                    <p>
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($Designs['poste']); ?>
                                    </p>

                                    <p>
                                        <strong>Contrat :</strong>
                                        <?php echo ($Designs['contrat']); ?>
                                    </p>
                                    <p>
                                        <strong>Niveau :</strong>
                                        <?php echo ($Designs['etudes']); ?>
                                    </p>
                                    <p>
                                        <strong>Experience :</strong>
                                        <?php echo ($Designs['experience']); ?>
                                    </p>
                                </div>

                            </div>

                            <div class="box_vendu">
                                <div class="vendu">

                                    <p class="ville">
                                        <strong>Ville :</strong>
                                        <?php echo ($Designs['ville']); ?>
                                    </p>
                                </div>

                            </div>

                            <p id="nom">
                                <?php echo $Designs['date']; ?>
                            </p>

                            <a
                                href="../entreprise/voir_offre.php?offres_id=<?= $Designs['offre_id']; ?>&entreprise_id=<?= $Designs['entreprise_id']; ?>">
                                <i class="fa-solid fa-eye"></i>Voir l'offre
                            </a>
                        </div>
                    </div>

                <?php endforeach ?>

            <?php endif; ?>
        </article>
    </section>












    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
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

        <article class="articles owl-carousel carousel3">
            <?php if (empty($offreRedaction)): ?>

                <h1 class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</h1>

            <?php else: ?>

                <?php foreach ($offreRedaction as $Redaction): ?>

                    <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                        data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                        <img src="../upload/<?php echo $Redaction['images'] ?>" alt="">
                        <div class="info-box">
                            <p class="p">
                                <strong>
                                    <?php echo $Redaction['entreprise']; ?>
                                </strong>
                            </p>

                            <div class="box_vendu">
                                <div class="vendu">

                                    <p>
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($Redaction['poste']); ?>
                                    </p>

                                    <p>
                                        <strong>Contrat :</strong>
                                        <?php echo ($Redaction['contrat']); ?>
                                    </p>
                                    <p>
                                        <strong>Niveau :</strong>
                                        <?php echo ($Redaction['etudes']); ?>
                                    </p>
                                    <p>
                                        <strong>Experience :</strong>
                                        <?php echo ($Redaction['experience']); ?>
                                    </p>
                                </div>

                            </div>

                            <div class="box_vendu">
                                <div class="vendu">

                                    <p class="ville">
                                        <strong>Ville :</strong>
                                        <?php echo ($Redaction['ville']); ?>
                                    </p>
                                </div>

                            </div>
                            <p id="nom">
                                <?php echo $Redaction['date']; ?>
                            </p>

                            <a
                                href="../entreprise/voir_offre.php?offres_id=<?= $Redaction['offre_id']; ?>&entreprise_id=<?= $Redaction['entreprise_id']; ?>">
                                <i class="fa-solid fa-eye"></i>Voir l'offre
                            </a>
                        </div>
                    </div>
                <?php endforeach ?>

            <?php endif; ?>
        </article>
    </section>










    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Marketing et communication</h1>
            <span></span>
            <div class="affiche">
                <img src="/image/marketing.jpg" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel4">
            <?php if (empty($offreMarcketing)): ?>

                <h1 class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</h1>

            <?php else: ?>

                <?php foreach ($offreMarcketing as $marketing): ?>

                    <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                        data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                        <img src="../upload/<?php echo $marketing['images'] ?>" alt="">
                        <div class="info-box">
                            <p class="p">
                                <strong>
                                    <?php echo $marketing['entreprise']; ?>
                                </strong>
                            </p>

                            <div class="box_vendu">
                                <div class="vendu">
                                    <p>
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($marketing['poste']); ?>
                                    </p>
                                    <p>
                                        <strong>Contrat :</strong>
                                        <?php echo ($marketing['contrat']); ?>
                                    </p>
                                    <p>
                                        <strong>Niveau :</strong>
                                        <?php echo ($marketing['etudes']); ?>
                                    </p>
                                    <p>
                                        <strong>Experience :</strong>
                                        <?php echo ($marketing['experience']); ?>
                                    </p>
                                </div>

                            </div>

                            <div class="box_vendu">
                                <div class="vendu">

                                    <p class="ville">
                                        <strong>Ville :</strong>
                                        <?php echo ($marketing['ville']); ?>
                                    </p>
                                </div>

                            </div>

                            <p id="nom">
                                <?php echo $marketing['date']; ?>
                            </p>

                            <a
                                href="../entreprise/voir_offre.php?offres_id=<?= $marketing['offre_id']; ?>&entreprise_id=<?= $marketing['entreprise_id']; ?>">
                                <i class="fa-solid fa-eye"></i>Voir l'offre
                            </a>
                        </div>
                    </div>

                <?php endforeach ?>

            <?php endif; ?>
        </article>
    </section>








    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Conseil et gestion d'entreprise</h1>
            <span></span>
            <div class="affiche">
                <img src="/image/gestion.jpg" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel5">
            <?php if (empty($offreBusiness)): ?>

                <h1 class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</h1>
                </h1>

            <?php else: ?>

                <?php foreach ($offreBusiness as $business): ?>

                    <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                        data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                        <img src="../upload/<?php echo $business['images'] ?>" alt="">
                        <div class="info-box">
                            <p class="p">
                                <strong>
                                    <?php echo $business['entreprise']; ?>
                                </strong>

                            </p>

                            <div class="box_vendu">
                                <div class="vendu">
                                    <p>
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($business['poste']); ?>
                                    </p>
                                    <p>
                                        <strong>Contrat :</strong>
                                        <?php echo ($business['contrat']); ?>
                                    </p>
                                    <p>
                                        <strong>Niveau :</strong>
                                        <?php echo ($business['etudes']); ?>
                                    </p>
                                    <p>
                                        <strong>Experience :</strong>
                                        <?php echo ($business['experience']); ?>
                                    </p>
                                </div>

                            </div>
                            <div class="box_vendu">
                                <div class="vendu">

                                    <p class="ville">
                                        <strong>Ville :</strong>
                                        <?php echo ($business['ville']); ?>
                                    </p>
                                </div>

                            </div>
                            <p id="nom">
                                <?php echo $business['date']; ?>
                            </p>

                            <a
                                href="../entreprise/voir_offre.php?offres_id=<?= $business['offre_id']; ?>&entreprise_id=<?= $business['entreprise_id']; ?>">
                                <i class="fa-solid fa-eye"></i>Voir l'offre
                            </a>
                        </div>
                    </div>

                <?php endforeach ?>

            <?php endif; ?>
        </article>
    </section>










    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Juridique</h1>
            <span></span>
            <div class="affiche">
                <img src="/image/juridique.jpg" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel6">
            <?php if (empty($offreJuridique)): ?>

                <h1 class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</h1>

            <?php else: ?>

                <?php foreach ($offreJuridique as $Juridique): ?>

                    <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                        data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                        <img src="../upload/<?php echo $Juridique['images'] ?>" alt="">
                        <div class="info-box">
                            <p class="p">
                                <strong>
                                    <?php echo $Juridique['entreprise']; ?>
                                </strong>
                            </p>

                            <div class="box_vendu">
                                <div class="vendu">
                                    <p>
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($Juridique['poste']); ?>
                                    </p>
                                    <p>
                                        <strong>Contrat :</strong>
                                        <?php echo ($Juridique['contrat']); ?>
                                    </p>
                                    <p>
                                        <strong>Niveau :</strong>
                                        <?php echo ($Juridique['etudes']); ?>
                                    </p>
                                    <p>
                                        <strong>Experience :</strong>
                                        <?php echo ($Juridique['experience']); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="box_vendu">
                                <div class="vendu">

                                    <p class="ville">
                                        <strong>Ville :</strong>
                                        <?php echo ($Juridique['ville']); ?>
                                    </p>
                                </div>

                            </div>

                            <p id="nom">
                                <?php echo $Juridique['date']; ?>
                            </p>

                            <a
                                href="../entreprise/voir_offre.php?offres_id=<?= $Juridique['offre_id']; ?>&entreprise_id=<?= $Juridique['entreprise_id']; ?>">
                                <i class="fa-solid fa-eye"></i>Voir l'offre
                            </a>
                        </div>
                    </div>

                <?php endforeach ?>

            <?php endif; ?>
        </article>
    </section>









    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Informatique et tech </h1>
            <span></span>
            <div class="affiche">
                <!-- <img src="/image/ingenieur.jpeg" alt=""> -->
                <img src="/image/info.jpg" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel7">
            <?php if (empty($offreInformatique)): ?>

                <h1 class="message">Aucune offre d'emploi n'est disponible pour cette catégorie.</h1>

            <?php else: ?>

                <?php foreach ($offreInformatique as $Informatique): ?>

                    <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                        data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                        <img src="../upload/<?php echo $Informatique['images'] ?>" alt="">
                        <div class="info-box">
                            <p class="p">
                                <strong>
                                    <?php echo $Informatique['entreprise']; ?>
                                </strong>

                            </p>
                            <div class="box_vendu">
                                <div class="vendu">
                                    <p>
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($Informatique['poste']); ?>
                                    </p>
                                    <p>
                                        <strong>Contrat :</strong>
                                        <?php echo ($Informatique['contrat']); ?>
                                    </p>
                                    <p>
                                        <strong>Niveau :</strong>
                                        <?php echo ($Informatique['etudes']); ?>
                                    </p>
                                    <p>
                                        <strong>Experience :</strong>
                                        <?php echo ($Informatique['experience']); ?>
                                    </p>
                                </div>

                            </div>

                            <div class="box_vendu">
                                <div class="vendu">

                                    <p class="ville">
                                        <strong>Ville :</strong>
                                        <?php echo ($Informatique['ville']); ?>
                                    </p>
                                </div>

                            </div>

                            <p id="nom">
                                <?php echo $Informatique['date']; ?>
                            </p>

                            <a
                                href="../entreprise/voir_offre.php?offres_id=<?= $Informatique['offre_id']; ?>&entreprise_id=<?= $Informatique['entreprise_id']; ?>">
                                <i class="fa-solid fa-eye"></i>Voir l'offre
                            </a>
                        </div>
                    </div>

                <?php endforeach ?>

            <?php endif; ?>
        </article>
    </section>





    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Finance et comptabilité </h1>
            <span></span>
            <div class="affiche">
                <!-- <img src="/image/ingenieur.jpeg" alt=""> -->
                <img src="/image/finance.png" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel8">

            <?php foreach ($afficheAllOffre as $Information): ?>
                <?php $infoEntreprise = getEntreprise($db, $Information['entreprise_id']) ?>

                <?php if ($Information['categorie'] === 'Finance et comptabilité'): ?>



                    <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                        data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                        <img src="../upload/<?php echo $infoEntreprise['images'] ?>" alt="">
                        <div class="info-box">
                            <p class="p">
                                <strong>
                                    <?php echo $infoEntreprise['entreprise']; ?>
                                </strong>

                            </p>
                            <div class="box_vendu">
                                <div class="vendu">
                                    <p>
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($Information['poste']); ?>
                                    </p>
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
                                </div>

                            </div>

                            <div class="box_vendu">
                                <div class="vendu">

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
            <?php endforeach ?>
        </article>
    </section>








    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Santé et bien-être </h1>
            <span></span>
            <div class="affiche">
                <!-- <img src="/image/ingenieur.jpeg" alt=""> -->
                <img src="/image/santé.png" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel7">

            <?php foreach ($afficheAllOffre as $Information): ?>
                <?php $infoEntreprise = getEntreprise($db, $Information['entreprise_id']) ?>

                <?php if ($Information['categorie'] === 'Santé et bien-être'): ?>



                    <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                        data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                        <img src="../upload/<?php echo $infoEntreprise['images'] ?>" alt="">
                        <div class="info-box">
                            <p class="p">
                                <strong>
                                    <?php echo $infoEntreprise['entreprise']; ?>
                                </strong>

                            </p>
                            <div class="box_vendu">
                                <div class="vendu">
                                    <p>
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($Information['poste']); ?>
                                    </p>
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
                                </div>

                            </div>

                            <div class="box_vendu">
                                <div class="vendu">

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
            <?php endforeach ?>
        </article>
    </section>







    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Éducation et formation </h1>
            <span></span>
            <div class="affiche">
                <!-- <img src="/image/ingenieur.jpeg" alt=""> -->
                <img src="/image/education.png" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel7">

            <?php foreach ($afficheAllOffre as $Information): ?>
                <?php $infoEntreprise = getEntreprise($db, $Information['entreprise_id']) ?>

                <?php if ($Information['categorie'] === 'Éducation et formation'): ?>



                    <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                        data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                        <img src="../upload/<?php echo $infoEntreprise['images'] ?>" alt="">
                        <div class="info-box">
                            <p class="p">
                                <strong>
                                    <?php echo $infoEntreprise['entreprise']; ?>
                                </strong>

                            </p>
                            <div class="box_vendu">
                                <div class="vendu">
                                    <p>
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($Information['poste']); ?>
                                    </p>
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
                                </div>

                            </div>

                            <div class="box_vendu">
                                <div class="vendu">

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
            <?php endforeach ?>
        </article>
    </section>









    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Tourisme et hôtellerie</h1>
            <span></span>
            <div class="affiche">
                <!-- <img src="/image/ingenieur.jpeg" alt=""> -->
                <img src="/image/tourisme.png" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel7">

            <?php foreach ($afficheAllOffre as $Information): ?>
                <?php $infoEntreprise = getEntreprise($db, $Information['entreprise_id']) ?>

                <?php if ($Information['categorie'] === 'Tourisme et hôtellerie'): ?>

                    <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                        data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                        <img src="../upload/<?php echo $infoEntreprise['images'] ?>" alt="">
                        <div class="info-box">
                            <p class="p">
                                <strong>
                                    <?php echo $infoEntreprise['entreprise']; ?>
                                </strong>

                            </p>
                            <div class="box_vendu">
                                <div class="vendu">
                                    <p>
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($Information['poste']); ?>
                                    </p>
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
                                </div>

                            </div>

                            <div class="box_vendu">
                                <div class="vendu">

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
            <?php endforeach ?>
        </article>
    </section>










    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Commerce et vente </h1>
            <span></span>
            <div class="affiche">
                <!-- <img src="/image/ingenieur.jpeg" alt=""> -->
                <img src="/image/vente.png" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel7">

            <?php foreach ($afficheAllOffre as $Information): ?>
                <?php $infoEntreprise = getEntreprise($db, $Information['entreprise_id']) ?>

                <?php if ($Information['categorie'] === 'Commerce et vente'): ?>



                    <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                        data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                        <img src="../upload/<?php echo $infoEntreprise['images'] ?>" alt="">
                        <div class="info-box">
                            <p class="p">
                                <strong>
                                    <?php echo $infoEntreprise['entreprise']; ?>
                                </strong>

                            </p>
                            <div class="box_vendu">
                                <div class="vendu">
                                    <p>
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($Information['poste']); ?>
                                    </p>
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
                                </div>

                            </div>

                            <div class="box_vendu">
                                <div class="vendu">

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
            <?php endforeach ?>
        </article>
    </section>










    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Transport et logistique </h1>
            <span></span>
            <div class="affiche">
                <!-- <img src="/image/ingenieur.jpeg" alt=""> -->
                <img src="/image/transport.png" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel7">

            <?php foreach ($afficheAllOffre as $Information): ?>
                <?php $infoEntreprise = getEntreprise($db, $Information['entreprise_id']) ?>

                <?php if ($Information['categorie'] === 'Transport et logistique'): ?>



                    <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                        data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                        <img src="../upload/<?php echo $infoEntreprise['images'] ?>" alt="">
                        <div class="info-box">
                            <p class="p">
                                <strong>
                                    <?php echo $infoEntreprise['entreprise']; ?>
                                </strong>

                            </p>
                            <div class="box_vendu">
                                <div class="vendu">
                                    <p>
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($Information['poste']); ?>
                                    </p>
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
                                </div>

                            </div>

                            <div class="box_vendu">
                                <div class="vendu">

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
            <?php endforeach ?>
        </article>
    </section>










    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Agriculture et agroalimentaire </h1>
            <span></span>
            <div class="affiche">
                <!-- <img src="/image/ingenieur.jpeg" alt=""> -->
                <img src="/image/agriculture.png" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel7">

            <?php foreach ($afficheAllOffre as $Information): ?>
                <?php $infoEntreprise = getEntreprise($db, $Information['entreprise_id']) ?>

                <?php if ($Information['categorie'] === 'Agriculture et agroalimentaire'): ?>



                    <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                        data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                        <img src="../upload/<?php echo $infoEntreprise['images'] ?>" alt="">
                        <div class="info-box">
                            <p class="p">
                                <strong>
                                    <?php echo $infoEntreprise['entreprise']; ?>
                                </strong>

                            </p>
                            <div class="box_vendu">
                                <div class="vendu">
                                    <p>
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($Information['poste']); ?>
                                    </p>
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
                                </div>

                            </div>

                            <div class="box_vendu">
                                <div class="vendu">

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
            <?php endforeach ?>
        </article>
    </section>










    <section class="produit_vedete">
        <div class="box1" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
            data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
            <span></span>
            <h1>Autre </h1>
            <span></span>
            <div class="affiche">
                <!-- <img src="/image/ingenieur.jpeg" alt=""> -->
                <img src="/image/autre.png" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel7">

            <?php foreach ($afficheAllOffre as $Information): ?>
                <?php $infoEntreprise = getEntreprise($db, $Information['entreprise_id']) ?>

                <?php if ($Information['categorie'] === 'Autre'): ?>

                    <div class="carousel" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom" data-aos-delay="0"
                        data-aos-duration="400" data-aos-easing="ease-in-out" data-aos-mirror="true" data-aos-once="false">
                        <img src="../upload/<?php echo $infoEntreprise['images'] ?>" alt="">
                        <div class="info-box">
                            <p class="p">
                                <strong>
                                    <?php echo $infoEntreprise['entreprise']; ?>
                                </strong>

                            </p>
                            <div class="box_vendu">
                                <div class="vendu">
                                    <p>
                                        <strong>Nous recherchons un(une)</strong>
                                        <?php echo ($Information['poste']); ?>
                                    </p>
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
                                </div>

                            </div>

                            <div class="box_vendu">
                                <div class="vendu">

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
            <?php endforeach ?>
        </article>
    </section>


    <script src="/js/owl.carousel.min.js"></script>
    <script src="/js/owl.carousel.js"></script>
    <script src="/js/owl.animate.js"></script>
    <script src="/js/owl.autoplay.js"></script>
    <script src="/js/silder_offres.js"></script>

    <script>
        // ..
        AOS.init();
    </script>


</body>

</html>