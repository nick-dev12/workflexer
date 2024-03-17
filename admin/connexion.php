<?php
session_start();
// Inclusion du fichier de connexion à la BDD
include '../conn/conn.php';


// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['admin']) && $_SESSION['admin']) {

    // Rediriger l'utilisateur vers la page d'accueil
    header('Location: ../index.php');
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

        $sql = "SELECT * FROM admin
            WHERE mail = :mail OR phone = :phone";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($mail && !$admin) {
            $erreurs = "Email incorrect";
        } else if ($phone && !$admin) {
            $erreurs = "Numéro incorrect";
        } else {

            // Vérifier mot de passe
            $passe = $_POST['passe'];
            if (empty($passe)) {
                $erreurs = "Mot de passe requis";
            } elseif (!password_verify($passe, $admin['passe'])) {
                $erreurs = "Mot de passe incorrect";
            } else {
                // Connexion réussie 
                // Générer un nouveau jeton unique
                $token = bin2hex(random_bytes(16)); // 16 octets donne 32 caractères hexadécimaux

                // Stocker le jeton dans la base de données avec l'ID de l'utilisateur
                $sqlUpdateToken = "UPDATE admin SET remember_token = :token WHERE id = :userId";
                $stmtUpdateToken = $db->prepare($sqlUpdateToken);
                $stmtUpdateToken->bindParam(':token', $token);
                $stmtUpdateToken->bindParam(':userId', $admin['id']);
                $stmtUpdateToken->execute();

                // Stocker le jeton dans le cookie (et éventuellement la session)
                setcookie('remember_mes', $token, time() + 60 * 60 * 24 * 30, '/');
                $_SESSION['admin'] = $admin['id']; // Initialisation de la variable de session

                header('location: t_admin.php');
                exit();
            }
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
                <h3>Connection</h3>


                <?php if (isset($erreurs)): ?>
                    <div class="erreur">
                        <?php echo $erreurs; ?>
                    </div>
                <?php endif; ?>


                <div class="box1">
                    <label for="mail">address-mail/n-telephone</label>
                    <input type="text" name="mail" id="mail">
                </div>

                <div class="box1">
                    <label for="passe">Mot de passe</label>
                    <input type="password" name="passe" id="passe">
                </div>

                <input type="submit" name="valider" value="valider" id="valider">

                <a href="/page/mdp_oublier.php">Mot de passe oublier ?</a>
            </form>
        </div>
    </section>


</body>

</html>