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
$routes->setDefaultController('Home');
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
$routes->get('/', 'Home::index');

$routes->get('cisco/oauth', 'CiscoController::oauth');
$routes->get('cisco/get-supported-device-types', 'CiscoController::getSupportedDeviceTypes');
$routes->get('cisco/smartAccountsSearch', 'CiscoController::smartAccountsSearch');
$routes->get('cisco/helloWord', 'CiscoController::helloWord');
$routes->get('cisco/smartRecommendationForPartners', 'CiscoController::smartRecommendationForPartners');
$routes->get('cisco/listVirtualAccounts', 'CiscoController::listVirtualAccounts');
$routes->get('cisco/getLicenseSummaryByTag', 'CiscoController::getLicenseSummaryByTag');

$routes->get('cisco/contractsSearch', 'CiscoController::contractsSearch');
$routes->get('cisco/licenseSubscriptionsUsage', 'CiscoController::licenseSubscriptionsUsage');




$routes->get('autodesk/oauth', 'AutodeskController::oauth');






$routes->get('interworks/oauth', 'InterworksController::oauth');
$routes->post('interworks/oauth', 'InterworksController::oauth');
$routes->get('interworks/token', 'InterworksController::token');
$routes->post('interworks/token', 'InterworksController::token');


$routes->get('customer/post', 'InterworksController::customerPost');
$routes->post('customer/post', 'InterworksController::customerPost');
$routes->put('customer/post', 'InterworksController::customerPost');


$routes->add('interworks/getSettingFieldsUrl', 'InterworksController::getSettingFieldsUrl');
$routes->add('interworks/validateSettingFieldsURL', 'InterworksController::validateSettingFieldsURL');
$routes->add('interworks/getServiceDefinitionsURL', 'InterworksController::getServiceDefinitionsURL');

$routes->add('interworks/accountGetSyncOptions', 'InterworksController::accountGetSyncOptions');
$routes->add('interworks/accountSynchronizeURL', 'InterworksController::accountSynchronizeURL');
$routes->add('interworks/accountDeleteURL', 'InterworksController::accountDeleteURL');
$routes->add('interworks/accountExistsURL', 'InterworksController::accountExistsURL');

$routes->get('interworks/subscriptionCreateURL', 'InterworksController::subscriptionCreateURL');
$routes->get('interworks/subscriptionUpdateURL', 'InterworksController::subscriptionUpdateURL');
$routes->get('interworks/validateSettingFieldsURL', 'InterworksController::validateSettingFieldsURL');
$routes->get('interworks/validateSettingFieldsURL', 'InterworksController::validateSettingFieldsURL');







/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
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
