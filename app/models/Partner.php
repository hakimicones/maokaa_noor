<?php
// app/models/Partner.php

class Partner {
    private $pdo;
    private $table = 'partenaires';
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAll($active = true) {
        $sql = "SELECT * FROM {$this->table}";
        if ($active) {
            $sql .= " WHERE active = 1";
        }
        $sql .= " ORDER BY display_order ASC, name ASC";
        
        return $this->pdo->query($sql)->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->table} (name, logo, description, website, active) 
             VALUES (?, ?, ?, ?, ?)"
        );
        
        return $stmt->execute([
            $data['name'],
            $data['logo'] ?? null,
            $data['description'] ?? '',
            $data['website'] ?? '',
            1
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->pdo->prepare(
            "UPDATE {$this->table} SET name = ?, logo = ?, description = ?, website = ?, 
             display_order = ?, active = ? WHERE id = ?"
        );
        
        return $stmt->execute([
            $data['name'],
            $data['logo'] ?? null,
            $data['description'] ?? '',
            $data['website'] ?? '',
            $data['display_order'] ?? 0,
            $data['active'] ?? 1,
            $id
        ]);
    }
    
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
}
