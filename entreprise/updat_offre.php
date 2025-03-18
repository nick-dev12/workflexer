<?php
session_start();

if (!isset($_SESSION['compte_entreprise'])) {
    header('Location: ../connection_compte.php');
    exit();
}

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
    <title>Modification de l'offre d'emploi</title>
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/update_offre.css">

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
                <img src="../upload/<?= $getEntreprise['images'] ?>" alt="Logo <?= $getEntreprise['entreprise'] ?>">
                <h2>Offre d'emploi</h2>
                <p class="company">
                    <?= $getEntreprise['entreprise'] ?>
                </p>

                <button class="toggle-company-info">
                    <i class="fas fa-chevron-down"></i> Informations sur l'entreprise
                </button>

                <div class="company-info-container">
                    <?php if ($afficheDescriptionentreprise): ?>
                        <p class="lien"><a href="<?= $afficheDescriptionentreprise['liens'] ?>" target="_blank">
                                <i class="fas fa-globe"></i> <?= $afficheDescriptionentreprise['liens'] ?>
                            </a></p>
                    <?php else: ?>
                        <p class="lien"><i class="fas fa-info-circle"></i> Aucun lien pour cette entreprise</p>
                    <?php endif; ?>

                    <h4><i class="fas fa-building"></i> Type d'entreprise</h4>
                    <p>
                        <?= $getEntreprise['types'] ?>
                    </p>

                    <h4><i class="fas fa-align-left"></i> Description de l'Entreprise</h4>
                    <?php if ($afficheDescriptionentreprise): ?>
                        <p class="description">
                            <?= $afficheDescriptionentreprise['descriptions'] ?>
                        </p>
                    <?php else: ?>
                        <p class="lien"><i class="fas fa-exclamation-circle"></i> Description indisponible !</p>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($Offres): ?>
                <div class="box3">
                    <h1>Détails de l'offre</h1>
                    <div class="poste-container">
                        <h2><i class="fas fa-briefcase"></i> Poste disponible : <span>
                                <?= $Offres['poste'] ?>
                            </span></h2>

                        <div class="nombre-poste-disponible">
                            <i class="fas fa-users"></i> Nombre de postes disponibles :
                            <span class="count"><?= isset($Offres['place']) ? $Offres['place'] : '1' ?></span>
                        </div>
                    </div>
                </div>


                <div class="box2">
                    <h3><i class="fas fa-tasks"></i> Missions et responsabilités</h3>
                    <?= $Offres['mission'] ?>
                </div>

                <div class="box2">
                    <h3><i class="fas fa-user-graduate"></i> Profil recherché</h3>
                    <p>Qualités et compétences requises:</p>
                    <?= $Offres['profil'] ?>
                </div>

                <div class="box2">
                    <h3><i class="fas fa-info-circle"></i> Informations supplémentaires</h3>
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

                <button class="btn2"><i class="fas fa-edit"></i> Modifier l'offre</button>

            </div>
        <?php endif; ?>


        <div class="container-b">
            <div class="form_off">
                <form method="post" action="">
                    <img class="img1" src="../image/croix.png" alt="Fermer">
                    <div class="box">
                        <label for="poste">Poste disponible</label>
                        <input type="text" name="poste" id="poste" value="<?= $Offres['poste'] ?>"
                            placeholder="Titre du poste">
                    </div>
                    <div class="box">
                        <label for="mission">Décrivez les missions et responsabilités</label>
                        <textarea name="mission" id="mission" cols="30"
                            rows="10"><?= htmlspecialchars_decode($Offres['mission']) ?></textarea>
                    </div>
                    <div class="box">
                        <label for="profil">Décrivez le profil recherché (qualités et compétences)</label>
                        <textarea name="profil" id="profil" cols="30"
                            rows="10"><?= htmlspecialchars_decode($Offres['profil']) ?></textarea>
                    </div>

                    <div class="box">
                        <label for="contrat">Type de contrat</label>
                        <select name="contrat" id="contrat">
                            <option value="<?= $Offres['contrat'] ?>"><?= ucfirst($Offres['contrat']) ?></option>
                            <option value="cdi">CDI</option>
                            <option value="cdd">CDD</option>
                            <option value="interim">Intérim</option>
                            <option value="freelance">Freelance</option>
                            <option value="apprentissage">Apprentissage</option>
                            <option value="stage">Stage</option>
                        </select>
                    </div>

                    <div class="box">
                        <label for="etude">Niveau d'étude requis</label>
                        <select name="etude" id="etude">
                            <option value="<?= $Offres['etudes'] ?>"><?= $Offres['etudes'] ?></option>
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
                        <label for="experience">Niveau d'expérience requis</label>
                        <select name="experience" id="experience">
                            <option value="<?= $Offres['experience'] ?>"><?= $Offres['experience'] ?></option>
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
                        <label for="localite">Région</label>
                        <input type="text" name="localite" id="localite" value="<?= $Offres['localite'] ?>"
                            placeholder="Ex: Île-de-France">
                    </div>
                    <div class="box">
                        <label for="Langues">Langues exigées</label>
                        <input type="text" name="langues" id="Langues" value="<?= $Offres['langues'] ?>"
                            placeholder="Ex: Français, Anglais">
                    </div>

                    <div class="box">
                        <label for="categorie">Secteur d'activité</label>
                        <select id="categorie" name="categorie">
                            <option value="<?= $Offres['categorie'] ?>"><?= $Offres['categorie'] ?></option>
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

                    <input type="submit" name="modifier" value="Enregistrer les modifications" id="valider">
                </form>
            </div>
        </div>

    </section>

    <script src="../script/bootstrap3.4.1.js"></script>
    <script src="../script/summernote@0.8.18.js"></script>
    <script>
        $(document).ready(function () {
            $('#mission').summernote({
                placeholder: 'Décrivez les missions et responsabilités du poste...',
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
                placeholder: 'Décrivez le profil idéal pour ce poste...',
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

        // Gestion de l'affichage du formulaire
        const img1 = document.querySelector('.img1');
        const containe = document.querySelector('.container-b');
        const btn2 = document.querySelector('.btn2');
        const formOff = document.querySelector('.form_off');

        // Fermeture du formulaire
        img1.addEventListener('click', () => {
            containe.classList.remove('active');
        });

        // Ouverture du formulaire
        btn2.addEventListener('click', () => {
            containe.classList.add('active');
        });

        // Fermeture du formulaire en cliquant à l'extérieur
        containe.addEventListener('click', (e) => {
            if (e.target === containe) {
                containe.classList.remove('active');
            }
        });

        // Empêcher la fermeture lorsqu'on clique sur le formulaire
        formOff.addEventListener('click', (e) => {
            e.stopPropagation();
        });

        // Gestion du bouton pour afficher/masquer les informations de l'entreprise
        const toggleCompanyInfoBtn = document.querySelector('.toggle-company-info');
        const companyInfoContainer = document.querySelector('.company-info-container');

        toggleCompanyInfoBtn.addEventListener('click', () => {
            companyInfoContainer.classList.toggle('active');
            toggleCompanyInfoBtn.classList.toggle('active');
        });

        // Animation au défilement pour les éléments de la page
        function animateOnScroll() {
            const elements = document.querySelectorAll('.box2, .box3, .box11');

            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;

                if (elementPosition < screenPosition) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        }

        // Ajouter des styles pour l'animation
        const style = document.createElement('style');
        style.innerHTML = `
            .box2, .box3, .box11 {
                opacity: 0;
                transform: translateY(20px);
                transition: opacity 0.5s ease, transform 0.5s ease;
            }
        `;
        document.head.appendChild(style);

        // Déclencher l'animation au chargement et au défilement
        window.addEventListener('load', animateOnScroll);
        window.addEventListener('scroll', animateOnScroll);
    </script>

</body>

</html>