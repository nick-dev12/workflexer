<?php
include_once('includes/header.php');

// Vérifier si l'ID est présent
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = "ID d'utilisateur invalide";
    header('Location: users.php');
    exit;
}

$userId = $_GET['id'];

// Récupérer les informations de l'utilisateur
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['error_message'] = "Utilisateur non trouvé";
    header('Location: users.php');
    exit;
}

// Récupérer les compétences de l'utilisateur
$sql = "SELECT * FROM competence_users WHERE users_id = :users_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':users_id', $userId);
$stmt->execute();
$competences = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les formations de l'utilisateur
$sql = "SELECT * FROM formation_users WHERE users_id = :users_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':users_id', $userId);
$stmt->execute();
$formations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les expériences professionnelles
$sql = "SELECT * FROM metier_users WHERE users_id = :users_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':users_id', $userId);
$stmt->execute();
$experiences = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Récupérer les certificats
$sql = "SELECT * FROM certificat_users WHERE users_id = :users_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':users_id', $userId);
$stmt->execute();
$certificats = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les centres d'intérêt
$sql = "SELECT * FROM centre_interet WHERE users_id = :users_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':users_id', $userId);
$stmt->execute();
$interets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les langues
$sql = "SELECT * FROM langue_users WHERE users_id = :users_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':users_id', $userId);
$stmt->execute();
$langues = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer le nombre de vues du profil
$sql = "SELECT COUNT(*) as total FROM vue_profil WHERE profil_id = :profil_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':profil_id', $userId);
$stmt->execute();
$vuesProfil = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Récupérer le nombre de candidatures
$sql = "SELECT COUNT(*) as total FROM postulation WHERE users_id = :users_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':users_id', $userId);
$stmt->execute();
$candidatures = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
?>

<div class="dashboard-header">
    <h1 class="dashboard-title">Profil de <?php echo $user['nom']; ?></h1>
    <p class="dashboard-subtitle">Consultez les informations détaillées de cet utilisateur professionnel.</p>
</div>

<div class="action-buttons">
    <a href="users.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
    <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-primary">
        <i class="fas fa-edit"></i> Modifier
    </a>
    <button class="btn btn-danger" data-confirm-delete="Êtes-vous sûr de vouloir supprimer cet utilisateur ?"
        onclick="if(confirm(this.dataset.confirmDelete)) window.location.href='delete_user.php?id=<?php echo $user['id']; ?>'">
        <i class="fas fa-trash"></i> Supprimer
    </button>
</div>

