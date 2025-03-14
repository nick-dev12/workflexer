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


  <title>Vérification et réinitialisation - Entreprise</title>
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

  <?php include('../navbare.php') ?>

  <?php if (isset($_SESSION['success_message'])): ?>
    <div class="success-message" id="successMessage">
      <i class="fas fa-check-circle"></i>
      <span><?php echo $_SESSION['success_message']; ?></span>
      <?php unset($_SESSION['success_message']); ?>
    </div>
  <?php endif; ?>

  <?php if (isset($_SESSION['error_message'])): ?>
    <div class="error-message" id="errorMessage">
      <i class="fas fa-exclamation-circle"></i>
      <span><?php echo $_SESSION['error_message']; ?></span>
      <?php unset($_SESSION['error_message']); ?>
    </div>
  <?php endif; ?>

  <section class="login-section">
    <div class="login-container">
      <div class="login-image" style="background-color: var(--secondary-color);">
        <img src="/image/undraw_secure_login_pdn4.svg" alt="Illustration de vérification">
      </div>

      <div class="login-form-container">
        <div class="login-header">
          <h2>Vérification et réinitialisation</h2>
          <p>Entrez votre code de vérification et créez un nouveau mot de passe pour votre compte entreprise</p>
        </div>

        <?php if (!empty($erreurs)): ?>
          <div class="error-message" id="error-message">
            <i class="fas fa-exclamation-circle"></i>
            <span><?php echo $erreurs; ?></span>
          </div>
        <?php endif; ?>

        <form method="post" action="" class="login-form">
          <div class="form-group">
            <label for="code">Code de vérification</label>
            <input type="number" name="code" id="code" class="form-input" placeholder="Entrez le code reçu par email">
          </div>

          <div class="form-group">
            <label for="mdp">Nouveau mot de passe</label>
            <input type="password" name="mdp" id="mdp" class="form-input"
              placeholder="Créez un nouveau mot de passe sécurisé">
            <i class="fas fa-eye password-toggle" id="togglePassword"></i>
            <div class="password-requirements">
              <div class="requirement" id="length-requirement">
                <i class="fas fa-times-circle requirement-icon"></i>
                <span>Au moins 8 caractères</span>
              </div>
              <div class="requirement" id="uppercase-requirement">
                <i class="fas fa-times-circle requirement-icon"></i>
                <span>Au moins une lettre majuscule</span>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" name="valider" class="submit-button"
              style="background-color: var(--secondary-color);">
              <i class="fas fa-check"></i>Valider
            </button>

            <div class="separator">ou</div>

            <a href="/entreprise/mdp_oublier.php" class="register-button"
              style="color: var(--secondary-color); border-color: var(--secondary-color);">
              <i class="fas fa-redo"></i>Demander un nouveau code
            </a>
          </div>
        </form>
      </div>
    </div>
  </section>

  <script>
    // Affichage/masquage du mot de passe
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('mdp');

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

    // Animation pour les messages de succès et d'erreur en haut de page
    const successMessage = document.getElementById('successMessage');
    const errorGlobalMessage = document.getElementById('errorMessage');

    if (successMessage) {
      setTimeout(() => {
        successMessage.classList.add('visible');
      }, 200);
      setTimeout(() => {
        successMessage.classList.remove('visible');
      }, 6000);
    }

    if (errorGlobalMessage) {
      setTimeout(() => {
        errorGlobalMessage.classList.add('visible');
      }, 200);
      setTimeout(() => {
        errorGlobalMessage.classList.remove('visible');
      }, 6000);
    }

    // Validation en temps réel du mot de passe
    const passwordInput = document.getElementById('mdp');
    const lengthRequirement = document.getElementById('length-requirement');
    const uppercaseRequirement = document.getElementById('uppercase-requirement');

    passwordInput.addEventListener('input', function () {
      const password = this.value;

      // Vérification de la longueur
      if (password.length >= 8) {
        lengthRequirement.querySelector('.requirement-icon').className = 'fas fa-check-circle requirement-icon valid';
        lengthRequirement.classList.add('met');
      } else {
        lengthRequirement.querySelector('.requirement-icon').className = 'fas fa-times-circle requirement-icon';
        lengthRequirement.classList.remove('met');
      }

      // Vérification de la présence d'une majuscule
      if (/[A-Z]/.test(password)) {
        uppercaseRequirement.querySelector('.requirement-icon').className = 'fas fa-check-circle requirement-icon valid';
        uppercaseRequirement.classList.add('met');
      } else {
        uppercaseRequirement.querySelector('.requirement-icon').className = 'fas fa-times-circle requirement-icon';
        uppercaseRequirement.classList.remove('met');
      }
    });

    // Ajustement pour les appareils mobiles
    window.addEventListener('resize', function () {
      if (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA') {
        document.activeElement.scrollIntoView({ behavior: 'smooth' });
      }
    });
  </script>
</body>

</html>