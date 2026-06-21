<?php
// $blockTitle = optional heading, $formSent = bool, $formError = string, $formData = array
$csrfToken = function_exists('generateCSRFToken') ? generateCSRFToken() : '';
$baseUrl = defined('BASE_URL') ? BASE_URL : '/';
?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <?php if (!empty($blockTitle)): ?>
                    <h2 class="section-title"><?php echo htmlspecialchars($blockTitle); ?></h2>
                <?php else: ?>
                    <h2 class="section-title">Contactez-nous</h2>
                <?php endif; ?>

                <?php if ($formSent): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.
                    </div>
                <?php else: ?>

                    <?php if (!empty($formError)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($formError); ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <input type="hidden" name="vep_contact_form" value="1">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
                        <div class="mb-3">
                            <label class="form-label">Nom complet *</label>
                            <input type="text" name="contact_nom" class="form-control"
                                   value="<?php echo htmlspecialchars($formData['nom'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="contact_email" class="form-control"
                                   value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" name="contact_telephone" class="form-control"
                                   value="<?php echo htmlspecialchars($formData['telephone'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sujet</label>
                            <input type="text" name="contact_sujet" class="form-control"
                                   value="<?php echo htmlspecialchars($formData['sujet'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message *</label>
                            <textarea name="contact_message" class="form-control" rows="5" required><?php echo htmlspecialchars($formData['message'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Captcha *</label>
                            <div class="d-flex align-items-center gap-3">
                                <a href="#" class="captcha-refresh" title="Rafraîchir">
                                    <img src="<?php echo htmlspecialchars($baseUrl); ?>includes/captcha-image.php"
                                         alt="Captcha" class="captcha-img rounded border" style="cursor:pointer;height:60px;">
                                </a>
                                <input type="text" name="captcha" class="form-control" placeholder="Code" required
                                       maxlength="5" style="max-width:120px;text-transform:uppercase;" autocomplete="off">
                            </div>
                            <div class="form-text mt-1">Entrez le code ci-contre. Cliquez sur l'image pour le changer.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Envoyer le message
                        </button>
                    </form>
                    <script>
                    (function() {
                        var img = document.querySelector('.captcha-img');
                        var link = document.querySelector('.captcha-refresh');
                        if (img && link) {
                            function refresh() {
                                img.src = '<?php echo htmlspecialchars($baseUrl); ?>includes/captcha-image.php?_=' + Date.now();
                            }
                            link.addEventListener('click', function(e) { e.preventDefault(); refresh(); });
                            img.addEventListener('click', refresh);
                        }
                    })();
                    </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
