<?php
// app/models/Category.php

class Category {
    private $pdo;
    private $table = 'categories';
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Obtenir toutes les catégories
     */
    public function getAll($active = true) {
        $sql = "SELECT * FROM {$this->table}";
        if ($active) {
            $sql .= " WHERE active = 1";
        }
        $sql .= " ORDER BY display_order ASC, name ASC";
        
        return $this->pdo->query($sql)->fetchAll();
    }
    
    /**
     * Obtenir une catégorie par ID
     */
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Obtenir une catégorie par slug
     */
    public function getBySlug($slug) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE slug = ? AND active = 1");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
    
    /**
     * Créer une catégorie
     */
    public function create($data) {
        $slug = $this->generateSlug($data['name']);
        
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->table} (name, slug, description, display_order, active) VALUES (?, ?, ?, ?, ?)"
        );
        
        return $stmt->execute([
            $data['name'],
            $slug,
            $data['description'] ?? '',
            (int)($data['display_order'] ?? 0),
            $data['active'] ?? 1
        ]);
    }
    
    /**
     * Mettre à jour une catégorie
     */
    public function update($id, $data) {
        $stmt = $this->pdo->prepare(
            "UPDATE {$this->table} SET name = ?, description = ?, display_order = ?, active = ? WHERE id = ?"
        );
        
        return $stmt->execute([
            $data['name'],
            $data['description'] ?? '',
            (int)($data['display_order'] ?? 0),
            $data['active'] ?? 1,
            $id
        ]);
    }

    /**
     * Supprimer une catégorie
     */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function count($active = true) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        if ($active) {
            $sql .= " WHERE active = 1";
        }
        $result = $this->pdo->query($sql)->fetch();
        return $result['total'] ?? 0;
    }
    
    /**
     * Obtenir le nombre de produits par catégorie
     */
    public function getProductCount($categoryId) {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) as count FROM produits WHERE categorie_id = ? AND active = 1"
        );
        $stmt->execute([$categoryId]);
        $result = $stmt->fetch();
        return $result['count'] ?? 0;
    }
    
    private function generateSlug($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = preg_replace('~-+~', '-', $text);
        $text = trim($text, '-');
        return strtolower($text);
    }
}
