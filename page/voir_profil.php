<?php
// Démarre la session
session_start();
// Récupérez l'ID du commerçant à partir de la session
// Récupérez l'ID de l'utilisateur depuis la variable de session



include_once('../controller/controller_users.php');
include_once('../controller/controller_competence_users.php');
include_once('../controller/controller_niveau_etude_experience.php');


$totalUsers = getTotalUsers($db);

// Pagination
$profils_par_page = 20;
$page_courante = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page_courante - 1) * $profils_par_page;

// Récupérer le nombre total de profils
$total_profils = getTotalUsersCount($db);
$total_pages = ceil($total_profils / $profils_par_page);

// Récupérer les profils pour la page courante
$totalUsers = getTotalUsers($db, $offset, $profils_par_page);


if (isset($_POST['recherche'])) {

    // Récupération des données du formulaire
    $recherche = htmlspecialchars($_POST['search']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $experience = htmlspecialchars($_POST['experience']);
    $etude = htmlspecialchars($_POST['etude']);

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
    <meta name="description"
        content="Découvrez les profils de professionnels qualifiés sur Work-Flexer. Des experts en informatique, design, marketing, ingénierie et bien d'autres domaines. Trouvez le talent idéal pour vos projets avec notre système de recherche avancé. Recrutement simplifié et profils vérifiés.">

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
    <title>Explorez les profils</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script defer src="https://unpkg.com/aos@next/dist/aos.js"></script>
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
                    <h1>Explorez les
                        profils qui conviennent à vos besoins</h1>
                    <p>
                        Un large éventail de profils professionnels, toutes catégories confondues, pour satisfaire le
                        moindre de vos besoins en main-d'œuvre et bien plus encore.
                    </p>

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


    <section class="emploi">
        <div class="box" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
            <img src="/image/ingenieur.jpeg" alt="">
            <a href="../profils/Ingénierie et architecture.php">Ingénierie et architecture</a>
        </div>



        <div class="box" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
            <img src="/image/webdesign.jpg" alt="">
            <a href="../profils/Design et création.php">Design et création</a>
        </div>



        <div class="box" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
            <img src="/image/Redaction.jpg" alt="">
            <a href="../profils/Rédaction et traduction.php">Rédaction et traduction</a>
        </div>


        <div class="box" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
            <img src="/image/marketing.jpg" alt="">
            <a href="../profils/Marketing et communication.php">Marketing et communication</a>
        </div>


        <div class="box" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
            <img src="/image/gestion.png" alt="">
            <a href="../profils/Conseil et gestion d'entreprise.php">Conseil et gestion d'entreprise</a>
        </div>




        <div class="box" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
            <img src="/image/juridique.jpg" alt="">
            <a href="../profils/Juridique.php">Juridique</a>
        </div>


        <div class="box" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
            <img src="/image/info.jpg" alt="">
            <a href="../profils/Informatique et tech.php">Informatique et tech</a>
        </div>


        <div class="box" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
            <img src="/image/finance.png" alt="">
            <a href="../profils/Finance et comptabilité.php">Finance et comptabilité</a>
        </div>


        <div class="box" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
            <img src="/image/santé.png" alt="">
            <a href="../profils/Santé et bien-être.php">Santé et bien-être</a>
        </div>


        <div class="box" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
            <img src="/image/education.png" alt="">
            <a href="../profils/Éducation et formation.php">Éducation et formation</a>
        </div>


        <div class="box" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
            <img src="/image/tourisme.png" alt="">

            <a href="../profils/Tourisme et hôtellerie.php">Tourisme et hôtellerie</a>
        </div>




        <div class="box" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
            <img src="/image/vente.png" alt="">
            <a href="../profils/Commerce et vente.php">Commerce et vente</a>
        </div>


        <div class="box" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
            <img src="/image/transport.png" alt="">
            <a href="../profils/Transport et logistique.php">Transport et logistique</a>
        </div>


        <div class="box" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
            <img src="/image/agriculture.png" alt="">
            <a href="../profils/Agriculture et agroalimentaire.php">Agriculture et agroalimentaire</a>
        </div>


        <div class="box" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
            data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom">
            <img src="/image/autre.png" alt="">
            <a href="../profils/Autre.php">Autre</a>
        </div>
    </section>


    <section class="tous_profil">
        <div class="container_box1">
            <div class="texte">
                <h1>
                    Tous les profils
                </h1>
            </div>


            <div class="produit_vedete">

                <article data-aos="fade-up" data-aos-delay="0" data-aos-duration="400" data-aos-easing="ease-in-out"
                    data-aos-mirror="true" data-aos-once="false" data-aos-anchor-placement="top-bottom"
                    class="articles ">
                    <?php if (empty($totalUsers)): ?>

                        <h1 class="message">Aucun profil disponible pour cette catégorie</h1>

                    <?php else: ?>
                        <?php foreach ($totalUsers as $users): ?>
                            <?php
                            $nombreCompetences = countCompetences($db, $users['id']);
                            $niveauEtude = gettNiveau($db, $users['id']);
                            ?>
                            <?php if ($nombreCompetences < 4): ?>
                            <?php else: ?>
                                <?php if ($users['statut'] == 'Occuper'): ?>

                                <?php else: ?>

                                    <div class="carousel">
                                        <?php if ($users['statut'] == 'Disponible'): ?>
                                            <p class="statut"><span></span>
                                                <?= $users['statut'] ?>
                                            </p>
                                        <?php else: ?>
                                            <?php if ($users['statut'] == 'Occuper'): ?>
                                                <p class="statut2"><span></span>
                                                    <?= $users['statut'] ?>
                                                </p>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <img src="../upload/<?php echo $users['images'] ?>" alt="">

                                        <div class="info-box">
                                            <h4>
                                                <?php echo substr($users['competences'], 0, 40) . '...' ?>
                                            </h4>

                                            <div class="vendu">
                                                <?php
                                                $afficheCompetences = getCompetences($db, $users['id']);
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
                                                                <?= substr($compe['competence'], 0, 20) . '...' ?>
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
                                                $fullName = $users['nom'];
                                                // Utilisez la fonction explode pour diviser le nom en mots
                                                $words = explode(' ', $fullName);
                                                // $words[0] contient le premier mot, $words[1] contient le deuxième mot
                                                $nameUsers = $words[0] . ' ' . $words[1];
                                                ?>
                                                <?php echo $nameUsers; ?>
                                            </p>

                                            <p class="ville">
                                                <?php echo $users['ville']; ?>
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

                                        <a href="/page/candidats.php?id=<?php echo $users['id']; ?>">
                                            <i class="fa-solid fa-eye"></i>Profil
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach ?>

                    <?php endif; ?>
                </article>

                <!-- Ajout de la pagination -->
                <div class="pagination">
                    <?php if ($total_pages > 1): ?>
                        <?php if ($page_courante > 1): ?>
                            <a href="?page=<?php echo $page_courante - 1; ?>" class="page-link">&laquo; Précédent</a>
                        <?php endif; ?>

                        <?php for ($i = max(1, $page_courante - 2); $i <= min($total_pages, $page_courante + 2); $i++): ?>
                            <?php if ($i == $page_courante): ?>
                                <span class="page-link active"><?php echo $i; ?></span>
                            <?php else: ?>
                                <a href="?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($page_courante < $total_pages): ?>
                            <a href="?page=<?php echo $page_courante + 1; ?>" class="page-link">Suivant &raquo;</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>




    <?php include('../footer.php') ?>






    <script src="/js/silder_offres.js"></script>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>




</body>

</html>