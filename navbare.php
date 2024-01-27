<?php
include('conn/conn.php');


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
    }
}


?>


<nav>
    <a class="logo" href="../index.php"> <img src="/image/WF__2_.png " alt=""></a>
   <div class="container" >
    <img class="menu" src="/image/menu.png" alt="">
   <div class="box1">
   <img class="cacheMenu" src="/image/croix.png" alt="">
        <a href="../index.php">Accueil</a>
        <a href="../page/voir_profil.php">Orientation</a>
        <a href="../page/Offres_d'emploi.php">Offres d'emploi</a>
        <a href="#">Entreprise</a>
        <a href="../page/voir_profil.php">Explorer les profils</a>
    </div>
<script>
    let menu = document.querySelector(".menu");
    let box1 = document.querySelector(".box1");
    let cacheMenu = document.querySelector(".cacheMenu");
    menu.addEventListener("click", function () {
        box1.style.left = "50%";
    })
    cacheMenu.addEventListener("click", function () {
        box1.style.left = "-200%";
    })
</script>
    <div id="box2">
        <form action="post">
            <input type="search" name="search" id="search">
            <div class="bo-">
                <label id="label" for="submit"><img src="/image/recherche-.png" alt=""></label>
                <input type="submit" name="submit" id="submit" value="submit">
            </div>
        </form>
    </div>
   </div>

    <?php if (isset($_SESSION['users_id'])): ?>

        <div class="box4">
            <div class="infos_users">
                <p class="affiche">
                    Profil
                </p>
                <img class="affiche" src="/upload/<?= $users['images']; ?>" alt="">
            </div>
            <a class="liens" href="../conn/dconn_users.php">Déconnexion</a>
        </div>
    <?php else: ?>

        <?php if (isset($_SESSION['compte_entreprise'])): ?>

            <div class="box4">
                <div class="infos_users">
                    <p class="affiche">
                        Profil
                    </p>
                    <img class="affiche" src="/upload/<?= $entreprise['images']; ?>" alt="">
                </div>
                <a class="liens" href="../conn/dconn_entreprise.php">Déconnexion</a>
            </div>
        <?php else: ?>

            <div class="box3">
                <a href="/inscription.php">Inscription</a>
                <a href="/connection_compte.php">Connexion</a>
            </div>

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
            <?php endif; ?>
        <?php endif; ?>
    </div>


    <script>
        let affiche = document.querySelector('.infos_users');
        let boxInfo = document.querySelector('.box_info');
        let del = document.querySelector('.del');

        affiche.addEventListener('click', () => {
                boxInfo.style.right = '5%';
        });

        del.addEventListener('click', () => {
                boxInfo.style.right = '-100%';
        });


    </script>
</nav>

<section class="section1">
    <div class="div" >
        <span>1</span>
        <p>Trouver rapidement les meilleurs talents qui correspondent à vos besoins</p>
    </div>
    <div class="div" >
        <span>2</span>
        <p>Un processus de recrutement freelance facile et sans prise de tête</p>
    </div>
    <div class="div" >
        <span>3</span>
        <p>Des profils hautement qualifiés et adaptables à vos projets</p>
    </div>
</section>