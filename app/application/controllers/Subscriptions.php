<?            

class Subscriptions extends MyController
{
    function __construct($vars)
    {
        parent::__construct($vars);
        
    }
    
    
    // http://api.interworks.muk.ua/api/Subscriptions/b231c268-bca9-496c-b333-cb659e7a9a1a/attributes/get-externalId?html=1
    // Документация
    // https://kb.interworks.cloud/display/ICPD/interworks.cloud+BSS+API#interworks.cloudBSSAPI-GetSubscription'sAttributes
    function subscriptionsGetExternalID($vars)
    {
        $url = str_replace('get-externalId', '', $vars['url']['redirect_url']);
        
        // Добавляем адрес в заголовок
        $this->interWorksOption['url'] = $url;
        
        // Отправляем запрос в interWorks
        $res = $this->interworks->query($this->interWorksOption);
//echo '<pre>'.print_r($res, true).'</pre>';
        $header = [
            'id',
            'externalId',
            'name',
            'value',
            'valueExternal',
            'code'
        ];    
            
        $str[] = $this->view->addString($header);
        
        if(!isset($res['attributes']) || count($res['attributes']) == 0)
            return $str;
        
        foreach($res['attributes'][0] as $k => $item)
        {
            $ar[] = $this->trimEx($item);
        }
        
//        $res['attributes'][0] = $this->trimEx($res['attributes'][0]);
        
        $str[] = $this->view->addString($ar);    
        
        $this->generateQuery($res, $str);
    }
    
    
    
    
    // http://api.interworks.muk.ua/api/Subscriptions/f62d4795-e4ae-4d0c-ad1e-12cd9e026805/pricingInfo
    function subscriptionsPricingInfoQuery($vars)
    {
        $this->interWorksOption['url'] = $vars['url']['redirect_url'];//'?'.http_build_query($_GET);;
        
        return $this->interworks->query($this->interWorksOption);
    }
    
    
    // Информация о подписке
    // http://api.interworks.muk.ua/api/Subscriptions/b4f771f6-c197-4ca5-89ac-b1bf6a8154ce/pricingInfo
    function subscriptionsPricingInfo($vars)
    {
        
        $res = $this->subscriptionsPricingInfoQuery($vars);
        
//        echo '<pre>'.print_r($res, true).'</pre>';
        
        $header = [
            'name',
            'total',
            'unitPrice',
            'discount',
            'discountType',
            'finalUnitPrice',
            'quantity',
            'priceList' => ['name', 'pricingMethod' => ['pricingMethod', 'amount', 'price']],
            'priceProtection' => ['periodEndDate', 'protecetedSalesPrice', 'protecetedCostPrice']
        ];
        
        $fields = $this->addHeader($header);
        $str[] = $this->view->addString($fields);
        
//        var_dump($res['name']);
        
        $ar = [
            'name' => @$res['name'],
            'total' => @$res['total'],
            'unitPrice' => @$res['unitPrice'],
            'discount' => @$res['discount'],
            'discountType' => @$res['discountType'],
            'finalUnitPrice' => @$res['finalUnitPrice'],
            'quantity' => @$res['quantity'],
            'priceListName' => @$res['priceList']['name'],
            'priceListPricingMethod' => @$res['priceList']['pricingMethod']['pricingMethod'],
            'priceListPricingMethodAmount' => @$res['priceList']['pricingMethod']['amount'],
            'priceListPricingMethodAmount' => @$res['priceList']['pricingMethod']['amount'],
            'priceListPricingMethodPrice' => @$res['priceList']['pricingMethod']['price'],
            'priceProtectionPeriodEndDate' => @$res['priceProtection']['periodEndDate'],
            'priceProtectionProtecetedSalesPrice' => @@$res['priceProtection']['protecetedSalesPrice'],
            'priceProtectionProtecetedCostPrice' => @$res['priceProtection']['protecetedCostPrice']
        ];
        
//        echo '<pre>'.print_r($ar, true).'</pre>';
        $str[] = $this->view->addString($ar);
        $this->generateQuery($res, $str);
    }
    
    
    // http://api.interworks.muk.ua/api/Subscriptions/b4f771f6-c197-4ca5-89ac-b1bf6a8154ce/attributes
    function subscriptionsAttributes($vars)
    {
        $this->interWorksOption['url'] = $vars['url']['redirect_url'];//'?'.http_build_query($_GET);;
        
        // Отправляем запрос в interWorks
        $res = $this->interworks->query($this->interWorksOption);
        
        var_dump($res);
        
        exit;
    }
    
    
    
    
    // /api/Subscriptions/{subscriptionId}/customfields
    // http://api.interworks.muk.ua/api/Subscriptions/f62d4795-e4ae-4d0c-ad1e-12cd9e026805/customfields
    function getSubscriptionsCustomfields($vars)
    {
        $this->interWorksOption['url'] = $vars['url']['redirect_url'];
        
        // Отправляем запрос в interWorks
        $res = $this->interworks->query($this->interWorksOption);
        
        var_dump($res);
        
        exit;
    }
    
    
    // http://api.interworks.muk.ua/api/Subscriptions/0FE8E339-90A6-463F-A3C3-9E3A3815B89F/characteristics
    function getSubscriptionsСharacteristics($vars)
    {
        $this->interWorksOption['url'] = $vars['url']['redirect_url'];
        
        // Отправляем запрос в interWorks
        $res = $this->interworks->query($this->interWorksOption);
        
        var_dump($res);
        
        exit;
    }
    
    
    function getAzureusagerecords($vars)
    {
        $this->interWorksOption['url'] = $vars['url']['redirect_url'];
        
        // Отправляем запрос в interWorks
        $res = $this->interworks->query($this->interWorksOption);
        
        var_dump($res);
        
        exit;
    }
    
    
    // http://api.interworks.muk.ua/api/Subscriptions/1dc2c618-9185-468d-8f7d-02344b5baeb4/addons
    function getAddons($vars)
    {
        //        $vars['url']['redirect_url'] = str_replace('getAddon', 'addons', $vars['url']['redirect_url']);
        
        $this->interWorksOption['url'] = $vars['url']['redirect_url'];
        
        // Отправляем запрос в interWorks
        $res = $this->interworks->query($this->interWorksOption);
        
        var_dump($res);
        
        exit;
    }
    
    
    // http://api.interworks.muk.ua/api/Subscriptions/1dc2c618-9185-468d-8f7d-02344b5baeb4/addon/13b9d53f-b781-4c2b-b10b-6d7c46c259e1/addonPricingInfo
    function getPricingInfo($vars)
    {
        $this->interWorksOption['url'] = str_replace('addonPricingInfo', 'pricingInfo', $vars['url']['redirect_url']);
        
        // Отправляем запрос в interWorks
        $res = $this->interworks->query($this->interWorksOption);
        
        var_dump($res);
        
        exit;
    }
    
    
}
