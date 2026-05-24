<?php
// app/models/Content.php

class Content {
    private $pdo;
    private $table = 'content';
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Trouver une page par slug
     */
    public function findBySlug($slug) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE slug = ? AND status = 'published'");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    /**
     * Trouver une page par ID
     */
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Lister toutes les pages
     */
    public function listAll($onlyPublished = true) {
        $sql = "SELECT * FROM {$this->table}";
        if ($onlyPublished) {
            $sql .= " WHERE status = 'published'";
        }
        $sql .= " ORDER BY id ASC";
        return $this->pdo->query($sql)->fetchAll();
    }

    /**
     * Créer une page
     */
    public function create($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->table} (slug, title, subtitle, meta_title, meta_description, body, template, status, language) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        
        $stmt->execute([
            $data['slug'],
            $data['title'],
            $data['subtitle'] ?? '',
            $data['meta_title'] ?? '',
            $data['meta_description'] ?? '',
            $data['body'] ?? '',
            $data['template'] ?? 'default',
            $data['status'] ?? 'draft',
            $data['language'] ?? 'fr'
        ]);
        
        return $this->pdo->lastInsertId();
    }

    /**
     * Mettre à jour une page
     */
    public function update($id, $data) {
        $stmt = $this->pdo->prepare(
            "UPDATE {$this->table} SET slug = ?, title = ?, subtitle = ?, meta_title = ?, 
             meta_description = ?, body = ?, template = ?, status = ?, language = ? WHERE id = ?"
        );
        
        return $stmt->execute([
            $data['slug'],
            $data['title'],
            $data['subtitle'] ?? '',
            $data['meta_title'] ?? '',
            $data['meta_description'] ?? '',
            $data['body'] ?? '',
            $data['template'] ?? 'default',
            $data['status'] ?? 'draft',
            $data['language'] ?? 'fr',
            $id
        ]);
    }

    /**
     * Supprimer une page
     */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
