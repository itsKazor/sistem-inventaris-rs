<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'handover';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

// Nurse Routes
$route['serah-terima'] = 'handover/index';
$route['serah-terima/save'] = 'handover/save';
$route['serah-terima/success/(:num)'] = 'handover/success/$1';

// API Routes
$route['api/rooms/(:num)/room-numbers'] = 'api/get_room_numbers/$1';
$route['api/room-numbers/(:num)/inventories'] = 'api/get_room_inventories/$1';

// Admin Routes
$route['admin'] = 'admin/auth/login';
$route['admin/login'] = 'admin/auth/login';
$route['admin/logout'] = 'admin/auth/logout';
$route['admin/dashboard'] = 'admin/dashboard/index';

$route['admin/handovers'] = 'admin/handover/index';
$route['admin/handovers/(:num)'] = 'admin/handover/show/$1';
$route['admin/handovers/show/(:num)'] = 'admin/handover/show/$1';
$route['admin/handovers/review/(:num)'] = 'admin/handover/review/$1';
$route['admin/handovers/(:num)/review'] = 'admin/handover/review/$1';
$route['admin/handovers/delete/(:num)'] = 'admin/handover/delete/$1';

$route['admin/rooms'] = 'admin/room/index';
$route['admin/rooms/store'] = 'admin/room/store';
$route['admin/rooms/update/(:num)'] = 'admin/room/update/$1';
$route['admin/rooms/delete/(:num)'] = 'admin/room/delete/$1';

$route['admin/room-numbers'] = 'admin/room_number/index';
$route['admin/room-numbers/store'] = 'admin/room_number/store';
$route['admin/room-numbers/update/(:num)'] = 'admin/room_number/update/$1';
$route['admin/room-numbers/delete/(:num)'] = 'admin/room_number/delete/$1';

$route['admin/inventory-items'] = 'admin/inventory_item/index';
$route['admin/inventory-items/store'] = 'admin/inventory_item/store';
$route['admin/inventory-items/update/(:num)'] = 'admin/inventory_item/update/$1';
$route['admin/inventory-items/delete/(:num)'] = 'admin/inventory_item/delete/$1';

$route['admin/room-inventories'] = 'admin/room_inventory/index';
$route['admin/room-inventories/(:num)'] = 'admin/room_inventory/manage/$1';
$route['admin/room-inventories/save/(:num)'] = 'admin/room_inventory/save/$1';

$route['admin/reports/issues'] = 'admin/report/issues';

$route['admin/media/patient/(:num)'] = 'admin/media/patient_photo/$1';
$route['admin/media/signature/(:num)/(:any)'] = 'admin/media/signature/$1/$2';
