<?php
// app/models/Slider.php

class Slider
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Retourne les slides actives d'un slider_id, triées par sort_order.
     */
    public function getBySlider(int $slider_id): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM sliders WHERE slider_id = :sid AND active = 1 ORDER BY sort_order ASC'
        );
        $stmt->execute([':sid' => $slider_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne toutes les slides d'un slider_id (actives + inactives), triées par sort_order.
     */
    public function getAllBySlider(int $slider_id): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM sliders WHERE slider_id = :sid ORDER BY sort_order ASC'
        );
        $stmt->execute([':sid' => $slider_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne tous les groupes distincts (slider_id) avec COUNT et label du premier slide.
     */
    public function getAllGroups(): array
    {
        $stmt = $this->pdo->query(
            'SELECT s.slider_id,
                    COUNT(s.id) AS slide_count,
                    (SELECT label FROM sliders WHERE slider_id = s.slider_id ORDER BY sort_order ASC LIMIT 1) AS first_label
             FROM sliders s
             GROUP BY s.slider_id
             ORDER BY s.slider_id ASC'
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne un slide par son id.
     */
    public function getById(int $id): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM sliders WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne le prochain slider_id disponible (MAX + 1).
     */
    public function getNextSliderId(): int
    {
        $stmt = $this->pdo->query('SELECT COALESCE(MAX(slider_id), 0) + 1 AS next_id FROM sliders');
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($row['next_id'] ?? 1);
    }

    /**
     * Crée un nouveau slide.
     */
    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO sliders (slider_id, label, subtitle, bg, image, text_position, sort_order, active)
             VALUES (:slider_id, :label, :subtitle, :bg, :image, :text_position, :sort_order, :active)'
        );
        return $stmt->execute([
            ':slider_id'     => (int)($data['slider_id']  ?? 1),
            ':label'         => $data['label']      ?? '',
            ':subtitle'      => $data['subtitle']   ?? null,
            ':bg'            => $data['bg']         ?? '#dde4ee',
            ':image'         => $data['image']      ?? null,
            ':text_position' => $data['text_position'] ?? 'center',
            ':sort_order'    => (int)($data['sort_order'] ?? 0),
            ':active'        => isset($data['active']) ? (int)$data['active'] : 1,
        ]);
    }

    /**
     * Met à jour un slide existant.
     */
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE sliders
             SET slider_id = :slider_id, label = :label, subtitle = :subtitle,
                 bg = :bg, image = :image, text_position = :text_position,
                 sort_order = :sort_order, active = :active
             WHERE id = :id'
        );
        return $stmt->execute([
            ':id'            => $id,
            ':slider_id'     => (int)($data['slider_id']  ?? 1),
            ':label'         => $data['label']      ?? '',
            ':subtitle'      => $data['subtitle']   ?? null,
            ':bg'            => $data['bg']         ?? '#dde4ee',
            ':image'         => $data['image']      ?? null,
            ':text_position' => $data['text_position'] ?? 'center',
            ':sort_order'    => (int)($data['sort_order'] ?? 0),
            ':active'        => isset($data['active']) ? (int)$data['active'] : 1,
        ]);
    }

    /**
     * Supprime un slide par son id.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM sliders WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Supprime tous les slides d'un slider_id.
     */
    public function deleteSlider(int $slider_id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM sliders WHERE slider_id = :sid');
        return $stmt->execute([':sid' => $slider_id]);
    }
}
