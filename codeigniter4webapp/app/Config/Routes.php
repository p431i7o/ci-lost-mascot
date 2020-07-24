<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Inicio');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Inicio::index');
$routes->get('/legal', 'Inicio::legal');

$routes->get('/Buscar','Buscador::buscar');
$routes->post('/Buscar','Buscador::buscar');

$routes->get('/registro', 'Usuario::form_registro');
$routes->post('/registrar_cuenta','Usuario::registrar_cuenta');
$routes->get('/registrar_cuenta','Usuario::form_registro');
$routes->get('/activacion_cuenta',"Usuario::activacion_cuenta");
$routes->get('/sesion','Usuario::form_sesion');
$routes->post('/sesion','Usuario::iniciar_sesion');
$routes->get('/cerrar_sesion','Usuario::cerrar_sesion');

$routes->get('/cuenta','Usuario::dashboard');

$routes->group('/api', ['namespace' => 'App\Controllers\API'], function($routes)
{
    // $routes->get('usuarios', 'Usuarios::index');
    // $routes->get('usuarios/list', 'Usuarios::index'); 

    $routes->group('usuarios',['namespace'=>'App\Controllers\API'],function($routes){
        $routes->get('/', 'Usuarios::index');
        $routes->get('list', 'Usuarios::index');        
    });
});


/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