<div class="user-profile">
    <div class="profile-header">
        <div class="profile-image">
            <img src="<?php echo !empty($user['images']) ? '../upload/' . $user['images'] : 'assets/images/default-avatar.png'; ?>"
                alt="<?php echo $user['nom']; ?>">
        </div>
        <div class="profile-info">
            <h2><?php echo $user['nom']; ?></h2>
            <p class="profession"><?php echo $user['profession']; ?></p>
            <p class="location"><i class="fas fa-map-marker-alt"></i> <?php echo $user['ville']; ?></p>
            <p class="status"><span
                    class="status-indicator <?php echo $user['statut'] == 'Disponible' ? 'active' : 'inactive'; ?>"></span>
                <?php echo $user['statut']; ?></p>
        </div>
        <div class="profile-stats">
            <div class="stat">
                <div class="stat-value"><?php echo $vuesProfil; ?></div>
                <div class="stat-label">Vues du profil</div>
            </div>
            <div class="stat">
                <div class="stat-value"><?php echo $candidatures; ?></div>
                <div class="stat-label">Candidatures</div>
            </div>
            <div class="stat">
                <div class="stat-value"><?php echo count($competences); ?></div>
                <div class="stat-label">Compétences</div>
            </div>
        </div>
    </div>

    <div class="profile-tabs">
        <div class="tabs">
            <button class="tab active" data-tab="infos">Informations</button>
            <button class="tab" data-tab="competences">Compétences</button>
            <button class="tab" data-tab="formations">Formations</button>
            <button class="tab" data-tab="experiences">Expériences</button>
            <button class="tab" data-tab="diplomes">Diplômes & Certificats</button>
        </div>

        <div class="tab-content active" id="infos">
            <div class="profile-section">
                <h3>Informations personnelles</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nom complet</div>
                        <div class="info-value"><?php echo $user['nom']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value"><?php echo $user['mail']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Téléphone</div>
                        <div class="info-value"><?php echo $user['phone']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Ville</div>
                        <div class="info-value"><?php echo $user['ville']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Profession</div>
                        <div class="info-value"><?php echo $user['profession']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Catégorie</div>
                        <div class="info-value"><?php echo $user['categorie']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Statut</div>
                        <div class="info-value"><?php echo $user['statut']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Date d'inscription</div>
                        <div class="info-value"><?php echo date('d/m/Y', strtotime($user['date'])); ?></div>
                    </div>
                </div>
            </div>

            <div class="profile-section">
                <h3>Langues</h3>
                <?php if (empty($langues)): ?>
                    <p class="no-data">Aucune langue spécifiée</p>
                <?php else: ?>
                    <div class="languages-list">
                        <?php foreach ($langues as $langue): ?>
                            <div class="language-item">
                                <div class="language-name"><?php echo $langue['langues']; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="profile-section">
                <h3>Centres d'intérêt</h3>
                <?php if (empty($interets)): ?>
                    <p class="no-data">Aucun centre d'intérêt spécifié</p>
                <?php else: ?>
                    <div class="interests-list">
                        <?php foreach ($interets as $interet): ?>
                            <div class="interest-item"><?php echo $interet['interet']; ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-content" id="competences">
            <div class="profile-section">
                <h3>Compétences</h3>
                <?php if (empty($competences)): ?>
                    <p class="no-data">Aucune compétence spécifiée</p>
                <?php else: ?>
                    <div class="skills-list">
                        <?php foreach ($competences as $competence): ?>
                            <div class="skill-item"><?php echo $competence['competence']; ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-content" id="formations">
            <div class="profile-section">
                <h3>Formations</h3>
                <?php if (empty($formations)): ?>
                    <p class="no-data">Aucune formation spécifiée</p>
                <?php else: ?>
                    <div class="formations-list">
                        <?php foreach ($formations as $formation): ?>
                            <div class="formation-item">
                                <div class="formation-header">
                                    <h4><?php echo $formation['diplome']; ?></h4>
                                    <div class="formation-period"><?php echo $formation['année_début']; ?> -
                                        <?php echo $formation['année_fin']; ?>
                                    </div>
                                </div>
                                <div class="formation-school"><?php echo $formation['etablissement']; ?></div>
                                <div class="formation-city"><?php echo $formation['ville']; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-content" id="experiences">
            <div class="profile-section">
                <h3>Expériences professionnelles</h3>
                <?php if (empty($experiences)): ?>
                    <p class="no-data">Aucune expérience spécifiée</p>
                <?php else: ?>
                    <div class="experiences-list">
                        <?php foreach ($experiences as $experience): ?>
                            <div class="experience-item">
                                <div class="experience-header">
                                    <h4><?php echo $experience['poste']; ?></h4>
                                    <div class="experience-period"><?php echo $experience['début']; ?> -
                                        <?php echo $experience['fin']; ?>
                                    </div>
                                </div>
                                <div class="experience-company"><?php echo $experience['entreprise']; ?></div>
                                <div class="experience-city"><?php echo $experience['ville']; ?></div>
                                <div class="experience-description"><?php echo $experience['description']; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-content" id="diplomes">
            <div class="profile-section">
                <h3>Diplômes</h3>
                <?php if (empty($diplomes)): ?>
                    <p class="no-data">Aucun diplôme spécifié</p>
                <?php else: ?>
                    <div class="diplomes-list">
                        <?php foreach ($diplomes as $diplome): ?>
                            <div class="diplome-item">
                                <div class="diplome-icon"><i class="fas fa-graduation-cap"></i></div>
                                <div class="diplome-info">
                                    <h4><?php echo $diplome['diplome']; ?></h4>
                                    <div class="diplome-date"><?php echo $diplome['date']; ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="profile-section">
                <h3>Certificats</h3>
                <?php if (empty($certificats)): ?>
                    <p class="no-data">Aucun certificat spécifié</p>
                <?php else: ?>
                    <div class="certificats-list">
                        <?php foreach ($certificats as $certificat): ?>
                            <div class="certificat-item">
                                <div class="certificat-icon"><i class="fas fa-certificate"></i></div>
                                <div class="certificat-info">
                                    <h4><?php echo $certificat['certificat']; ?></h4>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .action-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .user-profile {
        background-color: var(--light-bg);
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .profile-header {
        display: flex;
        padding: 30px;
        background-color: var(--primary-color);
        color: white;
        position: relative;
    }

    .profile-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-right: 30px;
    }

    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-info {
        flex: 1;
    }

    .profile-info h2 {
        font-size: 24px;
        margin-bottom: 5px;
    }

    .profession {
        font-size: 16px;
        margin-bottom: 10px;
        opacity: 0.9;
    }

    .location,
    .status {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
        font-size: 14px;
    }

    .location i,
    .status i {
        margin-right: 8px;
    }

    .status-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .status-indicator.active {
        background-color: #10b981;
    }

    .status-indicator.inactive {
        background-color: #ef4444;
    }

    .profile-stats {
        display: flex;
        gap: 20px;
        background-color: rgba(0, 0, 0, 0.1);
        padding: 15px 20px;
        border-radius: 8px;
        align-self: flex-start;
    }

    .stat {
        text-align: center;
        min-width: 80px;
    }

    .stat-value {
        font-size: 22px;
        font-weight: bold;
    }

    .stat-label {
        font-size: 12px;
        opacity: 0.9;
    }

    .profile-tabs {
        padding: 20px;
    }

    .tabs {
        display: flex;
        gap: 5px;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 20px;
    }

    .tab {
        padding: 10px 20px;
        background: none;
        border: none;
        color: var(--light-text);
        cursor: pointer;
        font-weight: 500;
        position: relative;
    }

    .tab.active {
        color: var(--primary-color);
    }

    .tab.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: var(--primary-color);
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .profile-section {
        margin-bottom: 30px;
    }

    .profile-section h3 {
        font-size: 18px;
        margin-bottom: 15px;
        color: var(--text-color);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .info-item {
        padding: 15px;
        background-color: #f8fafc;
        border-radius: 6px;
    }

    .info-label {
        font-size: 12px;
        color: var(--light-text);
        margin-bottom: 5px;
    }

    .info-value {
        font-weight: 500;
    }

    .skills-list,
    .languages-list,
    .interests-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .skill-item,
    .language-item,
    .interest-item {
        background-color: #f0f9ff;
        color: var(--primary-color);
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 14px;
    }

    .formation-item,
    .experience-item {
        margin-bottom: 20px;
        padding: 15px;
        background-color: #f8fafc;
        border-radius: 6px;
    }

    .formation-header,
    .experience-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .formation-header h4,
    .experience-header h4 {
        font-size: 16px;
        color: var(--text-color);
        margin: 0;
    }

    .formation-period,
    .experience-period {
        font-size: 14px;
        color: var(--light-text);
    }

    .formation-school,
    .experience-company {
        font-weight: 500;
        margin-bottom: 5px;
    }

    .formation-city,
    .experience-city {
        font-size: 14px;
        color: var(--light-text);
        margin-bottom: 5px;
    }

    .experience-description {
        font-size: 14px;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid var(--border-color);
    }

    .diplome-item,
    .certificat-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding: 15px;
        background-color: #f8fafc;
        border-radius: 6px;
    }

    .diplome-icon,
    .certificat-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: rgba(37, 99, 235, 0.1);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 18px;
    }

    .diplome-info h4,
    .certificat-info h4 {
        font-size: 16px;
        margin: 0 0 5px 0;
    }

    .diplome-date {
        font-size: 14px;
        color: var(--light-text);
    }

    .no-data {
        padding: 15px;
        background-color: #f8fafc;
        border-radius: 6px;
        text-align: center;
        color: var(--light-text);
    }

    @media (max-width: 991px) {
        .profile-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .profile-image {
            margin-right: 0;
            margin-bottom: 20px;
        }

        .profile-stats {
            margin-top: 20px;
            align-self: stretch;
        }
    }

    @media (max-width: 767px) {
        .tabs {
            flex-wrap: wrap;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                // Remove active class from all tabs and content
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));

                // Add active class to clicked tab and corresponding content
                this.classList.add('active');
                const tabId = this.dataset.tab;
                document.getElementById(tabId).classList.add('active');
            });
        });
    });
</script>

<?php
include_once('includes/footer.php');
?>