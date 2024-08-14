<?php
session_start();
include('../conn/conn.php');

include_once('app/controller/controllerEntreprise.php');
include_once('app/controller/controllerDescription.php');
include_once('app/controller/controllerOffre_emploi.php');
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
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

    <title>
        <?= $getEntreprise['entreprise']; ?>
    </title>
    <link rel="icon" href="../image/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="../image/logo.png" type="image/x-icon">
    <title>
        <?= $getEntreprise['entreprise']; ?>
    </title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/entreprise_profil.css">
    <link rel="stylesheet" href="../css/navbare.css">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>


    <?php include('../include/header_entreprise.php') ?>

    <section class="section3">

        <div class="section2-div ">
            <div class="slider1 owl-carousel">

                <img src="../image/cc1.webp" alt="">

                <img src="../image/cc3.jpg" alt="">

                <img src="../image/cc4.png" alt="">

                <img src="../image/cc5.jpeg" alt="">

            </div>

            <div class="box1">
                <h1>Bienvenue au Centre de Gestion des Offres et Appels d'Offre de Work-Flexer</h1>

                <p>
                    <span>
                        Nous sommes heureux de vous accueillir dans notre plateforme exclusive de gestion des offres et
                        appels d'offre. Work-Flexer, votre partenaire privilégié, met à votre disposition un outil de
                        gestion avancé pour simplifier le processus de recrutement et trouver les talents les plus
                        qualifiés
                        pour votre organisation.
                    </span>
                </p>

            </div>
        </div>

        <?php if (isset($_SESSION['success_message'])) : ?>
            <div class="message">
                <p>
                    <span></span>
                    <?php echo $_SESSION['success_message']; ?>
                    <?php unset($_SESSION['success_message']); ?>
                </p>
            </div>
        <?php else : ?>
            <?php if (isset($_SESSION['error_message'])) : ?>
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
            setTimeout(function() {
                messageErreur.classList.add('visible');
            }, 200); // 1000 millisecondes équivalent à 1 seconde

            // Fonction pour masquer le message avec une transition de fondu
            setTimeout(function() {
                messageErreur.classList.remove('visible');
            }, 6000); // 6000 millisecondes équivalent à 6 secondes
        </script>
        <div class="container_box3">
            <div class="box1">
                <h2>Description !</h2>
                <?php if (isset($afficheDescriptionentreprise['descriptions'])) : ?>
                    <p>
                        <?= $afficheDescriptionentreprise['descriptions'] ?>
                    </p>
                <?php else : ?>
                    <p class="p"> Ajouter une description pour que votre entreprise soit connue </p>
                <?php endif; ?>
            </div>
            <?php if (isset($afficheDescriptionentreprise['descriptions'])) : ?>
                <button class="btn1"><img src="../image/edite.png" alt=""></button>

                <div class="form_desc">
                    <form method="post" action="">
                        <div>
                            <textarea name="descriptions" id="summernote" cols="30" rows="10">
                                                                                                                                            <?php echo htmlspecialchars($afficheDescriptionentreprise['descriptions'], ENT_QUOTES, 'UTF-8') ?>
                                                                                                                                        </textarea>
                        </div>
                        <div class="div">
                            <label for="site">Avez vous un site web ?(facultatif*)</label>
                            <input type="text" name="liens" id="site" value="<?= $afficheDescriptionentreprise['liens'] ?>">
                        </div>
                        <input type="submit" name="modifiers" value="Modifier" id="ajouter">
                    </form>
                </div>
            <?php else : ?>
                <button class="btn1"><img src="../image/edite.png" alt=""></button>

                <div class="form_desc">
                    <form method="post" action="">
                        <div>
                            <textarea name="descriptions" id="summernote" cols="30" rows="10"></textarea>
                        </div>
                        <div class="div">
                            <label for="site">Avez vous un site web ?</label>
                            <input type="text" name="liens" id="site">
                        </div>
                        <input type="submit" name="ajouter" value="ajouter" id="ajouter">
                    </form>
                </div>
            <?php endif; ?>



            <script>
                let btn1 = document.querySelector('.btn1');
                let form_desc = document.querySelector('.form_desc');

                btn1.addEventListener('click', () => {

                    if (form_desc.style.height === '0px') {
                        form_desc.style.height = '350px'
                    } else {
                        form_desc.style.height = '0px'
                    }
                })
            </script>
        </div>

        <div class="container_box1">
            <div class="box1">
                <h1>Publier une offre!!</h1>
            </div>

            <div class="box2">
                <button class="btn2"><img src="../image/edite.png" alt=""></button>
            </div>
            <div class="form_off">
            <form method="post" action="">
    <img src="../image/croix.png" alt="" class="img1">

    <div class="box">
        <label for="poste">Poste disponible :</label>
        <input type="text" name="poste" id="poste" required placeholder="Exemple : Développeur web">
    </div>
    <div class="box">
        <label for="mission">Décrivez les missions et responsabilités :</label>
        <textarea name="mission" id="mission" cols="30" rows="10"></textarea>
    </div>
    <div class="box">
        <label for="profil">Décrivez le profil recherché (qualités et compétences) :</label>
        <textarea name="profil" id="profil" cols="30" rows="10" required placeholder="Décrivez le profil recherché, les qualités et compétences requises"></textarea>
    </div>

    <div class="box">
        <select name="contrat" id="contrat">
            <option value="">-- Type de contrat --</option>
            <option value="CDI">CDI</option>
            <option value="CDD">CDD</option>
            <option value="INTERIM">Intérim</option>
            <option value="FREELANCE">Freelance</option>
            <option value="APPRENTISSAGE">Apprentissage</option>
            <option value="STAGE">Stage</option>
        </select>
    </div>

    <div class="box">
        <select name="etude" id="etude">
            <option value="">-- Niveau d'étude requis --</option>
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
            <option value="Aucun">Aucun</option>
        </select>
    </div>

    <div class="box">
        <select name="experience" id="experience">
            <option value="">-- Niveau d'expérience requis --</option>
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
            <option value="Aucun">Aucun</option>
        </select>
    </div>

    <div class="box">
        <label for="places">Nombre de places disponibles :</label>
        <input type="number" name="places" id="places" required placeholder="Exemple : 5">
    </div>

    <div class="box">
        <label for="duree">Durée de l'offre avant expiration (en jours) :</label>
        <input type="number" name="duree" id="duree" required placeholder="Exemple : 30">
    </div>

    <div class="box">
        <label for="localite">Localité :</label>
        <input type="text" name="localite" id="localite" required placeholder="Exemple : Paris, Lyon, etc.">
    </div>

    <div class="box">
                        <label for="Langues">Langues exigées :</label>
                        <input type="text" name="langues" id="Langues" required placeholder="Exemple : Français, Anglais, Espagnol">
                    </div>

    <div class="box">
        <label for="categorie">Secteur d'activité</label>
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
    </div>

    <input type="submit" name="publier" value="Publier" id="valider">
