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

    $users_id = $_SESSION['users'];

    $pass = '';

 if(empty($_POST['pass'])){
    $erreurs = "Veuillez entrer un mot de passe";
 }else{
    $pass = htmlspecialchars($_POST['pass']);
 }
 

  if (empty($erreurs)) {

    $pass = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "UPDATE users
            SET passe = :pass WHERE id = :users_id";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':pass', $pass);
    $stmt->bindParam(':users_id', $users_id);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    
        // Connexion réussie 
        setcookie('users_id', $user['id'], time() + 60 * 60 * 24 * 30, '/');
        $_SESSION['users_id'] = $user['id']; // Initialisation de la variable de session

        header('location: ../page/mdp_message.php');
        exit();
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

  <section class="section1">
    <div>
      <span>1</span>
      <p>Trouver rapidement les meilleurs talents qui correspondent à vos besoins</p>
    </div>
    <div>
      <span>2</span>
      <p>Un processus de recrutement freelance facile et sans prise de tête</p>
    </div>
    <div>
      <span>3</span>
      <p>Des profils hautement qualifiés et adaptables à vos projets</p>
    </div>
  </section>

  <section class="section2">

    <div class="formulaire1  ">
      <img src="/image/undraw_secure_login_pdn4.svg" alt="">
      <form method="post" action="">
        <h3>Modification</h3>


        <?php if (isset($erreurs)) : ?>
          <div class="erreur"><?php echo $erreurs; ?></div>
        <?php endif; ?>


        <div class="box1">
          <label for="pass">Nouveau mot de passe</label>
          <input type="password" name="pass" id="pass">
        </div>

        <input type="submit" name="valider" value="Modifier" id="valider">
       
      </form>
    </div>
  </section>


</body>

</html>