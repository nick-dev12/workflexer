<?php
session_start();
// Inclusion du fichier de connexion à la BDD
include '../conn/conn.php';


// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['compte_entreprise']) && $_SESSION['compte_entreprise']) {

  // Rediriger l'utilisateur vers la page d'accueil
  header('Location: ../index.php');
  exit();
}




if (isset($_POST['valider'])) {

  $entreprise_id = $_POST['mail'];

  if (filter_var($entreprise_id, FILTER_VALIDATE_EMAIL)) {
    $mail = $entreprise_id;
  } else if (is_numeric($entreprise_id)) {
    $phone = $entreprise_id;
  } else {
    $erreurs = "Identifiant invalide";
  }

  if (empty($erreurs)) {

    $sql = "SELECT * FROM compte_entreprise
            WHERE mail = :mail OR phone = :phone";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':mail', $mail);
    $stmt->bindParam(':phone', $phone);
    $stmt->execute();
    $entreprise = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($entreprise) {
      if ($entreprise['verification_statut'] === '') {
        $erreurs = "Votre compte n'est pas encore validé";
        header('location: verification_entreprise.php');
        exit();
      }
    }

    if ($mail && !$entreprise) {
      $erreurs = "Email incorrect";
    } else if ($phone && !$entreprise) {
      $erreurs = "Numéro incorrect";
    } else if ($entreprise['verification_statut'] !== 'verified') {
      $erreurs = "Votre compte n'est pas active";
    } else {

      // Vérifier mot de passe
      $passe = $_POST['passe'];
      if (empty($passe)) {
        $erreurs = "Mot de passe requis";
      } elseif (!password_verify($passe, $entreprise['passe'])) {
        $erreurs = "Mot de passe incorrect";
      } else {
        // Connexion réussie 

        // Générer un nouveau jeton unique
        $token = bin2hex(random_bytes(16)); // 16 octets donne 32 caractères hexadécimaux

        // Stocker le jeton dans la base de données avec l'ID de l'utilisateur
        $sqlUpdateToken = "UPDATE compte_entreprise SET remember_token = :token WHERE id = :entreprise";
        $stmtUpdateToken = $db->prepare($sqlUpdateToken);
        $stmtUpdateToken->bindParam(':token', $token);
        $stmtUpdateToken->bindParam(':entreprise', $entreprise['id']);
        $stmtUpdateToken->execute();

        setcookie('compte_entreprise', $token, time() + 60 * 60 * 24 * 30, '/');
        $_SESSION['compte_entreprise'] = $entreprise['id']; // Initialisation de la variable de session

        header('location: entreprise_profil.php');
        exit();
      }
    }
  }
}



?>









<!DOCTYPE html>
<html lang="fr">

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

  <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
  <title>connexion_e</title>
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

  <?php include('../navbare.php') ?>


  <section class="section2">

    <div class="formulaire1  ">
      <img src="/image/undraw_secure_login_pdn4.svg" alt="">
      <form method="post" action="">
        <h3>Connexion</h3>


        <?php if (isset($erreurs)): ?>
          <div class="erreur"><?php echo $erreurs; ?></div>
        <?php endif; ?>


        <div class="box1">
          <label for="mail">adresse e-mail / n° de téléphone</label>
          <input type="text" name="mail" id="mail">
        </div>

        <div class="box1">
          <label for="passe">Mot de passe</label>
          <input type="password" name="passe" id="passe">
        </div>
        <input type="submit" name="valider" value="valider" id="valider">

        <a href="mdp_oublier.php">Mot de passe oublié ?</a>
      </form>

      <script>
        window.addEventListener('resize', function () {
          if (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA') {
            document.activeElement.scrollIntoView({ behavior: 'smooth' });
          }
        });
      </script>
    </div>
  </section>


</body>

</html>