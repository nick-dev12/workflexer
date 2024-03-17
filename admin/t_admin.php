<?php
session_start();
// Inclusion du fichier de connexion à la BDD
include '../conn/conn.php';

include '../entreprise/app/controller/controllerEntreprise.php';
include '../entreprise/app/controller/controllerOffre_emploi.php';
include('../controller/controller_admin.php');


if (empty($_SESSION['admin'])) {
    header('Location:../index.php');
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>
    <?php include('../include/header_admin.php') ?>

    <section class="section3">
        <h1>
            Entreprises enregistrer
        </h1>

        <form action="#">
            <div class="input-group">
                <input type="search" class="form-control" placeholder="Rechercher une entreprise">
                <label for="recherche"><img src="../image/recherche-.png" alt=""></label>
                <input id="recherche" type="submit" value="">
            </div>
        </form>

        <h3>

            Totale Entreprises <span>
                <?php if ($getAllentreprise): ?>
                    <?php $totale_entreprise = count($getAllentreprise);
                    echo $totale_entreprise;
                    ?>
                <?php else: ?>
                    0
                <?php endif; ?>
            </span>
        </h3>

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Nom de l'entreprise</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Taille</th>
                    <th>Ville</th>
                    <th>Catégorie</th>
                    <th>Offres</th>
                    <th>Voire</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($getAllentreprise): ?>
                    <?php foreach ($getAllentreprise as $entreprise): ?>
                        <?php $count = getOffresEmplois($db, $entreprise['id']);
                        $afficheCount = count($count);
                        ?>
                        <tr>
                            <td>
                                <?= $entreprise['nom'] ?>
                            </td>
                            <td>
                                <?= $entreprise['entreprise'] ?>
                            </td>
                            <td>
                                <?= $entreprise['mail'] ?>
                            </td>
                            <td>
                                <?= $entreprise['phone'] ?>
                            </td>
                            <td>
                                <?= $entreprise['taille'] ?>
                            </td>
                            <td>
                                <?= $entreprise['ville'] ?>
                            </td>
                            <td>
                                <?= $entreprise['categorie'] ?>
                            </td>
                            <td>
                                <?php echo $afficheCount ?>
                            </td>
                            <td class="vue"><img src="../image/vue.png" alt="Image 1">Voir</td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

</body>

</html>