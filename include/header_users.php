<link rel="stylesheet" href="../css/section2.css">


<section class="section2">
    <img src="../image/croix.png" alt="" class="img111">
        <div class="container">
            <div class="box1">
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

                <script>
                    let statut = document.querySelector('.statut')
                    let div_statut = document.querySelector('.div_statut')
                    let imag = document.querySelector('.imag')
                    statut.addEventListener('click', () => {
                            div_statut.style.left = '0'
                    })
                    imag.addEventListener('click', () => {
                            div_statut.style.left = '-200%'
                    })

                    // Ajouter un gestionnaire au clic n'importe où sur la page
                    document.addEventListener('click', (e) => {
                        // Vérifier que le clic ne vient pas du bouton
                        if (e.target !== statut) {
                            // Masquer la div
                            div_statut.style.left = '-200%'
                        }
                    });
                </script>


                <img class="affiche" src="/upload/<?= $users['images'] ?>" alt="">
                <span></span>
                <h2>
                    <?php echo $users['nom']; ?>
                </h2>
            </div>

            <div class="box2">
                <h3>
                    <?php echo $users['competences']; ?> et ingenieur des mine 
                </h3>
            </div>

            <div class="box3">
            <ul>
               <a href="../page/modifier.php"> <li class="tr3"><img src="../image/modifier.png" alt=""> <span class="td">Modifier</span></li></a>

               <a href="../page/user_profil.php"> <li class="tr"><img src="../image/a propos.png" alt=""> <span class="td">Mon parcour</span></li></a>

               <a href="/model_cv/cv_users.php"> <li class="tr4"><img src="../image/MCV.png" alt=""> <span class="td">Mon cv</span></li></a>

               <a href="../page/mes_demande.php"> <li class="tr1"><img src="../image/mdep.png" alt=""><span class="td">Mes demandes d’emploies</span></li></a>

               <a href="../page/message_users.php"> <li class="tr2"><img src="../image/modifier.png" alt=""><span class="td">Message</span></li></a>

               <a  href="../page/historique_users.php"> <li class="tr5"><img src="../image/historique.png" alt=""> <span class="td">Historique</span></li></a>   
            </ul>
               
            </div>
        </div>
    </section>