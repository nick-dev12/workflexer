
<link rel="stylesheet" href="../css/section2.css">


<section class="section2">
<img src="../image/croix.png" alt="" class="img111">
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
                <table>

                <tr class="me1">
                        <td id="td"><a href="modifier.php"><img src="../image/modifier.png" alt=""></a></td>
                        <td class="td" > <a href="../entreprise/modifier.php">Modifier</a></td>
                    </tr>

                    <tr class="me2" >
                        <td id="td"><a href="../entreprise/entreprise_profil.php"><img src="../image/entreprise_ic.png" alt=""></a></td>
                        <td class="td"><a href="../entreprise/entreprise_profil.php">Mon entreprise</a></td>
                    </tr>

                    <tr class="me3">
                        <td id="td"><img src="../image/candidat.png" alt=""></td>
                        <td class="td"><a href="../page/candidature.php">Candidats</a></td>
                    </tr>
                   
                    <tr class="me4">
                        <td id="td"><a href="message.php"><img src="../image/modifier.png" alt=""></a></td>
                        <td class="td"> <a href="../entreprise/message.php">Message</a></td>
                    </tr>
                    <tr class="me4">
                        <td id="td"><a href="message.php"><img src="../image/historique.png" alt=""></a></td>
                        <td class="td"> <a href="../entreprise/historique.php">Historique</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
