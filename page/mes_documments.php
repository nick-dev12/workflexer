<?php
session_start();
include '../conn/conn.php';
require '../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label;
use Endroid\QrCode\Logo;
use Endroid\QrCode\RoundBlockSizeMode;

// Ajouter ce code après les inclusions de contrôleurs
require_once(__DIR__ . '/../model/fcm_tokens_users.php');

// Vérifier si l'utilisateur a déjà activé les notifications
$hasNotificationsEnabled = false;
if (isset($_SESSION['users_id'])) {
    $token = getUserToken($db, $_SESSION['users_id']);
    $hasNotificationsEnabled = !empty($token);
}

function generateQRCode($userId)
{
    // Vérifier si l'ID utilisateur est défini
    if (!isset($_SESSION['users_id'])) {
        return '<p>Erreur : ID utilisateur non défini.</p>';
    }

    $userId = $_SESSION['users_id'];
    $url = 'https://www.work-flexer.com/page/candidats.php?id=' . $userId; // Lien vers le profil utilisateur

    // Chemin du répertoire des QR codes
    $qrCodeDir = __DIR__ . '/qrcodes';

    // Vérifier si le répertoire existe, sinon le créer
    if (!is_dir($qrCodeDir)) {
        mkdir($qrCodeDir, 0777, true);
    }

    try {
        // Créer une instance Builder avec la bonne syntaxe pour la version 6.0.6
        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $url,
            size: 300,
            margin: 10
        );

        // Construire le QR code
        $result = $builder->build();

        // Enregistrer le QR code en tant qu'image
        $qrCodePath = $qrCodeDir . '/user_' . $userId . '.png';
        $result->saveToFile($qrCodePath);

        // Vérifier si le fichier a été créé
        if (!file_exists($qrCodePath)) {
            return '<p>Erreur : le QR code n\'a pas pu être généré.</p>';
        }

        // Retourner l'image du QR code dans un <img> HTML
        return '<img src="qrcodes/user_' . $userId . '.png" alt="QR Code" />';
    } catch (Exception $e) {
        return '<p>Erreur : ' . $e->getMessage() . '</p>';
    }
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['users_id']) || empty($_SESSION['users_id'])) {
    // Rediriger vers la page de connexion ou une autre page appropriée
    header('Location: ../connection_compte.php');
    exit();
}

// Inclure le contrôleur de document
include_once('../controller/controller_document_users.php');
include_once('../controller/controller_users.php');

