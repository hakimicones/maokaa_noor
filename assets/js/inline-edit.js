// assets/js/inline-edit.js — Édition inline frontend avec WYSIWYG (Quill) pour le body

(function () {
    'use strict';

    var csrfToken = getMeta('csrf-token');
    var pageSlug  = getMeta('page-slug');
    var baseUrl   = getMeta('base-url') || '/';

    // ── Barre d'outils admin (toujours visible) ──────────────────────────
    var toolbar = document.createElement('div');
    toolbar.id = 'ie-toolbar';
    toolbar.innerHTML =
        '<i class="fas fa-pencil-alt ie-toolbar-icon"></i>' +
        '<span id="ie-toolbar-hint">Mode <strong>édition inline</strong> — cliquez sur un champ pour le modifier</span>' +
        '<a href="' + baseUrl + 'admin/" id="ie-toolbar-admin">' +
            'Tableau de bord <i class="fas fa-external-link-alt"></i>' +
        '</a>';
    document.body.prepend(toolbar);

    var editables = document.querySelectorAll('[data-inline-field]');
    if (!editables.length) return;

    editables.forEach(function (el) {
        var field = el.getAttribute('data-inline-field');
        if (field === 'body') {
            initBodyField(el);
        } else {
            initTextField(el, field);
        }
    });

    // ── Champs texte simples (title, subtitle) : contenteditable ─────────
    function initTextField(el, field) {
        el.setAttribute('contenteditable', 'true');
        el.setAttribute('spellcheck', 'true');
        el.classList.add('ie-field');

        var originalHTML = el.innerHTML;

        el.addEventListener('focus', function () {
            this.classList.add('ie-editing');
        });

        el.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                this.blur();
            }
            if (e.key === 'Escape') {
                this.innerHTML = originalHTML;
                this.blur();
            }
        });

        el.addEventListener('blur', function () {
            var self = this;
            self.classList.remove('ie-editing');
            var current = self.innerHTML;
            if (current === originalHTML) return;

            pulse(self, 'ie-saving');
            save(field, current, function (ok, data) {
                self.classList.remove('ie-saving');
                if (ok) {
                    originalHTML = current;
                    pulse(self, 'ie-success');
                    showToast(data.message, 'success');
                } else {
                    self.innerHTML = originalHTML;
                    pulse(self, 'ie-error');
                    showToast(data.message || 'Erreur inconnue', 'error');
                }
            });
        });
    }

    // ── Champ body : éditeur WYSIWYG Quill activé au clic ────────────────
    function initBodyField(el) {
        el.classList.add('ie-field', 'ie-body-hint');

        var hint = document.createElement('div');
        hint.className = 'ie-body-click-hint';
        hint.innerHTML = '<i class="fas fa-pencil-alt"></i> Cliquer pour éditer le contenu';
        el.appendChild(hint);

        el.addEventListener('click', function onFirstClick() {
            el.removeEventListener('click', onFirstClick);
            el.classList.remove('ie-body-hint');
            hint.remove();
            activateQuill(el);
        });
    }

    function activateQuill(el) {
        var originalHTML = el.innerHTML;

        // Construire le conteneur Quill
        var wrapper = document.createElement('div');
        wrapper.className = 'ie-quill-wrapper';

        var editorDiv = document.createElement('div');
        editorDiv.className = 'ie-quill-editor';
        editorDiv.innerHTML = originalHTML;

        var actionsBar = document.createElement('div');
        actionsBar.className = 'ie-quill-actions';
        actionsBar.innerHTML =
            '<button class="ie-btn ie-btn-save"><i class="fas fa-save"></i> Enregistrer</button>' +
            '<button class="ie-btn ie-btn-cancel"><i class="fas fa-times"></i> Annuler</button>';

        wrapper.appendChild(editorDiv);
        wrapper.appendChild(actionsBar);
        el.innerHTML = '';
        el.appendChild(wrapper);

        // Initialiser Quill
        var quill = new Quill(editorDiv, {
            theme: 'snow',
            placeholder: 'Rédigez votre contenu ici…',
            modules: {
                toolbar: [
                    [{ header: [2, 3, 4, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ color: [] }, { background: [] }],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    [{ align: [] }],
                    ['link', 'blockquote'],
                    ['clean']
                ]
            }
        });

        var saveBtn   = actionsBar.querySelector('.ie-btn-save');
        var cancelBtn = actionsBar.querySelector('.ie-btn-cancel');

        // ── Sauvegarde ────────────────────────────────────────────────────
        function doSave() {
            var html = quill.root.innerHTML;
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement…';

            save('body', html, function (ok, data) {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="fas fa-save"></i> Enregistrer';

                if (ok) {
                    originalHTML = html;
                    deactivateQuill(el, html, true);
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message || 'Erreur inconnue', 'error');
                }
            });
        }

        // ── Annulation ────────────────────────────────────────────────────
        function doCancel() {
            deactivateQuill(el, originalHTML, false);
        }

        saveBtn.addEventListener('click', doSave);
        cancelBtn.addEventListener('click', doCancel);

        // Ctrl+S pour sauvegarder depuis l'éditeur
        el.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                doSave();
            }
        });
    }

    function deactivateQuill(el, html, success) {
        el.innerHTML = html;
        if (success) {
            pulse(el, 'ie-success');
        }
        // Réactiver le clic pour une prochaine édition
        el.classList.add('ie-body-hint');
        var hint = document.createElement('div');
        hint.className = 'ie-body-click-hint';
        hint.innerHTML = '<i class="fas fa-pencil-alt"></i> Cliquer pour éditer le contenu';
        el.appendChild(hint);

        el.addEventListener('click', function onNextClick() {
            el.removeEventListener('click', onNextClick);
            el.classList.remove('ie-body-hint');
            hint.remove();
            activateQuill(el);
        });
    }

    // ── Envoi AJAX commun ─────────────────────────────────────────────────
    function save(field, value, callback) {
        fetch(baseUrl + 'includes/inline_edit.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                csrf_token: csrfToken,
                slug:       pageSlug,
                field:      field,
                value:      value
            })
        })
        .then(function (res) { return res.json(); })
        .then(function (data) { callback(data.success, data); })
        .catch(function () {
            callback(false, { message: 'Erreur de connexion au serveur' });
        });
    }

    // ── Feedback visuel ───────────────────────────────────────────────────
    function pulse(el, cls) {
        el.classList.remove('ie-saving', 'ie-success', 'ie-error');
        el.classList.add(cls);
        if (cls !== 'ie-saving') {
            setTimeout(function () { el.classList.remove(cls); }, 1800);
        }
    }

    function showToast(message, type) {
        var existing = document.getElementById('ie-toast');
        if (existing) existing.remove();

        var icon = type === 'success'
            ? '<i class="fas fa-check-circle"></i>'
            : '<i class="fas fa-exclamation-circle"></i>';

        var toast = document.createElement('div');
        toast.id        = 'ie-toast';
        toast.className = 'ie-toast ie-toast-' + type;
        toast.innerHTML = icon + ' ' + escapeHtml(message);
        document.body.appendChild(toast);

        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                toast.classList.add('ie-toast-visible');
            });
        });

        setTimeout(function () {
            toast.classList.remove('ie-toast-visible');
            setTimeout(function () { toast.remove(); }, 300);
        }, 3000);
    }

    // ── Utilitaires ───────────────────────────────────────────────────────
    function getMeta(name) {
        var el = document.querySelector('meta[name="' + name + '"]');
        return el ? el.getAttribute('content') : null;
    }

    function escapeHtml(str) {
        var d = document.createElement('div');
        d.appendChild(document.createTextNode(String(str)));
        return d.innerHTML;
    }

})();
