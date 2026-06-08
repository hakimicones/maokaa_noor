<?php
// admin/products/edit.php
// Modifier un produit existant

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

$productId = (int)($_GET['id'] ?? 0);
$product = $productModel->getById($productId, false);

if (!$product) {
    http_response_code(404);
    echo '<h1>Produit introuvable</h1>';
    exit;
}

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
            'caracteristiques_techniques' => sanitize($_POST['caracteristiques_techniques'] ?? ''),
            'active' => isset($_POST['active']) ? 1 : 0,
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'display_order' => (int)($_POST['display_order'] ?? 0)
        ];

        if (empty($data['nom'])) {
            $error = 'Le nom du produit est requis';
        } elseif (empty($data['categorie_id'])) {
            $error = 'La catégorie est requise';
        } else {
            $data['image'] = $product['image'] ?? null;
            $data['brochure_pdf'] = $product['brochure_pdf'] ?? null;

            if (!empty($_FILES['image']['name'])) {
                $result = upload_image($_FILES['image'], __DIR__ . '/../../assets/images/', 'prod');
                if (isset($result['error'])) {
                    $error = $result['error'];
                } else {
                    $data['image'] = 'assets/images/' . $result['filename'];
                }
            }

            if (empty($error) && !empty($_FILES['brochure_pdf']['name'])) {
                $result = upload_pdf($_FILES['brochure_pdf'], __DIR__ . '/../../assets/brochures/', 'broch');
                if (isset($result['error'])) {
                    $error = $result['error'];
                } else {
                    $data['brochure_pdf'] = '/assets/brochures/' . $result['filename'];
                }
            }

            if (empty($error)) {
                if ($productModel->update($productId, $data)) {
                    setFlash('success', 'Produit mis à jour avec succès');
                    logAudit('update_product', $product['nom']);
                    header('Location: ' . BASE_URL . 'admin/dashboard.php?section=products');
                    exit;
                }

                $error = 'Erreur lors de la mise à jour du produit';
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
    <title>Modifier un Produit - VEP Admin</title>
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
            <h3 class="mb-0">Modifier un Produit</h3>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="form-card">
            <form method="POST" enctype="multipart/form-data" data-validate="true">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">

                <div class="form-section-title">Informations Générales</div>

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom du Produit *</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($product['nom']); ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="categorie_id" class="form-label">Catégorie *</label>
                        <select class="form-select" id="categorie_id" name="categorie_id" required>
                            <option value="">-- Sélectionner une catégorie --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>" <?php echo ((int)$category['id'] === (int)($product['categorie_id'] ?? 0)) ? 'selected' : ''; ?>>
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
                                <option value="<?php echo $brand['id']; ?>" <?php echo ((int)$brand['id'] === (int)($product['marque_id'] ?? 0)) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($brand['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="display_order" class="form-label">Ordre d'affichage</label>
                        <input type="number" class="form-control" id="display_order" name="display_order" value="<?php echo (int)($product['display_order'] ?? 0); ?>">
                    </div>
                    <div class="col-md-4 mb-3 form-check mt-4">
                        <input class="form-check-input" type="checkbox" id="active" name="active" <?php echo !empty($product['active']) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="active">Produit actif</label>
                    </div>
                    <div class="col-md-4 mb-3 form-check mt-4">
                        <input class="form-check-input" type="checkbox" id="featured" name="featured" <?php echo !empty($product['featured']) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="featured">Produit mis en avant</label>
                    </div>
                </div>

                <div class="form-section-title">Description</div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description Courte</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="description_complete" class="form-label">Description Complète</label>
                    <textarea class="form-control" id="description_complete" name="description_complete" rows="5"><?php echo htmlspecialchars($product['description_complete'] ?? ''); ?></textarea>
                </div>

                <div class="form-section-title">Caractéristiques Techniques</div>

                <div class="mb-3">
                    <label for="caracteristiques_techniques" class="form-label">Spécifications</label>
                    <textarea class="form-control" id="caracteristiques_techniques" name="caracteristiques_techniques" rows="5"><?php echo htmlspecialchars($product['caracteristiques_techniques'] ?? ''); ?></textarea>
                </div>

                <div class="form-section-title">Média</div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image Principale</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/png,image/jpeg,image/webp">
                    <?php if (!empty($product['image'])): ?>
                        <div class="mt-2">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Image actuelle" style="max-width: 180px; border-radius: 8px;">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="brochure_pdf" class="form-label">Brochure PDF</label>
                    <input type="file" class="form-control" id="brochure_pdf" name="brochure_pdf" accept="application/pdf">
                    <?php if (!empty($product['brochure_pdf'])): ?>
                        <div class="mt-2">
                            <a href="<?php echo htmlspecialchars($product['brochure_pdf']); ?>" target="_blank">Voir la brochure actuelle</a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-submit">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
