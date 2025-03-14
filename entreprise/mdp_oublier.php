<?php
session_start();
// Inclusion du fichier de connexion à la BDD
include '../conn/conn.php';


// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['users_id']) && $_SESSION['users_id']) {

  // Rediriger l'utilisateur vers la page d'accueil
  header('Location: index.php');
  exit();
}



$erreurs = '';

if (isset($_POST['valider'])) {

  $nom = $mail = '';

  if (empty($_POST['nom'])) {
    $erreurs = "Veuillez entrer votre nom et prénom";
  } else {
    $nom = htmlspecialchars($_POST['nom']);
  }

  if (empty($_POST['mail'])) {
    $erreurs = "Veuillez entrer votre E-mail";
  } elseif (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
    $erreurs = "L'email n'est pas valide";
  } else {
    $mail = $_POST['mail'];
  }

  if (empty($erreurs)) {

    $sql = "SELECT * FROM compte_entreprise
            WHERE nom = :nom OR mail = :mail";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':mail', $mail);
    $stmt->execute();

    $entreprise = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($nom && !$entreprise) {
      $erreurs = "Nom incorrect";
    } else if ($mail && !$entreprise) {
      $erreurs = "E-mail incorrect";
    } else {
      // Connexion réussie 
      setcookie('entreprise', $entreprise['id'], time() + 60 * 60 * 24 * 30, '/');
      $_SESSION['entreprise'] = $entreprise['id']; // Initialisation de la variable de session

      header('location: mdp_message.php');
      exit();
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

  <title>Récupération de mot de passe - Entreprise</title>
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

  <section class="login-section">
    <div class="login-container">
      <div class="login-image" style="background-color: var(--secondary-color);">
        <img src="/image/undraw_secure_login_pdn4.svg" alt="Illustration de récupération de mot de passe">
      </div>

      <div class="login-form-container">
        <div class="login-header">
          <h2>Récupération de mot de passe</h2>
          <p>Veuillez entrer vos informations pour retrouver votre compte entreprise</p>
        </div>

        <?php if (!empty($erreurs)): ?>
          <div class="error-message" id="error-message">
            <i class="fas fa-exclamation-circle"></i>
            <span><?php echo $erreurs; ?></span>
          </div>
        <?php endif; ?>

        <form method="post" action="" class="login-form">
          <div class="form-group">
            <label for="nom">Nom et Prénom du responsable</label>
            <input type="text" name="nom" id="nom" class="form-input" placeholder="Entrez votre nom et prénom">
          </div>

          <div class="form-group">
            <label for="mail">Adresse e-mail professionnelle</label>
            <input type="email" name="mail" id="mail" class="form-input"
              placeholder="Entrez votre adresse e-mail professionnelle">
          </div>

          <div class="form-actions">
            <button type="submit" name="valider" class="submit-button"
              style="background-color: var(--secondary-color);">
              <i class="fas fa-search"></i>Trouver mon compte
            </button>

            <div class="separator">ou</div>

            <a href="/entreprise/connexion.php" class="register-button"
              style="color: var(--secondary-color); border-color: var(--secondary-color);">
              <i class="fas fa-arrow-left"></i>Retour à la connexion
            </a>
          </div>
        </form>
      </div>
    </div>
  </section>

  <script>
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