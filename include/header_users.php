<link rel="stylesheet" href="../css/section2.css">
<link rel="stylesheet" href="../css/share-profile.css">
<script src="../js/candidat-profile.js"></script>

<section class="section2 ste" id="ste">
    <img src="../image/croix.png" alt="" class="img111" id="img24">
    <div class="container">
        <div class="box1">

            <script>
                // Gestionnaire d'événements pour le bouton de statut
                const statutButton = document.querySelector('.statut');
                const divStatut = document.querySelector('.div_statut');
                const closeImg = document.querySelector('.imag');

                statutButton.addEventListener('click', () => {
                    divStatut.style.left = '0';
                });

                closeImg.addEventListener('click', () => {
                    divStatut.style.left = '-200%';
                });

                // Fermer la div au clic en dehors
                document.addEventListener('click', (e) => {
                    if (!divStatut.contains(e.target) && e.target !== statutButton) {
                        divStatut.style.left = '-200%';
                    }
                });
            </script>


            <img class="affiche" src="/upload/<?= $users['images'] ?>" alt="">

            <?php if ($users['statut'] == 'Disponible'): ?>
                <span id="statut" class="statut-disp">
                    <?= $users['statut'] ?>
                </span>
            <?php else: ?>
                <?php if ($users['statut'] == 'Occuper'): ?>
                    <span id="statut" class="statut-occ">
                        <?= $users['statut'] ?>
                    </span>
                <?php else: ?>
                    <span id="statut" class="statut occ">Statut</span>
                <?php endif; ?>
            <?php endif; ?>
            <div class="div_statut">
                <img class="imag" src="../image/croix.png" alt="">
                <a class="disp" href="?occuper=<?= $users['id'] ?>">Occuper</a>
                <a class=" occ" href="?disponible=<?= $users['id'] ?>">Disponible</a>
            </div>
            <span></span>
            <h2>
                <?php echo $users['nom']; ?>
            </h2>

            <!-- Bouton de partage -->
            <button class="share-button" id="shareProfileBtn">
                <i class="fas fa-share-alt"></i> Partager mon profil
            </button>

            <!-- Modal de partage -->
            <div class="share-modal" id="shareModal">
                <div class="share-modal-content">
                    <span class="share-close">&times;</span>
                    <h3>Partager mon profil</h3>
                    <div class="share-preview">
                        <div class="share-preview-card">
                            <img src="/upload/<?= $users['images'] ?>" alt="<?= $users['nom'] ?>">
                            <div class="share-preview-info">
                                <h4><?= $users['nom'] ?></h4>
                                <p><?= $users['competences'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="share-options">
                        <a href="#" class="share-option" id="shareWhatsapp">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp</span>
                        </a>
                        <a href="#" class="share-option" id="shareFacebook">
                            <i class="fab fa-facebook"></i>
                            <span>Facebook</span>
                        </a>
                        <a href="#" class="share-option" id="shareLinkedin">
                            <i class="fab fa-linkedin"></i>
                            <span>LinkedIn</span>
                        </a>
                        <a href="#" class="share-option" id="shareTwitter">
                            <i class="fab fa-twitter"></i>
                            <span>Twitter</span>
                        </a>
                        <a href="#" class="share-option" id="shareGmail">
                            <i class="fas fa-envelope"></i>
                            <span>Gmail</span>
                        </a>
                        <a href="#" class="share-option" id="shareCopyLink">
                            <i class="fas fa-link"></i>
                            <span>Copier le lien</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="box2">
            <h3>
                <?php echo $users['competences']; ?>
            </h3>
        </div>

        <div class="box3">
            <ul>
                <a href="../page/modifier.php">
                    <li class="tr3"><img src="../image/modifier 1.png" alt=""> <span class="td">Paramètres </span></li>
                </a>

                <a href="../page/user_profil.php">
                    <li class="tr"><img src="../image/diplômé.png" alt=""> <span class="td">Mon parcours</span></li>
                </a>

                <a href="/model_cv/cv_users.php">
                    <li class="tr4"><img src="../image/MCV.png" alt=""> <span class="td">Mon CV</span></li>
                </a>

                <a href="../page/mes_documments.php">
                    <li class="tr6"><img src="../image/fichier1.png" alt=""> <span class="td">Mes documents</span></li>
                </a>

                <a href="../page/mes_demande.php?supp4=<?= $_SESSION['users_id'] ?>">
                    <li class="tr1"><img src="../image/mdep.png" alt=""><span class="td">Mes demandes d'emplois</span>
                        <?php if (empty($notif_suivi) or empty($notif_suiviRecaler)): ?>
                        <?php else: ?>
                            <?php if (isset($notif_suivi) or isset($notif_suiviRecaler)): ?>
                                <em><?= $count_notif_suivi + $count_notif_suiviRecaler ?></em>
                            <?php endif; ?>
                        <?php endif; ?>
                    </li>
                </a>

                <a href="../page/candature_accepter.php">
                    <li class="tr10"><img src="../image/reussi.png" alt=""> <span class="td">Candidatures
                            acceptées</span>
                        <?php if (empty($notif_suivi) or empty($notif_suiviRecaler)): ?>
                        <?php else: ?>
                            <?php if (isset($notif_suivi)): ?>
                                <em><?= $count_notif_suivi ?></em>
                            <?php endif; ?>
                        <?php endif; ?>

                    </li>
                </a>

                <a href="../page/message_users.php?supp3=<?= $_SESSION['users_id'] ?>">
                    <li class="tr2"><img src="../image/message.png" alt=""><span class="td">Messages</span>
                        <?php if (empty($notif_users)): ?>
                        <?php else: ?>
                            <?php if (isset($notif_users)): ?>
                                <em><?= $count_notif_users ?></em>
                            <?php endif; ?>
                        <?php endif; ?>
                    </li>
                </a>

            </ul>

        </div>

        <a class="liens" href="../conn/dconn_users.php">Déconnexion</a>
    </div>


</section>



<section class="menu" id="menu">
    <img class="img23" id="img23" src="../image/menu n.png" alt="">
    <span class="span1">Menu</span>
</section>

<script>
    // Sélectionne l'élément avec la classe 'img' et l'assigne à img222
    let cache = document.getElementById('img23');

    let section = document.querySelector('.section2')
    // Sélectionne l'élément avec la classe 'ste' et l'assigne à section2
    let section2 = document.getElementById('ste');

    // Sélectionne l'élément avec la classe 'menu' et l'assigne à menu
    let menu1 = document.getElementById('menu');

    // Sélectionne l'élément avec la classe 'img111' et l'assigne à img111
    let img111 = document.getElementById('img24');

    // Ajoute un événement de clic à img222
    cache.addEventListener('click', () => {
        // Lorsque img222 est cliqué, déplace section2 à gauche (visible) et cache menu
        section2.style.left = '0';
        menu1.style.left = '-400px';
    });

    // Ajoute un événement de clic à img111
    img111.addEventListener('click', () => {
        // Lorsque img111 est cliqué, cache section2 et montre menu
        section2.style.left = '-250px';
        menu1.style.left = '0';
    });

    // Script pour le partage de profil
    document.addEventListener('DOMContentLoaded', function () {
        const shareBtn = document.getElementById('shareProfileBtn');
        const shareModal = document.getElementById('shareModal');
        const closeBtn = document.querySelector('.share-close');
        const copyLinkBtn = document.getElementById('shareCopyLink');

        // URL du profil à partager
        const profileId = <?= json_encode($users['id']) ?>;
        const profileUrl = `https://www.work-flexer.com/page/candidats.php?id=${profileId}`;
        const profileName = <?= json_encode($users['nom']) ?>;
        const profileJob = <?= json_encode($users['competences']) ?>;

        // Ouvrir la modal
        shareBtn.addEventListener('click', function () {
            shareModal.style.display = 'flex';
        });

        // Fermer la modal
        closeBtn.addEventListener('click', function () {
            shareModal.style.display = 'none';
        });

        // Fermer la modal en cliquant à l'extérieur
        window.addEventListener('click', function (event) {
            if (event.target === shareModal) {
                shareModal.style.display = 'none';
            }
        });

        // Partage WhatsApp
        document.getElementById('shareWhatsapp').addEventListener('click', function (e) {
            e.preventDefault();

            // Afficher un message de chargement
            const originalText = this.querySelector('span').textContent;
            this.querySelector('span').textContent = 'Préparation...';
            this.classList.add('loading');

            // Message simple et compatible WhatsApp
            const whatsappText = `${profileName} - ${profileJob}\n\nConsultez ce profil professionnel sur Work-Flexer :\n${profileUrl}`;
            const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(whatsappText)}`;

            setTimeout(() => {
                this.querySelector('span').textContent = originalText;
                this.classList.remove('loading');
                window.open(whatsappUrl, '_blank');
            }, 1500);
        });

        // Partage Facebook
        document.getElementById('shareFacebook').addEventListener('click', function (e) {
            e.preventDefault();
            const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(profileUrl)}`;
            window.open(facebookUrl, '_blank');
        });

        // Partage LinkedIn
        document.getElementById('shareLinkedin').addEventListener('click', function (e) {
            e.preventDefault();
            const linkedinUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(profileUrl)}`;
            window.open(linkedinUrl, '_blank');
        });

        // Partage Twitter
        document.getElementById('shareTwitter').addEventListener('click', function (e) {
            e.preventDefault();
            const twitterUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(`Découvrez le profil de ${profileName} - ${profileJob}`)}&url=${encodeURIComponent(profileUrl)}`;
            window.open(twitterUrl, '_blank');
        });

        // Partage Gmail
        document.getElementById('shareGmail').addEventListener('click', function (e) {
            e.preventDefault();

            // Demander si l'utilisateur souhaite personnaliser le message
            const wantsToCustomize = confirm("Souhaitez-vous personnaliser le message avant de l'envoyer?");

            // Informations de base
            let subject = `Profil professionnel de ${profileName} - ${profileJob}`;
            let body = `
Bonjour,

Je souhaite partager avec vous mon profil professionnel : ${profileName}, ${profileJob}.

Vous pouvez consulter mon profil complet sur Work-Flexer via ce lien :
${profileUrl}

Ce profil contient des informations détaillées sur mes compétences, mon expérience professionnelle, ma formation et mes réalisations.

Cordialement,
${profileName}

--
Work-Flexer - Votre plateforme de mise en relation professionnelle
Ce message a été envoyé via la fonction de partage de profil Work-Flexer
`;

            // Version HTML pour l'envoi via PHPMailer
            let htmlBody = `
<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #dddddd;">
  <!-- En-tête -->
  <table width="100%" bgcolor="#3b82f6" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td align="center" style="padding: 20px;">
        <h2 style="color: #ffffff; margin: 0; font-family: Arial, sans-serif;">Profil Work-Flexer</h2>
      </td>
    </tr>
  </table>
  
  <!-- Contenu principal -->
  <table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td style="padding: 30px; font-family: Arial, sans-serif;">
        <p style="font-size: 16px; line-height: 1.5; margin-top: 0;">Bonjour,</p>
        
        <p style="font-size: 16px; line-height: 1.5;">Je souhaite partager avec vous mon profil professionnel : <strong>${profileName}</strong>, ${profileJob}.</p>
        
        <p style="font-size: 16px; line-height: 1.5;">Vous pouvez consulter mon profil complet sur Work-Flexer via ce lien :</p>
        
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td align="center" style="padding: 15px 0;">
              <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td bgcolor="#3b82f6" style="padding: 12px 25px; border-radius: 4px;">
                    <a href="${profileUrl}" style="color: #ffffff; font-weight: bold; text-decoration: none; display: block; font-family: Arial, sans-serif;">Voir mon profil</a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        
        <p style="font-size: 16px; line-height: 1.5;">Ce profil contient des informations détaillées sur mes compétences, mon expérience professionnelle, ma formation et mes réalisations.</p>
        
        <p style="font-size: 16px; line-height: 1.5; margin-bottom: 0;">Cordialement,</p>
        <p style="font-size: 16px; line-height: 1.5; margin-top: 5px; font-weight: bold;">${profileName}</p>
      </td>
    </tr>
  </table>
  
  <!-- Pied de page -->
  <table width="100%" bgcolor="#f9fafb" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td align="center" style="padding: 15px; font-family: Arial, sans-serif;">
        <p style="font-size: 14px; color: #6b7280; margin: 0;">© ${new Date().getFullYear()} Work-Flexer - Votre plateforme de mise en relation professionnelle</p>
        <p style="font-size: 12px; color: #9ca3af; margin: 10px 0 0 0;">Ce message a été envoyé via la fonction de partage de profil Work-Flexer</p>
      </td>
    </tr>
  </table>
</div>
`;

            // Pour Gmail, on utilise le texte brut pour l'édition
            let plainTextBody = body;

            // Si l'utilisateur souhaite personnaliser
            if (wantsToCustomize) {
                // Créer une modal pour personnaliser le message
                const customizeModal = document.createElement('div');
                customizeModal.className = 'customize-email-modal';
                customizeModal.innerHTML = `
                    <div class="customize-email-content">
                        <span class="customize-close">&times;</span>
                        <h3>Personnaliser votre message</h3>
                        
                        <div class="form-group">
                            <label for="email-recipient">Adresse email du destinataire:</label>
                            <input type="email" id="email-recipient" class="form-control" placeholder="exemple@email.com" required>
                            <p class="field-error" id="recipient-error"></p>
                        </div>
                        
                        <div class="form-group">
                            <label for="email-subject">Objet:</label>
                            <input type="text" id="email-subject" value="${subject}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="email-body">Message:</label>
                            <textarea id="email-body" class="form-control" rows="12">${plainTextBody}</textarea>
                        </div>
                        
                        <div class="form-group files-group">
                            <label>Pièces jointes (facultatif):</label>
                            <div class="file-inputs">
                                <div class="file-input-group">
                                    <label for="cv-file" class="file-label">
                                        <i class="fas fa-file-pdf"></i> CV (PDF)
                                    </label>
                                    <input type="file" id="cv-file" class="file-input" accept=".pdf">
                                    <span class="file-name" id="cv-file-name">Aucun fichier sélectionné</span>
                                    <button type="button" class="file-clear" id="cv-file-clear" style="display: none;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                
                                <div class="file-input-group">
                                    <label for="motivation-file" class="file-label">
                                        <i class="fas fa-file-alt"></i> Lettre de motivation (PDF)
                                    </label>
                                    <input type="file" id="motivation-file" class="file-input" accept=".pdf">
                                    <span class="file-name" id="motivation-file-name">Aucun fichier sélectionné</span>
                                    <button type="button" class="file-clear" id="motivation-file-clear" style="display: none;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <p class="email-note"><i class="fas fa-info-circle"></i> Note: Votre message sera envoyé avec une mise en forme professionnelle.</p>
                        </div>
                        
                        <button id="send-email" class="customize-button">Envoyer</button>
                    </div>
                `;

                // Ajouter la modal au body
                document.body.appendChild(customizeModal);

                // Afficher la modal
                customizeModal.style.display = 'flex';

                // Gérer l'affichage des noms de fichiers
                document.getElementById('cv-file').addEventListener('change', function () {
                    const fileName = this.files.length ? this.files[0].name : 'Aucun fichier sélectionné';
                    document.getElementById('cv-file-name').textContent = fileName;
                    document.getElementById('cv-file-clear').style.display = this.files.length ? 'block' : 'none';
                });

                document.getElementById('motivation-file').addEventListener('change', function () {
                    const fileName = this.files.length ? this.files[0].name : 'Aucun fichier sélectionné';
                    document.getElementById('motivation-file-name').textContent = fileName;
                    document.getElementById('motivation-file-clear').style.display = this.files.length ? 'block' : 'none';
                });

                // Gérer la suppression des fichiers
                document.getElementById('cv-file-clear').addEventListener('click', function () {
                    document.getElementById('cv-file').value = '';
                    document.getElementById('cv-file-name').textContent = 'Aucun fichier sélectionné';
                    this.style.display = 'none';
                });

                document.getElementById('motivation-file-clear').addEventListener('click', function () {
                    document.getElementById('motivation-file').value = '';
                    document.getElementById('motivation-file-name').textContent = 'Aucun fichier sélectionné';
                    this.style.display = 'none';
                });

                // Gérer la fermeture de la modal
                document.querySelector('.customize-close').addEventListener('click', function () {
                    customizeModal.remove();
                });

                // Gérer l'envoi du message personnalisé
                document.getElementById('send-email').addEventListener('click', function () {
                    const recipient = document.getElementById('email-recipient').value;
                    const customSubject = document.getElementById('email-subject').value;
                    const customBody = document.getElementById('email-body').value;

                    // Validation de l'email
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    const recipientError = document.getElementById('recipient-error');

                    if (!emailRegex.test(recipient)) {
                        recipientError.textContent = "Veuillez entrer une adresse email valide";
                        return;
                    } else {
                        recipientError.textContent = "";
                    }

                    // Récupérer les fichiers PDF
                    const cvFile = document.getElementById('cv-file').files[0];
                    const motivationFile = document.getElementById('motivation-file').files[0];

                    // Envoyer via AJAX à un script PHP qui utilisera PHPMailer
                    const sendBtn = document.getElementById('send-email');
                    const originalBtnText = sendBtn.textContent;

                    // Changer le texte du bouton pour indiquer l'envoi en cours
                    sendBtn.textContent = "Envoi en cours...";
                    sendBtn.disabled = true;

                    // Préparer les données à envoyer
                    const formData = new FormData();
                    formData.append('recipient', recipient);
                    formData.append('subject', customSubject);
                    formData.append('textBody', customBody);
                    formData.append('htmlBody', htmlBody);
                    formData.append('senderName', profileName);
                    formData.append('profileUrl', profileUrl);

                    // Ajouter les fichiers s'ils existent
                    if (cvFile) {
                        formData.append('cv_file', cvFile);
                    }

                    if (motivationFile) {
                        formData.append('motivation_file', motivationFile);
                    }

                    // Envoyer la requête AJAX
                    fetch('../includes/send_profile_email.php', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Afficher un message de succès
                                alert("Votre message a été envoyé avec succès !");
                                customizeModal.remove();
                            } else {
                                // Afficher un message d'erreur
                                alert("Erreur lors de l'envoi du message : " + data.message);
                                sendBtn.textContent = originalBtnText;
                                sendBtn.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            alert("Une erreur s'est produite lors de l'envoi du message.");
                            sendBtn.textContent = originalBtnText;
                            sendBtn.disabled = false;
                        });
                });
            } else {
                // Créer une modal simplifiée pour saisir uniquement l'email du destinataire
                const recipientModal = document.createElement('div');
                recipientModal.className = 'customize-email-modal';
                recipientModal.innerHTML = `
                    <div class="customize-email-content">
                        <span class="customize-close">&times;</span>
                        <h3>Envoyer le profil par email</h3>
                        
                        <div class="form-group">
                            <label for="email-recipient-simple">Adresse email du destinataire:</label>
                            <input type="email" id="email-recipient-simple" class="form-control" placeholder="exemple@email.com" required>
                            <p class="field-error" id="recipient-simple-error"></p>
                        </div>
                        
                        <div class="form-group">
                            <p class="email-note"><i class="fas fa-info-circle"></i> Un email professionnel sera envoyé avec les informations de votre profil.</p>
                        </div>
                        
                        <button id="send-simple-email" class="customize-button">Envoyer</button>
                    </div>
                `;

                // Ajouter la modal au body
                document.body.appendChild(recipientModal);

                // Afficher la modal
                recipientModal.style.display = 'flex';

                // Gérer la fermeture de la modal
                recipientModal.querySelector('.customize-close').addEventListener('click', function () {
                    recipientModal.remove();
                });

                // Gérer l'envoi du message
                document.getElementById('send-simple-email').addEventListener('click', function () {
                    const recipient = document.getElementById('email-recipient-simple').value;

                    // Validation de l'email
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    const recipientError = document.getElementById('recipient-simple-error');

                    if (!emailRegex.test(recipient)) {
                        recipientError.textContent = "Veuillez entrer une adresse email valide";
                        return;
                    } else {
                        recipientError.textContent = "";
                    }

                    // Envoyer via AJAX à un script PHP qui utilisera PHPMailer
                    const sendBtn = document.getElementById('send-simple-email');
                    const originalBtnText = sendBtn.textContent;

                    // Changer le texte du bouton pour indiquer l'envoi en cours
                    sendBtn.textContent = "Envoi en cours...";
                    sendBtn.disabled = true;

                    // Préparer les données à envoyer
                    const formData = new FormData();
                    formData.append('recipient', recipient);
                    formData.append('subject', subject);
                    formData.append('textBody', plainTextBody);
                    formData.append('htmlBody', htmlBody);
                    formData.append('senderName', profileName);
                    formData.append('profileUrl', profileUrl);

                    // Envoyer la requête AJAX
                    fetch('../includes/send_profile_email.php', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Afficher un message de succès
                                alert("Votre message a été envoyé avec succès !");
                                recipientModal.remove();
                            } else {
                                // Afficher un message d'erreur
                                alert("Erreur lors de l'envoi du message : " + data.message);
                                sendBtn.textContent = originalBtnText;
                                sendBtn.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            alert("Une erreur s'est produite lors de l'envoi du message.");
                            sendBtn.textContent = originalBtnText;
                            sendBtn.disabled = false;
                        });
                });
            }
        });

        // Copier le lien
        copyLinkBtn.addEventListener('click', function (e) {
            e.preventDefault();
            navigator.clipboard.writeText(profileUrl).then(function () {
                // Feedback visuel
                const originalText = copyLinkBtn.querySelector('span').textContent;
                copyLinkBtn.querySelector('span').textContent = 'Lien copié !';
                copyLinkBtn.classList.add('copied');

                setTimeout(function () {
                    copyLinkBtn.querySelector('span').textContent = originalText;
                    copyLinkBtn.classList.remove('copied');
                }, 2000);
            });
        });
    });
</script>