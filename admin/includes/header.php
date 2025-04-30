<?php
session_start();
include_once('../conn/conn.php');
include_once('../controller/controller_admin.php');

// Vérifier si l'utilisateur est connecté

// Récupérer les informations de l'administrateur
$admin = infoAdmin($db, $_SESSION['admin']);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration Work-Flexer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <img src="../image/logo 2.png" alt="Work-Flexer Logo">
                    <h1>Administration</h1>
                </div>
                <button class="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <div class="sidebar-menu">
                <a href="dashboard.php" class="menu-link">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tableau de bord</span>
                </a>

                <div class="menu-section">Utilisateurs</div>

                <a href="users.php" class="menu-link">
                    <i class="fas fa-users"></i>
                    <span>Professionnels</span>
                </a>

                <a href="entreprises.php" class="menu-link">
                    <i class="fas fa-building"></i>
                    <span>Entreprises</span>
                </a>

                <div class="menu-section">Contenu</div>

                <a href="offres.php" class="menu-link">
                    <i class="fas fa-briefcase"></i>
                    <span>Offres d'emploi</span>
                </a>

                <a href="candidatures.php" class="menu-link">
                    <i class="fas fa-file-alt"></i>
                    <span>Candidatures</span>
                </a>

                <div class="menu-section">Administration</div>

                <a href="categories.php" class="menu-link">
                    <i class="fas fa-tags"></i>
                    <span>Catégories</span>
                </a>

                <a href="messages.php" class="menu-link">
                    <i class="fas fa-envelope"></i>
                    <span>Messages</span>
                </a>

                <a href="statistiques.php" class="menu-link">
                    <i class="fas fa-chart-bar"></i>
                    <span>Statistiques</span>
                </a>

                <a href="parametres.php" class="menu-link">
                    <i class="fas fa-cog"></i>
                    <span>Paramètres</span>
                </a>

                <a href="add_admin.php" class="menu-link">
                    <i class="fas fa-user-plus"></i>
                    <span>Ajouter un admin</span>
                </a>

                <div class="menu-section">Compte</div>

                <a href="profil.php" class="menu-link">
                    <i class="fas fa-user"></i>
                    <span>Profil</span>
                </a>

                <a href="logout.php" class="menu-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </a>
            </div>
        </div>

        <!-- Header -->
        <div class="header">
            <div class="header-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Rechercher...">
                <button><i class="fas fa-search"></i></button>
            </div>

            <div class="header-actions">
                <div class="notifications">
                    <button><i class="fas fa-bell"></i></button>
                    <span class="count">3</span>
                </div>

                <div class="profile">
                    <img src="<?php echo !empty($admin['image']) ? '../upload/' . $admin['image'] : 'assets/images/default-avatar.png'; ?>"
                        alt="<?php echo $admin['nom']; ?>">
                    <span><?php echo $admin['nom']; ?></span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">