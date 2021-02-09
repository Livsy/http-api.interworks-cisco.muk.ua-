<?            

    // 		Вход в interworks
    // 		https://bss.eu.interworks.cloud/Login.aspx
	
/*
	Создание учетной записи для API
	
	1. Входим в учетную запись
	2. Справа вверху есть ссыла в меню - setup
	3. Далее Administration -> System Options -> API Credentials
*/	
	

    //      Тестовый
    //		login: 	gestaging
    // 		pass:	P@ssw0rd
    //		id:		59

    //      Рабочый
    //		login: 	uaadmin
    // 		pass:	P@ssw0rd
    //		id:		65
	 
	//      Рабочый Казахстан
    //		login: 	kzadmin
    // 		pass:	P@ssw0rd
    //		id:		68

    //		https://bss.eu.interworks.cloud/
    //		ID: 37
    //		Login: iwaudit
    //		Pass: QPt5jr+5

    //		Документация
    // 		https://kb.interworks.cloud/display/ICPD/interworks.cloud+Billing+API#interworks.cloudBillingAPI-GetAccountBalance

    //		Новая документация
    //		https://my.interworkscloud.com/apidocs/
    


    require_once __DIR__.'/application/config/config.php';
    
    
    if(isset($_SERVER['REDIRECT_URL']) && $_SERVER['REDIRECT_URL'] == '/unittest')
    {
        $class = new Unittest();
        $class->getData();
        exit;
    }
    
    
    
    $viewClass = (isset($_GET['html']) && $_GET['html'] == 1) ? 'ViewHtml' : 'ViewXml';

    $rout = new Routes();
    
    $routConf = $rout->getData();
    
//    echo $routConf['class']; exit;
    
    if(class_exists($routConf['class']) && method_exists($routConf['class'], $routConf['method']))
    {
        $class = new $routConf['class'](['view' => new $viewClass]);     
        $class->{$routConf['method']}($routConf['url']);
    }

    
/*
        // Настройки для передачи POST
        $option = [
            'url'           => $redirect_url,
            'header'        => 1,
            'httpHeader'    => [
                'Authorization: Bearer '.$_SESSION['token'],
            ],
            'post'          => 1,
            'postField'     => [],
            'httpGet'       => 0,
            'getfields'     => []
        ];
*/



    

    







    
    
    
    
    











    


    

    
    