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
                    <?php echo $users['competences']; ?>
                </h3>
            </div>
            <div class="box3">
                <table>

                <tr class="tr3" >
                        <td id="td"><img src="../image/modifier.png" alt=""></td>
                        <td class="td"> <a href="../page/modifier.php">Modifier</a></td>
                    </tr>

                    <tr class="tr4" >
                        <td id="td"><img src="../image/MCV.png" alt=""></td>
                        <td class="td"> <a href="/model_cv/model1.php">Mon cv</a></td>
                    </tr>

                   
                    <tr class="tr ">
                        <td id="td"><a href="../page/user_profil.php"><img src="../image/mpc.png" alt=""></a></td>
                        <td class="td"><a href="../page/user_profil.php">Mon parcours</a></td>
                    </tr>
                   
                    <tr class="tr1">
                        <td id="td"> <a href="../page/mes_demande.php"><img src="../image/mdep.png" alt=""></a></td>
                        <td class="td"><a href="../page/mes_demande.php">Mes demandes d’emploies</a></td>
                    </tr>
                    <tr class="tr2" >
                        <td id="td"><a href="message.php"><img src="../image/modifier.png" alt=""></a></td>
                        <td class="td"> <a href="../page/message_users.php">Message</a></td>
                    </tr>
                    <tr class="me4">
                        <td id="td"><a href="../page/historique_users.php"><img src="../image/historique.png" alt=""></a></td>
                        <td class="td"> <a href="../page/historique_users.php">Historique</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </section>