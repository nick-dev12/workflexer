<?php

session_start();
include('../conn/conn.php');

include_once('../controller/controller_users.php');

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

    <title>
        <?= $getEntreprise['entreprise']; ?>
    </title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <link rel="stylesheet" href="../css/modifier_users.css">
    <link rel="stylesheet" href="../css/navbare.css">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>


    <?php include('../include/header_users.php') ?>

    <section class="section3">

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="message">
                <p>
                    <span></span>
                    <?php echo $_SESSION['success_message']; ?>
                    <?php unset($_SESSION['success_message']); ?>
                </p>
            </div>
        <?php else: ?>
            <?php if (isset($_SESSION['error_message'])): ?>
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
            setTimeout(function () {
                messageErreur.classList.add('visible');
            }, 200); // 1000 millisecondes équivalent à 1 seconde

            // Fonction pour masquer le message avec une transition de fondu
            setTimeout(function () {
                messageErreur.classList.remove('visible');
            }, 6000); // 6000 millisecondes équivalent à 6 secondes
        </script>

        <section class="section">

            <div class="container2">
                <div class="commande">
                    <h1>Paranètres et option </h1>

                    <h2>Informations Personnelles</h2>

                    <div class="param param1">
                        <img id="photo" src="../upload/<?= $users['images']; ?>" alt="">
                        <img id="photo1" src="../image/photo.png" alt="">
                        <form class="form0" action="" method="post" enctype="multipart/form-data">
                            <label id="upload" for="images"> <img id="galerie" src="../image/caméra.png" alt=""></label>
                            <input type="file" name="images" id="images"
                                accept="image/jpeg,image/jpg, image/png, image/gif">

                            <div class="preview">
                                <img id="imagePreview" src="" alt="view">
                            </div>
                            <div>
                                <label for="valide0"><img src="../image/valider.png" alt=""></label>
                                <input class="btn" type="submit" name="valide0" id="valide0" value="Valider">
                                <img class="close" src="../image/croix.png" alt="">
                            </div>

                            <script>
                                let inputImage = document.getElementById('images');
                                inputImage.addEventListener('change', () => {
                                    let file = inputImage.files[0];
                                    let imagePreview = document.getElementById('imagePreview');
                                    imagePreview.src = URL.createObjectURL(file);
                                })
                            </script>
                        </form>
                    </div>

                    <div class="param">
                        <p><strong>Nom :</strong> <?= $users['nom']; ?> <span class="edite"><img
                                    src="../image/edite.png" alt="">
                                Modifier</span> </p>
                        <form class="form" action="" method="post">
                            <input type="text" name="nom" id="nom" placeholder="<?= $users['nom']; ?> "
                                value="<?= $users['nom']; ?>" required>
                            <div>
                                <label for="valide1"><img src="../image/valider.png" alt=""></label>
                                <input class="btn" type="submit" name="valide1" id="valide1" value="Valider">
                                <img id="img" src="../image/croix.png" alt="">
                            </div>
                        </form>
                    </div>


                    <div class="param">
                        <p><strong>Email :</strong> <?= $users['mail']; ?> <span class="edite"><img
                                    src="../image/edite.png" alt=""> Modifier</span> </p>
                        <form class="form" action="" method="post">
                            <input type="email" name="mail" id="nom" placeholder="<?= $users['mail']; ?>"
                                value="<?= $users['mail']; ?>">
                            <input type="password" name="pass" id="nom" placeholder="mot de passe actuel" required>
                            <div>
                                <label for="valide3"><img src="../image/valider.png" alt=""></label>
                                <input class="btn" type="submit" name="valide3" id="valide3" value="Valider">
                                <img id="img" src="../image/croix.png" alt="">
                            </div>
                        </form>
                    </div>

                    <div class="param">
                        <p><strong>Téléphone :</strong> <?= $users['phone']; ?> <span class="edite"><img
                                    src="../image/edite.png" alt=""> Modifier</span> </p>
                        <form class="form" action="" method="post">
                            <input type="tel" name="phone" id="nom" placeholder="<?= $users['phone']; ?>"
                                value="<?= $users['phone']; ?>" required>
                            <div>
                                <label for="valide4"><img src="../image/valider.png" alt=""></label>
                                <input class="btn" type="submit" name="valide4" id="valide4" value="Valider">
                                <img id="img" src="../image/croix.png" alt="">
                            </div>
                        </form>
                    </div>

                    <div class="param">
                        <p><strong>Domaine de Competence :</strong> <?= $users['competences']; ?> <span
                                class="edite"><img src="../image/edite.png" alt="">
                                Modifier</span> </p>
                        <form class="form" action="" method="post">
                            <input type="text" name="competence" id="nom" placeholder="<?= $users['competences']; ?> "
                                value="<?= $users['competences']; ?>" required>
                            <div>
                                <label for="valide5"><img src="../image/valider.png" alt=""></label>
                                <input class="btn" type="submit" name="valide5" id="valide5" value="Valider">
                                <img id="img" src="../image/croix.png" alt="">
                            </div>
                        </form>
                    </div>


                    <div class="param">
                        <p><strong>Ville :</strong> <?= $users['ville']; ?> <span class="edite"><img
                                    src="../image/edite.png" alt="">
                                Modifier</span> </p>
                        <form class="form" action="" method="post">
                            <input type="text" name="ville" id="nom" placeholder="<?= $users['ville']; ?> "
                                value="<?= $users['ville']; ?>" required>
                            <div>
                                <label for="valide6"><img src="../image/valider.png" alt=""></label>
                                <input class="btn" type="submit" name="valide6" id="valide6" value="Valider">
                                <img id="img" src="../image/croix.png" alt="">
                            </div>
                        </form>
                    </div>

                    <div class="param">
                        <p><strong>Profession :</strong> <?= $users['profession']; ?> <span class="edite"><img
                                    src="../image/edite.png" alt="">
                                Modifier</span> </p>
                        <form class="form" action="" method="post">
                            <select name="profession" id="profession">
                                <option value="Étudiant">étudiant</option>
                                <option value="Professionnel">Professionnel</option>

                            </select>
                            <div>
                                <label for="valide7"><img src="../image/valider.png" alt=""></label>
                                <input class="btn" type="submit" name="valide7" id="valide7" value="Valider">
                                <img id="img" src="../image/croix.png" alt="">
                            </div>
                        </form>
                    </div>

                    <div class="param">
                        <p><strong>Secteur d’activité:</strong> <?= $users['categorie']; ?> <span class="edite"><img
                                    src="../image/edite.png" alt="">
                                Modifier</span> </p>
                        <form class="form" action="" method="post">
                            <select name="categorie" id="categorie">
                                <option value="">Sélectionnez une catégorie</option>
                                <option value="Informatique">Informatique et tech</option>
                                <option value="design">Design et création</option>
                                <option value="Rédaction">Rédaction et traduction</option>
                                <option value="marketing">Marketing et communication</option>
                                <option value="business">Conseil et gestion d'entreprise</option>
                                <option value="Juridique">Juridique</option>
                                <option value="Ingénierie">Ingénierie et architecture</option>
                                <option value="Finance et comptabilité">Finance et comptabilité</option>
                                <option value="Santé et bien-être">Santé et bien-être</option>
                                <option value="Éducation et formation">Éducation et formation</option>
                                <option value="Tourisme et hôtellerie">Tourisme et hôtellerie</option>
                                <option value="Commerce et vente">Commerce et vente</option>
                                <option value="Transport et logistique">Transport et logistique</option>
                                <option value="Agriculture et agroalimentaire">Agriculture et agroalimentaire</option>
                                <option value="Autre">Autre</option>
                            </select>
                            <div>
                                <label for="valide8"><img src="../image/valider.png" alt=""></label>
                                <input class="btn" type="submit" name="valide8" id="valide8" value="Valider">
                                <img id="img" src="../image/croix.png" alt="">
                            </div>
                        </form>
                    </div>

                    <div class="param">
                        <p><strong>Mot de passe :</strong> *********** <span class="edite"><img src="../image/edite.png"
                                    alt=""> Modifier</span> </p>
                        <form class="form" action="" method="post">
                            <input type="password" name="pass" id="nom" placeholder="mot de passe actuel" required>
                            <input type="password" name="pass1" id="nom" placeholder="nouveau mot de passe" required>
                            <div>
                                <label for="valide9"><img src="../image/valider.png" alt=""></label>
                                <input class="btn" type="submit" name="valide9" id="valide9" value="Valider">
                                <img id="img" src="../image/croix.png" alt="">
                            </div>
                        </form>
                    </div>


                    <h2>Mes Préférences</h2>



                    <script>
                        let photo1 = document.querySelector('#photo1')
                        let form0 = document.querySelector('.form0')
                        let close = document.querySelector('.close')
                        photo1.addEventListener('click', () => {
                            form0.style.transform = 'translateY(0)';
                        })
                        close.addEventListener('click', () => {
                            form0.style.transform = 'translateY(-100%)';
                        })
                        document.querySelectorAll('.edite').forEach((editButton, index) => {
                            editButton.addEventListener('click', () => {
                                const form = document.querySelectorAll('.form')[index];
                                form.style.transform = 'translateY(0)';
                            });
                        });

                        document.querySelectorAll('#img').forEach((closeButton, index) => {
                            closeButton.addEventListener('click', () => {
                                const form = document.querySelectorAll('.form')[index];
                                form.style.transform = 'translateY(-100%)';
                            });
                        });

                        // Ajout d'un écouteur d'événement pour détecter l'apparition du clavier
                        window.addEventListener('resize', function () {
                            if (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA') {
                                document.activeElement.scrollIntoView({ behavior: 'smooth' });
                            }
                        });
                    </script>
                </div>

            </div>


        </section>

    </section>

    <script>
        window.addEventListener('resize', function () {
            if (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA') {
                document.activeElement.scrollIntoView({ behavior: 'smooth' });
            }
        });
    </script>

</body>

</html>