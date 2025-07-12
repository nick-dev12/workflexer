<link rel="stylesheet" href="../css/section2.css">
<link rel="stylesheet" href="../css/share-profile.css">
<script src="../js/candidat-profile.js"></script>

<section class="section2 ste" id="ste">
    <img src="../image/croix.png" alt="" class="img111" id="img24">
    <div class="container">
        <div class="box1">



            <img class="affiche" src="/upload/<?= $users['images'] ?>" alt="">


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
        const userSkills = <?= json_encode($competencesUtilisateur ?? []); ?>;

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
            const whatsappText =
                `${profileName} - ${profileJob}\n\nConsultez ce profil professionnel sur Work-Flexer :\n${profileUrl}`;
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
            const facebookUrl =
                `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(profileUrl)}`;
            window.open(facebookUrl, '_blank');
        });

        // Partage LinkedIn
        document.getElementById('shareLinkedin').addEventListener('click', function (e) {
            e.preventDefault();

            // Afficher un message de chargement
            const originalText = this.querySelector('span').textContent;
            this.querySelector('span').textContent = 'Préparation...';
            this.classList.add('loading');

            // Description personnalisée pour LinkedIn
            const linkedinDescription =
                `${profileName} - ${profileJob} recherche activement de nouvelles opportunités professionnelles.\n\nDécouvrez son profil complet, ses compétences, expériences et réalisations sur Work-Flexer.`;

            // URL avec paramètres personnalisés
            const linkedinUrl =
                `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(profileUrl)}&title=${encodeURIComponent(`${profileName} - ${profileJob}`)}&summary=${encodeURIComponent(linkedinDescription)}`;

            setTimeout(() => {
                this.querySelector('span').textContent = originalText;
                this.classList.remove('loading');
                window.open(linkedinUrl, '_blank');
            }, 1500);
        });

        // Partage Twitter
        document.getElementById('shareTwitter').addEventListener('click', function (e) {
            e.preventDefault();
            const twitterUrl =
                `https://twitter.com/intent/tweet?text=${encodeURIComponent(`Découvrez le profil de ${profileName} - ${profileJob}`)}&url=${encodeURIComponent(profileUrl)}`;
            window.open(twitterUrl, '_blank');
        });

        // Partage Gmail
        document.getElementById('shareGmail').addEventListener('click', function (e) {
            e.preventDefault();

            // Demander si l'utilisateur souhaite personnaliser le message
            const wantsToCustomize = confirm("Souhaitez-vous personnaliser le message avant de l'envoyer?");

            // Générer le texte des compétences pour l'intégrer dans le corps
            const highlightedSkills = userSkills.filter(s => s.mis_en_avant == 1);
            const otherSkills = userSkills.filter(s => s.mis_en_avant != 1);
            const finalSkills = [...highlightedSkills, ...otherSkills].slice(0, 7);

            let skillsTextInline = '';
            if (finalSkills.length > 0) {
                skillsTextInline = "\n" + finalSkills.map(skill => {
                    const star = skill.mis_en_avant == 1 ? '★ ' : '• ';
                    return `  ${star}${skill.competence}`;
                }).join('\n');
            }

            // Informations de base
            let subject = `Profil professionnel de ${profileName}`;
            let body = `Bonjour,

Je me nomme ${profileName}.

En tant que professionnel passionné, je recherche activement de nouveaux défis où mettre à profit mon expertise. Voici un aperçu de mes compétences principales :
${skillsTextInline}

Mon profil détaillé contient l'ensemble de mes expériences, formations et réalisations. Je serais ravi d'échanger avec vous sur les opportunités de collaboration.

Cordialement,
${profileName}`;

            // Version HTML pour Gmail (avec les compétences intégrées)
            let skillsHtmlInline = '';
            if (finalSkills.length > 0) {
                skillsHtmlInline = finalSkills.map(skill => {
                    const isHighlighted = skill.mis_en_avant == 1;

                    if (isHighlighted) {
                        const star = '⭐';
                        const style =
                            'display: inline-block; margin: 4px 6px; padding: 8px 12px; background: linear-gradient(135deg, #fef3c7 0%, #fbbf24 100%); border: 2px solid #f59e0b; border-radius: 20px; font-size: 12px; font-weight: 700; color: #92400e; text-shadow: 0 1px 2px rgba(0,0,0,0.1); box-shadow: 0 3px 6px rgba(245, 158, 11, 0.3); font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; line-height: 1.2;';
                        return `<span style="${style}">${star} ${skill.competence}</span>`;
                    } else {
                        const star = '🔹';
                        const style =
                            'display: inline-block; margin: 4px 6px; padding: 8px 12px; background: linear-gradient(135deg, #dbeafe 0%, #93c5fd 100%); border: 2px solid #3b82f6; border-radius: 20px; font-size: 12px; font-weight: 600; color: #1e40af; text-shadow: 0 1px 2px rgba(0,0,0,0.1); box-shadow: 0 3px 6px rgba(59, 130, 246, 0.2); font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; line-height: 1.2;';
                        return `<span style="${style}">${star} ${skill.competence}</span>`;
                    }
                }).join(' ');
            }

            let htmlBody = `<div style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; line-height: 1.6; color: #374151; max-width: 600px; margin: 0 auto; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); padding: 30px; border-radius: 16px;">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="color: #2d3748; font-size: 28px; font-weight: 700; margin: 0 0 10px 0;">Profil Professionnel</h1>
                    <h2 style="color: #667eea; font-size: 20px; font-weight: 600; margin: 0;">${profileName}</h2>
                    <p style="font-size: 14px; margin-top: 5px; color: #667eea; font-weight: 600;">${profileJob}</p>
                </div>
        
                <p style="font-size: 18px; margin-bottom: 20px; color: #2d3748; font-weight: 500;">Bonjour,</p>
                <p style="font-size: 16px; margin-bottom: 30px; color: #4a5568; line-height: 1.6;">En tant que professionnel passionné, je recherche activement de nouveaux défis où mettre à profit mon expertise. Voici un aperçu de mes compétences principales :</p>
        
                <div id="skills-email-placeholder">
                    <div style="background: linear-gradient(135deg, #ffffff 0%, #f7fafc 100%); border-radius: 16px; padding: 25px; margin: 25px 0; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08); border: 1px solid #e2e8f0; text-align: center;">
                        <div style="font-size: 18px; font-weight: 600; color: #2d3748; margin-bottom: 15px;">💼 Compétences Clés</div>
                        <div style="line-height: 1.8;">
                            ${skillsHtmlInline}
                        </div>
                    </div>
                </div>
                
                <div style="text-align: center; margin: 35px 0;">
                    <a href="${profileUrl}" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 16px 40px; text-decoration: none; border-radius: 50px; font-weight: 600; font-size: 16px; box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);">
                        🔍 Découvrir mon profil complet
                    </a>
                </div>
                
                <p style="font-size: 16px; margin-bottom: 25px; color: #4a5568; line-height: 1.6;">Mon profil détaillé contient l'ensemble de mes expériences, formations et réalisations. Je serais ravi d'échanger avec vous sur les opportunités de collaboration.</p>
                
                <p style="font-size: 18px; font-weight: 600; color: #2d3748; margin-top: 30px;">Cordialement,<br>${profileName}</p>
            </div>`;

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
                        <button id="send-email" class="btn-primary btn-fixed">
                            <i class="fas fa-paper-plane"></i>
                            Envoyer
                        </button>
                        <h3><i class="fas fa-envelope"></i> Personnaliser votre message</h3>
                        
                        <div class="form-group">
                            <label for="email-recipient"><i class="fas fa-user"></i> Adresse email du destinataire:</label>
                            <input type="email" id="email-recipient" class="form-control" placeholder="exemple@email.com" required>
                            <p class="field-error" id="recipient-error"></p>
                        </div>
                        
                        <div class="form-group">
                            <label for="email-subject"><i class="fas fa-tag"></i> Objet:</label>
                            <input type="text" id="email-subject" value="${subject}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="email-body"><i class="fas fa-edit"></i> Message:</label>
                            <textarea id="email-body" class="form-control" rows="10">${plainTextBody}</textarea>
                            <small class="help-text">Personnalisez votre message selon vos besoins</small>
                        </div>
                        
                        <div class="form-group files-section">
                            <label class="section-title"><i class="fas fa-paperclip"></i> Pièces jointes <span class="optional-badge">(Facultatif)</span></label>
                            <p class="section-description">Vous pouvez ajouter des documents PDF pour enrichir votre candidature, mais ce n'est pas obligatoire.</p>
                            <div class="file-inputs">
                                <div class="file-input-group">
                                    <div class="file-input-wrapper">
                                        <input type="file" id="cv-file" class="file-input" accept=".pdf">
                                    <label for="cv-file" class="file-label">
                                            <div class="file-icon">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <div class="file-content">
                                                <span class="file-title">CV (PDF) - Facultatif</span>
                                                <span class="file-description">Ajoutez votre CV au format PDF si vous le souhaitez</span>
                                            </div>
                                            <div class="file-action">
                                                <i class="fas fa-plus"></i>
                                            </div>
                                    </label>
                                        <div class="file-preview" id="cv-preview" style="display: none;">
                                            <div class="file-info">
                                                <i class="fas fa-file-pdf file-type-icon"></i>
                                                <span class="file-name" id="cv-file-name"></span>
                                            </div>
                                            <button type="button" class="file-remove" id="cv-file-clear">
                                        <i class="fas fa-times"></i>
                                    </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="file-input-group">
                                    <div class="file-input-wrapper">
                                        <input type="file" id="motivation-file" class="file-input" accept=".pdf">
                                    <label for="motivation-file" class="file-label">
                                            <div class="file-icon">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <div class="file-content">
                                                <span class="file-title">Lettre de motivation (PDF) - Facultatif</span>
                                                <span class="file-description">Ajoutez votre lettre de motivation si vous en avez une</span>
                                            </div>
                                            <div class="file-action">
                                                <i class="fas fa-plus"></i>
                                            </div>
                                    </label>
                                        <div class="file-preview" id="motivation-preview" style="display: none;">
                                            <div class="file-info">
                                                <i class="fas fa-file-alt file-type-icon"></i>
                                                <span class="file-name" id="motivation-file-name"></span>
                                            </div>
                                            <button type="button" class="file-remove" id="motivation-file-clear">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                        
                        <div class="info-section">
                            <div class="info-card">
                                <i class="fas fa-info-circle"></i>
                                <span>Votre message sera envoyé avec une mise en forme professionnelle</span>
                    </div>
                        </div>
                    </div>
                    
                    <style>
                        .customize-email-modal {
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background: rgba(0, 0, 0, 0.6);
                            backdrop-filter: blur(8px);
                            display: none;
                            justify-content: center;
                            align-items: center;
                            z-index: 10000;
                            padding: 20px;
                            box-sizing: border-box;
                        }
                        
                        .customize-email-content {
                            background: #ffffff;
                            border-radius: 20px;
                            padding: 30px;
                            width: 100%;
                            max-width: 650px;
                            max-height: 90vh;
                            overflow-y: auto;
                            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
                            position: relative;
                            animation: modalSlideIn 0.3s ease-out;
                        }
                        
                        @keyframes modalSlideIn {
                            from {
                                opacity: 0;
                                transform: translateY(-30px) scale(0.95);
                            }
                            to {
                                opacity: 1;
                                transform: translateY(0) scale(1);
                            }
                        }
                        
                        .customize-close {
                            position: absolute;
                            top: 20px;
                            right: 25px;
                            font-size: 28px;
                            font-weight: bold;
                            color: #6b7280;
                            cursor: pointer;
                            transition: all 0.2s ease;
                            width: 35px;
                            height: 35px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            border-radius: 50%;
                            background: #f3f4f6;
                        }
                        
                        .customize-close:hover {
                            color: #ef4444;
                            background: #fee2e2;
                            transform: rotate(90deg);
                        }
                        
                        .customize-email-content h3 {
                            color: #1f2937;
                            font-size: 24px;
                            font-weight: 700;
                            margin: 0 0 25px 0;
                            display: flex;
                            align-items: center;
                            gap: 12px;
                        }
                        
                        .customize-email-content h3 i {
                            color: #667eea;
                            font-size: 22px;
                        }
                        
                        .form-group {
                            margin-bottom: 25px;
                        }
                        
                        .form-group label {
                            display: flex;
                            align-items: center;
                            gap: 8px;
                            font-weight: 600;
                            color: #374151;
                            margin-bottom: 8px;
                            font-size: 14px;
                        }
                        
                        .form-group label i {
                            color: #667eea;
                            font-size: 16px;
                        }
                        
                        .form-control {
                            width: 100%;
                            padding: 12px 16px;
                            border: 2px solid #e5e7eb;
                            border-radius: 12px;
                            font-size: 14px;
                            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
                            transition: all 0.2s ease;
                            background: #fafafa;
                            box-sizing: border-box;
                        }
                        
                        .form-control:focus {
                            outline: none;
                            border-color: #667eea;
                            background: #ffffff;
                            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
                        }
                        
                        .help-text {
                            color: #6b7280;
                            font-size: 12px;
                            margin-top: 5px;
                            display: block;
                        }
                        
                        .field-error {
                            color: #ef4444;
                            font-size: 12px;
                            margin-top: 5px;
                            margin-bottom: 0;
                        }
                        
                        .files-section {
                            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                            border-radius: 16px;
                            padding: 20px;
                            margin: 25px 0;
                        }
                        
                        .section-title {
                            font-size: 16px !important;
                            font-weight: 700 !important;
                            color: #1f2937 !important;
                            margin-bottom: 15px !important;
                        }
                        
                        .section-title .optional-badge {
                            background-color: #e5e7eb;
                            color: #4b5563;
                            padding: 4px 8px;
                            border-radius: 6px;
                            font-size: 12px;
                            font-weight: 600;
                            margin-left: 8px;
                        }
                        
                        .section-description {
                            color: #6b7280;
                            font-size: 13px;
                            margin-top: 8px;
                            margin-bottom: 15px;
                        }
                        
                        .file-inputs {
                            display: flex;
                            flex-direction: column;
                            gap: 15px;
                        }
                        
                        .file-input-group {
                            width: 100%;
                        }
                        
                        .file-input-wrapper {
                            position: relative;
                        }
                        
                        .file-input {
                            position: absolute;
                            opacity: 0;
                            pointer-events: none;
                        }
                        
                        .file-label {
                            display: flex;
                            align-items: center;
                            padding: 16px 20px;
                            background: #ffffff;
                            border: 2px dashed #d1d5db;
                            border-radius: 12px;
                            cursor: pointer;
                            transition: all 0.3s ease;
                            gap: 15px;
                            margin-bottom: 0 !important;
                        }
                        
                        .file-label:hover {
                            border-color: #667eea;
                            background: #f8faff;
                            transform: translateY(-2px);
                            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
                        }
                        
                        .file-icon {
                            width: 45px;
                            height: 45px;
                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                            border-radius: 12px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            color: white;
                            font-size: 18px;
                            flex-shrink: 0;
                        }
                        
                        .file-content {
                            flex: 1;
                            text-align: left;
                        }
                        
                        .file-title {
                            display: block;
                            font-weight: 600;
                            color: #1f2937;
                            font-size: 14px;
                            margin-bottom: 2px;
                        }
                        
                        .file-description {
                            display: block;
                            color: #6b7280;
                            font-size: 12px;
                        }
                        
                        .file-action {
                            width: 35px;
                            height: 35px;
                            background: #e5e7eb;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            color: #6b7280;
                            font-size: 16px;
                            transition: all 0.2s ease;
                            flex-shrink: 0;
                        }
                        
                        .file-label:hover .file-action {
                            background: #667eea;
                            color: white;
                        }
                        
                        .file-preview {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            padding: 12px 16px;
                            background: #f0f9ff;
                            border: 2px solid #0ea5e9;
                            border-radius: 12px;
                            margin-top: 10px;
                        }
                        
                        .file-info {
                            display: flex;
                            align-items: center;
                            gap: 10px;
                            flex: 1;
                        }
                        
                        .file-type-icon {
                            color: #0ea5e9;
                            font-size: 18px;
                        }
                        
                        .file-name {
                            font-weight: 500;
                            color: #0c4a6e;
                            font-size: 13px;
                        }
                        
                        .file-remove {
                            background: #ef4444;
                            color: white;
                            border: none;
                            width: 28px;
                            height: 28px;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            cursor: pointer;
                            transition: all 0.2s ease;
                            font-size: 12px;
                        }
                        
                        .file-remove:hover {
                            background: #dc2626;
                            transform: scale(1.1);
                        }
                        
                        .info-section {
                            margin: 20px 0;
                        }
                        
                        .info-card {
                            display: flex;
                            align-items: center;
                            gap: 12px;
                            padding: 15px 18px;
                            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
                            border: 1px solid #93c5fd;
                            border-radius: 12px;
                            color: #1e40af;
                            font-size: 13px;
                            font-weight: 500;
                        }
                        
                        .info-card i {
                            color: #3b82f6;
                            font-size: 16px;
                        }
                        
                        .btn-fixed {
                            position: absolute;
                            top: 20px;
                            right: 20px;
                            z-index: 10;
                            padding: 10px 20px;
                            font-size: 14px;
                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                            color: white;
                            border: none;
                            border-radius: 50px;
                            font-weight: 600;
                            cursor: pointer;
                            transition: all 0.3s ease;
                            display: flex;
                            align-items: center;
                            gap: 8px;
                            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
                        }
                        
                        .btn-fixed:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.5);
                        }
                        
                        .btn-fixed:disabled {
                            opacity: 0.7;
                            cursor: not-allowed;
                            transform: none;
                        }
                        
                        /* Responsive Design */
                        @media (max-width: 768px) {
                            .customize-email-modal {
                                padding: 15px;
                            }
                            
                            .customize-email-content {
                                padding: 25px 20px;
                                border-radius: 15px;
                                max-height: 95vh;
                            }
                            
                            .customize-email-content h3 {
                                font-size: 20px;
                                margin-bottom: 20px;
                                margin-top: 15px;
                            }
                            
                            .btn-fixed {
                                top: 15px;
                                right: 15px;
                                padding: 8px 16px;
                                font-size: 12px;
                            }
                            
                            .btn-fixed span {
                                display: none;
                            }
                            
                            .form-group {
                                margin-bottom: 20px;
                            }
                            
                            .files-section {
                                padding: 15px;
                                margin: 20px 0;
                            }
                            
                            .file-label {
                                padding: 12px 15px;
                                gap: 12px;
                            }
                            
                            .file-icon {
                                width: 40px;
                                height: 40px;
                                font-size: 16px;
                            }
                            
                            .file-title {
                                font-size: 13px;
                            }
                            
                            .file-description {
                                font-size: 11px;
                            }
                        }
                        
                        @media (max-width: 480px) {
                            .customize-email-content {
                                padding: 20px 15px;
                            }
                            
                            .customize-email-content h3 {
                                font-size: 18px;
                                flex-direction: column;
                                gap: 8px;
                                text-align: center;
                                margin-top: 20px;
                            }
                            
                            .btn-fixed {
                                position: relative;
                                top: auto;
                                right: auto;
                                width: 100%;
                                justify-content: center;
                                margin-bottom: 20px;
                                order: -1;
                            }
                            
                            .file-inputs {
                                gap: 12px;
                            }
                            
                            .file-label {
                                flex-direction: column;
                                text-align: center;
                                padding: 15px;
                                gap: 10px;
                            }
                            
                            .file-content {
                                text-align: center;
                            }
                        }
                    </style>
                `;

                // Ajouter la modal au body
                document.body.appendChild(customizeModal);

                // Afficher la modal
                customizeModal.style.display = 'flex';

                // Gérer l'affichage des noms de fichiers
                document.getElementById('cv-file').addEventListener('change', function () {
                    const fileLabel = document.querySelector('label[for="cv-file"]');
                    const filePreview = document.getElementById('cv-preview');
                    const fileName = document.getElementById('cv-file-name');

                    if (this.files.length) {
                        fileName.textContent = this.files[0].name;
                        fileLabel.style.display = 'none';
                        filePreview.style.display = 'flex';
                    } else {
                        fileLabel.style.display = 'flex';
                        filePreview.style.display = 'none';
                    }
                });

                document.getElementById('motivation-file').addEventListener('change', function () {
                    const fileLabel = document.querySelector('label[for="motivation-file"]');
                    const filePreview = document.getElementById('motivation-preview');
                    const fileName = document.getElementById('motivation-file-name');

                    if (this.files.length) {
                        fileName.textContent = this.files[0].name;
                        fileLabel.style.display = 'none';
                        filePreview.style.display = 'flex';
                    } else {
                        fileLabel.style.display = 'flex';
                        filePreview.style.display = 'none';
                    }
                });

                // Gérer la suppression des fichiers
                document.getElementById('cv-file-clear').addEventListener('click', function () {
                    const fileInput = document.getElementById('cv-file');
                    const fileLabel = document.querySelector('label[for="cv-file"]');
                    const filePreview = document.getElementById('cv-preview');

                    fileInput.value = '';
                    fileLabel.style.display = 'flex';
                    filePreview.style.display = 'none';
                });

                document.getElementById('motivation-file-clear').addEventListener('click', function () {
                    const fileInput = document.getElementById('motivation-file');
                    const fileLabel = document.querySelector('label[for="motivation-file"]');
                    const filePreview = document.getElementById('motivation-preview');

                    fileInput.value = '';
                    fileLabel.style.display = 'flex';
                    filePreview.style.display = 'none';
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
                    formData.append('skills', JSON.stringify(userSkills));
                    formData.append('userEmail', <?= json_encode($users['mail']) ?>);
                    formData.append('userPhone', <?= json_encode($users['phone']) ?>);
                    formData.append('userCompetence', <?= json_encode($users['competences']) ?>);

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
                    formData.append('skills', JSON.stringify(userSkills));
                    formData.append('userEmail', <?= json_encode($users['mail']) ?>);
                    formData.append('userPhone', <?= json_encode($users['phone']) ?>);
                    formData.append('userCompetence', <?= json_encode($users['competences']) ?>);

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