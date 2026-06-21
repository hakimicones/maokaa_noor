<?php
function generateCaptchaCode(int $length = 5): string
{
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $code;
}

function generateCaptchaSVG(string $code): string
{
    $width = 160;
    $height = 60;
    $charCount = strlen($code);
    $charWidth = $width / $charCount;

    $lines = [];
    $lines[] = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $width . '" height="' . $height . '" viewBox="0 0 ' . $width . ' ' . $height . '">';
    $lines[] = '<rect width="100%" height="100%" fill="#f0f4f8" rx="6"/>';

    // Lignes de fond aléatoires
    for ($i = 0; $i < 4; $i++) {
        $x1 = random_int(0, $width);
        $y1 = random_int(0, $height);
        $x2 = random_int(0, $width);
        $y2 = random_int(0, $height);
        $color = sprintf('#%06x', random_int(0, 0xCCCCCC));
        $lines[] = '<line x1="' . $x1 . '" y1="' . $y1 . '" x2="' . $x2 . '" y2="' . $y2 . '" stroke="' . $color . '" stroke-width="1.5" stroke-opacity="0.5"/>';
    }

    // Cercles de fond aléatoires
    for ($i = 0; $i < 8; $i++) {
        $cx = random_int(0, $width);
        $cy = random_int(0, $height);
        $r = random_int(4, 12);
        $color = sprintf('#%06x', random_int(0, 0xDDDDDD));
        $lines[] = '<circle cx="' . $cx . '" cy="' . $cy . '" r="' . $r . '" fill="' . $color . '" fill-opacity="0.3"/>';
    }

    // Caractères avec déformations aléatoires
    for ($i = 0; $i < $charCount; $i++) {
        $char = $code[$i];
        $x = 8 + $i * $charWidth + random_int(-5, 5);
        $y = random_int(38, 48);
        $rotate = random_int(-20, 20);
        $size = random_int(24, 32);
        $color = sprintf('#%06x', random_int(0x222222, 0x888888));
        $lines[] = '<text x="' . $x . '" y="' . $y . '" font-size="' . $size . '" font-family="Arial, sans-serif" font-weight="bold" fill="' . $color . '" transform="rotate(' . $rotate . ', ' . $x . ', ' . $y . ')" fill-opacity="0.9">' . htmlspecialchars($char) . '</text>';
    }

    $lines[] = '</svg>';
    return implode("\n", $lines);
}

function initCaptcha(): array
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $code = generateCaptchaCode();
    $token = bin2hex(random_bytes(16));
    $_SESSION['captcha_' . $token] = $code;
    $svg = generateCaptchaSVG($code);
    return ['token' => $token, 'svg' => $svg];
}

function verifyCaptcha(string $token, string $userInput): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $key = 'captcha_' . $token;
    if (!isset($_SESSION[$key])) {
        return false;
    }
    $expected = $_SESSION[$key];
    unset($_SESSION[$key]);
    return strtoupper(trim($userInput)) === $expected;
}
