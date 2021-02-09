<?
	require_once __DIR__.'/config.php';
    require_once __DIR__.'/interworks.php';
    
	define('excelRows', "\n");    	// Строка
	define('excelCols', ';');		// Колонка
    
    
    ini_set('max_execution_time', 999999999999); 
	
	var_dump($_SERVER);
	
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
        '/visible_output.php/api/invoices' => [
            'invoiceCode' => 'invoiceData',
            'createdDate' => 'getInvoiceByDate',
			'accounts'	=> 'getInvoiceByAccounts'
        ],
		'/visible_output.php//api/accounts' => [
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
	
	
	echo '<pre>'.print_r($res, true).'</pre>';