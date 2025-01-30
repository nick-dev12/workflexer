<?php
// Démarre la session
session_start();

if (isset($_GET['id'])) {
    include '../conn/conn.php';
    include_once('../controller/controller_users.php');
    include_once('../controller/controller_description_users.php');
    include_once('../controller/controller_metier_users.php');
    include_once('../controller/controller_competence_users.php');
    include_once('../controller/controller_formation_users.php');
    include_once('../controller/controller_diplome_users.php');
    include_once('../controller/controller_certificat_users.php');
    include_once('../controller/controller_outil_users.php');
    include_once('../controller/controller_langue_users.php');
    include_once('../controller/controller_projet_users.php');
    include_once('../controller/controller_message1.php');
    include_once('../controller/controller_appel_offre.php');
    include_once('../controller/controller_centre_interet.php');
}

if (isset($_SESSION['users_id'])) {
    include '../conn/conn.php';
    $users_id = $_SESSION['users_id'];
    include_once('../controller/controller_description_users.php');
    include_once('../controller/controller_metier_users.php');
    include_once('../controller/controller_competence_users.php');
    include_once('../controller/controller_formation_users.php');
    include_once('../controller/controller_diplome_users.php');
    include_once('../controller/controller_certificat_users.php');
    include_once('../controller/controller_outil_users.php');
    include_once('../controller/controller_langue_users.php');
    include_once('../controller/controller_projet_users.php');
    include_once('../controller/controller_users.php');
    include_once('../controller/controller_centre_interet.php');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Modèle 9</title>
    <link rel="stylesheet" href="../css/model9.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</head>

<body>
    <div class="cv-container" id="cv-content">
        <div class="header">
            <div class="profile">
                <img src="../upload/<?= $userss['images'] ?>" alt="Photo de profil">
                <div class="info">
                    <h1><?= $userss['nom'] ?></h1>
                    <h2><?= $userss['competences'] ?></h2>
                </div>
            </div>
            <div class="contact">
                <p><img src="../image/phone.png" alt=""> <?= $userss['phone'] ?></p>
                <p><img src="../image/icons8-gmail-48.png" alt=""> <?= $userss['mail'] ?></p>
                <p><img src="../image/address.png" alt=""> <?= $userss['ville'] ?></p>
            </div>
        </div>

        <div class="main-content">
            <div class="left-column">
                <section class="about">
                    <h3>À PROPOS</h3>
                    <?php if (empty($descriptions)): ?>
                        <p>Aucune donnée trouvée</p>
                    <?php else: ?>
                        <p><?= $descriptions['description'] ?></p>
                    <?php endif; ?>
                </section>

                <section class="skills">
                    <h3>COMPÉTENCES</h3>
                    <ul>
                        <?php if ($competencesUtilisateur): ?>
                            <?php foreach ($competencesUtilisateur as $competence): ?>
                                <li><?= $competence['competence'] ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>Aucune donnée trouvée</li>
                        <?php endif; ?>
                    </ul>
                </section>

                <section class="languages">
                    <h3>LANGUES</h3>
                    <ul>
                        <?php if ($afficheLangue): ?>
                            <?php foreach ($afficheLangue as $langue): ?>
                                <li><?= $langue['langue'] ?> (<?= $langue['niveau'] ?>)</li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>Aucune donnée trouvée</li>
                        <?php endif; ?>
                    </ul>
                </section>
            </div>

            <div class="right-column">
                <section class="experience">
                    <h3>EXPÉRIENCES</h3>
                    <?php if ($afficheMetier): ?>
                        <?php foreach ($afficheMetier as $metier): ?>
                            <div class="experience-item">
                                <h4><?= $metier['metier'] ?></h4>
                                <span class="date"><?= $metier['moisDebut'] ?>/<?= $metier['anneeDebut'] ?> -
                                    <?= $metier['moisFin'] ?>/<?= $metier['anneeFin'] ?></span>
                                <p><?= $metier['description'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucune donnée trouvée</p>
                    <?php endif; ?>
                </section>

                <section class="education">
                    <h3>FORMATIONS</h3>
                    <?php if ($formationUsers): ?>
                        <?php foreach ($formationUsers as $formation): ?>
                            <div class="education-item">
                                <h4><?= $formation['etablissement'] ?></h4>
                                <span class="date"><?= $formation['moisDebut'] ?>/<?= $formation['anneeDebut'] ?> -
                                    <?= $formation['moisFin'] ?>/<?= $formation['anneeFin'] ?></span>
                                <p><?= $formation['Filiere'] ?> (<?= $formation['niveau'] ?>)</p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucune donnée trouvée</p>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>

    <button class="download-btn" onclick="generatePDF()">Télécharger le CV</button>

    <script>
        function generatePDF() {
            const element = document.getElementById('cv-content');
            const options = {
                margin: [10, 10, 10, 10],
                filename: 'cv.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(options).from(element).save();
        }
    </script>
</body>

</html>