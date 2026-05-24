# GUIDE D'INSTALLATION RAPIDE - VEP

## ⚡ Démarrage en 5 minutes

### 1. Configuration Requise ✓
- PHP 7.4+ (testé sur PHP 8.0+)
- MySQL/MariaDB 5.7+
- XAMPP/Apache avec mod_rewrite
- ~10 MB d'espace disque

### 2. Vérifier les paramètres de connexion

Ouvrez `includes/config.php` et vérifiez:
```php
define('BASE_URL', '/Hebergement/maokaa/');  // Adapter le chemin
define('DB_HOST', 'localhost');               // Hôte MySQL
define('DB_NAME', 'maokaa');                  // Nom de la BD
define('DB_USER', 'root');                    // Utilisateur MySQL
define('DB_PASS', '');                        // Mot de passe MySQL
```

### 3. Initialiser la Base de Données

**Option A: Avec setup.php**
1. Assurez-vous que MySQL est actif
2. Ouvrez dans votre navigateur:
   ```
   http://localhost/Hebergement/maokaa/setup.php
   ```
3. Attendez le message de succès
4. **Supprimez setup.php après l'exécution!**

**Option B: Manuellement**
1. Ouvrez phpMyAdmin
2. Créez une nouvelle base de données `maokaa`
3. Importez `db/shema.sql`

### 4. Vérifier l'installation

Accédez à:
```
http://localhost/Hebergement/maokaa/
```

Vous devriez voir la page d'accueil VEP.

### 5. Première Connexion Admin

Allez à: `http://localhost/Hebergement/maokaa/login.php`

**Identifiants par défaut:**
```
Username: admin
Password: admin123
```

✅ **Installation Terminée!**

---

## 📝 Procédures Courantes

### Ajouter un Produit
1. Connexion Admin → Dashboard
2. Section "Produits" → "Ajouter un produit"
3. Remplir le formulaire
4. Uploader l'image et la brochure PDF
5. Cliquer "Créer le Produit"

### Ajouter une Marque
1. Dashboard → Section "Marques" → "Ajouter une marque"
2. Nom, Logo (optionnel), Description
3. Cliquer "Créer"

### Modifier une Page Statique
1. Accédez à la page via l'URL publique
2. Les contenus viennent de la table `content` BD
3. Pour modifier: SQL direct ou via éditeur futur

### Gérer les Messages de Contact
1. Dashboard → Section "Messages"
2. Cliquer "Voir" pour lire un message
3. Cliquer "Supprimer" pour supprimer

---

## 🔐 Sécurité Importante

### ⚠️ Avant de Mettre en Production

1. **Changez le mot de passe admin:**
   - Connectez-vous
   - Allez à Profil (futur)
   - Changez le mot de passe

2. **Créez un nouvel utilisateur admin:**
   - Supprimez l'utilisateur "admin" par défaut
   - Créez votre propre compte

3. **Sécurisez les fichiers sensibles:**
   - Renommez ou supprimez `setup.php`
   - Protégez le fichier `.htaccess`

4. **Permissions des Dossiers:**
   ```bash
   chmod 755 assets/
   chmod 755 assets/images/
   chmod 755 assets/brochures/
   chmod 755 admin/
   ```

5. **Sauvegardez Régulièrement:**
   ```bash
   mysqldump -u root maokaa > backup_$(date +%Y%m%d).sql
   ```

---

## 🐛 Dépannage Rapide

### "Page blanche" au démarrage
✓ Vérifiez `includes/config.php`
✓ Vérifiez la connexion MySQL
✓ Vérifiez les logs PHP

### "Identifiants invalides" au login
✓ Vérifiez que la table `admins` a des données
✓ Testez la connexion MySQL directement
✓ Vérifiez que PHP sessions sont activées

### Images ne s'affichent pas
✓ Vérifiez les chemins dans `<img src="">`
✓ Vérifiez que `/assets/images/` existe
✓ Vérifiez les permissions (755)

### "CSRF token invalide"
✓ Assurez-vous que `session_start()` est appelé
✓ Vérifiez que les sessions sont activées
✓ Videz le cache du navigateur

---

## 📊 Structure BD Simple

### Tables Principales
- `admins` - Utilisateurs administrateurs
- `produits` - Catalogue de produits
- `categories` - Catégories de produits
- `marques` - Marques partenaires
- `partenaires` - Partenaires commerciaux
- `actualites` - Articles de blog/news
- `contacts` - Messages de contact
- `content` - Pages statiques CMS

---

## 🚀 Prochaines Étapes

1. **Personnalisez le Design:**
   - Modifiez `assets/css/style.css`
   - Changez les couleurs primaires

2. **Ajoutez Votre Contenu:**
   - Ajoutez les produits réels
   - Mettez à jour les marques
   - Créez des actualités

3. **Optimisez les Images:**
   - Compressez les images produits
   - Convertissez en WebP si possible
   - Utilisez un CDN (optionnel)

4. **Configurez le Email:**
   - Intégrez PHPMailer pour les contacts
   - Configurez les notifications

5. **Analysez le Trafic:**
   - Installez Google Analytics
   - Configurez la Search Console
   - Suivez les performances

---

## 📱 Vérification Multi-Appareil

Testez sur:
- **Desktop**: Chrome, Firefox, Edge
- **Tablette**: iPad, Android
- **Mobile**: iPhone, Android

Tous les layouts doivent être responsifs ✓

---

## 💡 Tips & Astuces

- Utilisez **Ctrl+Maj+K** pour les DevTools
- Les fichiers CSS/JS sont cachés 7 jours (voir `.htaccess`)
- Les images sont cachées 1 an
- Activez gzip dans `.htaccess` pour les performances

---

## 📞 Support

Pour les problèmes:
1. Vérifiez la console PHP/MySQL
2. Lisez les logs d'erreur
3. Consultez le README.md
4. Testez avec des outils comme cURL/Postman

---

**Bravo! Votre site VEP est maintenant en ligne! 🎉**

Dernière mise à jour: 23 Mai 2024
