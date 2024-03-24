<?php

session_start();
include('../conn/conn.php');

include_once('app/controller/controllerEntreprise.php');

?>



<!DOCTYPE html>
<html lang="en">

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
        <?= $getEntreprise['entreprise']; ?>
    </title>
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
 <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>


    <?php include ('../include/header_entreprise.php') ?>

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
                            <input type="text" name="nom" id="" value=" <?= $getEntreprise['nom']; ?>" >
                        </div>
                        <input id="modif" name="valide1" type="submit" value="Modifier">
                    </form>

                    <form class="form2" action="" method="post">
                        <div>
                            <label for="nom">Nom de l'entreprise</label>
                            <input type="text" name="entreprise" id="" value="<?= $getEntreprise['entreprise']; ?>" >
                        </div>
                        <input id="modif" name="valide2" type="submit" value="Modifier">
                    </form>

                    <form class="form3" action="" method="post">
                        <div>
                            <label for="nom">E-mail</label>
                            <input type="text" name="mail" id="" value=" <?= $getEntreprise['mail']; ?>">
                        </div>
                        <input id="modif" type="submit" name="valide3" value="Modifier">
                    </form>

                    <form class="form4" action="" method="post">
                        <div>
                            <label for="nom">N-telephone</label>
                            <input type="tel" name="phone" id=""  value=" <?= $getEntreprise['phone']; ?>">
                        </div>
                        <input id="modif" type="submit" name="valide4" value="Modifier">
                    </form>

                    <form class="form5" action="" method="post">
                        <div>
                            <label for="nom">Type d'entreprise</label>
                            <input type="text" name="types" id=""  value=" <?= $getEntreprise['types']; ?>">
                        </div>
                        <input id="modif" type="submit" name="valide5" value="Modifier">
                    </form>

                    <form class="form6" action="" method="post">
                        <div>
                            <label for="nom">Ville</label>
                            <input type="text" name="ville" id=""  value=" <?= $getEntreprise['ville']; ?>">
                        </div>
                        <input id="modif" type="submit" name="valide6" value="Modifier">
                    </form>

                    <form class="form7" action="" method="post">
                        <div>
                        <label for="taille">Taille de l'entreprise</label>
                            <select name="taille" id="taille">
                                <option value="1">1 personne</option>
                                <option value="2_10">Entre 2 et 10</option>
                                <option value="11_49">Entre 11 et 49</option>
                                <option value="250_999">Entre 250 et 999</option>
                                <option value="1000_4999">Entre 1000 et 4999</option>
                            </select>
                        </div>
                        <input id="modif" type="submit" name="valide7" value="Modifier">
                    </form>

                    <form class="form8" action="" method="post">
                        <div>
                        <label for="categorie">Secteur d'activité</label>
                            <select id="categorie" name="categorie">
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
                        </div>
                        <input id="modif" type="submit" name="valide8" value="Modifier">
                    </form>

                </div>
                
                <h2> Mon profil </h2>
                <img class="img" src="../upload/<?= $getEntreprise['images']; ?>" alt="">
                <button class="btn" >Modifier</button>
                <div class="box-ul">
                    <ul class="ul">
                        <li>Nom :</li>
                        <li>Nom de l'entreprise :</li>
                        <li>A-mail :</li>
                        <li>N-telephone</li>
                        <li>Type d'entreprise :</li>
                        <li>Ville :</li>
                        <li>Taille :</li>
                        <li>Secteur d’activité:</li>
                    </ul>

                    <ul>
                        <li> <?= $getEntreprise['nom']; ?></li>
                        <li> <?= $getEntreprise['entreprise']; ?></li>
                        <li> <?= $getEntreprise['mail']; ?></li>
                        <li> <?= $getEntreprise['phone']; ?></li>
                        <li> <?= $getEntreprise['types']; ?></li>
                        <li> <?= $getEntreprise['ville']; ?></li>
                        <li> <?= $getEntreprise['taille']; ?></li>
                        <li> <?= $getEntreprise['categorie']; ?></li>
                    </ul>

                    <ul class="modif">
                        <li class="mdf1">Modifier</li>
                        <li class="mdf2">Modifier</li>
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

                let mdf2 = document.querySelector('.mdf2')
                let form2 = document.querySelector('.form2')

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
                    form2.style.display = 'none';
                    form3.style.display = 'none';
                    form4.style.display = 'none';
                    form5.style.display = 'none';
                    form6.style.display = 'none';
                    form7.style.display = 'none';
                    form8.style.display = 'none';
                    form0.style.display = 'none';
                })

                btn.addEventListener('click', () => {
                    box_form.style.display = 'block';
                    form0.style.display = 'block'
                })

                mdf1.addEventListener('click', () => {
                    box_form.style.display = 'block';
                    form1.style.display = 'block'
                })


                mdf2.addEventListener('click', () => {
                    box_form.style.display = 'block';
                    form2.style.display = 'block'
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

            </script>
        </div>

    </section>