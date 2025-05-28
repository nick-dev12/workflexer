<link rel="stylesheet" href="../css/section2.css">


<section class="section2 ste" id="ste">

    <img src="../image/croix.png" alt="" class="img111" id="img24">
    <div class="container">
        <div class="box1">
            <img src="../upload/<?= $getEntreprise['images']; ?>" alt="">
            <span></span>
            <h2>
                <?= $getEntreprise['nom']; ?>
            </h2>
        </div>

        <div class="box2">
            <h3> <?= $getEntreprise['entreprise']; ?></h3>
        </div>

        <div class="box3">
            <ul><a href="../entreprise/modifier.php">
                    <li class="tr3"><img src="../image/modifier 1.png" alt=""> <span class="td">Paramètres </span></li>
                </a><a href="../entreprise/entreprise_profil.php">
                    <li class="tr"><img src="../image/entreprise_ic.png" alt=""> <span class="td">Mon entreprise</span>
                    </li>
                </a><a href="../page/candidature.php?supp2= <?= $_SESSION['compte_entreprise'] ?>">
                    <li class="me3"><img src="../image/candidat.png" alt=""> <span class="td">Candidats</span>
                        <?php if (empty($afficheNotificationPostulation)): ?>

                        <?php else: ?>
                            <?php if (isset($afficheNotificationPostulation)): ?>
                                <em><?= $countnotificationPostulation ?></em>
                            <?php endif; ?>
                        <?php endif; ?>
                    </li>
                </a>
                <a href="../entreprise/message.php?supp1= <?= $_SESSION['compte_entreprise'] ?>">
                    <li class="tr2"><img src="../image/message.png" alt=""><span class="td">Messages</span>
                        <?php if (empty($afficheNotificationMessage)): ?>
                        <?php else: ?>
                            <em><?= $countafficheNotificationMessage ?></em><?php endif; ?>
                    </li>
                </a>

                <a href="../entreprise/offre_expirer.php">
                    <li class="tr7"><img src="../image/Expiration.png" alt=""> Offre expirée</li>
                </a>
                <a href="../entreprise/offre_suprimer.php">
                    <li class="tr8"><img src="../image/supprimé.png" alt=""> Offre supprimée</li>
                </a>
                <a href="../entreprise/historique.php">
                    <li class="tr5"><img src="../image/historique.png" alt=""> <span class="td">Historique</span></li>
                </a>
            </ul>
        </div>

        <a class="liens" href="../conn/dconn_entreprise.php">Déconnexion</a>
    </div>
</section>

<section class="menu" id="menu">
    <!-- <img src="../image/croix.png" alt="" class="img111"> -->
    <img class="img23" id="img23" src="../image/menu n.png" alt="">
    <span class="span1">menu</span>
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
        section2.style.left = '-100%';
        menu1.style.left = '0';
    });

</script>