<?php
session_start();
include_once('../conn/conn.php');
include_once('../controller/controller_admin.php');

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

// Récupérer les informations de l'administrateur
$admin = infoAdmin($db, $_SESSION['admin']);

// Vérifier si l'administrateur actuel a les droits suffisants
// Idéalement, il faudrait vérifier si l'admin a un rôle "super admin"
// Pour cet exemple, nous permettons à tous les administrateurs d'ajouter d'autres admins

// Traitement du formulaire d'ajout d'administrateur
if (isset($_POST['ajouter'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $mail = htmlspecialchars($_POST['mail']);
    $passe = $_POST['passe'];
    $confirm_passe = $_POST['confirm_passe'];
    $role = htmlspecialchars($_POST['role']);

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
                } else {
                    $errors[] = "Erreur lors du téléchargement de l'image";
                }
            } else {
                $errors[] = "Format d'image non supporté. Utilisez JPG, JPEG, PNG ou GIF";
            }
        }

        if (empty($errors)) {
            // Insérer le nouvel administrateur dans la base de données
            $sql = "INSERT INTO admin (nom, mail, passe, role, image, date_creation) 
                    VALUES (:nom, :mail, :passe, :role, :image, NOW())";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':passe', $hashed_password);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':image', $image);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Administrateur ajouté avec succès";
                header('Location: dashboard.php');
                exit;
            } else {
                $errors[] = "Erreur lors de l'ajout de l'administrateur";
            }
        }
    }
}

include_once('includes/header.php');
?>

<div class="dashboard-header">
    <h1 class="dashboard-title">Ajouter un Administrateur</h1>
    <p class="dashboard-subtitle">Créer un nouveau compte administrateur pour le système</p>
</div>

<?php if (isset($errors) && !empty($errors)): ?>
    <div class="alert alert-error" data-auto-dismiss="5000">
        <i class="fas fa-exclamation-circle"></i>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="form-container">
    <form method="post" action="" enctype="multipart/form-data" class="admin-form">
        <div class="form-section">
            <h3>Informations de base</h3>

            <div class="form-group">
                <label for="nom">Nom complet <span class="required">*</span></label>
                <input type="text" id="nom" name="nom" value="<?php echo isset($nom) ? htmlspecialchars($nom) : ''; ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="mail">Adresse email <span class="required">*</span></label>
                <input type="email" id="mail" name="mail"
                    value="<?php echo isset($mail) ? htmlspecialchars($mail) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="role">Rôle <span class="required">*</span></label>
                <select id="role" name="role" required>
                    <option value="admin" <?php echo (isset($role) && $role === 'admin') ? 'selected' : ''; ?>>
                        Administrateur</option>
                    <option value="super_admin" <?php echo (isset($role) && $role === 'super_admin') ? 'selected' : ''; ?>>Super Administrateur</option>
                    <option value="moderateur" <?php echo (isset($role) && $role === 'moderateur') ? 'selected' : ''; ?>>
                        Modérateur</option>
                </select>
            </div>
        </div>

        <div class="form-section">
            <h3>Sécurité</h3>

            <div class="form-group">
                <label for="passe">Mot de passe <span class="required">*</span></label>
                <input type="password" id="passe" name="passe" required>
                <small>Le mot de passe doit contenir au moins 8 caractères</small>
            </div>

            <div class="form-group">
                <label for="confirm_passe">Confirmer le mot de passe <span class="required">*</span></label>
                <input type="password" id="confirm_passe" name="confirm_passe" required>
            </div>
        </div>

        <div class="form-section">
            <h3>Photo de profil</h3>

            <div class="form-group">
                <label for="image">Image de profil</label>
                <input type="file" id="image" name="image" accept="image/*">
                <small>Formats acceptés: JPG, JPEG, PNG, GIF</small>
            </div>

            <div class="image-preview">
                <div id="preview-container" style="display: none;">
                    <img id="preview-image" src="#" alt="Aperçu">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="dashboard.php" class="btn btn-secondary">Annuler</a>
            <button type="submit" name="ajouter" class="btn btn-primary">Ajouter l'administrateur</button>
        </div>
    </form>
</div>

<style>
    .form-container {
        background-color: var(--light-bg);
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 30px;
        margin-bottom: 30px;
    }

    .admin-form {
        max-width: 800px;
        margin: 0 auto;
    }

    .form-section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .form-section h3 {
        margin-bottom: 20px;
        font-size: 18px;
        color: var(--text-color);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="password"],
    .form-group select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 16px;
    }

    .form-group input[type="file"] {
        padding: 8px 0;
    }

    .form-group small {
        display: block;
        margin-top: 5px;
        color: var(--light-text);
        font-size: 12px;
    }

    .required {
        color: var(--error-color);
    }

    .image-preview {
        margin-top: 15px;
    }

    #preview-container {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
        background-color: #f8fafc;
        border: 1px solid var(--border-color);
    }

    #preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 30px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        border: none;
        font-size: 16px;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-secondary {
        background-color: var(--light-bg);
        color: var(--text-color);
        border: 1px solid var(--border-color);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .alert ul {
        margin: 5px 0 0 20px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Aperçu de l'image
        const imageInput = document.getElementById('image');
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('preview-image');

        imageInput.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.addEventListener('load', function () {
                    previewImage.setAttribute('src', this.result);
                    previewContainer.style.display = 'block';
                });

                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        });
    });
</script>

<?php
include_once('includes/footer.php');
?>