<?php
// Configuración de la base de datos para SYMETRI STORE
// Usa la misma configuración del sistema principal
$mainConfig = include '../config/database.php';

// Configuración específica para e-commerce
$ecommerceConfig = [
    'dbname' => 'symetri_store', // Base de datos específica para e-commerce
    'prefix' => 'store_', // Prefijo para tablas de e-commerce
];

// Combinar configuraciones
return array_merge($mainConfig, $ecommerceConfig);
?>
