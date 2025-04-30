<?php
// Démarre la session
session_start();
include_once('../conn/conn.php');
include_once('../controller/controller_admin.php');

// Rediriger si déjà connecté
if (isset($_SESSION['admin'])) {
    header('Location: dashboard.php');
    exit;
}

// Traitement du formulaire de connexion
if (isset($_POST['connexion'])) {
    $mail = htmlspecialchars($_POST['mail']);
    $passe = $_POST['passe'];
    $remember = isset($_POST['remember']) ? true : false;

    // Vérifier si l'email existe
    $sql = "SELECT * FROM admin WHERE mail = :mail";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':mail', $mail);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($passe, $admin['passe'])) {
        // Connexion réussie
        $_SESSION['admin'] = $admin['id'];

        // Si "Se souvenir de moi" est coché
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $sql = "UPDATE admin SET remember_token = :token WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':id', $admin['id']);
            $stmt->execute();

            setcookie('remember_me', $token, time() + 30 * 24 * 60 * 60, '/', '', false, true);
        }

        header('Location: dashboard.php');
        exit;
    } else {
        $error_message = "Email ou mot de passe incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration Work-Flexer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #3b82f6;
            --text-color: #1e293b;
            --light-text: #64748b;
            --bg-color: #f1f5f9;
            --light-bg: #ffffff;
            --error-color: #ef4444;
            --success-color: #10b981;
            --border-color: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background-color: var(--light-bg);
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
        }

        .logo {
            margin-bottom: 24px;
        }

        .logo img {
            height: 60px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 24px;
            color: var(--primary-color);
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: var(--light-text);
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.2s;
        }

        .input-group input:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
            font-size: 14px;
            color: var(--light-text);
        }

        .remember-me input {
            margin-right: 8px;
        }

        .login-btn {
            background-color: var(--primary-color);
            color: white;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .login-btn:hover {
            background-color: var(--secondary-color);
        }

        .error-message {
            color: var(--error-color);
            margin-bottom: 20px;
            font-size: 14px;
            background-color: rgba(239, 68, 68, 0.1);
            padding: 8px;
            border-radius: 4px;
        }

        .back-to-site {
            margin-top: 20px;
            font-size: 14px;
        }

        .back-to-site a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .back-to-site a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <img src="../image/logo 2.png" alt="Work-Flexer Logo">
        </div>
        <h1>Administration</h1>

        <?php if (isset($error_message)): ?>
            <div class="error-message">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="input-group">
                <label for="mail">Adresse e-mail</label>
                <input type="email" name="mail" id="mail" required>
            </div>
            <div class="input-group">
                <label for="passe">Mot de passe</label>
                <input type="password" name="passe" id="passe" required>
            </div>
            <div class="remember-me">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Se souvenir de moi</label>
            </div>
            <button type="submit" name="connexion" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Connexion
            </button>
        </form>

        <div class="back-to-site">
            <a href="../index.php">
                <i class="fas fa-arrow-left"></i> Retour au site
            </a>
        </div>
    </div>
</body>

</html>