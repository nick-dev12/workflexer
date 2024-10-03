<?php
session_start();

if (isset($_GET['id'])) {
    $offre_id = $_GET['id'];
} else {
    header('Location: ../entreprise/entreprise_profil.php');
}

include_once('app/controller/controllerOffre_emploi.php');
include_once('app/controller/controllerEntreprise.php');
include_once('app/controller/controllerDescription.php');

$Offres = getOffres($db, $offre_id);
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="../image/logo.png" type="image/x-icon">
    <script src="../script/jquery-3.6.0.min.js"></script>
    <link href="../style/bootstrap.3.4.1.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/summernote@0.8.18.css">
    <title>offre d'emploi</title>
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/voir_offre.css">

</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>



    <section class="section3">

        <div class="job-offer">

            <div class="box11">
                <img src="../upload/<?= $getEntreprise['images'] ?>" alt="">
                <h2>Offre d'emploi</h2>
                <p class="company">
                    <?= $getEntreprise['entreprise'] ?>
                </p>

                <?php if ($afficheDescriptionentreprise): ?>
                    <p class="lien"><a href="<?= $afficheDescriptionentreprise['liens'] ?>">
                            <?= $afficheDescriptionentreprise['liens'] ?>
                        </a></p>
                <?php else: ?>
                    <p class="lien">Aucun lien pour cette entreprise</p>
                <?php endif; ?>

                <h4>Type d'entreprise</h4>
                <p>
                    <?= $getEntreprise['types'] ?>
                </p>

                <h4>Description de l'Entreprise</h4>
                <?php if ($afficheDescriptionentreprise): ?>
                    <p class="description">
                        <?= $afficheDescriptionentreprise['descriptions'] ?>
                    </p>
                <?php else: ?>
                    <p class="lien">Description indisponible !</p>
                <?php endif; ?>

            </div>

            <?php if ($Offres): ?>
                <div class="box3">
                    <h1>Detaille de l'offre</h1>
                    <h2>Poste disponible : <span>
                            <?= $Offres['poste'] ?>
                        </span></h2>
                </div>


                <div class="box2">
                    <h3>Missions et responsabilités</h3>
                    <?= $Offres['mission'] ?>
                </div>

                <div class="box2">
                    <h3>Profil recherché</h3>
                    <p>Qualités et compétences requises:</p>
                    <?= $Offres['profil'] ?>
                </div>

                <div class="box2">
                    <h3>Informations supplémentaires</h3>
                    <div class="box_info">
                        <p class="info"> <strong>Métier : </strong>
                            <?= $Offres['metier'] ?>
                        </p>
                        <p class="info"> <strong> Type de contrat :</strong>
                            <?= $Offres['contrat'] ?>
                        </p>
                        <p class="info"> <strong>Région : </strong>
                            <?= $Offres['localite'] ?>
                        </p>
                        <p class="info"> <strong>Ville : </strong>
                            <?= $getEntreprise['ville'] ?>
                        </p>
                        <p class="info"> <strong>Niveau d'expérience : </strong>
                            <?= $Offres['etudes'] ?>
                        </p>
                        <p class="info"> <strong>Langues exigées : </strong>
                            <?= $Offres['langues'] ?>
                        </p>
                    </div>

                </div>

                <button class="btn2"> Modifier l'offre </button>

            </div>
        <?php endif; ?>


        <div class="container-b">
            <div class="form_off">
                <form method="post" action="">
                    <img class="img1" src="../image/croix.png" alt="">
                    <div class="box">
                        <label for="poste">Poste disponible</label>
                        <input type="text" name="poste" id="poste" value="<?= $Offres['poste'] ?>">
                    </div>
                    <div class="box">
                        <label for="mission">décrivez les missions et responsabilités</label>
                        <textarea name="mission" id="mission" cols="30"
                            rows="10"><?= htmlspecialchars_decode($Offres['mission']) ?></textarea>
                    </div>
                    <div class="box">
                        <label for="profil">décrivez le profil rechercher (qualités et competence)</label>
                        <textarea name="profil" id="profil" cols="30"
                            rows="10"><?= htmlspecialchars_decode($Offres['profil']) ?></textarea>
                    </div>

                    <div class="box">
                        <select name="contrat" id="contrat">
                            <option value="<?= $Offres['contrat'] ?>">-- Type de contrat --</option>
                            <option value="cdi">CDI</option>
                            <option value="cdd">CDD</option>
                            <option value="interim">Intérim</option>
                            <option value="freelance">Freelance</option>
                            <option value="apprentissage">Apprentissage</option>
                            <option value="stage">Stage</option>
                        </select>
                    </div>

                    <div class="box">
                        <select name="etude" id="etude">
                            <option value="<?= $Offres['etudes'] ?>">-- Niveau d'étude requis --</option>
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

                    <div class="box">
                        <select name="experience" id="experience">
                            <option value="<?= $Offres['experience'] ?>">-- Niveau d'expérience requis --</option>
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
                    </div>
                    <div class="box">
                        <label for="localite">region </label>
                        <input type="text" name="localite" id="localite" value="<?= $Offres['localite'] ?>">
                    </div>
                    <div class="box">
                        <label for="Langues">Langues exigées</label>
                        <input type="text" name="langues" id="Langues" value="<?= $Offres['langues'] ?>">
                    </div>

                    <div class="box">
                        <label for="categorie">Secteur d'activité</label>
                        <select id="categorie" name="categorie">
                            <option value="<?= $Offres['categorie'] ?>">Sélectionnez une catégorie</option>
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

                    <input type="submit" name="modifier" value="modifier" id="valider">
                </form>
            </div>
        </div>





    </section>


    <!-- <section class="section4">
        <div class="box1">
            <h1>voir plus d'offre de cette categorie</h1>


            <div class="box2">
                <span><i class="fa-solid fa-chevron-left"></i></span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
            </div>
    
            <article class="articles owl-carousel carousel1">
                <div class="carousel">
                    <img src="/profils/preview_B0eCXi7.jpeg" alt="">
                    <p>informaticien de getion des affaires applique <span>1</span></p>
                    <div class="vendu">
                        <p>nous recherchons un personnels califier pour povoir nous aider dans </p>
                    </div>
                    <p id="nom">12 juillet 2023</p>
                    <a href="#"><i class="fa-solid fa-eye"></i></span>Profil</a>
                </div>
    
                <div class="carousel">
                    <img src="/profils/p1.jpeg" alt="">
                    <p>logistique<span>0</span></p>
                    <div class="vendu">
                        <span>html</span>
                        <span>css</span>
                        <span>java script</span>
                        <span>html</span>
                        <span>css</span>
                        <span>java script</span>
                    </div>
                    <p id="nom">t-shirt hummel</p>
                    <a href="#"><i class="fa-solid fa-eye"></i></span>Profil</a>
                </div>
    
                <div class="carousel">
                    <img src="/profils/p2.jpg" alt="">
                    <p>agronome<span>o</span></p>
                    <div class="vendu">
                        <span>css</span>
                        <span>java script</span>
                        <span>html</span>
                        <span>css</span>
                        <span>java script</span>
                    </div>
                    <p id="nom">Nom: Sylivin</p>
                    <a href="#"><i class="fa-solid fa-eye"></i></span>Profil</a>
                </div>
    
                <div class="carousel">
                    <img src="/profils/p3.jpeg" alt="">
                    <p>proffesseur de mathematique<span>0</span></p>
                    <div class="vendu">
                        <span>html</span>
                        <span>css</span>
                        <span>html</span>
                        <span>css</span>
                        <span>java script</span>
                    </div>
                    <p id="nom">Nom: pricil</p>
                    <a href="#"><i class="fa-solid fa-eye"></i></span>Profil</a>
                </div>
    
                <div class="carousel">
                    <img src="/profils/p4.jpeg" alt="">
                    <p>architecture<span>0</span></p>
                    <div class="vendu">
                        <span>html</span>
                        <span>css</span>
                        <span>java script</span>
                        <span>html</span>
                    </div>
                    <p id="nom">Nom: Sylivin</p>
                    <a href="#"><i class="fa-solid fa-eye"></i></span>Profil</a>
                </div>
    
                <div class="carousel">
                    <img src="/profils/p5.avif " alt="">
                    <p>disiner<span>0</span></p>
                    <div class="vendu">
                        <span>html</span>
                        <span>css</span>
                        <span>java script</span>
                        <span>html</span>
                        <span>css</span>
                        <span>java script</span>
                    </div>
                    <p id="nom">Nom: nike</p>
                    <a href="#"><i class="fa-solid fa-eye"></i></span>Profil</a>
                </div>
            </article>
        </div>
    </section> -->


    <!-- <section class="produit_vedete">
        <div class="box1">
            <span></span>
            <h1>voir plus d'offre de cette categorie</h1>
            <span></span>
        </div>

        <div class="box2">
            <span><i class="fa-solid fa-chevron-left"></i></span>
            <span><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel1">
            <div class="carousel">
                <img src="/profils/preview_B0eCXi7.jpeg" alt="">
                <p>informaticien de getion des affaires applique <span>1</span></p>
                <div class="vendu">
                    <p>nous recherchons un personnels califier pour povoir nous aider dans </p>
                </div>
                <p id="nom">12 juillet 2023</p>
                <a href="#"><i class="fa-solid fa-eye"></i></span>Profil</a>
            </div>

            <div class="carousel">
                <img src="/profils/p1.jpeg" alt="">
                <p>logistique<span>0</span></p>
                <div class="vendu">
                    <span>html</span>
                    <span>css</span>
                    <span>java script</span>
                    <span>html</span>
                    <span>css</span>
                    <span>java script</span>
                </div>
                <p id="nom">t-shirt hummel</p>
                <a href="#"><i class="fa-solid fa-eye"></i></span>Profil</a>
            </div>

            <div class="carousel">
                <img src="/profils/p2.jpg" alt="">
                <p>agronome<span>o</span></p>
                <div class="vendu">
                    <span>css</span>
                    <span>java script</span>
                    <span>html</span>
                    <span>css</span>
                    <span>java script</span>
                </div>
                <p id="nom">Nom: Sylivin</p>
                <a href="#"><i class="fa-solid fa-eye"></i></span>Profil</a>
            </div>

            <div class="carousel">
                <img src="/profils/p3.jpeg" alt="">
                <p>proffesseur de mathematique<span>0</span></p>
                <div class="vendu">
                    <span>html</span>
                    <span>css</span>
                    <span>html</span>
                    <span>css</span>
                    <span>java script</span>
                </div>
                <p id="nom">Nom: pricil</p>
                <a href="#"><i class="fa-solid fa-eye"></i></span>Profil</a>
            </div>

            <div class="carousel">
                <img src="/profils/p4.jpeg" alt="">
                <p>architecture<span>0</span></p>
                <div class="vendu">
                    <span>html</span>
                    <span>css</span>
                    <span>java script</span>
                    <span>html</span>
                </div>
                <p id="nom">Nom: Sylivin</p>
                <a href="#"><i class="fa-solid fa-eye"></i></span>Profil</a>
            </div>

            <div class="carousel">
                <img src="/profils/p5.avif " alt="">
                <p>disiner<span>0</span></p>
                <div class="vendu">
                    <span>html</span>
                    <span>css</span>
                    <span>java script</span>
                    <span>html</span>
                    <span>css</span>
                    <span>java script</span>
                </div>
                <p id="nom">Nom: nike</p>
                <a href="#"><i class="fa-solid fa-eye"></i></span>Profil</a>
            </div>
        </article>
    </section>

    

    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/owl.carousel.js"></script>
    <script src="../js/owl.animate.js"></script>
    <script src="../js/owl.autoplay.js"></script>
    
    <script>
        $(document).ready(function(){
    // Initialiser le carrousel 1 avec la portée appropriée
    $('.carousel1').owlCarousel({
      items: 4,
      loop: true,
      autoplay: true,
      animateOut: 'slideOutDown',
      animateIn: 'flipInX',
      stagePadding:1,
      smartSpeed:450,
      margin:0,
      nav: true,
      navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
    });
    var carousel1 = $('.carousel1').owlCarousel();
    $('.owl-next').click(function() {
      carousel1.trigger('next.owl.carousel');
    })
    $('.owl-prev').click(function() {
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
    $('.owl-next2').click(function() {
      carousel2.trigger('next.owl.carousel');
    })
    $('.owl-prev2').click(function() {
      carousel2.trigger('prev.owl.carousel');
    })


        });
      </script> -->


    <script src="../script/bootstrap3.4.1.js"></script>
    <script src="../script/summernote@0.8.18.js"></script>
    <script>
        $(document).ready(function () {
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
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        $(document).ready(function () {
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
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });


    </script>

    <script>
        let img1 = document.querySelector('.img1')
        let containe = document.querySelector('.container-b')
        let btn2 = document.querySelector('.btn2')

        img1.addEventListener('click', () => {
            containe.classList.remove('active')
        })
        btn2.addEventListener('click', () => {
            containe.classList.add('active')
        })

    </script>

</body>

</html>