<?php
// Configuración de seguridad 
// Extiende la configuración del sistema principal

$mainSecurityConfig = include '../config/security.php';

// Configuración específica para e-commerce
$ecommerceSecurityConfig = [
    'ecommerce' => [
        'session_timeout' => 3600, // 1 hora para e-commerce
        'max_cart_items' => 50,
        'max_order_value' => 10000.00,
        'payment_timeout' => 1800, // 30 minutos para completar pago
    ],
    
    'file_uploads' => [
        'products' => [
            'max_size' => 5 * 1024 * 1024, // 5MB
            'allowed_types' => ['jpg', 'jpeg', 'png', 'webp'],
            'scan_virus' => true,
        ],
    ],
    
    'api' => [
        'rate_limit' => 100, // 100 requests por minuto
        'cors_enabled' => true,
        'allowed_origins' => [
            'http://localhost:3000',
            'http://localhost:8080',
        ],
    ],
];

// Combinar configuraciones
return array_merge($mainSecurityConfig, $ecommerceSecurityConfig);
?>
