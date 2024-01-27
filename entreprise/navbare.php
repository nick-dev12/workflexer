<?php
include('../conn/conn.php');


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

?>


<nav>
        <a class="logo" href="../index.php"><span>Work</span><span>Flexers</span></a>

        <div class="box1">
            <a href="/index.php">Accueil</a>
            <a href="../page/Offres_d'emploi.php">Offres d'emploi</a>
            <a href="#">Entreprise</a>
            <a href="../page/voir_profil.php">Explorer les profils</a>
        </div>

        <div class="box2">
            <form action="post">
                <input type="search" name="search" id="search">
                <label for="submit"><i class="fa-solid fa-magnifying-glass fa-xs"></i></label>
                <input type="submit" name="submit" id="submit" value="submit">
            </form>
        </div>

        <?php if (isset($_SESSION['compte_entreprise'])) : ?>

            <div class="box4">
                <div class="infos_users">
                    <p class="affiche"><?php echo $entreprise['nom']; ?></p>
                    <img class="affiche" src="/upload/<?= $entreprise['images'] ;?>" alt="">
                </div>
                <a class="liens" href="conn/dconn_users.php">Deconnection</a>
            </div>
        <?php else : ?>

            <div class="box3">
                <a href="../inscription.php">Inscription</a>
                <a href="../connexion.php">Connexion</a>
            </div>

        <?php endif  ?>

        <div class="box_info">

        <img class="affiche" src="/upload/<?= $entreprise['images'] ?>" alt="">
            
            <table>
                <tr>
                    <th>Nom</th>
                    <td> <?php echo $entreprise['nom']; ?></td>
                </tr>
                <tr>
                    <th>E-mail</th>
                    <td><?php echo $entreprise['mail']; ?></td>
                </tr>
                <tr>
                    <th>Telephonne</th>
                    <td><?php echo $entreprise['phone']; ?></td>
                </tr>
                <tr>
                    <th>Ville</th>
                    <td><?php echo $entreprise['ville']; ?></td>
                </tr>
                <!-- <tr>
                    <th>domaine</th>
                    <td><?php echo $entreprise['competences']; ?></td>
                </tr> -->
            </table>

            <a href="../page/user_profil.php">Voir mon profil</a>
        </div>

        <script>
            let affiche = document.querySelector('.infos_users');
            let boxInfo = document.querySelector('.box_info');

            let isOpen = false;

            affiche.addEventListener('click', () => {

                if (!isOpen) {
                    boxInfo.style.right = '5%';
                    isOpen = true;
                } else {
                    boxInfo.style.right = '-100%';
                    isOpen = false;
                }

            });

            
        </script>
    </nav>


    <section class="section1">
        <div>
            <span>1</span>
            <p>Trouver rapidement les meilleurs talents qui correspondent à vos besoins</p>
        </div>
        <div>
            <span>2</span>
            <p>Un processus de recrutement freelance facile et sans prise de tête</p>
        </div>
        <div>
            <span>3</span>
            <p>Des profils hautement qualifiés et adaptables à vos projets</p>
        </div>
    </section>