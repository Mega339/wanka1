<?php
// Configuración centralizada de rutas para SYMETRI STORE
return [
    // Rutas del sistema principal
    'main_system' => [
        'root' => '../',
        'core' => '../core/',
        'config' => '../config/',
        'storage' => '../storage/',
        'logs' => '../storage/logs/',
    ],
    
    // Rutas específicas de e-commerce
    'ecommerce' => [
        'root' => './',
        'app' => './core/app/',
        'models' => './core/app/model/',
        'actions' => './core/app/action/',
        'views' => './core/app/view/',
        'assets' => './assets/',
        'css' => './assets/css/',
        'js' => './assets/js/',
        'images' => './assets/images/',
    ],
    
    // URLs del sistema
    'urls' => [
        'main_system' => 'http://localhost/ecommerce2',
        'ecommerce' => 'http://localhost/ecommerce2/cpanel',
        'assets' => 'http://localhost/ecommerce2/cpanel/assets',
        
    ],
    
    // Configuración de archivos
    'files' => [
        'max_upload_size' => 5 * 1024 * 1024, // 5MB
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp', 'gif'],
        'upload_path' => './assets/images/products/',
    ],
];
?>
