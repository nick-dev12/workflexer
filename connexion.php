<?php
session_start();
// Inclusion du fichier de connexion à la BDD

require_once 'conn/conn.php';

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['users_id']) && $_SESSION['users_id']) {

  // Rediriger l'utilisateur vers la page d'accueil
  header('Location: index.php');
  exit();
}


$erreurs = '';

if (isset($_POST['valider'])) {

  $user_id = $_POST['mail'];

  if (filter_var($user_id, FILTER_VALIDATE_EMAIL)) {
    $mail = $user_id;
  } else if (is_numeric($user_id)) {
    $phone = $user_id;
  } else {
    $erreurs = "Identifiant invalide";
  }

  if (empty($erreurs)) {

    $sql = "SELECT * FROM users
            WHERE mail = :mail OR phone = :phone";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':mail', $mail);
    $stmt->bindParam(':phone', $phone);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      if ($user['verification_statut'] === '') {
        $erreurs = "Votre compte n'est pas encore validé";
        header('location: verification_users.php');
        exit();
      }
    }

    if ($mail && !$user) {
      $erreurs = "Email incorrect";
    } else if ($phone && !$user) {
      $erreurs = "Numéro incorrect";
    } else {

      // Vérifier mot de passe
      $passe = $_POST['passe'];
      if (empty($passe)) {
        $erreurs = "Mot de passe requis";
      } elseif (!password_verify($passe, $user['passe'])) {
        $erreurs = "Mot de passe incorrect";
      } else {
        // Connexion réussie 
        // Générer un nouveau jeton unique
        $token = bin2hex(random_bytes(32)); // 32 octets donne 64 caractères hexadécimaux pour plus de sécurité
        
        // Définir l'expiration du token (30 jours)
        $tokenExpiry = date('Y-m-d H:i:s', time() + (30 * 24 * 60 * 60));

        // Stocker le jeton dans la base de données avec l'ID de l'utilisateur et la date d'expiration
        $sqlUpdateToken = "UPDATE users SET remember_token = :token, remember_token_expires = :expires WHERE id = :userId";
        $stmtUpdateToken = $db->prepare($sqlUpdateToken);
        $stmtUpdateToken->bindParam(':token', $token);
        $stmtUpdateToken->bindParam(':expires', $tokenExpiry);
        $stmtUpdateToken->bindParam(':userId', $user['id']);
        $stmtUpdateToken->execute();

        // Stocker le jeton dans le cookie pour 30 jours (plus sécurisé qu'une durée illimitée)
        setcookie('remember_me', $token, time() + (30 * 24 * 60 * 60), '/', '', false, true);
        $_SESSION['users_id'] = $user['id']; // Initialisation de la variable de session

        header('location: ../page/user_profil.php');
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


  <title>Connexion - Compte Professionnel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="../css/navbare.css">
  <link rel="stylesheet" href="/css/connexion.css">

</head>

<body>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
      style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <?php include('navbare.php') ?>

  <section class="login-section">
    <div class="login-container">
      <div class="login-image">
        <img src="/image/undraw_secure_login_pdn4.svg" alt="Illustration de connexion sécurisée">
      </div>

      <div class="login-form-container">
        <div class="login-header">
          <h2>Connexion</h2>
          <p>Accédez à votre espace professionnel pour gérer vos opportunités</p>
        </div>

        <?php if (!empty($erreurs)): ?>
          <div class="error-message" id="error-message">
            <i class="fas fa-exclamation-circle"></i>
            <span><?php echo $erreurs; ?></span>
          </div>
        <?php endif; ?>

        <form method="post" action="" class="login-form">
          <div class="form-group">
            <label for="mail">Adresse e-mail ou numéro de téléphone</label>
            <input type="text" name="mail" id="mail" class="form-input" placeholder="Entrez votre email ou téléphone">
          </div>

          <div class="form-group">
            <label for="passe">Mot de passe</label>
            <input type="password" name="passe" id="passe" class="form-input" placeholder="Entrez votre mot de passe">
            <i class="fas fa-eye password-toggle" id="togglePassword"></i>
          </div>

          <div class="forgot-password">
            <a href="/page/mdp_oublier.php">Mot de passe oublié ?</a>
          </div>

          <div class="form-actions">
            <button type="submit" name="valider" class="submit-button">
              <i class="fas fa-sign-in-alt"></i>Se connecter
            </button>

            <div class="separator">ou</div>

            <a href="/compte_travailleur.php" class="register-button">
              <i class="fas fa-user-plus"></i>Créer un compte professionnel
            </a>
          </div>
        </form>
      </div>
    </div>
  </section>

  <script>
    // Affichage/masquage du mot de passe
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('passe');

    togglePassword.addEventListener('click', function () {
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });

    // Animation pour les messages d'erreur
    const errorMessage = document.getElementById('error-message');
    if (errorMessage) {
      errorMessage.classList.add('shake');

      // Supprimer la classe après l'animation
      errorMessage.addEventListener('animationend', function () {
        this.classList.remove('shake');
      });
    }

    // Ajustement pour les appareils mobiles
    window.addEventListener('resize', function () {
      if (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA') {
        document.activeElement.scrollIntoView({ behavior: 'smooth' });
      }
    });
  </script>
</body>

</html>