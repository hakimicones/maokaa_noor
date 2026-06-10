# Rapport — Assistant IA de contenu (CMS Maokaa)

> Rédigé le 10 juin 2026

## 1. Objectif

Permettre à l'administrateur de régénérer/réécrire du contenu HTML à partir d'une
instruction en langage naturel, à trois niveaux :

1. **Page complète** (éditeur visuel GrapesJS).
2. **Corps de page complet** (édition inline frontend).
3. **Un champ ou un élément isolé** (paragraphe, titre, ou champ produit) via la
   barre d'outils WYSIWYG flottante.

Le tout en s'appuyant sur une **API compatible OpenAI (Chat Completions)**, donc
utilisable avec OpenAI, Mistral, DeepSeek, Groq, OpenRouter ou Ollama, simplement
en changeant la configuration `.env` — sans dépendance figée à un fournisseur.

---

## 2. Configuration (`.env`)

```
AI_API_URL=https://api.deepseek.com/v1
AI_API_KEY=sk-...
AI_MODEL=deepseek-chat
# AI_MAX_TOKENS=4096   (optionnel, défaut 4096)
```

- Actuellement configuré avec **DeepSeek** (`deepseek-chat`).
- Le fichier `.env` contient en commentaire des exemples prêts à l'emploi pour
  OpenAI, Mistral, Groq, OpenRouter (y compris modèles Claude via OpenRouter) et
  Ollama (local, sans clé). Changer de fournisseur = décommenter le bloc voulu,
  aucune modification de code requise.
- Si une des 3 variables (`AI_API_URL`, `AI_API_KEY`, `AI_MODEL`) est absente,
  l'assistant répond proprement : *"Service IA non configuré..."*.

---

## 3. Backend commun

### `includes/ai_client.php`

Fonction unique : `ai_generate_html(string $currentHtml, string $instruction): array`

