<?php
session_start();
include_once('../conn/conn.php');
include_once('../controller/controller_admin.php');

// Rediriger si déjà connecté
if (isset($_SESSION['admin'])) {
    header('Location: dashboard.php');
    exit;
}

// Traitement du formulaire d'inscription
if (isset($_POST['inscription'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $mail = htmlspecialchars($_POST['mail']);
    $passe = $_POST['passe'];
    $confirm_passe = $_POST['confirm_passe'];

    // Validation des données
    $errors = [];

    // Vérifier si l'email existe déjà
    $sql = "SELECT COUNT(*) as count FROM admin WHERE mail = :mail";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':mail', $mail);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        $errors[] = "Cet email est déjà utilisé";
    }

    // Vérifier que les mots de passe correspondent
    if ($passe !== $confirm_passe) {
        $errors[] = "Les mots de passe ne correspondent pas";
    }

    // Vérifier la complexité du mot de passe
    if (strlen($passe) < 8) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
    }

    // Si aucune erreur, ajouter l'administrateur
    if (empty($errors)) {
        // Hacher le mot de passe
        $hashed_password = password_hash($passe, PASSWORD_DEFAULT);

        // Traitement de l'image si elle existe
        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed)) {
                // Générer un nom unique pour l'image
                $new_filename = uniqid() . '.' . $ext;
                $destination = '../upload/' . $new_filename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $image = $new_filename;
                }
            }
        }

        // Insérer le nouvel administrateur
        $sql = "INSERT INTO admin (nom, mail, passe, image) VALUES (:nom, :mail, :passe, :image)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':passe', $hashed_password);
        $stmt->bindParam(':image', $image);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Votre compte administrateur a été créé avec succès. Veuillez vous connecter.";
            header('Location: index.php');
            exit;
        } else {
            $errors[] = "Une erreur est survenue lors de l'inscription";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Administration - Work-Flexer</title>
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

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .signup-container {
            background-color: var(--light-bg);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 500px;
            padding: 40px;
            text-align: center;
        }

        .logo {
            margin-bottom: 20px;
        }

        .logo img {
            height: 60px;
        }

        h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 30px;
            color: var(--text-color);
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-color);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 15px;
            color: var(--text-color);
            transition: border-color 0.2s;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .file-input {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8fafc;
            border: 1px dashed var(--border-color);
            border-radius: 6px;
            padding: 12px;
            cursor: pointer;
            font-size: 14px;
            color: var(--light-text);
            transition: all 0.2s;
        }

        .file-input-label:hover {
            background-color: #f1f5f9;
            border-color: var(--accent-color);
        }

        .file-input-label i {
            margin-right: 8px;
            font-size: 18px;
        }

        .file-input input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .signup-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 12px 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 10px;
        }

        .signup-btn:hover {
            background-color: var(--secondary-color);
        }

        .signup-btn i {
            margin-right: 8px;
        }

        .error-list {
            color: var(--error-color);
            margin-bottom: 20px;
            font-size: 14px;
            background-color: rgba(239, 68, 68, 0.1);
            padding: 12px;
            border-radius: 6px;
            text-align: left;
        }

        .error-list ul {
            margin: 0;
            padding-left: 20px;
        }

        .back-to-login {
            margin-top: 25px;
            font-size: 14px;
            color: var(--light-text);
        }

        .back-to-login a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .back-to-login a:hover {
            text-decoration: underline;
        }

        .password-strength {
            margin-top: 5px;
            font-size: 12px;
            color: var(--light-text);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--light-text);
        }

        .password-field {
            position: relative;
        }
    </style>
</head>

<body>
    <div class="signup-container">
        <div class="logo">
            <img src="../image/logo 2.png" alt="Work-Flexer Logo">
        </div>
        <h1>Inscription Administrateur</h1>

        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="error-list">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="" enctype="multipart/form-data">
            <div class="input-group">
                <label for="nom">Nom complet</label>
                <input type="text" name="nom" id="nom" value="<?php echo isset($nom) ? $nom : ''; ?>" required>
            </div>

            <div class="input-group">
                <label for="mail">Adresse e-mail</label>
                <input type="email" name="mail" id="mail" value="<?php echo isset($mail) ? $mail : ''; ?>" required>
            </div>

            <div class="input-group">
                <label for="passe">Mot de passe</label>
                <div class="password-field">
                    <input type="password" name="passe" id="passe" required>
                    <span class="password-toggle" onclick="togglePassword('passe')">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                <div class="password-strength">Le mot de passe doit contenir au moins 8 caractères</div>
            </div>

            <div class="input-group">
                <label for="confirm_passe">Confirmer le mot de passe</label>
                <div class="password-field">
                    <input type="password" name="confirm_passe" id="confirm_passe" required>
                    <span class="password-toggle" onclick="togglePassword('confirm_passe')">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="input-group">
                <label for="image">Photo de profil (optionnel)</label>
                <div class="file-input">
                    <label for="image" class="file-input-label">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span id="file-name">Choisir une image</span>
                    </label>
                    <input type="file" name="image" id="image" accept="image/*">
                </div>
            </div>

            <button type="submit" name="inscription" class="signup-btn">
                <i class="fas fa-user-plus"></i> S'inscrire
            </button>
        </form>

        <div class="back-to-login">
            Déjà inscrit? <a href="index.php">Se connecter</a>
        </div>
    </div>

    <script>
        // Afficher le nom du fichier sélectionné
        document.getElementById('image').addEventListener('change', function () {
            const fileName = this.files[0] ? this.files[0].name : 'Choisir une image';
            document.getElementById('file-name').textContent = fileName;
        });

        // Fonction pour afficher/masquer le mot de passe
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>