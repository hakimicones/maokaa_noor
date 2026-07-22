<?php
$csrfToken = function_exists('generateCSRFToken') ? generateCSRFToken() : '';
$siteKey = defined('HCAPTCHA_SITE_KEY') ? HCAPTCHA_SITE_KEY : '';
$bgImage = defined('BASE_URL') ? BASE_URL . 'assets/images/contact/contact-bg.jpg' : '/assets/images/contact/contact-bg.jpg';
?>
<section class="contact-modern">
    <div class="container">
        <div class="contact-inner">

            <!-- Left: Visual side -->
            <div class="contact-visual" style="background-image: url('<?php echo htmlspecialchars($bgImage); ?>');">
                <div class="overlay"></div>
                <div class="visual-content">
                    <h3>Parlons de votre projet</h3>
                    <p>Notre équipe est à votre écoute pour vous accompagner dans le choix de vos équipements de laboratoire.</p>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-text">
                            <strong>Adresse</strong>
                            <span>123 Avenue des Sciences, 75000 Paris</span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="info-text">
                            <strong>Téléphone</strong>
                            <span>+33 1 23 45 67 89</span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-text">
                            <strong>Email</strong>
                            <span>contact@maokaa.fr</span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-text">
                            <strong>Horaires</strong>
                            <span>Lun – Ven : 9h00 – 18h00</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Form side -->
            <div class="contact-form-side">
                <?php if ($formSent): ?>
                    <div style="text-align:center;padding:60px 0;">
                        <div style="font-size:72px;color:var(--secondary);margin-bottom:20px;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2 style="margin-bottom:10px;">Message envoyé !</h2>
                        <p style="color:var(--text-muted);font-size:16px;">
                            Votre message a bien été transmis. Nous vous répondrons dans les plus brefs délais.
                        </p>
                    </div>
                <?php else: ?>

                    <div class="form-badge">
                        <i class="fas fa-paper-plane"></i> Contactez-nous
                    </div>
                    <h2>Envoyez-nous un message</h2>
                    <p class="form-subtitle">Remplissez le formulaire ci-dessous et nous reviendrons vers vous rapidement.</p>

                    <?php if (!empty($formError)): ?>
                        <div class="alert alert-danger" style="border-radius:12px;font-size:14px;">
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($formError); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <input type="hidden" name="vep_contact_form" value="1">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">

                        <div class="form-group">
                            <div class="input-group-modern">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" name="contact_nom" class="form-control-modern"
                                       value="<?php echo htmlspecialchars($formData['nom'] ?? ''); ?>"
                                       placeholder="Nom complet *" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group-modern">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" name="contact_email" class="form-control-modern"
                                       value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>"
                                       placeholder="Email *" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group-modern">
                                <i class="fas fa-phone input-icon"></i>
                                <input type="tel" name="contact_telephone" class="form-control-modern"
                                       value="<?php echo htmlspecialchars($formData['telephone'] ?? ''); ?>"
                                       placeholder="Téléphone">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group-modern">
                                <i class="fas fa-tag input-icon"></i>
                                <input type="text" name="contact_sujet" class="form-control-modern"
                                       value="<?php echo htmlspecialchars($formData['sujet'] ?? ''); ?>"
                                       placeholder="Sujet">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group-modern">
                                <i class="fas fa-comment input-icon" style="top:22px;transform:none;"></i>
                                <textarea name="contact_message" class="form-control-modern" rows="5"
                                          placeholder="Votre message *" required><?php echo htmlspecialchars($formData['message'] ?? ''); ?></textarea>
                            </div>
                        </div>

                        <?php if (!empty($siteKey)): ?>
                        <div class="form-group">
                            <div class="h-captcha" data-sitekey="<?php echo htmlspecialchars($siteKey); ?>"></div>
                        </div>
                        <?php endif; ?>

                        <button type="submit" class="btn-send">
                            <i class="fas fa-paper-plane"></i> Envoyer le message
                        </button>
                    </form>

                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script src="https://js.hcaptcha.com/1/api.js" async defer></script>