- Construit un prompt système qui :
  - cadre le rôle (assistant d'édition pour un site Bootstrap 5 — VEP, Algérie) ;
  - exige une réponse = **uniquement** un fragment HTML (pas de balises
    `<html>/<head>/<body>`, pas de bloc ```` ```html ````, pas d'explication) ;
  - demande de **conserver tels quels** les shortcodes `[carousel ...]`,
    `[products ...]`, `[featured_products ...]`, `[brands]`, `[partners]`,
    `[contact_form]`, `[news ...]` (blocs dynamiques générés depuis la BDD) ;
  - impose l'usage de classes Bootstrap 5.
- Appelle `POST {AI_API_URL}/chat/completions` via cURL (timeout 60 s).
- Nettoie un éventuel fencing markdown ```` ```html ... ``` ````.
- Retourne `['success' => true, 'html' => ...]` ou `['success' => false, 'error' => ...]`.

### `includes/api_ai_content.php`

Endpoint AJAX `POST` appelé par les 3 interfaces front (GrapesJS + 2 modales inline).
Reçoit `{ csrf_token, html, instruction }`.

Étapes :
1. `isLoggedIn()` → 403 sinon.
2. Méthode `POST` → 405 sinon.
3. `verifyCSRFToken()` → 403 sinon.
4. Validation : `instruction` non vide et ≤ 2000 caractères ; `html` ≤ 60 000 caractères.
5. `ai_generate_html($html, $instruction)` → 502 si échec (avec message du fournisseur).
6. **`sanitize_body_html()`** sur le HTML retourné (anti-XSS, même pipeline que
   l'éditeur visuel et l'édition inline).
7. `logAudit('ai_content', 'Instruction IA : ' . substr($instruction, 0, 200))`.
8. Réponse : `{ success: true, html: <html nettoyé> }`.

---

## 4. Éditeur visuel GrapesJS (admin)

**Fichiers** : `admin/content/body-editor.php`, `admin/content/body-editor.js`

- `body-editor.php` expose `aiUrl` et `csrfToken` dans `window.__contentEditorConfig`.
- Bouton "Assistant IA" (icône baguette magique) ajouté au panel d'options GrapesJS,
  relié à la commande `ai-rewrite`.
- Au clic : modale `#ai-modal-overlay` (textarea instruction + bouton "Générer").
- Génération :
  - HTML envoyé = `blocksToShortcodes(editor.getHtml())` (état actuel du canvas) ;
  - réponse appliquée via `editor.setComponents(shortcodesToBlocks(data.html))` puis
    `syncBody()` → **le canvas sert de prévisualisation immédiate**.
- La sauvegarde réelle se fait ensuite via le bouton **"Enregistrer"** déjà existant
  (pipeline inchangé : `Content::update()`).

---

## 5. Édition inline frontend — assistant global (corps de page)

**Fichiers** : `assets/js/inline-edit.js`, `assets/css/inline-edit.css`

- Bouton **"Assistant IA"** (`#ie-ai-btn`) ajouté dans la barre `#ie-toolbar` (visible
  uniquement si la page a un champ `body`), via `initAiButton(bodyEl)`.
- `getCleanBodyHtml(bodyEl)` : clone le `body`, retire les éléments d'UI d'édition
  (`.ie-vep-btn`, `.ie-img-overlay`, classes `ie-*`, attributs `contenteditable`),
  et restaure les shortcodes (`[products ...]`, etc.) à partir de
  `.vep-block-wrapper[data-vep-shortcode]`.
- `openAiModal({ getHtml, onApply })` : modale générique `#ie-ai-modal`
  (textarea instruction → "Générer" → **aperçu HTML dans la modale**, lecture
  seule, rendu avec le CSS global du site → "Appliquer et enregistrer" / "Annuler").
- Pour l'assistant global : `onApply` appelle `saveField('body', html)` →
  `includes/inline_edit.php` → `sanitize_body_html()` → `UPDATE content SET body`,
  puis **rechargement de la page** (pour ré-exécuter `do_shortcode()` côté serveur
  et ré-afficher correctement les blocs dynamiques).

---

## 6. Assistant IA par champ — barre WYSIWYG flottante (NOUVEAU)

**Fichiers** : `assets/js/inline-edit.js`, `assets/css/inline-edit.css`

La barre flottante `#ie-wysiwyg-toolbar` (qui apparaît au focus d'un champ texte)
possède désormais un bouton **"IA"** (`data-cmd="ai-rewrite"`, icône baguette en
violet clair), séparé des boutons de mise en forme (gras/italique/H2/H3/lien...).

- **Disponible sur** :
  - chaque paragraphe / titre du corps de page (`initInlineText` → édition
    granulaire du body) ;
  - chaque champ produit éditable de la page détail produit (`initProductField`) :
    `nom`, `description`, `description_complete`, `caracteristiques_techniques`.
- `openFieldAiModal(target)` : réutilise la **même modale/endpoint** que
  l'assistant global, mais `getHtml = target.innerHTML` → l'IA ne reçoit/renvoie
  que le **fragment ciblé**.
- `unwrapIfSameTag(html, tagName)` : si l'IA renvoie un unique élément racine du
  même tag que le champ édité (ex. `<h2>...</h2>` pour un titre H2), seul son
  contenu est conservé — évite l'imbrication `<h2><h2>...</h2></h2>`.
- **Application** : `target.innerHTML = résultat`, feedback visuel (`pulse` +
  toast), puis sauvegarde **directe et sans rechargement de page** :
  - `saveProductField(productId, field, value)` → `includes/inline_edit_product.php`
    pour les champs produit ;
  - `serializeAndSaveBody(bodyEl)` → `includes/inline_edit.php` pour les
    paragraphes/titres du body.

---

## 7. Champs produit toujours éditables, même vides (NOUVEAU)

**Fichier** : `themes/default/templates/products.php`, `assets/css/inline-edit.css`

Avant cette modification, les blocs `description`, `description_complete` et
`caracteristiques_techniques` n'étaient générés dans le HTML que si la valeur en
base était non vide (`!empty(...)`). Si un produit n'avait pas encore de
description, l'admin n'avait **aucun élément cliquable** pour en ajouter une via
l'édition inline.

Modifications :
- Pour l'admin (`$isAdmin`), ces 3 blocs sont désormais **toujours rendus**, avec
  leurs attributs `data-inline-field` / `data-product-id`, même si la valeur DB
  est `NULL`/vide. Côté visiteur, le comportement est inchangé (blocs masqués si
  vides).
- Un attribut `data-ie-placeholder="..."` (ex. *"Ajouter une description
  détaillée..."*) est ajouté sur chaque champ, combiné à la règle CSS :
  ```css
  [data-inline-field][data-product-id].ie-field:empty::before {
      content: attr(data-ie-placeholder);
      color: #94a3b8;
      font-style: italic;
  }
  ```
  → un texte indicatif gris/italique s'affiche tant que le champ est vide, et
  disparaît dès que l'admin saisit du texte (placeholder type "champ de
  formulaire").
- Le titre `nom` (h1) était déjà toujours rendu ; un `data-ie-placeholder` lui a
  été ajouté par cohérence.

Ces champs, une fois remplis (manuellement ou via l'assistant IA par champ —
section 6), sont sauvegardés normalement via `saveProductField()`.

---

## 8. Sécurité

- **Accès admin uniquement** (`isLoggedIn()`) sur `api_ai_content.php`,
  `inline_edit.php` et `inline_edit_product.php`.
- **CSRF** vérifié sur chaque appel (`verifyCSRFToken()`).
- **`sanitize_body_html()`** appliqué systématiquement sur le HTML retourné par
  l'IA avant affichage/sauvegarde — défense en profondeur même si le modèle
  renvoie un `<script>` ou un attribut `onerror=`.
- **Limites anti-coût/anti-abus** : instruction ≤ 2000 caractères, HTML envoyé
  ≤ 60 000 caractères, `AI_MAX_TOKENS` configurable (défaut 4096), timeout cURL 60 s.
- **Clé API** uniquement côté serveur (`.env`, gitignored), jamais exposée au client.
- **Traçabilité** : chaque génération réussie crée une entrée `ai_content` dans
  `audit_logs` (instruction tronquée à 200 caractères) ; chaque sauvegarde de
  champ crée en plus une entrée `inline_edit` / `inline_edit_product`.

---

## 9. Comment tester

1. **Configuration** : vérifier que `.env` contient `AI_API_URL`, `AI_API_KEY`,
   `AI_MODEL` valides (DeepSeek configuré ; vérifier le solde du compte si erreur
   *"Insufficient Balance"*).
2. **GrapesJS** : `admin/content/body-editor.php?id=<id_page>` → bouton "Assistant
   IA" du panel → instruction → vérifier la mise à jour du canvas (shortcodes
   intacts) → "Enregistrer" → vérifier `content.body` en base.
3. **Assistant global (inline)** : connecté admin, ouvrir une page publique →
   bouton "Assistant IA" de `#ie-toolbar` → instruction → aperçu dans la modale →
   "Appliquer et enregistrer" → page rechargée, blocs dynamiques (`[carousel]`,
   `[products]`, etc.) toujours fonctionnels.
4. **Assistant par champ** : sur la page détail d'un produit (admin), cliquer dans
   un champ (ex. "Description détaillée" ou "Caractéristiques techniques", même
   vide → placeholder visible) → barre flottante → bouton "IA" → instruction →
   "Appliquer et enregistrer" → le champ se met à jour **sans rechargement**
   (pulse vert + toast). Même flux sur un paragraphe/titre d'une page classique.
5. **Cas d'erreur** : `.env` mal configuré → message clair ; instruction vide →
   refus côté modale ; clé API invalide/quota épuisé → message d'erreur du
   fournisseur affiché dans la modale (ex. *"Insufficient Balance"*).
6. **Audit** : vérifier dans `audit_logs` la présence des entrées `ai_content`,
   `inline_edit` et `inline_edit_product` après chaque test.

---

## 10. Hors périmètre (volontairement non traité)

- Pas de réécriture/adaptation d'une **sélection de texte** au sein d'un champ.
- Pas de génération de texte libre inséré séparément (hors champ existant).
- Pas de tableau de bord d'usage/coût IA, pas de rate-limiting dédié au-delà des
  limites de taille (section 8).
- Pas d'abstraction multi-fournisseurs au-delà du format Chat Completions
  compatible OpenAI (couvre déjà OpenAI, Mistral, DeepSeek, Groq, OpenRouter,
  Ollama).

---

## 11. Récapitulatif des fichiers

**Nouveaux** :
- `includes/ai_client.php`
- `includes/api_ai_content.php`

**Modifiés** :
- `.env` (variables `AI_*`, configuré pour DeepSeek)
- `admin/content/body-editor.php` / `admin/content/body-editor.js`
- `assets/js/inline-edit.js`
- `assets/css/inline-edit.css`
- `themes/default/templates/products.php`
- `PROJECT_MAP.md` (TECH_STACK + section SYSTEM_FLOW "Assistant IA")
