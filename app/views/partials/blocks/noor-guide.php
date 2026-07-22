<?php
$baseUrl = defined('BASE_URL') ? rtrim(BASE_URL, '/') : '';
$imgPath = $baseUrl . '/assets/images/noor-guide/';
?>
<!-- ============ NOOR GUIDE HERO ============ -->
<section class="noor-hero">
    <div class="noor-particles">
        <span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="noor-badge">
                    <i class="fas fa-mobile-alt"></i> Application mobile
                </div>
                <h1>Découvrez <span class="highlight">Noor Guide</span></h1>
                <p class="noor-tagline">
                    Une application mobile conçue pour accompagner les personnes aveugles et malvoyantes dans leurs déplacements, en offrant une expérience de navigation simple, intuitive et entièrement accessible.
                </p>
                <div class="noor-cta">
                    <a href="#features" class="noor-btn-primary">
                        <i class="fas fa-rocket"></i> Découvrir l'application
                    </a>
                    <a href="#showcase" class="noor-btn-secondary">
                        <i class="fas fa-play-circle"></i> Voir le fonctionnement
                    </a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="noor-hero-image">
                    <img src="<?php echo $imgPath; ?>mobile-app.jpg" alt="Noor Guide Application">
                    <div class="floating-card fc-1">
                        <div class="fc-icon" style="background:linear-gradient(135deg,#435980,#5a7da0);">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <div class="fc-text">
                            <strong>Navigation</strong>
                            <span>Guidage intelligent</span>
                        </div>
                    </div>
                    <div class="floating-card fc-2">
                        <div class="fc-icon" style="background:linear-gradient(135deg,#87A952,#a8c66a);">
                            <i class="fas fa-bluetooth-b"></i>
                        </div>
                        <div class="fc-text">
                            <strong>Bluetooth</strong>
                            <span>Détection à proximité</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ FEATURES ============ -->
<section class="noor-features" id="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-label noor-reveal">
                    <i class="fas fa-star"></i> Fonctionnalités
                </div>
                <h2 class="noor-section-title noor-reveal">Tout ce dont vous avez besoin pour vous déplacer en toute autonomie</h2>
                <p class="noor-section-sub noor-reveal">
                    Noor Guide combine plusieurs technologies pour offrir une expérience de navigation complète et accessible.
                </p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4 noor-reveal">
                <div class="noor-feature-card">
                    <span class="fc-number">01</span>
                    <div class="fc-icon-wrap">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h4>Navigation intelligente</h4>
                    <p>Choisissez votre destination parmi les lieux disponibles et laissez Noor Guide vous accompagner tout au long de votre parcours.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 noor-reveal">
                <div class="noor-feature-card">
                    <span class="fc-number">02</span>
                    <div class="fc-icon-wrap">
                        <i class="fas fa-route"></i>
                    </div>
                    <h4>Création de parcours personnalisés</h4>
                    <p>Planifiez vos déplacements en créant des parcours personnalisés composés de plusieurs destinations. Organisez votre itinéraire selon vos besoins.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 noor-reveal">
                <div class="noor-feature-card">
                    <span class="fc-number">03</span>
                    <div class="fc-icon-wrap">
                        <i class="fas fa-bluetooth-b"></i>
                    </div>
                    <h4>Détection des dispositifs à proximité</h4>
                    <p>L'application détecte les dispositifs de guidage Bluetooth situés à proximité, affiche leur disponibilité ainsi que leur distance.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 noor-reveal">
                <div class="noor-feature-card">
                    <span class="fc-number">04</span>
                    <div class="fc-icon-wrap">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h4>Informations sur les lieux</h4>
                    <p>Consultez les informations essentielles sur chaque lieu avant de commencer votre déplacement afin de mieux préparer votre parcours.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 noor-reveal">
                <div class="noor-feature-card">
                    <span class="fc-number">05</span>
                    <div class="fc-icon-wrap">
                        <i class="fas fa-universal-access"></i>
                    </div>
                    <h4>Expérience pensée pour l'accessibilité</h4>
                    <p>Chaque écran a été conçu pour être entièrement compatible avec les lecteurs d'écran. Navigation fluide et interactions simples pour une expérience inclusive.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 noor-reveal">
                <div class="noor-feature-card">
                    <span class="fc-number">06</span>
                    <div class="fc-icon-wrap">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h4>Une solution au service de l'autonomie</h4>
                    <p>Notre objectif est de permettre aux personnes aveugles et malvoyantes de se déplacer avec davantage d'autonomie, de confiance et de sérénité.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ STATS ============ -->
<section class="noor-stats noor-reveal-scale">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-6 col-lg-3 noor-stat-item">
                <div class="stat-number" data-count="98">0</div>
                <div class="stat-label">% de satisfaction utilisateurs</div>
            </div>
            <div class="col-6 col-lg-3 noor-stat-item">
                <div class="stat-number" data-count="500">0</div>
                <div class="stat-label">Lieux équipés</div>
            </div>
            <div class="col-6 col-lg-3 noor-stat-item">
                <div class="stat-number" data-count="15">0</div>
                <div class="stat-label">Villes partenaires</div>
            </div>
            <div class="col-6 col-lg-3 noor-stat-item">
                <div class="stat-number" data-count="24">0</div>
                <div class="stat-label">Dispositifs Bluetooth /7</div>
            </div>
        </div>
    </div>