</form>

            </div>

            <script>
                let btn2 = document.querySelector('.btn2')
                let form_off = document.querySelector('.form_off')
                let img1 = document.querySelector('.img1')

                btn2.addEventListener('click', () => {
                    form_off.style.height = 'auto'
                })
                img1.addEventListener('click', () => {
                    form_off.style.height = '0'
                })
            </script>
        </div>


        <div class="container_box2">
            <div class="box1">
                <h1>Mes offres</h1>
                <span>
                    <?php $countOffre = count($afficheOffreEmplois);
                    echo $countOffre
                    ?>
                </span>
            </div>

            <div class="box2">
                <?php
                if (empty($afficheOffreEmplois)) :
                ?>
                    <p class="info"><strong>Info!</strong> Aucune offre d’emplois publier ! veuillez ajouter une offre</p>
                <?php else : ?>

                    <?php
                    foreach ($afficheOffreEmplois as $offres) :
                    ?>
                    <?php if($offres['statut'] === 'publiee' or $offres['statut'] === '') : ?>
                        <?php $countOffre = countOffre($db, $offres['entreprise_id'], $offres['offre_id']); ?>
                        <div class="carousel">
                        <a class="suprimer" href="?offre_id=<?= $offres['offre_id']; ?>"> Supprimer</a>
                        <div class="vue">
                                    <img src="../image/vue.png" alt="">
                                    <span>
                                        <?= $countOffre ?>
                                    </span>
                                </div>

                            <div class="boximg">
                                <img src="../upload/<?= $offres['images'] ?> " alt="">
                            </div>
                           

                            <div class="box_vendu">

                            <p class="p"><strong>Nous recherchons un(une)</strong>
                                        <?= $offres['poste'] ?>
                                    </p>
                                <div class="vendu">
                                    <p><strong>Niveau :</strong>
                                        <?= $offres['etudes'] ?>
                                    </p>
                                    <p><strong>Experience :</strong>
                                        <?= $offres['experience'] ?>
                                    </p>
                                    <p><strong>Contrat :</strong>
                                        <?= $offres['contrat'] ?>
                                    </p>
                                    <p><strong>Localite :</strong>
                                        <?= $offres['ville'] ?>
                                    </p>
                                </div>
                            </div>

                            <p id="nom">
                                <?= $offres['date'] ?>
                            </p>

                            <div class="liens">
                                <a class="liens" href="../entreprise/updat_offre.php?id=<?= $offres['offre_id'] ?>"><i class="fa-solid fa-eye"></i></span>Voir l'offre</a>
                            </div>

                        </div>

                        <?php endif ?>
                    <?php endforeach; ?>
                <?php endif ?>

            </div>
        </div>

        <div class="box_assistance">
        <div>
            <a  href="#container_box6"><button id="contacte"><img src="../image/service.png" alt=""></button></a>
        <a class="whatsapp" href="https://api.whatsapp.com/send?phone=785303879" target="_blank" ><img src="../image/whatsapp.png" alt=""></a>
        <a class="mail" href="mailto:workflexer.service@gmail.com"><img src="../image/icons8-gmail-48.png" alt=""> </a>
        </div>
      </div>

        <div class="container_box6" id="container_box6">
           
            <div class="box1">
                <h1>Assistance</h1>
              <br>
                <p>Ou écrivez nous ici !</p>
            </div>

            <div class="box2">
                <form action="" method="post">
                    <textarea name="message" id="message" cols="30" rows="10"></textarea>
                    <button name="send" type="submit">Envoyer</button>
                </form>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="/js/owl.carousel.min.js"></script>
    <script src="/js/owl.carousel.js"></script>
    <script src="/js/owl.animate.js"></script>
    <script src="/js/owl.autoplay.js"></script>


    <script>
        $(document).ready(function() {
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
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        $(document).ready(function() {
            $('#mission').summernote({
                placeholder: 'ajoute une description!!',
                tabsize: 6,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        $(document).ready(function() {
            $('#profil').summernote({
                placeholder: 'ajoute une description!!',
                tabsize: 6,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Initialiser le carrousel 1 avec la portée appropriée
            $('.slider1').owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                animateOut: 'slideOutDown',
                animateIn: 'flipInX',
                stagePadding: 1,
                smartSpeed: 700,
                margin: 0,
                nav: true,
                navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
            });
            var carousel1 = $('.slider').owlCarousel();
            $('.owl-next').click(function() {
                carousel1.trigger('next.owl.carousel');
            })
            $('.owl-prev').click(function() {
                carousel1.trigger('prev.owl.carousel');
            })


        });
    </script>



</body>

</html>