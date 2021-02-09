<?

    //      My Example
    //      http://api.interworks.muk.ua/api/invoices?createdDate=2018-02-01&sort=invoiceDate&order=desc
    //      http://api.interworks.muk.ua/api/invoices/?invoiceCode=000624
	
	
	
	// 		Вход в interworks
	// 		https://bss.eu.interworks.cloud/Login.aspx
	
	
	
	
/*
https://kb.interworks.cloud/display/ICPD/interworks.cloud+Billing+API#interworks.cloudBillingAPI-GetAccountBalance

Get Account Balance
https://<host_name>/api/accounts/<account_id>/balance
http://api.interworks.muk.ua/api/accounts/2792/balance - рабочая ссылка


Example 1 - Without Parameters
GET: https://<host_name>/api/accounts


"creditLimit": "Unlimited",
view-source:http://api.interworks.muk.ua/api/accounts - рабочая ссылка
*/
	
	
	
    
/*
	// Вывод данных как файл excel
	
    header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
    header("Content-type:   application/x-msexcel; charset=utf-8");
    header("Content-Disposition: attachment; filename=abc.xsl"); 
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
*/    

//echo '<pre>'.print_r($_SERVER, true).'</pre>'; exit;

/*
if($_SERVER['REMOTE_ADDR'] == '10.1.11.127')
{
	require_once __DIR__.'/index_new.php';
	exit;
}
*/



    require_once __DIR__.'/config.php';
    require_once __DIR__.'/interworks.php';
	
    
	define('excelRows', "\n");    	// Строка
	define('excelCols', ';');		// Колонка
    
    
    ini_set('max_execution_time', 999999999999); 
	
	
	if(!isset($_SERVER['REDIRECT_URL']) || empty($_SERVER['REDIRECT_URL']))
    {
        die('Строка запроса отсутствует.');
    }
	
	$obj = new InterWorks($conf);

    $token = $obj->getToken();
	
    
    $option = [
        'url'           => $_SERVER['REDIRECT_URL'].'?'.http_build_query($_GET),
        'header'        => 1,
        'httpHeader'    => [
            'Authorization: Bearer '.$_SESSION['token'],
			'X-Api-Version: 2.1'
        ],
        'post'          => 0,
        'postField'     => '',
        'httpGet'       => 1,             
        'getfields'     => []
    ];


