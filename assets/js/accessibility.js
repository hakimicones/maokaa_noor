// assets/js/accessibility.js
// VEP — Barre d'outils accessibilité

(function() {
    'use strict';

    var root = document.documentElement;
    var STORAGE_KEY = 'vep-a11y-settings';

    // Charger les préférences sauvegardées
    function loadSettings() {
        try {
            var saved = localStorage.getItem(STORAGE_KEY);
            return saved ? JSON.parse(saved) : {};
        } catch (e) {
            return {};
        }
    }

    // Sauvegarder les préférences
    function saveSettings(settings) {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(settings));
        } catch (e) {
            // Silently fail if localStorage is not available
        }
    }

    // Initialiser la barre d'outils
    function initToolbar() {
        var settings = loadSettings();

        // Contraste élevé
        var btnContrast = document.getElementById('btn-high-contrast');
        if (btnContrast) {
            if (settings.highContrast) {
                document.body.classList.add('high-contrast');
                btnContrast.setAttribute('aria-pressed', 'true');
            }
            btnContrast.addEventListener('click', function() {
                var pressed = this.getAttribute('aria-pressed') === 'true';
                this.setAttribute('aria-pressed', !pressed);
                document.body.classList.toggle('high-contrast');
                settings.highContrast = !pressed;
                saveSettings(settings);
            });
        }

        // Agrandir le texte
        var btnIncrease = document.getElementById('btn-increase-text');
        if (btnIncrease) {
            if (settings.fontSize) {
                root.style.fontSize = settings.fontSize + 'px';
            }
            btnIncrease.addEventListener('click', function() {
                var current = parseFloat(getComputedStyle(root).fontSize);
                if (current < 28) {
                    var newSize = current + 2;
                    root.style.fontSize = newSize + 'px';
                    settings.fontSize = newSize;
                    saveSettings(settings);
                }
            });
        }

        // Réduire le texte
        var btnDecrease = document.getElementById('btn-decrease-text');
        if (btnDecrease) {
            btnDecrease.addEventListener('click', function() {
                var current = parseFloat(getComputedStyle(root).fontSize);
                if (current > 14) {
                    var newSize = current - 2;
                    root.style.fontSize = newSize + 'px';
                    settings.fontSize = newSize;
                    saveSettings(settings);
                }
            });
        }

        // Menu mobile
        var menuToggle = document.querySelector('.menu-toggle');
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                var nav = document.getElementById('nav-main');
                var expanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !expanded);
                nav.classList.toggle('is-open');
            });
        }
    }

    // Initialiser au chargement
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initToolbar);
    } else {
        initToolbar();
    }

    // Exposer les fonctions pour usage externe
    window.VEP = window.VEP || {};
    window.VEP.accessibility = {
        loadSettings: loadSettings,
        saveSettings: saveSettings
    };

})();