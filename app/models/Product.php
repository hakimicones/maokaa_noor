<?php
// app/models/Product.php

class Product {
    private $pdo;
    private $table = 'produits';
    private $imagesTable = 'produit_images';
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Obtenir tous les produits actifs
     */
    public function getAll($active = true, $limit = null, $offset = 0) {
        $sql = "SELECT p.*, c.name as categorie_name, m.name as marque_name 
                FROM {$this->table} p
                LEFT JOIN categories c ON p.categorie_id = c.id
                LEFT JOIN marques m ON p.marque_id = m.id";
        
        if ($active) {
            $sql .= " WHERE p.active = 1";
        }
        
        $sql .= " ORDER BY p.display_order ASC, p.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        }

        return $this->pdo->query($sql)->fetchAll();
    }

    /**
     * Obtenir les produits populaires/featured
     */
    public function getFeatured($limit = 6) {
        $sql = "SELECT p.*, c.name as categorie_name, m.name as marque_name 
                FROM {$this->table} p
                LEFT JOIN categories c ON p.categorie_id = c.id
                LEFT JOIN marques m ON p.marque_id = m.id
                WHERE p.active = 1 AND p.featured = 1
                ORDER BY p.display_order ASC, p.created_at DESC
                LIMIT " . (int)$limit;

        return $this->pdo->query($sql)->fetchAll();
    }
    
    /**
     * Obtenir un produit par ID
     */
    public function getById($id, $activeOnly = true) {
        $sql = "SELECT p.*, c.name as categorie_name, m.name as marque_name, m.id as marque_id
             FROM {$this->table} p
             LEFT JOIN categories c ON p.categorie_id = c.id
             LEFT JOIN marques m ON p.marque_id = m.id
             WHERE p.id = ?";
        if ($activeOnly) {
            $sql .= " AND p.active = 1";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Obtenir un produit par slug
     */
    public function getBySlug($slug) {
        $stmt = $this->pdo->prepare(
            "SELECT p.*, c.name as categorie_name, m.name as marque_name
             FROM {$this->table} p
             LEFT JOIN categories c ON p.categorie_id = c.id
             LEFT JOIN marques m ON p.marque_id = m.id
             WHERE p.slug = ? AND p.active = 1"
        );
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
    
    /**
     * Produits par catégorie
     */
    public function getByCategory($categoryId, $limit = null, $offset = 0) {
        $sql = "SELECT p.*, c.name as categorie_name, m.name as marque_name 
                FROM {$this->table} p
                LEFT JOIN categories c ON p.categorie_id = c.id
                LEFT JOIN marques m ON p.marque_id = m.id
                WHERE p.categorie_id = ? AND p.active = 1
                ORDER BY p.display_order ASC, p.nom ASC";
        
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Produits par lettre
     */
    public function getByLetter($letter) {
        $stmt = $this->pdo->prepare(
            "SELECT p.*, c.name as categorie_name, m.name as marque_name
             FROM {$this->table} p
             LEFT JOIN categories c ON p.categorie_id = c.id
             LEFT JOIN marques m ON p.marque_id = m.id
             WHERE p.lettre_alphabet = ? AND p.active = 1
             ORDER BY p.nom ASC"
        );
        $stmt->execute([strtoupper($letter)]);
        return $stmt->fetchAll();
    }
    
    /**
     * Rechercher les produits
     */
    public function search($query, $limit = 20) {
        $query = "%{$query}%";
        $sql = "SELECT p.*, c.name as categorie_name, m.name as marque_name
             FROM {$this->table} p
             LEFT JOIN categories c ON p.categorie_id = c.id
             LEFT JOIN marques m ON p.marque_id = m.id
             WHERE p.active = 1 AND (p.nom LIKE ? OR p.description LIKE ?)
             ORDER BY p.nom ASC
             LIMIT " . (int)$limit;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$query, $query]);
        return $stmt->fetchAll();
    }
    
    /**
     * Créer un produit
     */
    public function create($data) {
        $slug = $this->generateSlug($data['nom']);
        
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->table} 
             (nom, slug, description, description_complete, image, brochure_pdf, 
              categorie_id, marque_id, lettre_alphabet, caracteristiques_techniques, active)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        
        $letter = strtoupper(substr($data['nom'], 0, 1));
        
        return $stmt->execute([
            $data['nom'],
            $slug,
            $data['description'] ?? '',
            $data['description_complete'] ?? '',
            $data['image'] ?? null,
            $data['brochure_pdf'] ?? null,
            $data['categorie_id'],
            $data['marque_id'] ?? null,
            $letter,
            $data['caracteristiques_techniques'] ?? '',
            1
        ]);
    }
    
    /**
     * Mettre à jour un produit
     */
    public function update($id, $data) {
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            if (in_array($key, ['nom', 'description', 'description_complete', 'image', 'brochure_pdf', 
                               'categorie_id', 'marque_id', 'caracteristiques_techniques', 'active', 'featured', 'display_order'])) {
                $fields[] = "{$key} = ?";
                $values[] = $value;
            }
        }
        
        $values[] = $id;
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }
    
    /**
     * Supprimer un produit
     */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    /**
     * Ajouter une image à la galerie
     */
    public function addImage($productId, $imagePath, $altText = '') {
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->imagesTable} (produit_id, image, alt_text) VALUES (?, ?, ?)"
        );
        return $stmt->execute([$productId, $imagePath, $altText]);
    }
    
    /**
     * Obtenir les images d'un produit
     */
    public function getImages($productId) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->imagesTable} WHERE produit_id = ? ORDER BY display_order ASC"
        );
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Générer un slug
     */
    private function generateSlug($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = preg_replace('~-+~', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        
        // Vérifier l'unicité
        $count = 0;
        $originalSlug = $text;
        while ($this->slugExists($text)) {
            $count++;
            $text = $originalSlug . '-' . $count;
        }
        
        return $text;
    }
    
    /**
     * Vérifier si un slug existe
     */
    private function slugExists($slug) {
        $stmt = $this->pdo->prepare("SELECT id FROM {$this->table} WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->rowCount() > 0;
    }
    
    /**
     * Obtenir le nombre total de produits
     */
    public function count($active = true) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        if ($active) {
            $sql .= " WHERE active = 1";
        }
        $result = $this->pdo->query($sql)->fetch();
        return $result['total'] ?? 0;
    }
}
