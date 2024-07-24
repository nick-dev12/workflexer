<?php

session_start();
include('../conn/conn.php');


// Récupérez l'ID du commerçant à partir de la session
    // Récupérez l'ID de l'utilisateur depuis la variable de session
    $users_id = $_SESSION['users_id'];

    // Vous pouvez maintenant utiliser $commercant_id pour récupérer les informations de l'utilisateur depuis la base de données
    // Écrivez votre requête SQL pour récupérer les informations nécessaires
    $conn = "SELECT * FROM users WHERE id = :users_id";
    $stmt = $db->prepare($conn);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->execute();
    $users = $stmt->fetch(PDO::FETCH_ASSOC);


    include_once('../controller/controller_users.php');

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5JBWCPV7');</script>
<!-- End Google Tag Manager -->

    <title>
        Modifier
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

        <script src="../script/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <link rel="stylesheet" href="../css/modifier_users.css">
    <link rel="stylesheet" href="../css/navbare.css">
</head>

<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>


    <?php include('../include/header_users.php') ?>

   
    <section class="section3">

    

    <?php if (isset($_SESSION['success_message'])): ?>
            <div class="success">
                <?php echo $_SESSION['success_message']; ?>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        <?php else: ?>
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="erreur">
                    <?php echo $_SESSION['error_message']; ?>
                    <?php unset($_SESSION['error_message']); ?>
                </div>
            <?php else: ?>

                <?php if (isset($_SESSION['delete_message'])): ?>
                    <div class="delete">
                        <?php echo $_SESSION['delete_message']; ?>
                        <?php unset($_SESSION['delete_message']); ?>
                    </div>

                <?php endif; ?>
            <?php endif; ?>

        <?php endif; ?>

        <script>
            let success = document.querySelector('.success')
            setTimeout(() => {
                success.classList.add('visible')
            }, 200)
            setTimeout(() => {
                success.classList.remove('visible')
            }, 8000)

            let erreur = document.querySelector('.erreur')
            setTimeout(() => {
                erreur.classList.add('visible')
            }, 200)
            setTimeout(() => {
                erreur.classList.remove('visible')
            }, 8000)

            let delet = document.querySelector('.delete')
            setTimeout(() => {
                delet.classList.add('visiblee')
            }, 200)
            setTimeout(() => {
                delet.classList.remove('visiblee')
            }, 8000)
        </script>

        <div class="mdf_info">
            <div class="box-info">
                <div class="box-form1 box-form ">
                    <img class="croix1" src="../image/croix.png" alt="">

                    <form class="form0" action="" method="post" enctype="multipart/form-data" >
                    <div class="ab">
                                <div>
                                    <label class="label" for="images"> <img id="img" src="/image/galerie.jpg" alt=""></label>
                                    <input type="file" name="images" id="images" accept="image/jpeg,image/jpg, image/png, image/gif">
                                </div>
                                <div class="im">
                                    <img id="imagePreview" src="" alt="view">
                                </div>

                            </div>
                        <input id="modif" name="valide0" type="submit" value="Modifier">
                        <script>
        // Récupérer l'élément input type file
        const inputImage = document.getElementById('images');

        // Écouter le changement de fichier sélectionné
        inputImage.addEventListener('change', () => {

            // Récupérer le premier fichier sélectionné
            const file = inputImage.files[0];

            // Afficher l'aperçu dans l'élément img
            const previewImg = document.getElementById('imagePreview');
            previewImg.src = URL.createObjectURL(file);

        });
    </script>
                    </form>

                    <form class="form1" action="" method="post">
                        <div>
                            <label for="nom">Nom</label>
                            <input type="text" name="nom" id="" value=" <?= $users['nom']; ?>" >
                        </div>
                        <input id="modif" name="valide1" type="submit" value="Modifier">
                    </form>
                    

                    <form class="form3" action="" method="post">
                        <div>
                            <label for="nom">E-mail</label>
                            <input type="text" name="mail" id="" value=" <?= $users['mail']; ?>">
                        </div>
                        <input id="modif" type="submit" name="valide3" value="Modifier">
                    </form>

                    <form class="form4" action="" method="post">
                        <div>
                            <label for="nom">N-telephone</label>
                            <input type="tel" name="phone" id=""  value=" <?= $users['phone']; ?>">
                        </div>
                        <input id="modif" type="submit" name="valide4" value="Modifier">
                    </form>

                    <form class="form5" action="" method="post">
                        <div>
                            <label for="nom">Domaine de Competence</label>
                            <input type="text" name="competence" id=""  value=" <?= $users['competences']; ?>">
                        </div>
                        <input id="modif" type="submit" name="valide5" value="Modifier">
                    </form>

                    <form class="form6" action="" method="post">
                        <div>
                            <label for="nom">Ville</label>
                            <input type="text" name="ville" id=""  value=" <?= $users['ville']; ?>">
                        </div>
                        <input id="modif" type="submit" name="valide6" value="Modifier">
                    </form>

                    <form class="form7" action="" method="post">
                        <div>
                        <label for="profession">Profession</label>
                            <select name="profession" id="profession">
                                <option value="Étudiant">étudiant</option>
                                <option value="Professionnel">Professionnel</option>
                                
                            </select>
                        </div>
                        <input id="modif" type="submit" name="valide7" value="Modifier">
                    </form>

                    <form class="form8" action="" method="post">
                        <div>
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
                        <input id="modif" type="submit" name="valide8" value="Modifier">
                    </form>

                </div>
                <h2> Mon profil </h2>
                <img class="img" src="../upload/<?= $users['images']; ?>" alt="">
                <button class="btn" >Modifier</button>
                <div class="box-ul">
                    <ul class="ul">
                        <li>Nom :</li>
                        <li>E-mail :</li>
                        <li>N-telephone</li>
                        <li>Domaine de Competence</li>
                        <li>Ville :</li>
                        <li>Profession</li>
                        <li>Secteur d’activité:</li>
                    </ul>

                    <ul>
                        <li> <?= $users['nom']; ?></li>
                        <li> <?= $users['mail']; ?></li>
                        <li> <?= $users['phone']; ?></li>
                        <li> <?= $users['competences']; ?></li>
                        <li> <?= $users['ville']; ?></li>
                        <li> <?= $users['profession']; ?></li>
                        <li> <?= $users['categorie']; ?></li>
                    </ul>

                    <ul class="modif">
                        <li class="mdf1">Modifier</li>
                        <li class="mdf3">Modifier</li>
                        <li class="mdf4">Modifier</li>
                        <li class="mdf5">Modifier</li>
                        <li class="mdf6">Modifier</li>
                        <li class="mdf7">Modifier</li>
                        <li class="mdf8">Modifier</li>
                    </ul>
                </div>
            </div>

            <script>

                let box_form = document.querySelector('.box-form')
                let croix1 = document.querySelector('.croix1')

                let mdf1 = document.querySelector('.mdf1')
                let form1 = document.querySelector('.form1')
                
                let mdf3 = document.querySelector('.mdf3')
                let form3 = document.querySelector('.form3')

                let mdf4 = document.querySelector('.mdf4')
                let form4 = document.querySelector('.form4')

                let mdf5 = document.querySelector('.mdf5')
                let form5 = document.querySelector('.form5')

                let mdf6 = document.querySelector('.mdf6')
                let form6 = document.querySelector('.form6')

                let mdf7 = document.querySelector('.mdf7')
                let form7 = document.querySelector('.form7')

                let mdf8 = document.querySelector('.mdf8')
                let form8 = document.querySelector('.form8')

                let btn =document.querySelector('.btn')
                let form0 = document.querySelector('.form0')

                croix1.addEventListener('click', () => {
                    box_form.style.display = 'none';
                    form1.style.display = 'none';
                    form3.style.display = 'none';
                    form4.style.display = 'none';
                    form5.style.display = 'none';
                    form6.style.display = 'none';
                    form7.style.display = 'none';
                    form8.style.display = 'none';
                    form0.style.display = 'none';
                })

                mdf1.addEventListener('click', () => {
                    box_form.style.display = 'block';
                    form1.style.display = 'block'
                })
              

                mdf3.addEventListener('click', () => {
                    box_form.style.display = 'block';
                    form3.style.display = 'block'
                })
                mdf4.addEventListener('click', () => {
                    box_form.style.display = 'block';
                    form4.style.display = 'block'
                })
                mdf5.addEventListener('click', () => {
                    box_form.style.display = 'block';
                    form5.style.display = 'block'
                })
                mdf6.addEventListener('click', () => {
                    box_form.style.display = 'block';
                    form6.style.display = 'block'
                })
                mdf7.addEventListener('click', () => {
                    box_form.style.display = 'block';
                    form7.style.display = 'block'
                })
                mdf8.addEventListener('click', () => {
                    box_form.style.display = 'block';
                    form8.style.display = 'block'
                })

                btn.addEventListener('click', () => {
                    box_form.style.display = 'block';
                    form0.style.display = 'block'
                })
            </script>
        </div>

    </section>