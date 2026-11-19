<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ======================================
// CONFIGURACIÓN GENERAL
// ======================================

// Desactivar rutas automáticas
$routes->setAutoRoute(false);


// ======================================
// INICIO Y CIERRE DE SESIÓN
// ======================================

// Página principal
$routes->get('/', 'Login::index');

// Mostrar formulario de inicio de sesión
$routes->get('login', 'Login::index');

// Validar usuario y contraseña
$routes->post('login/autenticar', 'Login::autenticar');

// Cerrar sesión
$routes->post('login/salir', 'Login::salir');


// ======================================
// RUTAS PROTEGIDAS
// ======================================

// Solo se permite el acceso a usuarios
// que hayan iniciado sesión correctamente.

$routes->group('', ['filter' => 'auth'], static function ($routes) {

    // ==================================
    // PANEL PRINCIPAL
    // ==================================

    // Mostrar menú principal
    $routes->get('panel', 'Panel::index');


    // ==================================
    // MÓDULO DE USUARIOS
    // ==================================

    $routes->group('usuarios', ['filter' => 'admin'], static function ($routes) {
        $routes->get('', 'Usuarios::index');
        $routes->post('guardar', 'Usuarios::guardar');
        $routes->get('editar/(:num)', 'Usuarios::editar/$1');
        $routes->post('actualizar/(:num)', 'Usuarios::actualizar/$1');
        $routes->post('eliminar/(:num)', 'Usuarios::eliminar/$1');
    });


    // ==================================
    // MÓDULO DE IMÁGENES
    // ==================================

    // Mostrar galería de imágenes
    $routes->get('imagenes', 'Imagenes::index');
    $routes->get('imagenes/ver/(:num)', 'Imagenes::ver/$1');

    // Subir nueva imagen
    $routes->post('imagenes/subir', 'Imagenes::subir');

    // Cambiar categoría de imagen
    $routes->post('imagenes/organizar', 'Imagenes::organizar');

    // Eliminar imagen
    $routes->post('imagenes/eliminar', 'Imagenes::eliminar');


    // ==================================
    // MÓDULO DE DOCUMENTOS
    // ==================================

    // Mostrar panel de documentos
    $routes->get('documentos', 'Documentos::index');

    // Generar documento Word
    $routes->get('documentos/word', 'Documentos::word');

    // Generar archivo Excel
    $routes->get('documentos/excel', 'Documentos::excel');

    // Generar documento PDF
    $routes->get('documentos/pdf', 'Documentos::pdf');

    // Generar imagen PNG
    $routes->get('documentos/png', 'Documentos::png');

});
