<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ==========================================
// 1. PUBLIC ROUTES (Petugas / Perawat Form)
// ==========================================
$routes->get('/', 'HandoverController::index');
$routes->get('/serah-terima', 'HandoverController::index');
$routes->post('/serah-terima/save', 'HandoverController::save');
$routes->get('/serah-terima/success/(:num)', 'HandoverController::success/$1');

// ==========================================
// 2. API ENDPOINTS (Dynamic Fetch)
// ==========================================
$routes->get('/api/rooms/(:num)/rooms', 'Api\RoomController::getRoomNumbers/$1');
$routes->get('/api/rooms/(:num)/room-numbers', 'Api\RoomController::getRoomNumbers/$1'); // Alias fallback
$routes->get('/api/room-numbers/(:num)/inventories', 'Api\RoomInventoryController::getInventories/$1');

// ==========================================
// 3. ADMIN AUTHENTICATION
// ==========================================
$routes->get('/admin/login', 'Admin\AuthController::login');
$routes->post('/admin/login', 'Admin\AuthController::attemptLogin');
$routes->get('/admin/logout', 'Admin\AuthController::logout');

// ==========================================
// 4. ADMIN PROTECTED ROUTES (adminAuth Filter)
// ==========================================
$routes->group('admin', ['filter' => 'adminAuth'], static function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Admin\DashboardController::index');

    // Transactions / Handovers
    $routes->get('handovers', 'Admin\HandoverController::index');
    $routes->get('handovers/(:num)', 'Admin\HandoverController::show/$1');
    $routes->post('handovers/(:num)/review', 'Admin\HandoverController::review/$1');
    $routes->get('handovers/delete/(:num)', 'Admin\HandoverController::delete/$1');

    // Riwayat Kondisi Kamar
    $routes->get('room-numbers/(:num)/history', 'Admin\HandoverController::history/$1');

    // Laporan Masalah (Rusak, Kurang, Perlu Perbaikan)
    $routes->get('reports/issues', 'Admin\ReportController::issues');

    // Master Data Ruang
    $routes->get('rooms', 'Admin\RoomController::index');
    $routes->post('rooms/store', 'Admin\RoomController::store');
    $routes->post('rooms/update/(:num)', 'Admin\RoomController::update/$1');
    $routes->get('rooms/delete/(:num)', 'Admin\RoomController::delete/$1');

    // Master Data Kamar
    $routes->get('room-numbers', 'Admin\RoomNumberController::index');
    $routes->post('room-numbers/store', 'Admin\RoomNumberController::store');
    $routes->post('room-numbers/update/(:num)', 'Admin\RoomNumberController::update/$1');
    $routes->get('room-numbers/delete/(:num)', 'Admin\RoomNumberController::delete/$1');



    // Master Inventaris Item
    $routes->get('inventory-items', 'Admin\InventoryItemController::index');
    $routes->post('inventory-items/store', 'Admin\InventoryItemController::store');
    $routes->post('inventory-items/update/(:num)', 'Admin\InventoryItemController::update/$1');
    $routes->get('inventory-items/delete/(:num)', 'Admin\InventoryItemController::delete/$1');

    // Inventaris Standar per Kamar (Baseline Setup)
    $routes->get('room-inventories', 'Admin\RoomInventoryController::index');
    $routes->get('room-inventories/(:num)', 'Admin\RoomInventoryController::manage/$1');
    $routes->post('room-inventories/(:num)', 'Admin\RoomInventoryController::save/$1');

    // Protected Media Serving
    $routes->get('media/patient/(:num)', 'Admin\MediaController::patientPhoto/$1');
    $routes->get('media/room-photo/(:num)', 'Admin\MediaController::roomPhoto/$1');
    $routes->get('media/signature/(:num)/(:segment)', 'Admin\MediaController::signature/$1/$2');
});
