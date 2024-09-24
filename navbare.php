<?php
include ('conn/conn.php');

include('entreprise/app/controller/controllerEntreprise.php');
include('controller/controller_users.php');


if (isset($_SESSION['users_id'])) {
    // L'utilisateur est connecté, récupérez son ID
    $users_id = $_SESSION['users_id'];

    // Maintenant, vous pouvez utiliser $users_id pour récupérer les informations de l'utilisateur depuis la base de données
    // Écrivez votre requête SQL pour récupérer les informations nécessaires
    $conn = "SELECT * FROM users WHERE id = :users_id";
    $stmt = $db->prepare($conn);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->execute();
    $users = $stmt->fetch(PDO::FETCH_ASSOC);
} else {

    if (isset($_SESSION['compte_entreprise'])) {
        // L'utilisateur est connecté, récupérez son ID
        $entreprise_id = $_SESSION['compte_entreprise'];

        // Maintenant, vous pouvez utiliser $entreprise_id pour récupérer les informations de l'utilisateur depuis la base de données
        // Écrivez votre requête SQL pour récupérer les informations nécessaires
        $conn = "SELECT * FROM compte_entreprise WHERE id = :entreprise_id";
        $stmt = $db->prepare($conn);
        $stmt->bindParam(':entreprise_id', $entreprise_id);
        $stmt->execute();
        $entreprise = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        if (isset($_SESSION['admin'])) {
            // L'utilisateur est connecté, récupérez son ID
            $admin = $_SESSION['admin'];

            // Maintenant, vous pouvez utiliser $admin pour récupérer les informations de l'utilisateur depuis la base de données
            // Écrivez votre requête SQL pour récupérer les informations nécessaires
            $conn = "SELECT * FROM admin WHERE id = :admin";
            $stmt = $db->prepare($conn);
            $stmt->bindParam(':admin', $admin);
            $stmt->execute();
            $admins = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
}


if (isset($_SESSION['compte_entreprise'])) {
    include_once ('controller/controller_message1.php');
}

if (isset($_SESSION['users_id'])) {
    include ('controller/controller_message1.php');
}


if (isset($_GET['offres_id']) and isset($_GET['statut'])) {

    if (isset($_SESSION['users_id'])) {
        deletTMP_Message($db, $_GET['entreprise_id'], $_GET['offres_id'], $_GET['users_id']);
    }

    if (isset($_SESSION['compte_entreprise'])) {
        deletTMP_Message2($db, $_GET['entreprise_id'], $_GET['offres_id'], $_GET['users_id']);
    }

}

include (__DIR__ . '/controller/controller_statut_offre.php');
?>

<link rel="stylesheet" href="/css/navbare.css">

<nav>
    <a class="logo" href="../index.php"> <img src="/image/logo.png " alt="logo"></a>
    <div class="container">
        <img class="menu" src="/image/menu.png" alt="">
        <div class="box1">
            <img class="cacheMenu" src="/image/croix.png" alt="">
            <a href="../page/orientation.php">Orientation</a>
            <a href="../page/Offres_d'emploi.php">Offres d'emploi</a>
            <a href="/page/entreprise.php">Entreprise</a>
            <a href="../page/voir_profil.php">Explorez les profils</a>
        </div>
        <script>
            let menu = document.querySelector(".menu");
            let box1 = document.querySelector(".box1");
            let cacheMenu = document.querySelector(".cacheMenu");
            menu.addEventListener("click", function () {
                box1.style.transform = "translateY(0%)";
            })
            cacheMenu.addEventListener("click", function () {
                box1.style.transform = "translateY(-200%)";
            })
        </script>

    </div>

    <?php if (isset($_SESSION['users_id'])): ?>

        <div class="box4">
            <div class="infos_users">
                <img class="affiche" src="/upload/<?= $users['images']; ?>" alt="">

            </div>
        </div>

        <div class="not">
            <img src="/image/notification.png" alt="" class="notif">
            <?php if ($notif_users or $notif_suivi or $notif_suiviRecaler): ?>
                <span><?= $count_notif_users + $count_notif_suivi + $count_notif_suiviRecaler ?></span>
            <?php else: ?>

            <?php endif; ?>
        </div>

        <div class="box_notif">
            <img src="/image/croix.png" alt="" class="croi">

            <?php if (empty($notif_users)): ?>
            <?php else: ?>
                <a href="message_users.php?supp3= <?= $_SESSION['users_id'] ?>">
                    <div class="item">
                        <img src="/image/notif.png" alt="">
                        <p>Vous avez <span><?= $count_notif_users ?></span> nouveaux messages</p>
                    </div>
                </a>
            <?php endif; ?>

            <?php if (empty($notif_suiviRecaler)): ?>
            <?php else: ?>
                <a href="/page/mes_demande.php?supp4= <?= $_SESSION['users_id'] ?>">
                    <div class="item">
                        <img src="/image/notif.png" alt="">
                        <p>Vous avez <span><?= $count_notif_suiviRecaler ?></span> candidature(s) recalée(s)</p>
                    </div>
                </a>
            <?php endif; ?>


            <?php if (empty($notif_suivi)): ?>
            <?php else: ?>
                <a href="/page/mes_demande.php?supp2= <?= $_SESSION['users_id'] ?>">
                    <div class="item">
                        <img src="/image/notif.png" alt="">
                        <p>Vous avez <span><?= $count_notif_suivi ?></span> candidature(s) acceptée(s)</p>
                    </div>
                </a>
            <?php endif; ?>


            <script>
                let not1 = document.querySelector('.not');
                let notif1 = document.querySelector('.croi')
                let notification1 = document.querySelector('.box_notif')

                not1.addEventListener('click', () => {
                    notification1.style.display = 'block'
                })
                notif1.addEventListener('click', () => {
                    notification1.style.display = 'none'
                })
            </script>
        </div>

    <?php else: ?>



        <?php if (isset($_SESSION['compte_entreprise'])): ?>

            <div class="box4">
                <div class="infos_users">
                    <img class="affiche" src="/upload/<?= $entreprise['images']; ?>" alt="">
                </div>
            </div>

            <div class="not">
                <img src="/image/notification.png" alt="" class="notif">
                <?php if ($afficheNotificationMessage or $afficheNotificationPostulation): ?>

                    <span><?= $countafficheNotificationMessage + $countnotificationPostulation ?></span><?php else: ?>
                <?php endif; ?>
            </div>


            <div class="box_notif">
                <img src="/image/croix.png" alt="" class="croi">

                <?php if (empty($afficheNotificationMessage)): ?>
                <?php else: ?>
                    <a href="/entreprise/message.php?supp1= <?= $_SESSION['compte_entreprise'] ?>">
                        <div class="item">
                            <img src="/image/notif.png" alt="">
                            <p>Vous avez <span><?= $countafficheNotificationMessage ?></span> nouveaux message(s)</p>
                        </div>
                    </a>
                <?php endif; ?>


                <?php if (empty($afficheNotificationPostulation)): ?>
                <?php else: ?>
                    <a href="/page/candidature.php?supp2= <?= $_SESSION['compte_entreprise'] ?>">
                        <div class="item">
                            <img src="/image/notif.png" alt="">
                            <p>Vous avez <span><?= $countnotificationPostulation ?></span> nouvelle(s) postulation(s)</p>
                        </div>
                    </a>
                <?php endif; ?>


                <script>
                    let not = document.querySelector('.not');
                    let notif = document.querySelector('.croi')
                    let notification = document.querySelector('.box_notif')

                    not.addEventListener('click', () => {
                        notification.style.display = 'block'
                    })
                    notif.addEventListener('click', () => {
                        notification.style.display = 'none'
                    })
                </script>
            </div>

        <?php else: ?>
            <?php if (isset($_SESSION['admin'])): ?>
                <div class="box4">
                    <div class="infos_users">
                        <p class="affiche">
                            Profil
                        </p>
                        <img class="affiche" src="/upload/<?= $admins['image']; ?>" alt="">
                    </div>
                    <a class="liens" href="../conn/dconn_admin.php">Déconnexion</a>
                </div>
            <?php else: ?>

                <div class="box3">
                    <a href="/inscription.php">Inscription</a>
                    <a href="/connection_compte.php">Connexion</a>
                </div>

            <?php endif ?>
        <?php endif ?>

    <?php endif ?>


    <div class="box_info">
        <?php if (isset($_SESSION['users_id'])): ?>
            <img class="affiche" src="/upload/<?= $users['images'] ?>" alt="">
            <img class="del" src="/image/croix.png" alt="">
            <table>
                <tr>
                    <th>Nom</th>
                    <td>
                        <?php echo $users['nom']; ?>
                    </td>
                </tr>
                <tr>
                    <th>E-mail</th>
                    <td>
                        <?php echo $users['mail']; ?>
                    </td>
                </tr>
                <tr>
                    <th>Téléphone</th>
                    <td>
                        <?php echo $users['phone']; ?>
                    </td>
                </tr>
                <tr>
                    <th>Ville</th>
                    <td>
                        <?php echo $users['ville']; ?>
                    </td>
                </tr>
                <tr>
                    <th>domaine</th>
                    <td>
                        <?php echo $users['competences']; ?>
                    </td>
                </tr>
            </table>

            <a href="../page/user_profil.php">Voir mon profil</a>
            <a class="dconn" href="/conn/dconn_users.php">Deconnexion</a>

        <?php else: ?>

            <?php if (isset($_SESSION['compte_entreprise'])): ?>

                <img class="del" src="/image/croix.png" alt="">
                <img class="affiche" src="/upload/<?= $entreprise['images'] ?>" alt="">

                <table>
                    <tr>
                        <th>Nom</th>
                        <td>
                            <?php echo $entreprise['nom']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>E-mail</th>
                        <td>
                            <?php echo $entreprise['mail']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Téléphone</th>
                        <td>
                            <?php echo $entreprise['phone']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Ville</th>
                        <td>
                            <?php echo $entreprise['ville']; ?>
                        </td>
                    </tr>
                    <!-- <tr>
                    <th>domaine</th>
                    <td><?php echo $entreprise['competences']; ?></td>
                </tr> -->
                </table>

                <a href="../entreprise/entreprise_profil.php">Voir mon profil</a>
                <a class="dconn" href="/conn/dconn_entreprise.php">Deconnexion</a>

            <? else: ?>
                <?php if (isset($_SESSION['admin'])): ?>

                    <img class="del" src="/image/croix.png" alt="">
                    <img class="affiche" src="/upload/<?= $entreprise['images'] ?>" alt="">

                    <table>
                        <tr>
                            <th>Nom</th>
                            <td>
                                <?php echo $admins['nom']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>E-mail</th>
                            <td>
                                <?php echo $admins['mail']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Téléphone</th>
                            <td>
                                <?php echo $admins['phone']; ?>
                            </td>
                        </tr>

                    </table>

                    <a href="/admin/t_admin.php">Voir mon profil</a>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>


    <script>
        let affiche = document.querySelector('.infos_users');
        let boxInfo = document.querySelector('.box_info');
        let del = document.querySelector('.del');

        affiche.addEventListener('click', () => {
            boxInfo.style.right = '10%';
        });

        del.addEventListener('click', () => {
            boxInfo.style.right = '-500%';
        });


    </script>
</nav>

<section id="none" class="section1">
    <div class="div">
        <span>1</span>
        <p>Trouvez rapidement les meilleurs talents qui correspondent à vos besoins</p>
    </div>
    <div class="div">
        <span>2</span>
        <p>Un processus de recrutement freelance facile et sans prise de tête</p>
    </div>
    <div class="div">
        <span>3</span>
        <p>Des profils hautement qualifiés et adaptables à vos projets</p>
    </div>
</section>