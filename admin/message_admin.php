<?php
session_start();
include '../conn/conn.php';

$sql = "SELECT * FROM admin_message ";
$stmt = $db->prepare($sql);
$stmt->execute();
$message = $stmt->fetchAll(PDO::FETCH_ASSOC);

include('../controller/controller_users.php');
include('../entreprise/app/controller/controllerEntreprise.php');
include('../controller/controller_admin.php');

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
    <link rel="stylesheet" href="../style/font-awesome.6.4.0.min.css">

    <script src="../script/jquery-3.6.0.min.js"></script>

    <script src="../script/summernote@0.8.18.js"></script>
    <link rel="stylesheet" href="../style/summernote@0.8.18.css">


    <link rel="stylesheet" href="../css/message.css">
    <link rel="stylesheet" href="../css/navbare.css">

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>



    <?php include('../include/header_admin.php') ?>


    <section class="section3">

        <img src="../image/fleche.png" alt="" class="img222">
        <script>
            let img222 = document.querySelector('.img222');
            let section2 = document.querySelector('.section2');
            let img111 = document.querySelector('.img111')
            img222.addEventListener('click', () => {
                section2.style.marginLeft = '0px';
                img222.style.display = 'none';
            });

            img111.addEventListener('click', () => {
                section2.style.marginLeft = '-150%';
                img222.style.display = 'block';
            });
        </script>
        <div class="container_profil">

            <div class="box3">
                <h2>Candidatures retenues</h2>
                <?php if (empty($message)): ?>
                    <p><strong>Info :</strong> Aucun message trouver !!</p>
                <?php else: ?>
                    <?php foreach ($message as $messages): ?>
                        <?php ?>
                        <?php if ($messages['compte'] === 'compte professionnel'): ?>
                            <?php $infoUsers = infoUsers($db, $messages['utilisateur_id']); ?>
                            <?php ?>
                            <a class="professionnel" href="get_message.php?utilisateur_id=<?= $messages['utilisateur_id'] ?>">
                                <div class="info professionnel">
                                    <img src="../upload/<?php echo $infoUsers['images'] ?>" alt="">
                                    <div class="div">
                                        <h4>
                                            <?= $infoUsers['nom'] ?>
                                        </h4>
                                        <p> <strong>Competences:</strong>
                                            <?= $infoUsers['competences'] ?>
                                        </p>
                                        <p><span class="span1"><strong>E-mail:</strong>
                                                <?= $infoUsers['mail'] ?>
                                            </span>
                                    </div>
                                </div>
                            </a>
                        <?php else: ?>
                            <?php if ($messages['compte'] === 'compte entreprise'): ?>
                                <?php $infoUsers = getEntreprise($db, $messages['utilisateur_id']); ?>
                                <a href="get_message.php?utilisateur_id=<?= $messages['utilisateur_id'] ?>">
                                    <div class="info">
                                        <img src="../upload/<?php echo $infoUsers['images'] ?>" alt="">
                                        <div class="div">
                                            <h4>
                                                <?= $infoUsers['nom'] ?>
                                            </h4>
                                            <p> <strong>Entreprise name:</strong>
                                                <?= $infoUsers['entreprise'] ?>
                                            </p>
                                            <p><span class="span1"><strong>E-mail:</strong>
                                                    <?= $infoUsers['mail'] ?>
                                                </span>
                                        </div>
                                    </div>
                                </a>
                            <?php endif; ?>

                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>


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



</body>

</html>