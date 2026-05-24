<?php
// admin/products/create.php
// Créer un nouveau produit

require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/upload.php';
require_once __DIR__ . '/../../app/models/Product.php';
require_once __DIR__ . '/../../app/models/Category.php';
require_once __DIR__ . '/../../app/models/Brand.php';

requirePasswordChange();

$productModel = new Product($pdo);
$categoryModel = new Category($pdo);
$brandModel = new Brand($pdo);

$categories = $categoryModel->getAll(false);
$brands = $brandModel->getAll(false);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Token de sécurité invalide';
    } else {
        $data = [
            'nom' => sanitize($_POST['nom'] ?? ''),
            'description' => sanitize($_POST['description'] ?? ''),
            'description_complete' => sanitize($_POST['description_complete'] ?? ''),
            'categorie_id' => (int)($_POST['categorie_id'] ?? 0),
            'marque_id' => !empty($_POST['marque_id']) ? (int)$_POST['marque_id'] : null,
            'caracteristiques_techniques' => sanitize($_POST['caracteristiques_techniques'] ?? '')
        ];
        
        // Validation
        if (empty($data['nom'])) {
            $error = 'Le nom du produit est requis';
        } elseif (empty($data['categorie_id'])) {
            $error = 'La catégorie est requise';
        } else {
            // Traiter l'image
            if (!empty($_FILES['image']['name'])) {
                $result = upload_image($_FILES['image'], __DIR__ . '/../../assets/images/', 'prod');
                if (isset($result['error'])) {
                    $error = $result['error'];
                } else {
                    $data['image'] = '/assets/images/' . $result['filename'];
                }
            }

            // Traiter la brochure PDF
            if (empty($error) && !empty($_FILES['brochure_pdf']['name'])) {
                $result = upload_pdf($_FILES['brochure_pdf'], __DIR__ . '/../../assets/brochures/', 'broch');
                if (isset($result['error'])) {
                    $error = $result['error'];
                } else {
                    $data['brochure_pdf'] = '/assets/brochures/' . $result['filename'];
                }
            }
            
            // Créer le produit
            if (empty($error)) {
                if ($productModel->create($data)) {
                    setFlash('success', 'Produit créé avec succès!');
                    logAudit('create_product', $data['nom']);
                    header('Location: ' . BASE_URL . 'admin/dashboard.php?section=products');
                    exit;
                } else {
                    $error = 'Erreur lors de la création du produit';
                }
            }
        }
    }
}

$csrfToken = generateCSRFToken();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit - VEP Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .form-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 30px;
        }
        .form-section-title {
            font-size: 18px;
            font-weight: 600;
            margin-top: 30px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
            color: #667eea;
        }
        .form-control, .form-select {
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px 40px;
            font-weight: 600;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5 mb-5">
        <div class="d-flex align-items-center mb-4">
            <a href="<?php echo BASE_URL; ?>admin/dashboard.php?section=products" class="btn btn-outline-secondary me-3">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <h3 class="mb-0">Ajouter un Produit</h3>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="form-card">
            <form method="POST" enctype="multipart/form-data" data-validate="true">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                
                <!-- Informations Générales -->
                <div class="form-section-title">Informations Générales</div>
                
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom du Produit *</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                    <small class="text-muted">Exemple: Balance Analytique BM500</small>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="categorie_id" class="form-label">Catégorie *</label>
                        <select class="form-select" id="categorie_id" name="categorie_id" required>
                            <option value="">-- Sélectionner une catégorie --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="marque_id" class="form-label">Marque</label>
                        <select class="form-select" id="marque_id" name="marque_id">
                            <option value="">-- Aucune marque --</option>
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?php echo $brand['id']; ?>">
                                    <?php echo htmlspecialchars($brand['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <!-- Description -->
                <div class="form-section-title">Description</div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description Courte</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description courte pour la liste des produits"></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="description_complete" class="form-label">Description Complète</label>
                    <textarea class="form-control" id="description_complete" name="description_complete" rows="5" placeholder="Description détaillée avec tous les détails"></textarea>
                </div>
                
                <!-- Caractéristiques -->
                <div class="form-section-title">Caractéristiques Techniques</div>
                
                <div class="mb-3">
                    <label for="caracteristiques_techniques" class="form-label">Spécifications</label>
                    <textarea class="form-control" id="caracteristiques_techniques" name="caracteristiques_techniques" rows="5" placeholder="Caractéristiques techniques du produit"></textarea>
                    <small class="text-muted">Vous pouvez utiliser du HTML pour la mise en forme</small>
                </div>
                
                <!-- Média -->
                <div class="form-section-title">Média</div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">Image Principale</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, WebP. Taille max: 2 MB</small>
                </div>
                
                <div class="mb-3">
                    <label for="brochure_pdf" class="form-label">Brochure PDF</label>
                    <input type="file" class="form-control" id="brochure_pdf" name="brochure_pdf" accept=".pdf">
                    <small class="text-muted">Format: PDF. Taille max: 5 MB</small>
                </div>
                
                <!-- Actions -->
                <div class="mt-5 d-flex gap-2">
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-save"></i> Créer le Produit
                    </button>
                    <a href="<?php echo BASE_URL; ?>admin/dashboard.php?section=products" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
</body>
</html>
