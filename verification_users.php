<?php
session_start();
// Inclusion du fichier de connexion à la BDD
include 'conn/conn.php';


// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['users_id']) && $_SESSION['users_id']) {

  // Rediriger l'utilisateur vers la page d'accueil
  header('Location: index.php');
  exit();
}




if (isset($_POST['valider'])) {
  $code = '';

  if (empty($_POST['code'])) {
    $erreurs = 'Ce champ ne doit pas être vide.';
  } else {
    $code = htmlspecialchars($_POST['code']);
  }

  if (empty($erreurs)) {

    $sql = "SELECT * FROM users
            WHERE verification = :verification ";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':verification', $code);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($code && !$user) {
      $erreurs = "Code incorrect";
    } else {
      // Générer un nouveau jeton unique
      $token = bin2hex(random_bytes(16)); // 16 octets donne 32 caractères hexadécimaux
      $verified_statut = 'verified';
      // Stocker le jeton dans la base de données avec l'ID de l'utilisateur 
      $sqlUpdateToken = "UPDATE users SET remember_token = :token , verification_statut = :verified_statut  WHERE id = :id";
      $stmtUpdateToken = $db->prepare($sqlUpdateToken);
      $stmtUpdateToken->bindParam(':token', $token);
      $stmtUpdateToken->bindParam(':verified_statut', $verified_statut);
      $stmtUpdateToken->bindParam(':id', $user['id']);
      $stmtUpdateToken->execute();

      // Stocker le jeton dans le cookie (et éventuellement la session)
      setcookie('remember_me', $token, time() + 60 * 60 * 24 * 30, '/');
      $_SESSION['users_id'] = $user['id']; // Initialisation de la variable de session

      header('location: page/user_profil.php');
      exit();
    }
  }
}




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
      <img src="/image/undraw_secure_login_pdn4.svg" alt="">
      <form method="post" action="">
        <h3>Confirmation de compte</h3>

        <?php if (isset($erreurs)): ?>
          <div class="erreur">
            <?php echo $erreurs; ?>
          </div>
        <?php endif; ?>


        <div class="box1">
          <label for="code">Entrer le code de vérification envoyé à votre boîte mail.</label>
          <input type="text" name="code" id="code">
        </div>

        <input type="submit" name="valider" value="valider" id="valider">
      </form>
    </div>
  </section>


</body>

</html>