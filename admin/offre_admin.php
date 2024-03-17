<?php
session_start();
// Inclusion du fichier de connexion à la BDD
include '../conn/conn.php';

include '../entreprise/app/controller/controllerEntreprise.php';
include '../entreprise/app/controller/controllerOffre_emploi.php';
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/offre_admin.css">
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
            Offres D'emplois enregistrer
        </h1>

        <form action="#">
            <div class="input-group">
                <input type="search" class="form-control" placeholder="Rechercher d'offres">
                <label for="recherche"><img src="../image/recherche-.png" alt=""></label>
                <input id="recherche" type="submit" value="">
            </div>
        </form>

        <h3>

            Totale D'offre <span>
                <?php $totale_offres = count($getAlloffres_emploi);
                echo $totale_offres;
                ?>
            </span>
        </h3>

        <table>
            <thead>
                <tr>
                    <th>Entreprise</th>
                    <th>Poste</th>
                    <th>Contrat</th>
                    <th>Etude</th>
                    <th>Experience</th>
                    <th>Ville</th>
                    <th>Catégorie</th>
                    <th>Voire</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($getAlloffres_emploi as $offres): ?>
                    <?php $entreprise = getEntreprise($db, $offres['entreprise_id']);
                    ?>
                    <tr>
                        <td>
                            <?= $entreprise['entreprise'] ?>
                        </td>
                        <td>
                            <?= $offres['poste'] ?>
                        </td>
                        <td>
                            <?= $offres['contrat'] ?>
                        </td>
                        <td>
                            <?= $offres['etudes'] ?>
                        </td>

                        <td>
                            <?= $offres['experience'] ?>
                        </td>

                        <td>
                            <?= $offres['localite'] ?>
                        </td>
                        <td>
                            <?= $offres['categorie'] ?>
                        </td>
                        <td class="vue"><img src="../image/vue.png" alt="Image 1"> <a
                                href="../entreprise/voir_offre.php?offres_id=<?= $offres['offre_id']; ?>&entreprise_id=<?= $offres['entreprise_id']; ?>">Voir
                                l'offre
                            </a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

</body>

</html>