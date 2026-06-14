<?php
// includes/settings_helpers.php — Helpers pour la table settings

function get_setting(PDO $pdo, string $key, string $default = ''): string {
    static $cache = [];
    if (!isset($cache[$key])) {
        $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $val = $stmt->fetchColumn();
        $cache[$key] = $val !== false ? $val : $default;
    }
    return $cache[$key];
}

function set_setting(PDO $pdo, string $key, string $value): bool {
    $stmt = $pdo->prepare(
        "INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)
         ON DUPLICATE KEY UPDATE setting_value = ?"
    );
    return $stmt->execute([$key, $value, $value]);
}