</section>

<!-- ============ SHOWCASE ============ -->
<section class="noor-showcase" id="showcase">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label noor-reveal" style="display:inline-flex;">
                <i class="fas fa-cogs"></i> Fonctionnement
            </div>
            <h2 class="noor-section-title noor-reveal">Comment ça marche</h2>
            <p class="noor-section-sub noor-reveal" style="margin:0 auto 10px;">
                Une expérience utilisateur fluide, du choix de la destination à l'arrivée.
            </p>
        </div>

        <div class="noor-showcase-item">
            <div class="showcase-text noor-reveal-left">
                <div class="step-badge"><i class="fas fa-search"></i> Étape 1</div>
                <h3>Navigation intelligente</h3>
                <p>Choisissez votre destination parmi les lieux disponibles et laissez Noor Guide vous accompagner tout au long de votre parcours. L'application calcule l'itinéraire optimal et vous guide pas à pas avec des instructions vocales claires.</p>
            </div>
            <div class="showcase-image noor-reveal-right">
                <img src="<?php echo $imgPath; ?>navigation.jpg" alt="Navigation intelligente">
            </div>
        </div>

        <div class="noor-showcase-item reverse">
            <div class="showcase-text noor-reveal-right">
                <div class="step-badge"><i class="fas fa-route"></i> Étape 2</div>
                <h3>Création de parcours personnalisés</h3>
                <p>Planifiez vos déplacements en créant des parcours personnalisés composés de plusieurs destinations. Organisez votre itinéraire selon vos besoins et suivez-le facilement depuis l'application.</p>
            </div>
            <div class="showcase-image noor-reveal-left">
                <img src="<?php echo $imgPath; ?>innovation.jpg" alt="Création de parcours">
            </div>
        </div>

        <div class="noor-showcase-item">
            <div class="showcase-text noor-reveal-left">
                <div class="step-badge"><i class="fas fa-bluetooth-b"></i> Étape 3</div>
                <h3>Détection des dispositifs Bluetooth</h3>
                <p>L'application détecte les dispositifs de guidage Bluetooth situés à proximité, affiche leur disponibilité ainsi que leur distance, afin de faciliter la connexion et l'activation du bon dispositif.</p>
            </div>
            <div class="showcase-image noor-reveal-right">
                <img src="<?php echo $imgPath; ?>accessibility.jpg" alt="Détection Bluetooth">
            </div>
        </div>
    </div>
</section>

<!-- ============ ACCESSIBILITY FOCUS ============ -->
<section class="noor-cta-section">
    <div class="container">
        <div class="noor-cta-card noor-reveal-scale">
            <h2>Une expérience pensée pour l'accessibilité</h2>
            <p>
                Chaque écran de Noor Guide a été conçu pour être entièrement compatible avec les lecteurs d'écran. L'interface propose une navigation fluide, des formulaires accessibles et des interactions simples afin de garantir une expérience inclusive pour tous les utilisateurs.
            </p>
            <p style="font-size:15px;color:rgba(255,255,255,0.6);margin-top:-20px;">
                <i class="fas fa-check-circle" style="color:var(--secondary);"></i> Compatible VoiceOver & TalkBack
                &nbsp;&nbsp;&nbsp;
                <i class="fas fa-check-circle" style="color:var(--secondary);"></i> Contraste élevé
                &nbsp;&nbsp;&nbsp;
                <i class="fas fa-check-circle" style="color:var(--secondary);"></i> Navigation au clavier
            </p>
            <p style="margin-top:-10px;">
                <a href="#features" class="noor-btn-primary">
                    <i class="fas fa-arrow-down"></i> En savoir plus
                </a>
            </p>
        </div>
    </div>
</section>

<!-- ============ NOOR GUIDE JS ============ -->
<script>
(function() {
    'use strict';

    // --- Scroll Reveal ---
    var revealEls = document.querySelectorAll('.noor-reveal, .noor-reveal-left, .noor-reveal-right, .noor-reveal-scale');
    if (revealEls.length && 'IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });
        revealEls.forEach(function(el) { observer.observe(el); });
    } else {
        revealEls.forEach(function(el) { el.classList.add('revealed'); });
    }

    // --- Stat Counter Animation ---
    var statNumbers = document.querySelectorAll('.noor-stat-item .stat-number');
    if (statNumbers.length && 'IntersectionObserver' in window) {
        var statObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var el = entry.target;
                    var target = parseInt(el.getAttribute('data-count'), 10);
                    var current = 0;
                    var step = Math.ceil(target / 60);
                    var timer = setInterval(function() {
                        current += step;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        el.textContent = current + (target === 98 ? '%' : '+');
                    }, 25);
                    statObserver.unobserve(el);
                }
            });
        }, { threshold: 0.5 });
        statNumbers.forEach(function(el) { statObserver.observe(el); });
    }

    // --- Smooth scroll for anchor links ---
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
})();
</script>
