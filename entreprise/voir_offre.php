<?php
session_start();
if (isset($_GET['id'])) {
    $offre_id = $_GET['id'];
} else {
    header('Location: ../page/Offres_d\'emploi.php');
}

include_once('app/controller/controllerOffre_emploi.php');
include_once('app/controller/controllerEntreprise.php');
include_once('app/controller/controllerDescription.php');
include_once('../controller/controller_users.php');
include_once('../controller/controller_postulation.php');

$Offres = getOffres($db, $offre_id);
$entreprise_id = $Offres['entreprise_id'];
$getEntreprise = getEntreprise($db, $entreprise_id);
$afficheDescriptionentreprise = getDescriptionEntreprise($db, $entreprise_id);

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

    <title>Profil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="../css/owl.carousel.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/voir_offre.css">
    <link rel="stylesheet" href="../css/navbare.css">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>


    <section class="section2">
        <div class="box1">
            <h1>Info de l'Entreprise</h1>

            <img src="../upload/<?= $getEntreprise['images'] ?>" alt="">

            <table>
                <tr>
                    <th>NOM</th>
                    <td>
                        <?= $getEntreprise['entreprise'] ?>
                    </td>
                </tr>
                <tr>
                    <th>site internet</th>
                    <?php if ($afficheDescriptionentreprise): ?>
                        <td><a href="<?= $afficheDescriptionentreprise['liens'] ?>">
                                <?= $afficheDescriptionentreprise['liens'] ?>
                            </a></td>
                    <?php else: ?>
                        <td>Aucun lien pour cette entreprise</td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th>Type d'entreprise</th>
                    <td><strong>
                            <?= $getEntreprise['types'] ?>
                        </strong></td>
                </tr>

                <tr>
                    <th>description de l'Entreprise</th>
                    <?php if ($afficheDescriptionentreprise): ?>
                        <td>
                            <?= $afficheDescriptionentreprise['descriptions'] ?>
                        </td>
                    <?php else: ?>
                        <td>Aucune description pour cette entreprise</td>
                    <?php endif; ?>

                </tr>
            </table>
        </div>
    </section>



    <section class="section3">
        <?php if ($Offres): ?>
            <div class="box1">
                <h1>detaille de l'offre</h1>
                <h2>poste disponible : <span>
                        <?= $Offres['poste'] ?>
                    </span></h2>

                <h3>Mission et responsabiliter</h3>

                <?= $Offres['mission'] ?>

                <h3>profil rechercher (caliter et competance) </h3>

                <?= $Offres['profil'] ?>

                <h1 class="suplement">Info suplementaire</h1>


                <table>
                    <tr>
                        <th>Métier :</th>
                        <td>
                            <?= $Offres['metier'] ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Type de contrat :</th>
                        <td>
                            <?= $Offres['contrat'] ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Région :</th>
                        <td>
                            <?= $Offres['localite'] ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Ville :</th>
                        <td>
                            <?= $getEntreprise['ville'] ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Niveau d'expérience :</th>
                        <td>
                            <?= $Offres['experience'] ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Niveau d'études :</th>
                        <td>
                            <?= $Offres['etudes'] ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Langues exigées :</th>
                        <td>
                            <?= $Offres['langues'] ?>
                        </td>
                    </tr>
                </table>

                <?php
                if (isset($_SESSION['users_id'])) {
                    $getInfo = getInfoUsers($db, $_SESSION['users_id']);
                }

                ?>

                <?php if (isset($_SESSION['users_id'])): ?>
                    <form action="" method="post">
                        <input type="hidden" name="id_users" id="" value="<?= $getInfo['id'] ?>">
                        <input type="hidden" name="nom_users" id="" value="<?= $getInfo['nom'] ?>">
                        <input type="hidden" name="mail_users" id="" value="<?= $getInfo['mail'] ?>">
                        <input type="hidden" name="phone_users" id="" value="<?= $getInfo['phone'] ?>">
                        <input type="hidden" name="competence_users" id="" value="<?= $getInfo['competences'] ?>">
                        <input type="hidden" name="profession_users" id="" value="<?= $getInfo['profession'] ?>">
                        <input type="hidden" name="images_users" id="" value="<?= $getInfo['images'] ?>">

                        <?php if (isset($getPostulation['offre_id'])): ?>
                            <p class="msg001">Vous avez déjà envoyer votre candidature merci de patienter une réponse favorable.</p>
                        <?php else: ?>
                            <button class="btn001" type="submit" name="postuler">Postuler pour cette offre</button>
                        <?php endif; ?>
                    </form>
                <?php endif; ?>



            </div>
        <?php endif; ?>
    </section>




    <div class="container_box10">
        <h2>Offres qui correspondes a votre profil </h2>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>
        <div class="slider owl-carousel carousel3">
            <?php foreach ($afficheAllOffre as $affiches): ?>

                <?php if ($affiches['categorie'] == $Offres['categorie']): ?>

                    <?php $info_entreprise = getEntreprise($db, $affiches['entreprise_id']) ?>
                    <div class="carousel">
                        <img src="../upload/<?php echo $info_entreprise['images'] ?>" alt="">
                        <p class="p">
                            <strong>
                                <?php echo $info_entreprise['entreprise']; ?>
                            </strong>
                        </p>

                        <div class="box_vendu">
                            <div class="vendu">
                                <p>
                                    <strong>Nous recherchons un(une)</strong>
                                    <?php echo ($affiches['poste']); ?>
                                </p>
                            </div>
                        </div>

                        <div class="box_vendu">
                            <div class="vendu">
                                <p class="ville">
                                    <strong>Ville :</strong>
                                    <?php echo ($affiches['localite']); ?>
                                </p>
                            </div>
                        </div>

                        <p id="nom">
                            <?php echo $affiches['date']; ?>
                        </p>
                        <a
                            href="../entreprise/voir_offre.php?id=<?= $affiches['offre_id']; ?>&entreprise_id=<?= $affiches['entreprise_id']; ?>">
                            <i class="fa-solid fa-eye"></i>Voir l'offre
                        </a>
                    </div>

                <?php endif; ?>
            <?php endforeach ?>
        </div>
    </div>


    <?php include('../footer.php') ?>


    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/owl.carousel.js"></script>
    <script src="../js/owl.animate.js"></script>
    <script src="../js/owl.autoplay.js"></script>

    <script>
        $(document).ready(function () {
            // Initialiser le carrousel 1 avec la portée appropriée
            $('.carousel1').owlCarousel({
                items: 4,
                loop: true,
                autoplay: true,
                animateOut: 'slideOutDown',
                animateIn: 'flipInX',
                stagePadding: 1,
                smartSpeed: 450,
                margin: 0,
                nav: true,
                navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
            });
            var carousel1 = $('.carousel1').owlCarousel();
            $('.owl-next').click(function () {
                carousel1.trigger('next.owl.carousel');
            })
            $('.owl-prev').click(function () {
                carousel1.trigger('prev.owl.carousel');
            })


            $('.boot').owlCarousel({
                items: 1,
                loop: true,
                autoplay: false,
                autoplayTimeout: 5000,
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



        $(document).ready(function () {
            // Carrousel 3  
            var carousel3 = $('.carousel3');
            var numItems2 = carousel3.find('.carousel').length;

            if (numItems2 > 3) {

                // Initialiser Owl carousel3 si il y a plus de 4 éléments
                carousel3.owlCarousel({
                    items: 4, // Limitez le nombre d'éléments à afficher à 5
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 6000,
                    animateOut: 'slideOutDown',
                    animateIn: 'flipInX',
                    stagePadding: 30,
                    smartSpeed: 450,
                    margin: 20,
                    nav: true,
                    navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
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