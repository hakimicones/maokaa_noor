Objectif : créer une interface d’édition HTML visuelle pour les pages CMS, avec une expérience proche d’Elementor.

1. Choix de la bibliothèque
- Utiliser GrapesJS comme éditeur visuel principal.
- Ajouter DOMPurify pour nettoyer le HTML avant sauvegarde.
- Ajouter un nettoyage serveur via HTMLPurifier ou une whitelist stricte côté PHP.

2. Intégration dans l’admin
- creer une vue dedie au body avec un éditeur GrapesJS dans les pages de création et d’édition des CMS.
- les boutons qui appelle cette vues sont dans la liste des pages CMS et lors de la modification d'une page (edition)  
- Charger le HTML existant dans l’éditeur au chargement.
- Envoyer le HTML final via un champ hidden au formulaire.

3. UX / interface utilisateur
- Ajouter une bibliothèque de blocs à gauche : hero, texte, image, deux colonnes, CTA, cards, galerie, statistiques, contact.
- Ajouter un panneau de réglages à droite pour les styles et les attributs.
- Ajouter un mode aperçu desktop/mobile.
- Ajouter undo/redo, sauvegarde et aperçu.

4. Sécurité
- Nettoyer le HTML côté frontend avec DOMPurify.
- Sanitiser côté backend avant insertion en base.

5. Rendu public
- Réutiliser le template existant qui affiche body.
- Vérifier que les pages CMS continuent à rendre le HTML correctement.

6. Étapes d’implémentation
- Modifier admin/content/create.php.
- Modifier admin/content/edit.php.
- Vérifier le rendu et la sauvegarde.
- Ajouter des blocs personnalisés adaptés au site VEP.
