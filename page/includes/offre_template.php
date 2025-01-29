<?php
// Définir les variables en fonction de la source
$titre = isset($offre['titre']) ? $offre['titre'] : $offre['poste'];
$contrat = isset($offre['type_contrat']) ? $offre['type_contrat'] : $offre['contrat'];
$date = isset($offre['date_publication']) ? $offre['date_publication'] : $offre['date'];
$entreprise = $offre['entreprise'];
$localisation = isset($offre['localisation']) ? $offre['localisation'] : $offre['localite'];

// Déterminer le lien
$lien = '#';
switch ($offre['source']) {
    case 'offre_emploi':
        $lien = "../entreprise/voir_offre.php?offres_id=" . $offre['offre_id'];
        break;
    case 'emploi_emploi':
        $lien = "emploi_details1.php?id=" . $offre['offre_id'];
        break;
    case 'emploi_dakar':
        $lien = "emploi_details2.php?id=" . $offre['offre_id'];
        break;
    case 'senjob':
        $lien = "emploi_details3.php?id=" . $offre['offre_id'];
        break;
}
?>

<div class="header">
    <span class="contrat"><?php echo $contrat; ?></span>
    <span class="date"><?php echo $date; ?></span>
</div>
<h2 class="poste"><?php echo $titre; ?></h2>
<div class="entreprise">
    <img src="../image/immeuble.png" alt="Entreprise">
    <span><?php echo $entreprise; ?></span>
</div>
<div class="localite">
    <img src="../image/position.png" alt="Localisation">
    <span><?php echo $localisation; ?></span>
</div>
<?php if (isset($offre['mission']) || isset($offre['description'])): ?>
    <!-- <p class="description">
        <?php
        $description = isset($offre['mission']) ? $offre['mission'] : $offre['description'];
        echo substr($description, 0, 100) . '...';
        ?>
    </p> -->
<?php endif; ?>
<a href="<?php echo $lien; ?>" class="details-btn">
    Voir les détails
</a>