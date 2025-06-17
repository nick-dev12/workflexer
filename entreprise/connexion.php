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
        $token = bin2hex(random_bytes(32)); // 32 octets donne 64 caractères hexadécimaux pour plus de sécurité

        // Stocker le jeton dans la base de données avec l'ID de l'utilisateur
        $sqlUpdateToken = "UPDATE compte_entreprise SET remember_token = :token WHERE id = :entreprise";
        $stmtUpdateToken = $db->prepare($sqlUpdateToken);
        $stmtUpdateToken->bindParam(':token', $token);
        $stmtUpdateToken->bindParam(':entreprise', $entreprise['id']);
        $stmtUpdateToken->execute();

        // Stocker le jeton dans le cookie pour une durée de 10 ans (connexion permanente)
        // 60 secondes * 60 minutes * 24 heures * 365 jours * 10 ans
        setcookie('compte_entreprises', $token, time() + 60 * 60 * 24 * 365 * 10, '/', '', false, true);
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
  <title>Connexion - Compte Entreprise</title>
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

  <section class="login-section">
    <div class="login-container">
      <div class="login-image" style="background-color: var(--secondary-color);">
        <img src="/image/undraw_secure_login_pdn4.svg" alt="Illustration de connexion sécurisée">
      </div>

      <div class="login-form-container">
        <div class="login-header">
          <h2>Connexion Entreprise</h2>
          <p>Accédez à votre espace entreprise pour gérer vos offres d'emploi</p>
        </div>

        <?php if (isset($erreurs)): ?>
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
            <a href="mdp_oublier.php">Mot de passe oublié ?</a>
          </div>

          <div class="form-actions">
            <button type="submit" name="valider" class="submit-button"
              style="background-color: var(--secondary-color);">
              <i class="fas fa-sign-in-alt"></i>Se connecter
            </button>

            <div class="separator">ou</div>

            <a href="/compte_entreprise.php" class="register-button"
              style="color: var(--secondary-color); border-color: var(--secondary-color);">
              <i class="fas fa-building"></i>Créer un compte entreprise
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