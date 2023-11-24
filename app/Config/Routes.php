<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//Users
$routes->get('/', 'Home::index');
$routes->get('/loadProducts', 'Home::products');
$routes->get('/users', 'Users::index');

$routes->group('api', ['filter' => 'cors'], function ($routes) {
    // Your API routes go here...
    $routes->get('/products', 'Products::index');

});
//Products
$routes->get('/products', 'Products::index');
$routes->post('/products/add', 'Products::create');
$routes->get('/products/show/(:segment)', 'Products::show/$1');
$routes->post('/products/edit/(:segment)', 'Products::update/$1');
$routes->delete('/products/delete/(:segment)', 'Products::delete/$1');


// Item Types 
$routes->get('/itemtypes', 'ItemsTypes::index');
$routes->post('/itemtype/add', 'ItemsTypes::create');
$routes->get('/itemtypes/show/(:segment)', 'ItemsTypes::show/$1');
$routes->post('/itemtypes/edit/(:segment)', 'ItemsTypes::update/$1');
$routes->delete('/itemtypes/delete/(:segment)', 'ItemsTypes::delete/$1');

// Sales
$routes->get('/sales', 'Sales::index');
$routes->post('/sales/add', 'Sales::create');
$routes->get('/sales/show/(:segment)', 'Sales::show/$1');
$routes->post('/sales/edit/(:segment)', 'Sales::update/$1');
$routes->delete('/sales/delete/(:segment)', 'Sales::delete/$1');

//Prices
$routes->get('/prices', 'Prices::index');
$routes->post('/prices/add', 'Prices::create');
$routes->get('/prices/show/(:segment)', 'Prices::show/$1');
$routes->post('/prices/edit/(:segment)', 'Prices::update/$1');
$routes->delete('/prices/delete/(:segment)', 'Prices::delete/$1');

