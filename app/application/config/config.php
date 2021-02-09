<?php
// documentation
// http://kb.interworks.cloud/display/ICPD/interworks.cloud+Billing+API
// http://kb.interworks.cloud/pages/viewpage.action?pageId=47874831



    

/*
////////////////////////////////////////////
/////                                  /////
/////                                  /////
/////       Содание доступа к API      /////
/////                                  /////
/////                                  /////
////////////////////////////////////////////

Авторизовываемся
ссылка: https://bss.eu.interworks.cloud

Переходим справа по ссылке setup (справа вверху)

Далее меню: Setup -> AdministrationSystem -> OptionsAPI -> Credentials

*/


/*
https://bss.eu.interworks.cloud
ID: 65
Login: uaadmin
Pass: P@ssw0rd
*/

    session_start();
    
    error_reporting(E_ALL);
	
	// Путь  соединения
    define('hostProtocol', 'https://');
    define('host', 'bss.eu.interworks.cloud/');
	
	define('azureProductCode', 'MS-AZR-0145P'); 	// Код продукта Azure
	
	// Генерирование ответа
	define('excelRows', "\n");    	// Строка
	define('excelCols', ';');		// Колонка
    
    
    ini_set('max_execution_time', 999999999999); 

/*
    // Test Server
    $accountid = 59;
    $confInterworks = [
        'clientKey'     => 'd84ca0ae-ecc8-4fb0-9db0-de5030edff80',
        'clientSecret'  => 'OyskwtcakKSMvMr4jS7VpQ0iIChMpoWnDE2yRuc6MRM=',
        'host'          => 'bss.eu.interworks.cloud',
        'grant_type'    => 'password',
        'username'      => 'vitaliy.bss.eu',
        'password'      => 'testtest1'
    ];
*/
    
	// Work Server
	switch ($_SERVER['SERVER_NAME'])
	{
		case 'api.interworks.muk.ua':
		{
			$accountid = 65;
			$confInterworks = [
				'clientKey'     => 'ab4e1011-6329-4c9d-9bcd-8316a523ddc2',
				'clientSecret'  => '6F1Bt/8cS/iuYHZTEcC8C+IqgsTRwpcGUP/y/Eo2g54=',
				'host'          => 'bss.eu.interworks.cloud',
				'grant_type'    => 'password',
		//        'username'      => 'connect.bss.eu.work',
		//        'password'      => 'Testtest1='
				'username'      => '1Cintegration',
				'password'      => 'X@Kt2gfQ'
			];
			
			break;
		}
		
// CISCO
		case 'api.interworks.cisco.muk.ua':
		{
			$accountid = 65;
			$confInterworks = [
				'clientKey'     => 'ab4e1011-6329-4c9d-9bcd-8316a523ddc2',
				'clientSecret'  => '6F1Bt/8cS/iuYHZTEcC8C+IqgsTRwpcGUP/y/Eo2g54=',
				'host'          => 'bss.eu.interworks.cloud',
				'grant_type'    => 'password',
		//        'username'      => 'connect.bss.eu.work',
		//        'password'      => 'Testtest1='
				'username'      => '1Cintegration',
				'password'      => 'X@Kt2gfQ'
			];
			
			break;
		}
		
		case 'api.interworks-kz.muk.ua':
		{
/*
API Key Authentication		AW/o3nCSEhhwpHfldszmRzAUupyG3ke7kplNeAYAdA9ly3moRgJI6g==
Client Key					d2e2cc10-8afc-489d-9c62-df4a70ad5561
Client Secret				0hfSU64km3LsVU4CSHOwKM0naE/XVJ1jIlWgGHnf38o=
Reguest Token URL			https://bss.eu.interworks.cloud/oauth/token
*/			
			
			
			$accountid = 68;
			$confInterworks = [
				'clientKey'     => 'd2e2cc10-8afc-489d-9c62-df4a70ad5561',
				'clientSecret'  => '0hfSU64km3LsVU4CSHOwKM0naE/XVJ1jIlWgGHnf38o=',
				'host'          => 'bss.eu.interworks.cloud',
				'grant_type'    => 'password',
				'username'      => '1CintegrationKZ',
				'password'      => 'X@Kt2gfQ'
			];
			
			break;
		}
		
		
		case 'api.interworks-by.muk.ua':
		{
/*
API Key Authentication		AW/o3nCSEhhwpHfldszmRzAUupyG3ke7kplNeAYAdA9ly3moRgJI6g==
Client Key					d2e2cc10-8afc-489d-9c62-df4a70ad5561
Client Secret				0hfSU64km3LsVU4CSHOwKM0naE/XVJ1jIlWgGHnf38o=
Reguest Token URL			https://bss.eu.interworks.cloud/oauth/token
*/			
			
			
			$accountid = 38;
			$confInterworks = [
				'clientKey'     => '960777f0-947f-4385-9ae2-6b5c00da72c2',
				'clientSecret'  => 'uWfnxPqOx8wukgJCYVOChEmH0R6WozAvoLuN7D7RRXg=',
				'host'          => 'bss.eu.interworks.cloud',
				'grant_type'    => 'password',
				'username'      => '1CintegrationBY',
				'password'      => 'X@Kt2gfQ'
			];
			
			break;
		}
	}
    

    
    
    
    // Mysql
    $mysql = [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => 'bW?x8n{N%zfj',
        'database' => 'api.interworks.muk.ua'
    ];
	
	
	
	//
	// Список доступных адресов
	//
    $url = [
        '/api/invoices' => [
            'invoiceCode' 	=> 	'invoiceData',     // ? Наверное не нужно. проверить
            'createdDate' 	=> 	'getInvoiceByDate',
            'invoiceDate'   =>  'getInvoiceByDate',
			'accounts'		=> 	'getInvoiceByAccounts',
            'products'      =>  'getInvoiceByProduct',
            'characteristics' => 'getSubscriptionsCharacteristics'
        ],
		'/api/accounts' 	=> [
//			'balance-temp' 		=> 	'accountBalance',
			'balance' 		    => 	'accountBalance',
			'accounts' 		    => 	'accountsInfo'
		],
		'/api/Subscriptions'=> [
			'get-externalId'    => 	'subscriptionsGetExternalID',
			'accountId' 	    => 	'subscriptionsByAccount',
            'attributes'        => 'subscriptionsAttributes',
            'pricingInfo'       => 'subscriptionsPricingInfo',
//            'characteristics' => 'getSubscriptionsCharacteristics'
            'customfields'      => 'getSubscriptionsCustomfields',
            'characteristics'   => 'getSubscriptionsСharacteristics',
            'azureusagerecords' => 'getAzureusagerecords',
            'addons'          => 'getAddons',
            'addonPricingInfo' => 'getPricingInfo'
		],
		'/api/payments' => [
            'add'               => 'addPayment'
        ],
		'/api/cisco' => [
            'index'               => 'index'
        ],
        'welcome' => [
            'index' => 'index'
        ],
		'/cisco/invoice' => [
			'create' => 'create',
            'update' => 'update'
        ],
    ];

    
    
    function __autoload($class_name){
        
        $folder = ['core', 'controllers', 'models', 'config'];
        
        foreach($folder as $item)
        {
            if(file_exists($_SERVER['DOCUMENT_ROOT'].'/application/'.$item.'/' . $class_name . '.php'))
            {
                require $_SERVER['DOCUMENT_ROOT'].'/application/'.$item.'/' . $class_name . '.php'; 
                return true;
            }
        }
    }
    
    
    