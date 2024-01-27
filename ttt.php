<section class="produit_vedete">
        <div class="box1">
            <span></span>
            <h1> Design et création</h1>
            <span></span>
            <div class="affiche">
                <!-- <img src="/image/info.jpg" alt=""> -->
                <img src="/image/webdesign.jpg" alt="">
            </div>
        </div>

        <div class="box2">
            <span><i class="fa-solid fa-chevron-left"></i></span>
            <span><i class="fa-solid fa-chevron-right"></i></span>
        </div>

        <article class="articles owl-carousel carousel2">
            <?php if (empty($UsersDesign)): ?>

                <h1 class="message">Aucun profil disponible pour cette catégorie</h1>

            <?php else: ?>

                <?php foreach ($UsersDesign as $Designs): ?>
                    <?php if ($Designs['statut'] == 'Occuper'): ?>

                    <?php else: ?>

                        <div class="carousel">
                            <?php if ($Designs['statut'] == 'Disponible'): ?>
                                <p class="statut"><span></span>
                                    <?= $Designs['statut'] ?>
                                </p>
                            <?php else: ?>
                                <?php if ($Designs['statut'] == 'Occuper'): ?>
                                    <p class="statut2"><span></span>
                                        <?= $Designs['statut'] ?>
                                    </p>
                                <?php else: ?>
                                    <p class="statut"><span></span> Disponible</p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <img src="../upload/<?php echo $Designs['images'] ?>" alt="">
                            <h4>
                                <?php echo $Designs['competences']; ?>
                            </h4>

                            <div class="vendu">
                                <?php $afficheCompetences = getCompetences($db, $Designs['id']) ?>
                                <?php if (empty($afficheCompetences)): ?>
                                    <span>Competences indisponibles</span>
                                <?php else: ?>
                                    <?php
                                    $competencesAffichees = 0; // Initialiser le compteur de compétences affichées
                    
                                    foreach ($afficheCompetences as $compe):
                                        if ($competencesAffichees < 4):
                                            ?>
                                            <span>
                                                <?= $compe['competence'] ?>
                                            </span>
                                            <?php
                                            $competencesAffichees++;
                                        endif;
                                    endforeach;
                                    ?>
                                <?php endif; ?>
                            </div>
                            <p id="nom"><strong>Nom :</strong>
                                <?php echo $Designs['nom']; ?>
                            </p>
                            <p id="nom"><strong>Ville :</strong>
                                <?php echo $Designs['ville']; ?>
                            </p>

                            <a href="/page/candidats.php?id=<?php echo $Designs['id']; ?>">
                                <i class="fa-solid fa-eye"></i>Profil
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach ?>

            <?php endif; ?>
        </article>
    </section>