// Récupérer les infos utilisateur
$users_id = $_SESSION['users_id'];
$conn = "SELECT * FROM users WHERE id = :users_id";
$stmt = $db->prepare($conn);
$stmt->bindParam(':users_id', $users_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Initialisation des variables pour les alertes
$successMessage = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';

// Nettoyer les messages de session après les avoir récupérés
if (isset($_SESSION['success_message']))
    unset($_SESSION['success_message']);
if (isset($_SESSION['error_message']))
    unset($_SESSION['error_message']);

// Déterminer le type de fichier pour l'icône
function getDocumentIcon($filename)
{
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    switch ($extension) {
        case 'pdf':
            return '../image/pdf-icon.png';
        case 'doc':
        case 'docx':
            return '../image/word-icon.png';
        case 'xls':
        case 'xlsx':
        case 'csv':
            return '../image/excel-icon.png';
        case 'ppt':
        case 'pptx':
            return '../image/powerpoint-icon.png';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            return '../image/image-icon.png';
        case 'txt':
            return '../image/text-icon.png';
        case 'zip':
        case 'rar':
            return '../image/archive-icon.png';
        default:
            return '../image/document.png';
    }
}

// Obtenir une version lisible de la taille de fichier
function getFileSize($filename)
{
    $filepath = '../document/' . $filename;
    if (!file_exists($filepath)) {
        return 'N/A';
    }

    $size = filesize($filepath);
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;

    return round($size / pow(1024, $power), 2) . ' ' . $units[$power];
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Gérez vos documents professionnels sur Work-Flexer. Téléchargez, organisez et partagez facilement vos CV, certifications et autres documents importants.">

    <!-- Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5JBWCPV7');
    </script>
    <!-- End Google Tag Manager -->

    <title>Mes Documents - Work-Flexer</title>
    <link rel="icon" href="../image/logo 2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/mes_documments.css">
    <link rel="stylesheet" href="../css/navbare.css">
    <link rel="stylesheet" href="../css/aos.css" />
    <script defer src="../js/aos.js"></script>
    <script src="../script/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JBWCPV7" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include('../navbare.php') ?>
    <?php include('../include/header_users.php') ?>

    <section class="section3">
        <?php if (!empty($successMessage)): ?>
            <div class="alert alert--success">
                <i class="fas fa-check-circle alert__icon"></i>
                <span><?php echo $successMessage; ?></span>
            </div>
        <?php endif; ?>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert--error">
                <i class="fas fa-exclamation-circle alert__icon"></i>
                <span><?php echo $errorMessage; ?></span>
            </div>
        <?php endif; ?>

        <div class="document-manager" data-aos="fade-up" data-aos-duration="800">
            <div class="document-manager__header">
                <div class="document-manager__title">
                    <img src="../image/fichier1.png" alt="Documents" class="document-manager__title-icon">
                    Mes Documents
                    <span class="document-manager__counter"><?php echo $rowCount; ?></span>
                </div>
            </div>

            <div class="document-manager__content">
                <form action="" method="post" enctype="multipart/form-data" class="upload-form" data-aos="fade-up"
                    data-aos-delay="200">
                    <div class="upload-form__container">
                        <label for="file" class="upload-form__dropzone">
                            <img src="../image/fichier.png" alt="Téléverser" class="upload-form__dropzone-icon">
                            <p class="upload-form__dropzone-text">Cliquez ici ou glissez un fichier pour le téléverser
                            </p>
                            <div id="documentName" class="upload-form__file-info"></div>
                        </label>
                        <input type="file" name="document" id="file" class="upload-form__input"
                            accept="application/pdf,.pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation, text/plain, text/csv">
                        <button type="submit" name="téléverser" class="upload-form__button" id="uploadButton" disabled>
                            <i class="fas fa-upload"></i>
                            Téléverser le document
                        </button>
                    </div>
                </form>

                <?php if ($rowCount > 0): ?>
                    <ul class="document-list" data-aos="fade-up" data-aos-delay="400">
                        <?php foreach ($GetDocumentUsers as $document): ?>
                            <?php
                            $fileIcon = getDocumentIcon($document['document']);
                            $fileSize = getFileSize($document['document']);
                            $fileExtension = strtoupper(pathinfo($document['document'], PATHINFO_EXTENSION));
                            ?>
                            <li class="document-list__item">
                                <img src="<?php echo $fileIcon; ?>" alt="<?php echo $fileExtension; ?>"
                                    class="document-list__icon">

                                <div class="document-list__details">
                                    <div class="document-list__name"><?php echo $document['document']; ?></div>
                                    <div class="document-list__info">
                                        <div class="document-list__info-item">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span>Ajouté le:
                                                <?php echo date('d/m/Y', strtotime($document['created_at'] ?? 'now')); ?></span>
                                        </div>
                                        <div class="document-list__info-item">
                                            <i class="fas fa-file-alt"></i>
                                            <span><?php echo $fileExtension; ?></span>
                                        </div>
                                        <div class="document-list__info-item">
                                            <i class="fas fa-weight-hanging"></i>
                                            <span><?php echo $fileSize; ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="document-list__actions">
                                    <a href="../document/<?php echo $document['document']; ?>"
                                        class="document-list__action document-list__action--download tooltip">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <a href="?document_id=<?php echo $document['document_id']; ?>"
                                        class="document-list__action document-list__action--delete tooltip"
                                        data-tooltip="Supprimer"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="document-list__empty" data-aos="fade-up" data-aos-delay="400">
                        <i class="fas fa-file-alt" style="font-size: 48px; color: #ccc; margin-bottom: 20px;"></i>
                        <p>Vous n'avez aucun document pour le moment.</p>
                        <p>Téléversez vos CV, diplômes et certifications pour les partager avec les recruteurs.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="support-section">
            <div class="support-button" id="supportButton">
                <i class="fas fa-headset"></i>
            </div>

            <div class="support-popup" id="supportPopup">
                <div class="support-popup__header">
                    <h3 class="support-popup__title">Assistance</h3>
                    <span class="support-popup__close" id="closeSupport">&times;</span>
                </div>
                <div class="support-popup__body">
                    <p>Comment pouvons-nous vous aider ?</p>
                    <form action="" method="post" class="support-popup__form">
                        <textarea name="message"
                            placeholder="Décrivez votre problème ou posez-nous une question..."></textarea>
                        <button type="submit" name="send">
                            <i class="fas fa-paper-plane"></i> Envoyer
                        </button>
                    </form>
                    <div class="support-popup__alternatives">
                        <a href="https://api.whatsapp.com/send?phone=785303879" target="_blank" class="tooltip"
                            data-tooltip="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="mailto:workflexer.service@gmail.com" class="tooltip" data-tooltip="Email">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Initialiser AOS (Animation On Scroll)
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init();

            // Gestion du formulaire de téléversement
            const fileInput = document.getElementById('file');
            const documentName = document.getElementById('documentName');
            const uploadButton = document.getElementById('uploadButton');

            fileInput.addEventListener('change', function () {
                const fileName = this.files[0]?.name;
                if (fileName) {
                    documentName.textContent = fileName;
                    documentName.style.display = 'block';
                    uploadButton.disabled = false;
                } else {
                    documentName.textContent = '';
                    documentName.style.display = 'none';
                    uploadButton.disabled = true;
                }
            });

            // Gestion du bouton d'assistance
            const supportButton = document.getElementById('supportButton');
            const supportPopup = document.getElementById('supportPopup');
            const closeSupport = document.getElementById('closeSupport');

            supportButton.addEventListener('click', function () {
                supportPopup.classList.toggle('active');
            });

            closeSupport.addEventListener('click', function () {
                supportPopup.classList.remove('active');
            });

            // Fermer le popup quand on clique en dehors
            document.addEventListener('click', function (event) {
                if (!supportPopup.contains(event.target) && event.target !== supportButton) {
                    supportPopup.classList.remove('active');
                }
            });

            // Cacher les alertes après 5 secondes
            setTimeout(function () {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.classList.add('fadeOut');
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 300);
                });
            }, 5000);
        });
    </script>

    <!-- Script pour les notifications -->
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notificationButton = document.getElementById('notification-button-user');
            const notificationStatus = document.getElementById('notification-status');

            // Si le bouton de notification existe et n'est pas désactivé
            if (notificationButton && !notificationButton.disabled) {
                // Vérifier si les notifications sont prises en charge
                if (!('Notification' in window)) {
                    notificationStatus.innerHTML = '<div class="alert alert--error"><i class="fas fa-exclamation-circle"></i> Votre navigateur ne prend pas en charge les notifications.</div>';
                    notificationButton.disabled = true;
                    return;
                }

                // Vérifier si le service worker est pris en charge
                if (!('serviceWorker' in navigator)) {
                    notificationStatus.innerHTML = '<div class="alert alert--error"><i class="fas fa-exclamation-circle"></i> Votre navigateur ne prend pas en charge les Service Workers.</div>';
                    notificationButton.disabled = true;
                    return;
                }

                // Configuration Firebase
                const firebaseConfig = {
                    apiKey: "AIzaSyBV9jAeyVG2RvKRr6l0d1mk6c_O_2hScGg",
                    authDomain: "send-notification-257c0.firebaseapp.com",
                    projectId: "send-notification-257c0",
                    storageBucket: "send-notification-257c0.firebasestorage.app",
                    messagingSenderId: "276851238884",
                    appId: "1:276851238884:web:03262cc0ea23a80154c9f1",
                    measurementId: "G-N4TGHGX008"
                };

                // Initialisation de Firebase
                if (!window.firebase || !firebase.apps.length) {
                    firebase.initializeApp(firebaseConfig);
                }

                const messaging = firebase.messaging();

                // Gérer le clic sur le bouton d'activation des notifications
                notificationButton.addEventListener('click', async function () {
                    try {
                        // Demander la permission pour les notifications
                        const permission = await Notification.requestPermission();

                        if (permission === 'granted') {
                            notificationStatus.innerHTML = '<div class="alert alert--success"><i class="fas fa-check-circle"></i> Obtention du token FCM...</div>';

                            // Enregistrer le service worker
                            const registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');
                            messaging.useServiceWorker(registration);

                            // Obtenir le token FCM
                            const token = await messaging.getToken();

                            if (token) {
                                // Envoyer le token au serveur
                                const response = await fetch('../ajax/save_fcm_token_user.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        token: token,
                                        device_info: navigator.userAgent
                                    }),
                                });

                                const data = await response.json();

                                if (data.success) {
                                    notificationStatus.innerHTML = '<div class="alert alert--success"><i class="fas fa-check-circle"></i> Notifications activées avec succès!</div>';
                                    notificationButton.innerHTML = '<i class="fas fa-bell"></i> Notifications activées';
                                    notificationButton.classList.replace('btn-primary', 'btn-success');
                                    notificationButton.disabled = true;
                                } else {
                                    throw new Error(data.message || 'Erreur lors de l\'enregistrement du token');
                                }
                            } else {
                                throw new Error('Impossible d\'obtenir le token FCM');
                            }
                        } else {
                            notificationStatus.innerHTML = '<div class="alert alert--warning"><i class="fas fa-exclamation-triangle"></i> Vous avez refusé les notifications.</div>';
                        }
                    } catch (error) {
                        console.error('Erreur:', error);
                        notificationStatus.innerHTML = `<div class="alert alert--error"><i class="fas fa-times-circle"></i> Erreur: ${error.message}</div>`;
                    }
                });

                // Écouteur pour les messages reçus en premier plan
                messaging.onMessage((payload) => {
                    console.log('Message reçu:', payload);

                    // Créer et afficher la notification
                    const notification = new Notification(payload.notification.title, {
                        body: payload.notification.body,
                        icon: '/image/logo 2.png'
                    });

                    // Gérer le clic sur la notification
                    notification.onclick = function () {
                        window.focus();
                        window.location.href = '/page/user_profil.php';
                        notification.close();
                    };
                });
            }
        });
    </script>
</body>

</html>