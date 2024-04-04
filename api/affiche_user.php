<?php

$ch = curl_init("https://work-flexer.com/api/getUsers.php");

// Désactiver la vérification du certificat SSL (non recommandé en production)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$json = curl_exec($ch);

// Vérifier s'il y a eu une erreur lors de la requête cURL
if($json === false) {
    echo 'Erreur cURL : ' . curl_error($ch);
    // Gérer l'erreur de requête cURL selon vos besoins
} else {
    // Fermer la session cURL
    curl_close($ch);
    
    // Vérifier si la réponse est vide
    if(empty($json)) {
        echo 'Réponse vide';
        // Gérer la réponse vide selon vos besoins
    } else {
        // Décoder la réponse JSON
        $data = json_decode($json, true);
        
        // Vérifier si le décodage JSON a échoué
        if($data === null) {
            echo 'Erreur de décodage JSON : ' . json_last_error_msg();
            // Gérer l'erreur de décodage JSON selon vos besoins
        } else {
            // Parcourir les données JSON
            foreach ($data as $datas) {
                // Vérifier si 'id' est présent dans chaque objet
                if (isset($datas['id'])) {
                    echo $datas['id'] ;
                    echo $datas['nom'] . '<br> <br>';
                } else {
                    // Gérer l'absence de l'élément 'id' dans un objet
                    echo "ID absent dans un objet";
                }
            }
        }
    }
}


