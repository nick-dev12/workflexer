<?php
session_start();
// Inclusion du fichier de connexion à la BDD
include '../conn/conn.php';


// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['compte_entreprise']) && $_SESSION['compte_entreprise']) {

  // Rediriger l'utilisateur vers la page d'accueil
  header('Location: index.php');
  exit();
}


$erreurs = '';

if (isset($_POST['valider'])) {
  $code = htmlspecialchars($_POST['code']);
  $mdp = htmlspecialchars($_POST['mdp']);

  // Vérification du champ mot de passe
  if (empty($mdp)) {
    $erreurs = 'Nouveau mot de passe obligatoire';
  } else {
    // Hachage du mot de passe
    $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
  }

  // Requête pour récupérer les données de l'utilisateur avec le code de vérification
  $sql = "SELECT * FROM verification_entreprise WHERE code = :code";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(":code", $code);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  // Si aucun résultat n'est retourné, le code est incorrect
  if (!$result) {
    $erreurs = "Code incorrect";
  } else {
    // Si le code est correct, mettre à jour le mot de passe de l'utilisateur
    $entreprise_id = $result["entreprise_id"];
    $sql_update = "UPDATE compte_entreprise SET passe = :mdp WHERE id = :entreprise_id";
    $stmt_update = $db->prepare($sql_update);
    $stmt_update->bindValue(":mdp", $mdp_hash);
    $stmt_update->bindValue(":entreprise_id", $entreprise_id);
    $stmt_update->execute();

    $sql = " DELETE FROM verification_entreprise WHERE code = :code ";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":code", $code);
    $stmt->execute();

    // Redirection vers la page de profil utilisateur après la mise à jour du mot de passe
    header('location: connexion.php');
    exit();
  }
}


// Connexion réussie 
// Générer un nouveau jeton unique
// $token = bin2hex(random_bytes(16)); // 16 octets donne 32 caractères hexadécimaux

// Stocker le jeton dans la base de données avec l'ID de l'utilisateur
// $sqlUpdateToken = "UPDATE users SET remember_token = :token WHERE id = :userId";
// $stmtUpdateToken = $db->prepare($sqlUpdateToken);
// $stmtUpdateToken->bindParam(':token', $token);
// $stmtUpdateToken->bindParam(':userId', $user['id']);
// $stmtUpdateToken->execute();

// Stocker le jeton dans le cookie (et éventuellement la session)
// setcookie('remember_me', $token, time() + 60 * 60 * 24 * 30, '/');
// $_SESSION['users_id'] = $user['id']; // Initialisation de la variable de session

?>









<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Google Tag Manager -->
  <script>(function (w, d, s, l, i) {
      w[l] = w[l] || []; w[l].push({
        'gtm.start':
          new Date().getTime(), event: 'gtm.js'
      }); var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
          'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');</script>
  <!-- End Google Tag Manager -->


  <title>Verification</title>
  <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="../css/navbare.css">
  <link rel="stylesheet" href="/css/connexion.css">

</head>

<body>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
      style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->




  <section class="section2">

    <div class="formulaire1  ">
      <form method="post" action="">
        <h3>Verification</h3>


        <?php if (isset($erreurs)): ?>
          <div class="erreur"><?php echo $erreurs; ?></div>
        <?php endif; ?>


        <div class="box1">
          <label for="code">Code de Verification</label>
          <input type="number" name="code" id="code">
        </div>
        <div class="box1">
          <label for="mdp">Nouveau mot de passe</label>
          <input type="password" name="mdp" id="mdp">
        </div>

        <input type="submit" name="valider" value="Valider" id="valider">

      </form>
    </div>
  </section>


</body>

</html>