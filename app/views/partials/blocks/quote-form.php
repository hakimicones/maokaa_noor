<div class="modal fade" id="quoteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Demande de devis</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <div id="quote-success" class="alert alert-success d-none">
          <i class="fas fa-check-circle me-2"></i><span></span>
        </div>
        <div id="quote-error" class="alert alert-danger d-none">
          <i class="fas fa-exclamation-circle me-2"></i><span></span>
        </div>
        <form id="quoteForm">
          <input type="hidden" name="produit_id" id="quote-produit-id" value="">
          <div class="mb-3">
            <label class="form-label">Produit</label>
            <input type="text" id="quote-produit-nom" class="form-control" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Nom complet *</label>
            <input type="text" name="nom" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Téléphone</label>
            <input type="tel" name="telephone" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Quantité</label>
            <input type="number" name="quantite" class="form-control" value="1" min="1">
          </div>
          <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="message" class="form-control" rows="4" placeholder="Vos questions ou pr&eacute;cisions..."></textarea>
          </div>
          <button type="submit" class="btn btn-primary w-100" id="quote-submit">
            <i class="fas fa-paper-plane me-2"></i>Envoyer la demande
          </button>
        </form>
      </div>
    </div>
  </div>
</div>