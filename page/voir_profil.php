<?php
// Démarre la session
session_start();
// Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session



include_once('../controller/controller_users.php');
include_once('../controller/controller_competence_users.php');
include_once('../controller/controller_niveau_etude_experience.php');


if(isset($_POST['recherche'])){

    // Récupération des données du formulaire
    $recherche = $_POST['search'] ;
    $categorie =$_POST['categorie'];
    $experience = $_POST['experience'];
    $etude = $_POST['etude'];

    // Requête SQL pour rechercher dans la base de données en fonction des critères
    $sql = "SELECT u.* FROM users u LEFT JOIN niveau_etude e ON u.id = e.users_id WHERE 1=1";
    if (!empty($recherche)) {
        $sql .= " AND (u.competences LIKE :recherche OR u.nom LIKE :recherche)";
    }else{
        $erreurs= ' Ce champ ne doit pas etre vide !';
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
    <title>Profils</title>
    <link rel="stylesheet" href="/css/slick.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/slick.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/voir_profil.css">
    <link rel="stylesheet" href="/css/owl.theme.default.css">
    <link rel="stylesheet" href="/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/css/animate.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
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
                    <img src="/image/recherche.png" alt="">
                    <img src="/image/profile1.jpg" alt="">
                    <img src="/image/profile2.jpg" alt="">
                </div>
                <div class="text">
                    <h1 data-aos="fade-right" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
                        data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">Exploré les
                        profils qui conviennent à vos besoins</h1>
                    <p data-aos="fade-left" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
                        data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-right">
                        Un large éventail de profiles professionnels toute catégorie confondu pour satisfaire le
                        moindres de vos besoins en main d'œuvre et bien plus encore
                    </p>
                    <form data-aos="fade-left" data-aos-delay="500" data-aos-duration="1000"
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

    <!-- <div class="affiche">
        <img src="/image/webdesign.jpg" alt="">
    </div> -->
    <section class="produit_vedete">
        <div class="box1">
            <span></span>
            <h1>Ingénierie et architecture</h1>
            <span></span>
            <div class="affiche">
                <img src="/image/ingenieur.jpeg" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel1">
            <?php if (empty($Usersingegneur)): ?>

                <h1 class="message">Aucun profil disponible pour cette categorie</h1>

            <?php else: ?>
                <?php foreach ($Usersingegneur as $ingenieurs): ?>
                    <?php
                    $nombreCompetences = countCompetences($db, $ingenieurs['id']);
                    $niveauEtude = gettNiveau($db,$ingenieurs['id']);
                    ?>
                    <?php if ($nombreCompetences < 5): ?>
                    <?php else: ?>
                    <?php if ($ingenieurs['statut'] == 'Occuper'): ?>

                    <?php else: ?>
                        <div class="carousel">

                            <?php if ($ingenieurs['statut'] == 'Disponible'): ?>
                                <p class="statut"><span></span>
                                    <?= $ingenieurs['statut'] ?>
                                </p>
                            <?php else: ?>
                                <?php if ($ingenieurs['statut'] == 'Occuper'): ?>
                                    <p class="statut2"><span></span>
                                        <?= $ingenieurs['statut'] ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <img src="../upload/<?php echo $ingenieurs['images'] ?>" alt="">
                           
                            <div class="info-box">
                            <h4>
                                <?php echo $ingenieurs['competences']; ?>
                            </h4>

                            <div class="vendu">
                                <?php $afficheCompetences = getCompetences($db, $ingenieurs['id']) ?>
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
                                    $fullName = $ingenieurs['nom'];
                                    // Utilisez la fonction explode pour diviser le nom en mots
                                    $words = explode(' ', $fullName);
                                    // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                    $nameUsers = $words[0] . ' ' . $words[1];
                                    ?>
                                <?php echo $nameUsers?>
                            </p>

                            <p class="ville">
                                <?php echo $ingenieurs['ville']; ?>
                            </p>

                            <div class="divpp"></div>
                           <p class="pp"><strong>Niveau :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['etude'] ?>
                                <?php endif; ?>
                            </p>
                            <p class="pp"><strong>Experience :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['experience'] ?>
                                <?php endif; ?>
                            </p>
                            </div>

                            <a href="/page/candidats.php?id=<?php echo $ingenieurs['id']; ?>">
                                <i class="fa-solid fa-eye"></i>Profil
                            </a>
                        </div>

                    <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach ?>
            <?php endif; ?>
        </article>

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

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel3">
            <?php if (empty($UsersRédaction)): ?>

                <h1 class="message">Aucun profil disponible pour cette catégorie</h1>

            <?php else: ?>

                <?php foreach ($UsersRédaction as $Redaction): ?>
                    <?php
                    $nombreCompetences = countCompetences($db, $Redaction['id']);
                    $niveauEtude = gettNiveau($db,$Redaction['id']);
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
                                <?php echo $nameUsers?>
                            </p>

                            <p class="ville">
                                <?php echo $Redaction['ville']; ?>
                            </p>

                            <div class="divpp"></div>
                           <p class="pp"><strong>Niveau :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['etude'] ?>
                                <?php endif; ?>
                            </p>
                            <p class="pp"><strong>Experience :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
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






    <section class="produit_vedete">
        <div class="box1">
            <span></span>
            <h1>Design et création</h1>
            <span></span>
            <div class="affiche">
                <img src="/image/webdesign.jpg" alt="">
            </div>
        </div>

        <div class="box2">
            <span class="owl-prev"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="owl-next"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel2">
            <?php if (empty($UsersDesign)): ?>

                <h1 class="message">Aucun profil disponible pour cette catégorie</h1>

            <?php else: ?>

                <?php foreach ($UsersDesign as $Designs): ?>
                    <?php
                    $nombreCompetences = countCompetences($db, $Designs['id']);
                    $niveauEtude = gettNiveau($db,$Designs['id']);
                    ?>
                    <?php if ($nombreCompetences < 4): ?>
                    <?php else: ?>
                    <?php if ($Designs['statut'] == 'Occuper'): ?>

                    <?php else: ?>
                        <div class="carousel">

                            <?php if ($Designs['statut'] == 'Disponible'): ?>
                                <p class="statut"><span></span>
                                    <?= $Designs['statut'] ?>
                                </p>
                            <?php else: ?>
                                <?php if ($Designs['statut'] == 'Occuper'): ?>
                                    <p class="statut2"><span></span>
                                        <?= $Designs['statut'] ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <img src="../upload/<?php echo $Designs['images'] ?>" alt="">
                           
                            <div class="info-box">
                            <h4>
                                <?php echo $Designs['competences']; ?>
                            </h4>

                            <div class="vendu">
                                <?php $afficheCompetences = getCompetences($db, $Designs['id']) ?>
                                <?php if (empty($afficheCompetences)): ?>
                                    <span>Competences indisponibles</span>
                                <?php else: ?>
                                    <?php
                                    $competencesAffichees = 0; // Initialiser le compteur de compétences affichées
                                    foreach ($afficheCompetences as $compe):
                                        if ($competencesAffichees < 4):
                                            ?>
                                            
                                            <span>
                                                <?php  
                                                echo $compe['competence'];
                                                 ?>
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
                                    $fullName = $Designs['nom'];
                                    // Utilisez la fonction explode pour diviser le nom en mots
                                    $words = explode(' ', $fullName);
                                    // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                    $nameUsers = $words[0] . ' ' . $words[1];
                                    ?>
                                <?php echo $nameUsers?>
                            </p>

                            <p class="ville">
                                <?php echo $Designs['ville']; ?>
                            </p>

                            <div class="divpp"></div>
                           <p class="pp"><strong>Niveau :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['etude'] ?>
                                <?php endif; ?>
                            </p>
                            <p class="pp"><strong>Experience :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['experience'] ?>
                                <?php endif; ?>
                            </p>

                            </div>

                            <a href="/page/candidats.php?id=<?php echo $Designs['id']; ?>">
                                <i class="fa-solid fa-eye"></i>Profil
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php endif;?>
                <?php endforeach ?>



            <?php endif; ?>
        </article>
    </section>



    <section class="produit_vedete">
        <div class="box1">
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

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel4">
            <?php if (empty($Usersmarketing)): ?>

                <h1 class="message">Aucun profil disponible pour cette catégorie</h1>

            <?php else: ?>

                <?php foreach ($Usersmarketing as $marketing): ?>
                    <?php
                    $nombreCompetences = countCompetences($db,  $marketing['id']);
                    $niveauEtude = gettNiveau($db,$marketing['id']);
                    ?>
                    <?php if ($nombreCompetences < 4): ?>
                    <?php else: ?>
                    <?php if ($marketing['statut'] == 'Occuper'): ?>

                    <?php else: ?>

                        <div class="carousel">
                            <?php if ($marketing['statut'] == 'Disponible'): ?>
                                <p class="statut"><span></span>
                                    <?= $marketing['statut'] ?>
                                </p>
                            <?php else: ?>
                                <?php if ($marketing['statut'] == 'Occuper'): ?>
                                    <p class="statut2"><span></span>
                                        <?= $marketing['statut'] ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <img src="../upload/<?php echo $marketing['images'] ?>" alt="">
                           
                            <div class="info-box">
                            <h4>
                                <?php echo $marketing['competences']; ?>
                            </h4>

                            <div class="vendu">
                                <?php $afficheCompetences = getCompetences($db, $marketing['id']) ?>
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
                                    $fullName = $marketing['nom'];
                                    // Utilisez la fonction explode pour diviser le nom en mots
                                    $words = explode(' ', $fullName);
                                    // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                    $nameUsers = $words[0] . ' ' . $words[1];
                                    ?>
                                <?php echo $nameUsers?>
                            </p>

                            <p class="ville">
                                <?php echo $marketing['ville']; ?>
                            </p>

                            <div class="divpp"></div>
                           <p class="pp"><strong>Niveau :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['etude'] ?>
                                <?php endif; ?>
                            </p>
                            <p class="pp"><strong>Experience :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['experience'] ?>
                                <?php endif; ?>
                            </p>

                            </div>

                            <a href="/page/candidats.php?id=<?php echo $marketing['id']; ?>">
                                <i class="fa-solid fa-eye"></i>Profil
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php endif;?>
                <?php endforeach ?>

            <?php endif; ?>
        </article>
    </section>








    <section class="produit_vedete">
        <div class="box1">
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

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel5">
            <?php if (empty($Usersbusiness)): ?>

                <h1 class="message">Aucun profil disponible pour cette catégorie</h1>

            <?php else: ?>

                <?php foreach ($Usersbusiness as $business): ?>
                    <?php
                    $nombreCompetences = countCompetences($db, $business['id']);
                    $niveauEtude = gettNiveau($db,$business['id']);
                    ?>
                    <?php if ($nombreCompetences < 4): ?>
                    <?php else: ?>
                    <?php if ($business['statut'] == 'Occuper' ) : ?>

                    <?php else: ?>

                        <div class="carousel">
                            <?php if ($business['statut'] == 'Disponible'): ?>
                                <p class="statut"><span></span>
                                    <?= $business['statut'] ?>
                                </p>
                            <?php else: ?>
                                <?php if ($business['statut'] == 'Occuper'): ?>
                                    <p class="statut2"><span></span>
                                        <?= $business['statut'] ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>
                            <img src="../upload/<?php echo $business['images'] ?>" alt="">

                           <div class="info-box">
                           <h4>
                                <?php echo $business['competences']; ?>
                            </h4>



                            <div class="vendu">
                                <?php $afficheCompetences = getCompetences($db, $business['id']) ?>
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
                                    $fullName = $business['nom'];
                                    // Utilisez la fonction explode pour diviser le nom en mots
                                    $words = explode(' ', $fullName);
                                    // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                    $nameUsers = $words[0] . ' '. $words[1] ;
                                    ?>
                                <?php echo $nameUsers?>
                            </p>

                            <p class="ville">
                                <?php echo $business['ville']; ?>
                            </p> 

                           <div class="divpp"></div>
                           <p class="pp"><strong>Niveau :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['etude'] ?>
                                <?php endif; ?>
                            </p>
                            <p class="pp"><strong>Experience :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['experience'] ?>
                                <?php endif; ?>
                            </p>
                           </div>
                           
                            <a href="/page/candidats.php?id=<?php echo $business['id']; ?>">
                                <i class="fa-solid fa-eye"></i>Profil
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php endif;?>
                <?php endforeach ?>

            <?php endif; ?>
        </article>
    </section>










    <section class="produit_vedete">
        <div class="box1">
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

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel6">
            <?php if (empty($UsersJuridique)): ?>

                <h1 class="message">Aucun profil disponible pour cette catégorie</h1>

            <?php else: ?>

                <?php foreach ($UsersJuridique as $Juridique): ?>
                    <?php
                    $nombreCompetences = countCompetences($db, $Juridique['id']);
                    $niveauEtude = gettNiveau($db,$Juridique['id']);
                    ?>
                    <?php if ($nombreCompetences < 5): ?>
                    <?php else: ?>
                        <?php if ($Juridique['statut'] == 'Occuper'): ?>

                        <?php else: ?>

                            <div class="carousel">
                                <?php if ($Juridique['statut'] == 'Disponible'): ?>
                                    <p class="statut"><span></span>
                                        <?= $Juridique['statut'] ?>
                                    </p>
                                <?php else: ?>
                                    <?php if ($Juridique['statut'] == 'Occuper'): ?>
                                        <p class="statut2"><span></span>
                                            <?= $Juridique['statut'] ?>
                                        </p>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <img src="../upload/<?php echo $Juridique['images'] ?>" alt="">
                                
                               <div class="info-box">
                               <h4>
                                    <?php echo $Juridique['competences']; ?>
                                </h4>

                                <div class="vendu">
                                    <?php $afficheCompetences = getCompetences($db, $Juridique['id']);
                                    $nombreCompetencesAffichees = 5;
                                    ?>
                                    <?php if (empty($afficheCompetences)): ?>
                                        <span>Competences indisponibles</span>
                                    <?php else: ?>
                                        <?php foreach ($afficheCompetences as $key => $compe):
                                            if ($key < $nombreCompetencesAffichees):
                                                ?>
                                                <span>
                                                    <?= $compe['competence'] ?>
                                                </span>
                                                <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    <?php endif; ?>
                                </div>
                                <p class="nom">
                                    <?php
                                    $fullName = $Juridique['nom'];
                                    // Utilisez la fonction explode pour diviser le nom en mots
                                    $words = explode(' ', $fullName);
                                    // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                    $nameUsers = $words[0] . ' ' . $words[1];
                                    ?>
                                    <?php echo $nameUsers; ?>
                                </p>
                                <p class="ville">
                                    <?php echo $Juridique['ville']; ?>
                                </p>

                                <div class="divpp"></div>
                           <p class="pp"><strong>Niveau :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['etude'] ?>
                                <?php endif; ?>
                            </p>
                            <p class="pp"><strong>Experience :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['experience'] ?>
                                <?php endif; ?>
                            </p>
                           </div>

                               

                                <a href="/page/candidats.php?id=<?php echo $Juridique['id']; ?>">
                                    <i class="fa-solid fa-eye"></i>Profil
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach ?>

            <?php endif; ?>

        </article>
    </section>









    <section class="produit_vedete">
        <div class="box1">
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

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel7">
            <?php if (empty($UsersInformatique)): ?>

                <h1 class="message">Aucun profil disponible pour cette catégorie</h1>

            <?php else: ?>

                <?php foreach ($UsersInformatique as $Informatique): ?>
                    <?php
                    $nombreCompetences = countCompetences($db, $Informatique['id']);
                    $niveauEtude = gettNiveau($db,$Informatique['id']);
                    ?>
                    <?php if ($nombreCompetences < 5): ?>
                    <?php else: ?>
                    <?php if ($Informatique['statut'] == 'Occuper'): ?>

                    <?php else: ?>

                        <div class="carousel">
                            <?php if ($Informatique['statut'] == 'Disponible'): ?>
                                <p class="statut"><span></span>
                                    <?= $Informatique['statut'] ?>
                                </p>
                            <?php else: ?>
                                <?php if ($Informatique['statut'] == 'Occuper'): ?>
                                    <p class="statut2"><span></span>
                                        <?= $Informatique['statut'] ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <img src="../upload/<?php echo $Informatique['images'] ?>" alt="">
                           
                            <div class="info-box">
                            <h4>
                                <?php echo $Informatique['competences']; ?>
                            </h4>

                            <div class="vendu">
                                <?php
                                $afficheCompetences = getCompetences($db, $Informatique['id']);
                                // Garder seulement les 4 premières 
                                $afficheCompetences = array_slice($afficheCompetences, 0, 4);

                                ?>

                                <?php if (empty($afficheCompetences)): ?>
                                    <span>Competences indisponibles</span>
                                <?php else: ?>
                                    <?php
                                    $competencesAffichees = 0; // Initialiser le compteur de compétences affichées
                    
                                    foreach ($afficheCompetences as $compe):
                                        if ($competencesAffichees < 5):
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
                                    $fullName = $Informatique['nom'];
                                    // Utilisez la fonction explode pour diviser le nom en mots
                                    $words = explode(' ', $fullName);
                                    // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                    $nameUsers = $words[0] . ' '. $words[1] ;
                                    ?>
                                    <?php echo $nameUsers; ?>
                            </p>

                            <p class="ville">
                                <?php echo $Informatique['ville']; ?>
                            </p>

                            <div class="divpp"></div>
                           <p class="pp"><strong>Niveau :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['etude'] ?>
                                <?php endif; ?>
                            </p>
                            <p class="pp"><strong>Experience :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['experience'] ?>
                                <?php endif; ?>
                            </p>
                            </div>

                            <a href="/page/candidats.php?id=<?php echo $Informatique['id']; ?>">
                                <i class="fa-solid fa-eye"></i>Profil
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach ?>

            <?php endif; ?>
        </article>
    </section>





    <section class="produit_vedete">
        <div class="box1">
            <span></span>
            <h1>Finance et comptabilité</h1>
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

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel7">

                <?php foreach ($getUssersCategorie as $teste): ?>
                    <?php if($teste['categorie'] === 'Finance et comptabilité'):?>
                        <?php if(empty($teste['categorie'] === 'Finance et comptabilité')) :?>
                             <h1 class="message">Aucun profil disponible pour cette catégorie</h1>
                            <?php else: ?>
                    <?php
                    $nombreCompetences = countCompetences($db, $teste['id']);
                    $niveauEtude = gettNiveau($db,$teste['id']);
                    ?>
                    <?php if ($nombreCompetences < 4): ?>
                    <?php else: ?>
                    <?php if ($teste['statut'] == 'Occuper'): ?>

                    <?php else: ?>

                        <div class="carousel">
                            <?php if ($teste['statut'] == 'Disponible'): ?>
                                <p class="statut"><span></span>
                                    <?= $teste['statut'] ?>
                                </p>
                            <?php else: ?>
                                <?php if ($teste['statut'] == 'Occuper'): ?>
                                    <p class="statut2"><span></span>
                                        <?= $teste['statut'] ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <img src="../upload/<?php echo $teste['images'] ?>" alt="">
                           
                            <div class="info-box">
                            <h4>
                                <?php echo $teste['competences']; ?>
                            </h4>

                            <div class="vendu">
                                <?php
                                $afficheCompetences = getCompetences($db, $teste['id']);
                                // Garder seulement les 4 premières 
                                $afficheCompetences = array_slice($afficheCompetences, 0, 4);

                                ?>

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
                                    $fullName = $teste['nom'];
                                    // Utilisez la fonction explode pour diviser le nom en mots
                                    $words = explode(' ', $fullName);
                                    // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                    $nameUsers = $words[0] . ' '. $words[1] ;
                                    ?>
                                    <?php echo $nameUsers; ?>
                            </p>

                            <p class="ville">
                                <?php echo $teste['ville']; ?>
                            </p>

                            <div class="divpp"></div>
                           <p class="pp"><strong>Niveau :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['etude'] ?>
                                <?php endif; ?>
                            </p>
                            <p class="pp"><strong>Experience :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['experience'] ?>
                                <?php endif; ?>
                            </p>
                            </div>

                            <a href="/page/candidats.php?id=<?php echo $teste['id']; ?>">
                                <i class="fa-solid fa-eye"></i>Profil
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach ?>
           
        </article>
    </section>






    <section class="produit_vedete">
        <div class="box1">
            <span></span>
            <h1>Santé et bien-être</h1>
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

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel7">

                <?php foreach ($getUssersCategorie as $teste): ?>
                    <?php if($teste['categorie'] === 'Santé et bien-être'):?>
                        <?php if(empty($teste['categorie'] === 'Santé et bien-être')) :?>
                             <h1 class="message">Aucun profil disponible pour cette catégorie</h1>
                            <?php else: ?>
                    <?php
                    $nombreCompetences = countCompetences($db, $teste['id']);
                    $niveauEtude = gettNiveau($db,$teste['id']);
                    ?>
                    <?php if ($nombreCompetences < 4): ?>
                    <?php else: ?>
                    <?php if ($teste['statut'] == 'Occuper'): ?>

                    <?php else: ?>

                        <div class="carousel">
                            <?php if ($teste['statut'] == 'Disponible'): ?>
                                <p class="statut"><span></span>
                                    <?= $teste['statut'] ?>
                                </p>
                            <?php else: ?>
                                <?php if ($teste['statut'] == 'Occuper'): ?>
                                    <p class="statut2"><span></span>
                                        <?= $teste['statut'] ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <img src="../upload/<?php echo $teste['images'] ?>" alt="">
                           
                            <div class="info-box">
                            <h4>
                                <?php echo $teste['competences']; ?>
                            </h4>

                            <div class="vendu">
                                <?php
                                $afficheCompetences = getCompetences($db, $teste['id']);
                                // Garder seulement les 4 premières 
                                $afficheCompetences = array_slice($afficheCompetences, 0, 4);

                                ?>

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
                                    $fullName = $teste['nom'];
                                    // Utilisez la fonction explode pour diviser le nom en mots
                                    $words = explode(' ', $fullName);
                                    // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                    $nameUsers = $words[0] . ' '. $words[1] ;
                                    ?>
                                    <?php echo $nameUsers; ?>
                            </p>

                            <p class="ville">
                                <?php echo $teste['ville']; ?>
                            </p>

                            <div class="divpp"></div>
                           <p class="pp"><strong>Niveau :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['etude'] ?>
                                <?php endif; ?>
                            </p>
                            <p class="pp"><strong>Experience :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['experience'] ?>
                                <?php endif; ?>
                            </p>
                            </div>

                            <a href="/page/candidats.php?id=<?php echo $teste['id']; ?>">
                                <i class="fa-solid fa-eye"></i>Profil
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach ?>
           
        </article>
    </section>





    <section class="produit_vedete">
        <div class="box1">
            <span></span>
            <h1>Éducation et formation</h1>
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

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel7">

                <?php foreach ($getUssersCategorie as $teste): ?>
                    <?php if($teste['categorie'] === 'Éducation et formation'):?>
                        <?php if(empty($teste['categorie'] === 'Éducation et formation')) :?>
                             <h1 class="message">Aucun profil disponible pour cette catégorie</h1>
                            <?php else: ?>
                    <?php
                    $nombreCompetences = countCompetences($db, $teste['id']);
                    $niveauEtude = gettNiveau($db,$teste['id']);
                    ?>
                    <?php if ($nombreCompetences < 4): ?>
                    <?php else: ?>
                    <?php if ($teste['statut'] == 'Occuper'): ?>

                    <?php else: ?>

                        <div class="carousel">
                            <?php if ($teste['statut'] == 'Disponible'): ?>
                                <p class="statut"><span></span>
                                    <?= $teste['statut'] ?>
                                </p>
                            <?php else: ?>
                                <?php if ($teste['statut'] == 'Occuper'): ?>
                                    <p class="statut2"><span></span>
                                        <?= $teste['statut'] ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <img src="../upload/<?php echo $teste['images'] ?>" alt="">
                           
                            <div class="info-box">
                            <h4>
                                <?php echo $teste['competences']; ?>
                            </h4>

                            <div class="vendu">
                                <?php
                                $afficheCompetences = getCompetences($db, $teste['id']);
                                // Garder seulement les 4 premières 
                                $afficheCompetences = array_slice($afficheCompetences, 0, 4);

                                ?>

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
                                    $fullName = $teste['nom'];
                                    // Utilisez la fonction explode pour diviser le nom en mots
                                    $words = explode(' ', $fullName);
                                    // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                    $nameUsers = $words[0] . ' '. $words[1] ;
                                    ?>
                                    <?php echo $nameUsers; ?>
                            </p>

                            <p class="ville">
                                <?php echo $teste['ville']; ?>
                            </p>

                            <div class="divpp"></div>
                           <p class="pp"><strong>Niveau :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['etude'] ?>
                                <?php endif; ?>
                            </p>
                            <p class="pp"><strong>Experience :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['experience'] ?>
                                <?php endif; ?>
                            </p>
                            </div>

                            <a href="/page/candidats.php?id=<?php echo $teste['id']; ?>">
                                <i class="fa-solid fa-eye"></i>Profil
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach ?>
           
        </article>
    </section>






    <section class="produit_vedete">
        <div class="box1">
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

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel7">

                <?php foreach ($getUssersCategorie as $teste): ?>
                    <?php if($teste['categorie'] === 'Tourisme et hôtellerie'):?>
                        <?php if(empty($teste['categorie'] === 'Tourisme et hôtellerie')) :?>
                             <h1 class="message">Aucun profil disponible pour cette catégorie</h1>
                            <?php else: ?>
                    <?php
                    $nombreCompetences = countCompetences($db, $teste['id']);
                    $niveauEtude = gettNiveau($db,$teste['id']);
                    ?>
                    <?php if ($nombreCompetences < 4): ?>
                    <?php else: ?>
                    <?php if ($teste['statut'] == 'Occuper'): ?>

                    <?php else: ?>

                        <div class="carousel">
                            <?php if ($teste['statut'] == 'Disponible'): ?>
                                <p class="statut"><span></span>
                                    <?= $teste['statut'] ?>
                                </p>
                            <?php else: ?>
                                <?php if ($teste['statut'] == 'Occuper'): ?>
                                    <p class="statut2"><span></span>
                                        <?= $teste['statut'] ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <img src="../upload/<?php echo $teste['images'] ?>" alt="">
                           
                            <div class="info-box">
                            <h4>
                                <?php echo $teste['competences']; ?>
                            </h4>

                            <div class="vendu">
                                <?php
                                $afficheCompetences = getCompetences($db, $teste['id']);
                                // Garder seulement les 4 premières 
                                $afficheCompetences = array_slice($afficheCompetences, 0, 4);

                                ?>

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
                                    $fullName = $teste['nom'];
                                    // Utilisez la fonction explode pour diviser le nom en mots
                                    $words = explode(' ', $fullName);
                                    // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                    $nameUsers = $words[0] . ' '. $words[1] ;
                                    ?>
                                    <?php echo $nameUsers; ?>
                            </p>

                            <p class="ville">
                                <?php echo $teste['ville']; ?>
                            </p>

                            <div class="divpp"></div>
                           <p class="pp"><strong>Niveau :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['etude'] ?>
                                <?php endif; ?>
                            </p>
                            <p class="pp"><strong>Experience :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['experience'] ?>
                                <?php endif; ?>
                            </p>
                            </div>

                            <a href="/page/candidats.php?id=<?php echo $teste['id']; ?>">
                                <i class="fa-solid fa-eye"></i>Profil
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach ?>
           
        </article>
    </section>







    <section class="produit_vedete">
        <div class="box1">
            <span></span>
            <h1>Commerce et vente</h1>
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

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel7">

                <?php foreach ($getUssersCategorie as $teste): ?>
                    <?php if($teste['categorie'] === 'Commerce et vente'):?>
                        <?php if(empty($teste['categorie'] === 'Commerce et vente')) :?>
                             <h1 class="message">Aucun profil disponible pour cette catégorie</h1>
                            <?php else: ?>
                    <?php
                    $nombreCompetences = countCompetences($db, $teste['id']);
                    $niveauEtude = gettNiveau($db,$teste['id']);
                    ?>
                    <?php if ($nombreCompetences < 4): ?>
                    <?php else: ?>
                    <?php if ($teste['statut'] == 'Occuper'): ?>

                    <?php else: ?>

                        <div class="carousel">
                            <?php if ($teste['statut'] == 'Disponible'): ?>
                                <p class="statut"><span></span>
                                    <?= $teste['statut'] ?>
                                </p>
                            <?php else: ?>
                                <?php if ($teste['statut'] == 'Occuper'): ?>
                                    <p class="statut2"><span></span>
                                        <?= $teste['statut'] ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <img src="../upload/<?php echo $teste['images'] ?>" alt="">
                           
                            <div class="info-box">
                            <h4>
                                <?php echo $teste['competences']; ?>
                            </h4>

                            <div class="vendu">
                                <?php
                                $afficheCompetences = getCompetences($db, $teste['id']);
                                // Garder seulement les 4 premières 
                                $afficheCompetences = array_slice($afficheCompetences, 0, 4);

                                ?>

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
                                    $fullName = $teste['nom'];
                                    // Utilisez la fonction explode pour diviser le nom en mots
                                    $words = explode(' ', $fullName);
                                    // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                    $nameUsers = $words[0] . ' '. $words[1] ;
                                    ?>
                                    <?php echo $nameUsers; ?>
                            </p>

                            <p class="ville">
                                <?php echo $teste['ville']; ?>
                            </p>

                            <div class="divpp"></div>
                           <p class="pp"><strong>Niveau :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['etude'] ?>
                                <?php endif; ?>
                            </p>
                            <p class="pp"><strong>Experience :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['experience'] ?>
                                <?php endif; ?>
                            </p>
                            </div>

                            <a href="/page/candidats.php?id=<?php echo $teste['id']; ?>">
                                <i class="fa-solid fa-eye"></i>Profil
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach ?>
           
        </article>
    </section>






    <section class="produit_vedete">
        <div class="box1">
            <span></span>
            <h1>Transport et logistique</h1>
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

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel7">

                <?php foreach ($getUssersCategorie as $teste): ?>
                    <?php if($teste['categorie'] === 'Transport et logistique'):?>
                        <?php if(empty($teste['categorie'] === 'Transport et logistique')) :?>
                             <h1 class="message">Aucun profil disponible pour cette catégorie</h1>
                            <?php else: ?>
                    <?php
                    $nombreCompetences = countCompetences($db, $teste['id']);
                    $niveauEtude = gettNiveau($db,$teste['id']);
                    ?>
                    <?php if ($nombreCompetences < 4): ?>
                    <?php else: ?>
                    <?php if ($teste['statut'] == 'Occuper'): ?>

                    <?php else: ?>

                        <div class="carousel">
                            <?php if ($teste['statut'] == 'Disponible'): ?>
                                <p class="statut"><span></span>
                                    <?= $teste['statut'] ?>
                                </p>
                            <?php else: ?>
                                <?php if ($teste['statut'] == 'Occuper'): ?>
                                    <p class="statut2"><span></span>
                                        <?= $teste['statut'] ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <img src="../upload/<?php echo $teste['images'] ?>" alt="">
                           
                            <div class="info-box">
                            <h4>
                                <?php echo $teste['competences']; ?>
                            </h4>

                            <div class="vendu">
                                <?php
                                $afficheCompetences = getCompetences($db, $teste['id']);
                                // Garder seulement les 4 premières 
                                $afficheCompetences = array_slice($afficheCompetences, 0, 4);

                                ?>

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
                                    $fullName = $teste['nom'];
                                    // Utilisez la fonction explode pour diviser le nom en mots
                                    $words = explode(' ', $fullName);
                                    // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                    $nameUsers = $words[0] . ' '. $words[1] ;
                                    ?>
                                    <?php echo $nameUsers; ?>
                            </p>

                            <p class="ville">
                                <?php echo $teste['ville']; ?>
                            </p>

                            <div class="divpp"></div>
                           <p class="pp"><strong>Niveau :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['etude'] ?>
                                <?php endif; ?>
                            </p>
                            <p class="pp"><strong>Experience :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['experience'] ?>
                                <?php endif; ?>
                            </p>
                            </div>

                            <a href="/page/candidats.php?id=<?php echo $teste['id']; ?>">
                                <i class="fa-solid fa-eye"></i>Profil
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach ?>
           
        </article>
    </section>





    <section class="produit_vedete">
        <div class="box1">
            <span></span>
            <h1>Agriculture et agroalimentaire</h1>
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

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel7">

                <?php foreach ($getUssersCategorie as $teste): ?>
                    <?php if($teste['categorie'] === 'Agriculture et agroalimentaire'):?>
                        <?php if(empty($teste['categorie'] === 'Agriculture et agroalimentaire')) :?>
                             <h1 class="message">Aucun profil disponible pour cette catégorie</h1>
                            <?php else: ?>
                    <?php
                    $nombreCompetences = countCompetences($db, $teste['id']);
                    $niveauEtude = gettNiveau($db,$teste['id']);
                    ?>
                    <?php if ($nombreCompetences < 4): ?>
                    <?php else: ?>
                    <?php if ($teste['statut'] == 'Occuper'): ?>

                    <?php else: ?>

                        <div class="carousel">
                            <?php if ($teste['statut'] == 'Disponible'): ?>
                                <p class="statut"><span></span>
                                    <?= $teste['statut'] ?>
                                </p>
                            <?php else: ?>
                                <?php if ($teste['statut'] == 'Occuper'): ?>
                                    <p class="statut2"><span></span>
                                        <?= $teste['statut'] ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <img src="../upload/<?php echo $teste['images'] ?>" alt="">
                           
                            <div class="info-box">
                            <h4>
                                <?php echo $teste['competences']; ?>
                            </h4>

                            <div class="vendu">
                                <?php
                                $afficheCompetences = getCompetences($db, $teste['id']);
                                // Garder seulement les 4 premières 
                                $afficheCompetences = array_slice($afficheCompetences, 0, 4);

                                ?>

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
                                    $fullName = $teste['nom'];
                                    // Utilisez la fonction explode pour diviser le nom en mots
                                    $words = explode(' ', $fullName);
                                    // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                    $nameUsers = $words[0] . ' '. $words[1] ;
                                    ?>
                                    <?php echo $nameUsers; ?>
                            </p>

                            <p class="ville">
                                <?php echo $teste['ville']; ?>
                            </p>

                            <div class="divpp"></div>
                           <p class="pp"><strong>Niveau :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['etude'] ?>
                                <?php endif; ?>
                            </p>
                            <p class="pp"><strong>Experience :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['experience'] ?>
                                <?php endif; ?>
                            </p>
                            </div>

                            <a href="/page/candidats.php?id=<?php echo $teste['id']; ?>">
                                <i class="fa-solid fa-eye"></i>Profil
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach ?>
           
        </article>
    </section>






    <section class="produit_vedete">
        <div class="box1">
            <span></span>
            <h1>Autre</h1>
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

        <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
            class="articles owl-carousel carousel7">

                <?php foreach ($getUssersCategorie as $teste): ?>
                    <?php if($teste['categorie'] === 'Autre'):?>
                        <?php if(empty($teste['categorie'] === 'Autre')) :?>
                             <h1 class="message">Aucun profil disponible pour cette catégorie</h1>
                            <?php else: ?>
                    <?php
                    $nombreCompetences = countCompetences($db, $teste['id']);
                    $niveauEtude = gettNiveau($db,$teste['id']);
                    ?>
                    <?php if ($nombreCompetences < 4): ?>
                    <?php else: ?>
                    <?php if ($teste['statut'] == 'Occuper'): ?>

                    <?php else: ?>

                        <div class="carousel">
                            <?php if ($teste['statut'] == 'Disponible'): ?>
                                <p class="statut"><span></span>
                                    <?= $teste['statut'] ?>
                                </p>
                            <?php else: ?>
                                <?php if ($teste['statut'] == 'Occuper'): ?>
                                    <p class="statut2"><span></span>
                                        <?= $teste['statut'] ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <img src="../upload/<?php echo $teste['images'] ?>" alt="">
                           
                            <div class="info-box">
                            <h4>
                                <?php echo $teste['competences']; ?>
                            </h4>

                            <div class="vendu">
                                <?php
                                $afficheCompetences = getCompetences($db, $teste['id']);
                                // Garder seulement les 4 premières 
                                $afficheCompetences = array_slice($afficheCompetences, 0, 4);

                                ?>

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
                                    $fullName = $teste['nom'];
                                    // Utilisez la fonction explode pour diviser le nom en mots
                                    $words = explode(' ', $fullName);
                                    // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                    $nameUsers = $words[0] . ' '. $words[1] ;
                                    ?>
                                    <?php echo $nameUsers; ?>
                            </p>

                            <p class="ville">
                                <?php echo $teste['ville']; ?>
                            </p>

                            <div class="divpp"></div>
                           <p class="pp"><strong>Niveau :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['etude'] ?>
                                <?php endif; ?>
                            </p>
                            <p class="pp"><strong>Experience :</strong>
                            <?php if(empty($niveauEtude['etude'])) :?>
                                indisponibles
                            <?php else :?>
                                <?php echo $niveauEtude['experience'] ?>
                                <?php endif; ?>
                            </p>
                            </div>

                            <a href="/page/candidats.php?id=<?php echo $teste['id']; ?>">
                                <i class="fa-solid fa-eye"></i>Profil
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach ?>
           
        </article>
    </section>

    <?php include('../footer.php') ?>






    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="/js/owl.carousel.min.js"></script>
    <script src="/js/owl.carousel.js"></script>
    <script src="/js/owl.animate.js"></script>
    <script src="/js/owl.autoplay.js"></script>
    <script src="/js/silder_offres.js"></script>




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