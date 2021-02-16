<?php namespace App\Controllers;

/*
 * https://apiconsole.cisco.com/io-docs#/lib-files/api.core-file-decoder.lib-files.index
 * login: Cisco_XaaS@muk.cloud
 * pass: API@roketJump1140
 *
 * vitaliy.obukhov@gmail.com
 * t.7X!3z_67T!rLB
 *
 *
 * Управление данными
 * https://ccrc.cisco.com/subscriptions/landing?code=uFw9rV5PH82ar3EvddHvQFc10pEjdsKauX8AAABn&state=xyz
 */

/*
 * Application Name: CsicoAccess2
 * https://apidocs-prod.cisco.com/explore;category=Smart_Accounts_&_Licensing_APIs;sgroup=Smart_Accounts
 * https://apidocs-prod.cisco.com/explore;category=Smart_Accounts_&_Licensing_APIs;sgroup=Smart_Accounts
 *
 * Client ID: e37b439c-901c-47fc-b0e9-b4312a4da2bc
 * Client Secret: 9565bfc7-a399-42be-b515-bba53cd0c861
 * */
class CiscoController extends BaseController
{
/*
	var $conf = [
        'client_id' 	=> 'rm95fdz7j3ub5vht9qkcpdhw',
        'client_secret' 	=> 'ypMjMzDE6Y4DbRYGrN9Msfq5',
    ];
*/
/*
    var $conf = [
        'client_id' 	=> 'qtdhhs6ht8veu4sxgc9ngyac',
        'client_secret' 	=> 'PhZmecqpSaWJ9AKuqY5k26D8',
    ];
*/

/*
// Cisco_XaaS@muk.cloud
    var $conf = [
        'client_id' 	=> 'e37b439c-901c-47fc-b0e9-b4312a4da2bc',
        'client_secret' 	=> '9565bfc7-a399-42be-b515-bba53cd0c861',
    ];
*/

    // https://anypoint.mulesoft.com/apiplatform/apx/#/apps/624120
    // https://apidocs-prod.cisco.com/explore;category=Commerce_APIs;sgroup=PMI - Request API Access
    var $conf = [
        'client_id' 	    => 'a75106a9cc8843d6bd0eae4ed37ed688',
        'client_secret' 	=> '4381A55A382c4fB6A0Fd80471c12BD13',
    ];




	var $accessToken = '';
	
	public function index()
	{
		return view('welcome_message');
	}
	
/*
https://apiconsole.cisco.com/docs/read/overview/Platform_Introduction

{  
        "token_type": "Bearer",  
        "expires_in": 3599,  
        "refresh_token": "VdjcZSbkceN2ll9Cd9JGq1lsKqw5x4Sj7dwWLNscsP", 
        "access_token": "TJQIE4IWRfL6RcA2PhCxKcFE1SDT"  
}

Authorization: <token_type> <access-token>
Authorization: Bearer KSBs9TtSLTTM6vBptZJLNaoPtTqP


https://apiconsole.cisco.com/io-docs

button "Autorize"


*/



    // Get Smart Accounts
    // Documentation: https://apidocs-prod.cisco.com/explore;category=Plug_&_Play_Connect_APIs;sgroup=Smart_Account_Services;epname=Get_Smart_Accounts
    // Output: {"status":"COMPLETE","message":"NO DATA FOUND","messageCode":"DMS-ERR-121"}
    function getSmartAccounts()
    {
        $token = $this->oauth();

        echo $token.'<br>';

        $output = $this->getData([
            'url'           => "https://swapi.cisco.com/services/api/software/dms/v2/smartaccounts",
            'header'        => 1,
            'httpHeader'    => [
//                    'Content-Type: application/x-www-form-urlencoded',
                'authorization: Bearer ' .$token,
                'Accept: application/json',
                'Content-Type:application/json'
            ],
            'post'          => 0,
            'postField'     => '',

            'httpGet' => 1,
            'getfields'     => [],
        ]);

        var_dump($output); exit;
    }



