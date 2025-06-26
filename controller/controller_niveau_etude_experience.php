<?php
require_once( __DIR__.'/../model/niveau_etude_experience.php');

// Fonction pour traiter les données du formulaire (utilisée pour l'ajout et la modification)
function processNiveauForm($db, $isUpdate = false) {
    if (!isset($_SESSION['users_id'])) {
        $_SESSION['error_message'] = "Utilisateur non authentifié.";
        return;
    }

    $users_id = $_SESSION['users_id'];
    $errors = [];

    $etude = $_POST['etude'] ?? '';
    $experience = $_POST['experience'] ?? '';

    // Validation
    if (empty($etude)) {
        $errors[] = "Veuillez choisir un niveau d'études.";
    }
    if (empty($experience)) {
        $errors[] = "Veuillez choisir un niveau d'expérience.";
    }

    $etude_valeurs = ["Bac+1an" => 1, "Bac+2ans" => 2, "Bac+3ans" => 3, "Bac+4ans" => 4, "Bac+5ans" => 5, "Bac+6ans" => 6, "Bac+7ans" => 7, "Bac+8ans" => 8, "Bac+9ans" => 9, "Bac+10ans" => 10, "Aucun" => 0];
    $experience_valeurs = ["1an" => 1, "2ans" => 2, "3ans" => 3, "4ans" => 4, "5ans" => 5, "6ans" => 6, "7ans" => 7, "8ans" => 8, "9ans" => 9, "10ans" => 10, "Aucun" => 0];

    if (!isset($etude_valeurs[$etude])) {
        $errors[] = "Niveau d'étude invalide.";
    }
    if (!isset($experience_valeurs[$experience])) {
        $errors[] = "Niveau d'expérience invalide.";
    }

    if (empty($errors)) {
        $n_etude = $etude_valeurs[$etude];
        $n_experience = $experience_valeurs[$experience];
        
        if ($isUpdate) {
            // Logique de mise à jour
            if (updateNiveau($db, $users_id, $etude, $experience, $n_etude, $n_experience)) {
                $_SESSION['success_message'] = "Niveaux mis à jour avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la mise à jour des niveaux.";
            }
        } else {
            // Logique d'insertion
            if (postNiveau($db, $users_id, $etude, $experience, $n_etude, $n_experience)) {
                $_SESSION['success_message'] = "Niveaux enregistrés avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'enregistrement des niveaux.";
            }
        }
    } else {
        $_SESSION['error_message'] = $errors[0];
    }
}

// Action: Ajouter les niveaux
if (isset($_POST['Ajouters'])) {
    processNiveauForm($db, false);
    header('Location: user_profil.php#niveau-section');
    exit();
}

// Action: Modifier les niveaux
if (isset($_POST['Ajouters1'])) {
    processNiveauForm($db, true);
    header('Location: user_profil.php#niveau-section');
    exit();
}

if(isset($_GET['id'])){
    $getNiveauEtude =  gettNiveau($db,$_GET['id']);
}else{
    if(isset($_SESSION['users_id'])){
        $getNiveauEtude =  gettNiveau($db, $_SESSION['users_id']);
    }
}


?>