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

if (isset($_COOKIE['users_id'])) {
  $users_id = $_COOKIE['users_id'];
} else {
  $users_id = '';
}

$erreurs = '';

if (isset($_POST['valider'])) {

    $nom = $mail = '';

 if(empty($_POST['nom'])){
    $erreurs = "Veuillez entrer votre nom et prénom";
 }else{
    $nom = htmlspecialchars($_POST['nom']);
 }

 if(empty($_POST['mail'])){
    $erreurs = "Veuillez entrer votre E-mail";
 }elseif (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
    $erreurs = "L'email n'est pas valide";
} else {
    $mail = $_POST['mail'];
 }

  if (empty($erreurs)) {

    $sql = "SELECT * FROM users
            WHERE nom = :nom OR mail = :mail";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':mail', $mail);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($nom && !$user) {
      $erreurs = "Nom incorrect";
    } else if ($mail && !$user) {
      $erreurs = "E-mail incorrect";
    } else {
        // Connexion réussie 
        setcookie('users', $user['id'], time() + 60 * 60 * 24 * 30, '/');
        $_SESSION['users'] = $user['id']; // Initialisation de la variable de session

        header('location: ../page/mdp_message.php');
        exit();
      }
    }
  }




if (isset($_SESSION['users_id'])) {
  // L'utilisateur est connecté, récupérez son ID
  $users_id = $_SESSION['users_id'];

  // Maintenant, vous pouvez utiliser $users_id pour récupérer les informations de l'utilisateur depuis la base de données
  // Écrivez votre requête SQL pour récupérer les informations nécessaires
  $conn = "SELECT * FROM users WHERE id = :users_id";
  $stmt = $db->prepare($conn);
  $stmt->bindParam(':users_id', $users_id);
  $stmt->execute();
  $users = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
  // L'utilisateur n'est pas connecté, gérez ce cas ici (redirection, message d'erreur, etc.)
  // Par exemple, vous pouvez rediriger vers la page de connexion

}

?>









<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5JBWCPV7');</script>
<!-- End Google Tag Manager -->

  <title>Recuperation</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="../css/navbare.css">
  <link rel="stylesheet" href="/css/mdp.css">
</head>

<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

  
<?php include ('../navbare.php') ?>

  <section class="section2">

    <div class="formulaire1  ">
      <img src="/image/undraw_secure_login_pdn4.svg" alt="">
      <form method="post" action="">
        <h3>Verification</h3>


        <?php if (isset($erreurs)) : ?>
          <div class="erreur"><?php echo $erreurs; ?></div>
        <?php endif; ?>


        <div class="box1">
          <label for="nom">Nom et Prénom</label>
          <input type="text" name="nom" id="nom">
        </div>

        <div class="box1">
          <label for="mail">E-mail</label>
          <input type="text" name="mail" id="mail">
        </div>

        <input type="submit" name="valider" value="Trouver mon compte" id="valider">
       
      </form>
    </div>
  </section>


</body>

</html>