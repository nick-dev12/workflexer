<link rel="stylesheet" href="../css/section2.css">


<section class="section2 ste" id="ste">
    <img src="../image/croix.png" alt="" class="img111" id="img24">
    <div class="container">
        <div class="box1">

            <script>
                // Gestionnaire d'événements pour le bouton de statut
                const statutButton = document.querySelector('.statut');
                const divStatut = document.querySelector('.div_statut');
                const closeImg = document.querySelector('.imag');

                statutButton.addEventListener('click', () => {
                    divStatut.style.left = '0';
                });

                closeImg.addEventListener('click', () => {
                    divStatut.style.left = '-200%';
                });

                // Fermer la div au clic en dehors
                document.addEventListener('click', (e) => {
                    if (!divStatut.contains(e.target) && e.target !== statutButton) {
                        divStatut.style.left = '-200%';
                    }
                });
            </script>


            <img class="affiche" src="/upload/<?= $users['images'] ?>" alt="">

            <?php if ($users['statut'] == 'Disponible'): ?>
                <button class="statut occ">
                    <?= $users['statut'] ?>
                </button>
            <?php else: ?>
                <?php if ($users['statut'] == 'Occuper'): ?>
                    <button class="statut disp">
                        <?= $users['statut'] ?>
                    </button>
                <?php else: ?>
                    <button class="statut occ">Statut</button>
                <?php endif; ?>
            <?php endif; ?>
            <div class="div_statut">
                <img class="imag" src="../image/croix.png" alt="">
                <a class="disp" href="?occuper=<?= $users['id'] ?>">Occuper</a>
                <a class=" occ" href="?disponible=<?= $users['id'] ?>">Disponible</a>
            </div>
            <span></span>
            <h2>
                <?php echo $users['nom']; ?>
            </h2>
        </div>

        <div class="box2">
            <h3>
                <?php echo $users['competences']; ?>
            </h3>
        </div>

        <div class="box3">
            <ul>
                <a href="../page/modifier.php">
                    <li class="tr3"><img src="../image/modifier 1.png" alt=""> <span class="td">Paramètres </span></li>
                </a>

                <a href="../page/user_profil.php">
                    <li class="tr"><img src="../image/diplômé.png" alt=""> <span class="td">Mon parcours</span></li>
                </a>

                <a href="/model_cv/cv_users.php">
                    <li class="tr4"><img src="../image/MCV.png" alt=""> <span class="td">Mon CV</span></li>
                </a>

                <a href="../page/mes_documments.php">
                    <li class="tr6"><img src="../image/fichier1.png" alt=""> <span class="td">Mes documents</span></li>
                </a>

                <a href="../page/mes_demande.php?supp4=<?= $_SESSION['users_id'] ?>">
                    <li class="tr1"><img src="../image/mdep.png" alt=""><span class="td">Mes demandes d'emplois</span>
                        <?php if (empty($notif_suivi) or empty($notif_suiviRecaler)): ?>
                        <?php else: ?>
                            <?php if (isset($notif_suivi) or isset($notif_suiviRecaler)): ?>
                                <em><?= $count_notif_suivi + $count_notif_suiviRecaler ?></em>
                            <?php endif; ?>
                        <?php endif; ?>
                    </li>
                </a>

                <a href="../page/candature_accepter.php">
                    <li class="tr10"><img src="../image/reussi.png" alt=""> <span class="td">Candidatures
                            acceptées</span>
                        <?php if (empty($notif_suivi) or empty($notif_suiviRecaler)): ?>
                        <?php else: ?>
                            <?php if (isset($notif_suivi)): ?>
                                <em><?= $count_notif_suivi ?></em>
                            <?php endif; ?>
                        <?php endif; ?>

                    </li>
                </a>

                <a href="../page/message_users.php?supp3=<?= $_SESSION['users_id'] ?>">
                    <li class="tr2"><img src="../image/message.png" alt=""><span class="td">Messages</span>
                        <?php if (empty($notif_users)): ?>
                        <?php else: ?>
                            <?php if (isset($notif_users)): ?>
                                <em><?= $count_notif_users ?></em>
                            <?php endif; ?>
                        <?php endif; ?>
                    </li>
                </a>

            </ul>

        </div>

        <a class="liens" href="../conn/dconn_users.php">Déconnexion</a>
    </div>


</section>



<section class="section2 menu" id="menu">
    <img class="img23" id="img23" src="../image/menu n.png" alt="">
    <div class="container">
        <div class="box1">

            <img class="affiche" src="/upload/<?= $users['images'] ?>" alt="">
            <span></span>

        </div>


        <div class="box3">
            <ul>
                <a href="../page/modifier.php">
                    <li class="tr3"><img src="../image/modifier 1.png" alt=""> </li>
                </a>

                <a href="../page/user_profil.php">
                    <li class="tr"><img src="../image/a propos.png" alt=""> <span class="td">À propos</span></li>
                </a>

                <a href="/model_cv/cv_users.php">
                    <li class="tr4"><img src="../image/MCV.png" alt=""></li>
                </a>

                <a href="../page/mes_documments.php">
                    <li class="tr6"><img src="../image/fichier1.png" alt=""></li>
                </a>

                <a href="../page/mes_demande.php?supp4=<?= $_SESSION['users_id'] ?>">
                    <li class="tr1"><img src="../image/mdep.png" alt="">
                        <?php if (($notif_suivi) or ($notif_suiviRecaler)): ?>
                            <em><?= $count_notif_suivi + $count_notif_suiviRecaler ?></em>
                        <?php else: ?>
                        <?php endif; ?>
                    </li>
                </a>

                <a href="../page/candature_accepter.php">
                    <li class="tr10"><img src="../image/reussi.png" alt=""> <span class="td"></span>
                        <?php if ($notif_suivi): ?>
                            <em><?= $count_notif_suivi ?></em>
                        <?php else: ?>
                        <?php endif; ?>

                    </li>
                </a>

                <a href="../page/message_users.php?supp3=<?= $_SESSION['users_id'] ?>">
                    <li class="tr2"><img src="../image/message.png" alt="">
                        <?php if (empty($notif_users)): ?>
                        <?php else: ?>
                            <?php if (isset($notif_users)): ?>
                                <em><?= $count_notif_users ?></em>
                            <?php endif; ?>
                        <?php endif; ?>
                    </li>
                </a>

            </ul>

        </div>
    </div>



</section>

<script>
    // Sélectionne l'élément avec la classe 'img' et l'assigne à img222
    let cache = document.getElementById('img23');

    let section = document.querySelector('.section2')
    // Sélectionne l'élément avec la classe 'ste' et l'assigne à section2
    let section2 = document.getElementById('ste');

    // Sélectionne l'élément avec la classe 'menu' et l'assigne à menu
    let menu1 = document.getElementById('menu');

    // Sélectionne l'élément avec la classe 'img111' et l'assigne à img111
    let img111 = document.getElementById('img24');

    // Ajoute un événement de clic à img222
    cache.addEventListener('click', () => {
        // Lorsque img222 est cliqué, déplace section2 à gauche (visible) et cache menu
        section2.style.left = '0';
        menu1.style.left = '-400px';
    });

    // Ajoute un événement de clic à img111
    img111.addEventListener('click', () => {
        // Lorsque img111 est cliqué, cache section2 et montre menu
        section2.style.left = '-250px';
        menu1.style.left = '0';
    });

</script>