	// License Subscriptions Usage
	// https://apidocs-prod.cisco.com/explore;category=Smart_Accounts_&_Licensing_APIs;sgroup=Licenses;epname=License_Subscriptions_Usage
	//
    // Смарт аккаунт: BAYADERA GROUP (bayaderagroup.com)
    // Смарт аккаунт: smartsec (smartsec.com.ua)
    // Смарт аккаунт: atom (atom.gov.ua)

    function licenseSubscriptionsUsage()
	{
	    $token = $this->oauth();

        echo $token.'<br>';

        $output = $this->getData([
            'url'           => "https://swapi.cisco.com/services/api/smart-accounts-and-licensing/v1/accounts/mukxaas38638/license-subscriptions",
            'header'        => 1,
            'httpHeader'    => [
//                    'Content-Type: application/x-www-form-urlencoded',
                'authorization: Bearer ' .$token,
                'Accept: application/json',
                'Content-Type:application/json'
            ],
            'post'          => 1,
            'postField'     => json_encode([        //http_build_query([]),
                'virtualAccounts' => ['0' => "DEFAULT"],
                'limit' => 50,
                'offset' => 0
            ]),

            'httpGet' => 0,
            'getfields'     => [],
        ]);

        var_dump($output); exit;
	}



		




	
	// /get-supported-device-types
	function getSupportedDeviceTypes()
	{
//		/curl -X GET "https://api.cisco.com/api/firepower-core-decoder/get-supported-device-types" -H "accept: application/json" -H "authorization: Bearer 7ujTo71Rz2x07UKdnMY6xy8LmtqT"
		
		
		
		$output = $this->getData([
                'url'           => 'https://api.cisco.com/api/firepower-core-decoder/get-supported-device-types',
                'header'        => 1,
                'httpHeader'    => [
                    'Authorization: Bearer 7ujTo71Rz2x07UKdnMY6xy8LmtqT',// .base64_encode($this->conf['clientKey'].':'.$this->conf['clientSecret']),
					'accept: application/json'
				],
                'post'          => 0,
                'postField'     => '',

                'httpGet' => 1,
                'getfields'     => [],
            ]);
			
			
			var_dump($output); exit;
	}
	
	
	/* Получаем Токен (Авторизация)
	 * Документация - https://apiconsole.cisco.com/docs/read/overview/Platform_Introduction
	 * PDF файл - Token Developer Guide (359 KB)
	 *
	 * https://cloudsso.cisco.com/as/authorization.oauth2?response_type=token&client_id=rm95fdz7j3ub5vht9qkcpdhw&redirect_uri=http://api.interworks-cisco.muk.ua/cisco/oauth
	 *
	 * http://api.interworks-cisco.muk.ua/cisco/oauth
	*/
    function oauth()
    {

        if(!empty($this->accessToken))
        {
            return $this->accessToken;
        }

        $conf = [
            'url' => 'https://cloudsso.cisco.com/as/token.oauth2', // client_credentials
            'post' => [
                'grant_type' => 'password', //  'client_credentials', //'authorization_code',
                'client_id' 	=> $this->conf['client_id'], //'rm95fdz7j3ub5vht9qkcpdhw',
                'client_secret' 	=> $this->conf['client_secret'], //'ypMjMzDE6Y4DbRYGrN9Msfq5',
                'username'	=> 'Cisco_XaaS@muk.cloud',
                'password'	=> 'API@roketJump1140',


            ],
            'header' => [
                "cache-control: no-cache",
                'Accept-Encoding: gzip,deflate',
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
                'User-Agent: Jakarta Commons-HttpClient/3.1',
                'Host: cloudsso.cisco.com',
            ]
        ];




        $ch = curl_init($conf['url']);
        curl_setopt_array($ch, array(
            CURLOPT_URL => $conf['url'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => urldecode(http_build_query($conf['post'])),
            CURLOPT_HTTPHEADER => $conf['header'],
        ));

        $response = curl_exec($ch);

        $info = curl_getinfo($ch);

        curl_close($ch);

        $responseArr = json_decode($response, JSON_FORCE_OBJECT);

        if(isset($responseArr['access_token']))
        {
            $this->accessToken = $responseArr['access_token'];
        }
/*
        echo '<br>------ $response  -------<br>';
        echo $response;
//        echo '<br>------ $err -------<br>';
//        echo $err;
        echo '<br>------ $info -------<br>';
        echo '<pre>'.print_r($info, true).'</pre>';;
*/
        return $this->accessToken;





//			echo base64_encode($this->conf['clientKey'].':'.$this->conf['clientSecret']); exit;
        $output = $this->getData([
            'url'           => $this->conf['url'],
            'header'        => 1,
            'httpHeader'    => [
//                    'Content-Type: application/x-www-form-urlencoded', 
                'Authorization: Bearer ' .base64_encode($this->conf['clientKey'].':'.$this->conf['clientSecret']),

//					'Flow: application'
//                    'Host:'.$this->conf['host'],
//                    'X-Api-Version: 2.2'
            ],
            'post'          => 1,
            'postField'     => http_build_query([
                'grant_type' => $this->conf['grant_type'],
                'response_type' => 'code',
                'redirect_uri' => $this->conf['url'],
                'scope' => 'read',
                'client_id' => $this->conf['clientKey'],
                'Flow' => 'application',
//					'client_secret' => $this->conf['clientSecret'],
                'username'  => $this->conf['username'],
                'password'  => $this->conf['password']
            ]),

            'httpGet' => 0,
            'getfields'     => [],
        ]);


        echo('<pre>'.$output.'</pre>'); exit;

    }


    // Validate Provisioning
    // Documentation:       https://apidocs-prod.cisco.com/explore;category=Commerce_APIs;sgroup=PMI;epname=Validate_Provisioning
    // Link: http://api.interworks-cisco.muk.ua/cisco/contractsSearch
    // 403 Forbidden - Not Authorized
    function validateProvisioning()
    {

        $token = $this->oauth();

        echo $token.'<br>';

        $output = $this->getData([
            'url'           => "https://apx-poe.cisco.com/ccw/api/v1.0/provisioning/validate",
            'header'        => 1,
            'httpHeader'    => [
//                    'Content-Type: application/x-www-form-urlencoded',
                'authorization: Bearer ' .$token,
                'Accept: application/json',
                'Content-Type:application/json'
            ],
            'post'          => 1,
            'postField'     => '
{
  "uuid": "POEUUID_11022017_01111",
  "createdBy": "ccoid",
  "createdDateTime": "2021-02-15T22:01:59.787+0000",
  "csbSubscriptionId": "POEcsbsub_11022017_01",
  "csbOrderId": "POEcsbord_11022017_01",
  "purchaseOrderNumber": "POEUUID_11022017_01",
  "billingAddressId": 100000000,
  "billingAddressName": "sample billing address name",
  "currency": "USD",
  "paymentMethod": "NET30",
  "rejectDuplicatePO": "N",
  "intialTerm": 12,
  "autoRenewalTerm": 12,
  "billingModel": "Monthly Billing",
  "requestedStartDate": "2021-02-15",
  "parties": [
    {
      "partyType": "End Customer",
      "partyName": "TEST NOT REAL 2",
      "addressLine1": "1217 Kildaire Farm Rd",
      "addressLine2": "",
      "city": "Cary",
      "state": "NC",
      "postalCode": "27511",
      "country": "US",
      "businessContactName": "dummyContact",
      "businessContactEmail": "dummyContact@gmail.com",
      "businessContactTelephone": "4078027828"
    },
    {
      "partyType": "Reseller",
      "partyName": "ALEXANDER OPEN SYSTEMS",
      "addressLine1": "12980 FOSTER ST STE 300",
      "addressLine2": "",
      "city": "OVERLAND PARK",
      "state": "KS",
      "postalCode": "66213",
      "country": "US",
      "businessContactName": "test contact",
      "businessContactEmail": "testcontact@AOS5.COM",
      "businessContactTelephone": "913-307-2300ext2303",
      "accountNumber": "38019164"
    }
  ],
  "offers": [
    {
      "lineNumber": 1,
      "offerSKU": "A-SPK-NU-M3",
      "quantity": 1,
      "csbCiscoKey": "2163146462363366067",
      "offerDescription": "Spark M3 offer",
      "provisioningAttributes": [
        {
          "attributeIdentifier": "0000",
          "attributeName": "csbil.Provisioning Contact.EMAIL",
          "attributeValue": "ordersimp-sapol1102201701@mailinator.com"
        }
      ]
    }
  ],
  "tncacceptance": "Y"
}            
            ',

            'httpGet' => 0,
            'getfields'     => [],
        ]);

        var_dump($output); exit;
    }



    // Contracts Search
    // Documentation:       https://apidocs-prod.cisco.com/explore;category=Commerce_Renewal_APIs;sgroup=Contracts_Search
    // Link: http://api.interworks-cisco.muk.ua/cisco/contractsSearch
    // 403 Forbidden - Not Authorized
    function contractsSearch()
    {

        $token = $this->oauth();

        echo $token.'<br>';

        $output = $this->getData([
            'url'           => "https://api-test.cisco.com/ccw/renewals/api/v1.0/search/contractSummary",
            'header'        => 1,
            'httpHeader'    => [
//                    'Content-Type: application/x-www-form-urlencoded',
                'authorization: Bearer ' .$token,
                'Accept: application/json',
                'Content-Type:application/json'
            ],
            'post'          => 1,
            'postField'     => json_encode([        //http_build_query([]),
                'billToLocation' => '88888',
                'limit' => 200,
                'offset' => 1
            ]),

            'httpGet' => 0,
            'getfields'     => [],
        ]);

        var_dump($output); exit;
    }



    // Get Virtual Accounts
    // Documentation: https://apidocs-prod.cisco.com/explore;category=Plug_&_Play_Connect_APIs;sgroup=Smart_Account_Services;epname=Get_Virtual_Accounts
    function getVirtualAccounts()
    {
        $token = $this->oauth();

        echo $token.'<br>';

        $conf = [
            'smartAccountDomain' => 'bayaderagroup.com', // bayaderagroup.com //
            'accountType' => 'HOLDING', //  CUSTOMER  HOLDING
        ];

        $output = $this->getData([
            'url'           => "https://swapi.cisco.com/services/api/software/dms/v2/smartaccounts/{$conf['smartAccountDomain']}/virtualaccounts",
            'header'        => 1,
            'httpHeader'    => [
//                    'Content-Type: application/x-www-form-urlencoded',
                'authorization: Bearer ' .$token,
                'Accept: application/json',
                'Content-Type:application/json'
            ],
            'post'          => 0,
            'postField'     => '',

            'httpGet' => 1,
            'getfields'     => [],
        ]);

        var_dump($output); exit;
    }







    //https://apidocs-prod.cisco.com/explore;category=Smart_Accounts_&_Licensing_APIs;sgroup=Virtual_Accounts;epname=List_Virtual_Accounts
    // List Virtual Accounts
    function listVirtualAccounts()
    {
        $token = $this->oauth();

        echo $token.'<br>';

        $conf = [
            'smartAccountDomain' => 'smartsec.com.ua', // bayaderagroup.com
            'accountType' => 'HOLDING', //  CUSTOMER  HOLDING
        ];

        $output = $this->getData([
            'url'           => "https://swapi.cisco.com/services/api/smart-accounts-and-licensing/v1/accounts/{$conf['smartAccountDomain']}/{$conf['accountType']}/virtual-accounts",
            'header'        => 1,
            'httpHeader'    => [
//                    'Content-Type: application/x-www-form-urlencoded',
                'authorization: Bearer ' .$token, //base64_encode($this->conf['client_id'].':'.$this->conf['client_secret']),
            ],
            'post'          => 0,
            'postField'     => http_build_query([]),

            'httpGet' => 1,
            'getfields'     => [],
        ]);

        var_dump($output); exit;
    }







    // https://apidocs-prod.cisco.com/explore;category=Smart_Accounts_&_Licensing_APIs;sgroup=Smart_Accounts;epname=Smart_Recommendation_for_Partners
    // Smart Recommendation for Partners
    // Не известный параметры POST - crPartyID
    function smartRecommendationForPartners()
    {
        $token = $this->oauth();

        echo $token.'<br>';

        $output = $this->getData([
            'url'           => 'https://swapi.cisco.com/services/api/smart-accounts-and-licensing/v2/accounts/search',
            'header'        => 1,
            'httpHeader'    => [

                'authorization: Bearer ' .$token, //base64_encode($this->conf['client_id'].':'.$this->conf['client_secret']),
            ],
            'post'          => 1,
            'postField'     => http_build_query([
                'crPartyID' => '?????????????????',
            ]),
            'httpGet' => 0,
            'getfields'     => [],
        ]);

        var_dump($output); exit;
    }




    // Smart Accounts Search
    // Documentation:   https://apidocs-prod.cisco.com/explore;category=Smart_Accounts_&_Licensing_APIs;sgroup=Smart_Accounts;epname=Smart_Accounts_Search
    // Link:            http://api.interworks-cisco.muk.ua/cisco/smartAccountsSearch
    // output:          {"status":"COMPLETE","message_code":"NO DATA FOUND","message":"No matching record found for given input"}
    function smartAccountsSearch()
    {
        $token = $this->oauth();

        echo $token.'<br>';

        $output = $this->getData([
//                'url'           => 'https://swapi.cisco.com/services/api/smart-accounts-and-licensing/v1/accounts/search',
            'url'           => 'https://swapi.cisco.com/services/api/smart-accounts-and-licensing/v2/accounts/search',
            'header'        => 1,
            'httpHeader'    => [
//                    'Content-Type: application/x-www-form-urlencoded',
                'authorization: Bearer ' .$token, //base64_encode($this->conf['client_id'].':'.$this->conf['client_secret']),
//                    'grant_type' => 'password', //  'client_credentials', //'authorization_code',
//                    'client_id' 	=> $this->conf['client_id'], //'rm95fdz7j3ub5vht9qkcpdhw',
//                    'client_secret' 	=> $this->conf['client_secret'], //'ypMjMzDE6Y4DbRYGrN9Msfq5',
//                    'username'	=> 'Cisco_XaaS@muk.cloud',
//                    'password'	=> 'API@roketJump1140',

//					'Flow: application'
//                    'Host:'.$this->conf['host'],
//                    'X-Api-Version: 2.2'
            ],
            'post'          => 0,
// oauth_token=SlAV32hkKG&client_id=464119&format=json
            'postField'     => http_build_query([
//                    'oauth_token' => $this->accessToken,
//                    'format' => 'json',
//                    'client_id' => $this->conf['client_id'],

            ]),

            'httpGet' => 1,
            'getfields'     => [
//                    'grant_type' => 'password', //  'client_credentials', //'authorization_code',
//                    'client_id' 	=> $this->conf['client_id'], //'rm95fdz7j3ub5vht9qkcpdhw',
//                    'client_secret' 	=> $this->conf['client_secret'], //'ypMjMzDE6Y4DbRYGrN9Msfq5',
            ],
        ]);

        var_dump($output); exit;
    }




    // Не работает - Invaid Smart Account ID
    // Get License Summary by Tag
    // documentation: https://apidocs-prod.cisco.com/explore;category=Smart_Accounts_&_Licensing_APIs;sgroup=Smart_Licensing_Using_Policy;epname=Get_License_Summary_by_Tag
    // link: http://api.interworks-cisco.muk.ua/cisco/getLicenseSummaryByTag
    function getLicenseSummaryByTag()
    {
        $token = $this->oauth();

        echo $token.'<br>';

        $output = $this->getData([
            'url'           => 'https://swapi.cisco.com/services/api/services/api/smart-accounts-and-licensing/v3/licenses/summary',
            'header'        => 1,
            'httpHeader'    => [
                'authorization: Bearer ' .$token,
                'Accept: application/json',
                'Content-Type:application/json'
            ],
            'post'          => 1,

            'postField'     => json_encode([
                'timestamp' => microtime(true),
                'nonce' => '1234',
                'tags' => [],
                'softwareTags' => []
                ]),

            'httpGet' => 0,
            'getfields'     => [],
        ]);

        var_dump($output); exit;
    }



    function helloWord()
    {
        $token = $this->oauth();

        echo $token.'<br>';


        $output = $this->getData([
            'url'           => 'https://api.cisco.com/hello',
            'header'        => 1,
            'httpHeader'    => [
//                    'Content-Type: application/x-www-form-urlencoded',
                'authorization: Bearer ' .$this->accessToken, //base64_encode($this->conf['client_id'].':'.$this->conf['client_secret']),
                'accept: text/plain',


//					'Flow: application'
//                    'Host:'.$this->conf['host'],
//                    'X-Api-Version: 2.2'
            ],
            'post'          => 0,
// oauth_token=SlAV32hkKG&client_id=464119&format=json
            'postField'     => http_build_query([
//                    'oauth_token' => $this->accessToken,
//                    'format' => 'json',
//                    'client_id' => $this->conf['client_id'],
            ]),

            'httpGet' => 1,
            'getfields'     => [],
        ]);

        echo $output; exit;
    }

        

        // Перез запросом я уже вызывают getToken поэтому здесь подключение избыточно!!!!!!!!!!!!!!!!!!!!!
        function query($options)
        {

            $options['url'] =  hostProtocol.host.$options['url'];

            $output = $this->getData($options);
            
            if(!isset($output[0]) || $output[0] == 'HTTP/1.1 500 Internal Server Error')
            {
                $this->setLog('Token is old.');
                return false;
            }

            $vars =  json_decode($output, true);

            return $vars;
        }




        // Отправка запроса по CURL
        function getData($data)
        {
            $ch = curl_init($data['url']);
            curl_setopt($ch, CURLOPT_URL, $data['url']);  

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_HEADER, $data['header']); 
            curl_setopt($ch, CURLINFO_HEADER_OUT, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $data['httpHeader']); 
//			curl_setopt($ch, CURLOPT_PROXYHEADER, $data['httpHeader']); 
			

            if(isset($data['post']) && $data['post'] == 1)
                curl_setopt($ch, CURLOPT_POST, $data['post']);



            //    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  
//            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
            //    curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);         
            if($data['httpGet'] <> 1)
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data['postField']);
            else
                curl_setopt($ch, CURLOPT_HTTPGET, $data['httpGet']);

            curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14");
            curl_setopt($ch, CURLINFO_OS_ERRNO, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // таймаут соединения
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);        // таймаут ответа
            curl_setopt($ch, CURLOPT_MAXREDIRS, 1);       // останавливаться после 10-ого
            curl_setopt($ch, CURLOPT_HTTP_VERSION, 'HTTP/1.1');

            $output = curl_exec($ch);


            if(curl_errno($ch))
                $this->setLog('Request Error:' . curl_error($ch));

            $info = curl_getinfo($ch); 

            //            echo '<br>Info header<br>';
            echo '<pre>'.print_r($info, true).'</pre>';

            curl_close($ch);

            return $output; 
        }


        function setLog($str)
        {
//            file_put_contents(__DIR__.'/InterWorks_'.date('Y.m.d').'.txt', date('H:i:s').' '.$str."\n");
        }

	//--------------------------------------------------------------------

}