//    $option = [
//        'url'           => $_SERVER['REDIRECT_URL'],
//        'header'        => 1,
//        'httpHeader'    => [
//            'Authorization: Bearer '.$_SESSION['token'],
//        ],
//        'post'          => 1,
//        'postField'     => [],
//        'httpGet'       => 0,
//        'getfields'     => []
//    ];
    

    
    
    
    

	// Список доступных адресов
    $url = [
        '/api/invoices' => [
            'invoiceCode' => 'invoiceData',
            'createdDate' => 'getInvoiceByDate',
			'accounts'	=> 'getInvoiceByAccounts'
        ],
		'/api/accounts' => [
			'balance' => 'accountBalance',
			'accounts' => 'accountsInfo'
		],
		
		
		
		
    ];
    
	// Приводим REDIRECT_URL к общему виду (без слеша в конце)
	if($_SERVER['REDIRECT_URL']{mb_strlen($_SERVER['REDIRECT_URL'])-1} == '/')
	{
		$_SERVER['REDIRECT_URL'] = mb_substr($_SERVER['REDIRECT_URL'], 0, strlen($_SERVER['REDIRECT_URL'])-1);
	}
	//echo '<pre>'.print_r($_SERVER, true).'</pre>'; exit;
	// Поиск адреса в разрешенных адресах
	
	if(count($_GET) == 0)
	{
		foreach($url as $k => $z)
		{
			if(mb_strpos($_SERVER['REDIRECT_URL'], $k) !== false)
				$_SERVER['REDIRECT_URL'] = $k;
		}
	}
	
    if(!isset($url[$_SERVER['REDIRECT_URL']]))
    {
        die('Сопоставление адресной строки методом обработки не найдены');
    }
    
    
    // Поиск схожих индексов между $_GET и массим в адресами $url
    $ar = array_keys(array_intersect_key($_GET, $url[$_SERVER['REDIRECT_URL']]));
	
	if(count($ar) == 0 && count($_GET) == 0)
	{
		$temp = explode('/', $_SERVER['REQUEST_URI']);

		foreach($url[$_SERVER['REDIRECT_URL']] as $k => $z)
		{
			foreach($temp as $itemUrl)
			{
				
				if($k == $itemUrl)
				{
					$ar[] = $k;
				}
			}
		}
	}
	
	
    
    // Поиск метода для обработки
    if(count($ar) > 0 && function_exists($url[$_SERVER['REDIRECT_URL']][$ar[0]]))
	{
		$res = $obj->query($option);
		
		// echo '<pre>'.print_r($res, true).'</pre>'; exit; // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		
		$str = firstString();
		$str .= $url[$_SERVER['REDIRECT_URL']][$ar[0]]($res);
		echo $str .= lastString();
		addToLog($mysql, $str, $res);
	}
    else
    {
        die('Метод не найден');
    }
	
	
	
	
	
	
	
	function accountBalance(&$res)
	{
		$header = [
			'id',
			'balance',
			'debitInvoicesTotal',
			'debitInvoicesCount',
			'creditInvoicesTotal',
			'creditInvoicesCount',
			'paymentsTotal',
			'paymentsCount',
			'refundsTotal',
			'refundsCount'
		];
		
		$str = addString($header);
		
		if(!isset($res['Type']) && count($res) > 0)
		{
			for($i = 0; $i < count($res); $i++)
			{
				// Создаем массив для строки и в пример берем заголовки
				foreach($header as $item)
				{
					$ar[$item] = trimEx((isset($res[$i][$item]) ? $res[$i][$item] : (isset($res[$item]) ? $res[$item] : '!!!Error!!!')));
				}

				$str .= addString($ar);
				
				if(isset($res[$item])) break;
			}
		}
        
        return $str;
	}
	
	
	function accountsInfo(&$res)
	{
		
		$header = [
			'id',
			'name',
			'code',
			'phone',
			'fax',
			'registrationNumber',
			'taxAuthority',
			'businessActivity',
			'enableOrdering',
			'email',
			'billToAccountId',
			'type',
			'industry',
			'webSite',
			'source',
			'tradingName',
			'prorateBillingEnabled',
			'prorateBillingDate',
			'creditLimit',
			'partialChargesInvoicing',
			'separateInvoicesEnabled',
			'enableReselling',
			'description',
		];
		
		
		$header = [
			'id',
			'name',
			'code',
			'prorateBillingEnabled',
			'prorateBillingDate',
			'creditLimit',
			'partialChargesInvoicing',
			'separateInvoicesEnabled',
		];
		
		$str = addString($header);
		
		if(isset($res[0]))
		{
			for($i = 0; $i < count($res); $i++)
			{
				// Создаем массив для строки и в пример берем заголовки
				$ar = [];
				foreach($header as $item)
				{
					$ar[$item] = trimEx($res[$i][$item]);
				}

				$str .= addString($ar);
				
				
			}
		}
		else
		{
			foreach($header as $item)
			{
				$ar[$item] = trimEx($res[$item]);
			}

			$str .= addString($ar);
		}
        
        return $str;
		
	}
	
	
	
	
	function getInvoiceByAccounts(&$res)
	{
		var_dump($res);
	}
	
    
    
    
    // Данные по инвойсу
    function invoiceData(&$res)
    {
		
		
		$header = [
			'id',
			'name',
			'billingPeriodStart',
			'billingPeriodEnd',
			'productId',
			'productCode',
			'unit',
			'quantity',
			'costPrice',
			'finalPrice',
			'accountId',
			'accountName',
			'subscriptionId'
		];
		
		$str = addString($header);
        
        if(!isset($res['Type']))
        {
            for($i = 0; $i < count($res); $i++)
            {
				// Создаем массив для строки и в пример берем заголовки
				foreach($header as $item)
				{
					$ar[$item] = trimEx($res[$i][$item]);
				}
				
				// Поля требующие форматирования
				$ar['billingPeriodStart'] 	= date('Y-m-d', strtotime($ar['billingPeriodStart']));
				$ar['billingPeriodEnd'] 	= date('Y-m-d', strtotime($ar['billingPeriodEnd']));
				
				// Если это продукт Azure
				if($res[$i]['productCode'] == azureProductCode)
				{
					
					$ar['quantity'] = $ar['costPrice'] = $ar['finalPrice'] = 0;
					
					$ar['subscriptionId'] = mb_substr($ar['subscriptionId'], 0, mb_strpos($ar['subscriptionId'], '-'));
					
					foreach($res[$i]['usageRecords'] as $usageRecordsItem)
					{
						
						foreach($usageRecordsItem as $z)
						{
							$ar['quantity'] += floatval($usageRecordsItem['quantity']);
							$ar['costPrice'] += floatval($usageRecordsItem['quantity']) * floatval($usageRecordsItem['costPrice']);
							$ar['finalPrice'] += floatval($usageRecordsItem['quantity']) * floatval($usageRecordsItem['finalPrice']);
						}
					}
				}
				// Остальные продукты не Azure
				else
				{
					if($ar['unit'] == 'Month')
					{
						$ar['unit'] = mb_substr($ar['unit'], 0, mb_strpos($ar['unit'], '-'));
					}
					else if($ar['unit'] == 'Annually')
					{
						$ar['unit'] = mb_substr($ar['unit'], 0, mb_strpos($ar['unit'], '-')).'_1Y';
					}
				}
                
				$str .= addString($ar);
            }
        }
        
        return $str;
    }
    
    // Список инвойсов по дате
    function getInvoiceByDate(&$res)
    {
		$header = [
			'code',
			'billingAccountId',
			'billingAccountName',
			'stage',
			'totalAmount',
			'type'
		];
        
		$str = addString($header);
		
		if(!isset($res['Type']))
		{
			for($i = 0; $i < count($res); $i++)
			{
				// Создаем массив для строки и в пример берем заголовки
				foreach($header as $item)
				{
					$ar[$item] = trimEx($res[$i][$item]);
//					$ar[$item] = $res[$i][$item];
				}

				$str .= addString($ar);
			}
		}
        
        return $str;
    }
    
    

    
    
exit;

    



    
    



