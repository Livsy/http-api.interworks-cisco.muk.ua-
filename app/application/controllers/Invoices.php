<?

class Invoices extends MyController
{
    var $vars;
    
    
    function __construct($vars)
    {
        parent::__construct($vars);
        
        $this->vars = $vars;
        
    }
    
    // Список инвойсов по дате
    // http://test.api.interworks.muk.ua/api/invoices?invoiceDate=2017-12-28&sort=invoiceDate&order=desc&html=1
    function getInvoiceByDate($vars)
    {
        $get = $_GET;
        if(isset($get['html']))
            unset($get['html']);
                                                             
        $url = $vars['url']['redirect_url'].'?'.http_build_query($_GET).'&size=1000000'; 
        //$url = '/api/invoices?invoiceDate='.$_GET['createdDate']; 
        $this->interWorksOption['url'] = $url;
        
        // Отправляем запрос в interWorks
        $res = $this->interworks->query($this->interWorksOption);
//echo '<pre>'.print_r($res, true).'</pre>'; exit;
        
        $header = [
            'id',
            'code',
            'billingAccountId',
            'billingAccountName',
            'stage',
            'totalAmount',
            'type',
            'date',
            'dueDate',
            'description',
            'accountId'
        ];
        
        $str[] = $this->view->addString($header);
        
        if(!isset($res['Type']))
        {
            for($i = 0; $i < count($res['data']); $i++)
            {
                $ar = [];
                
                // У Interwork почему-то попадают инвойсы с текущей датой и датой следующего дня                
//                if($_GET['createdDate'].'T00:00:00+02:00' != $res[$i]['date'])
//                    continue;
                
                // Создаем массив для строки и в пример берем заголовки
                foreach($header as $item)
                {
                    $ar[$item] = $this->trimEx($res['data'][$i][$item]);
                }
                $ar['date'] = date('Y-m-d', strtotime($ar['date']));
                $ar['dueDate'] = date('Y-m-d', strtotime($ar['dueDate']));

                $str[] = $this->view->addString($ar);
            }
        }
        $this->generateQuery($res, $str);

    }
    
    
    
    
    // Данные по инвойсу
    // http://api.interworks.muk.ua/api/invoices/?invoiceCode=000478&html=1
    function invoiceData($vars)
    {

        $url = $vars['url']['redirect_url'].'?'.http_build_query($_GET);
        
        $this->interWorksOption['url'] = $url;
        
        // Отправляем запрос в interWorks
        $res = $this->interworks->query($this->interWorksOption);
// echo '<pre>'.print_r($res, true).'</pre>'; exit;
        $header = [
            'id',
            'billingPeriodStart',
            'billingPeriodEnd',
            'product' => ['id', 'code', 'name'],
            'productType' => ['id', 'name'] ,
            'unit',
            'costPrice',
            'finalPrice',
            'costTotal',
            'finalTotal',
            'subscriptions' => ['id', 'name', 'externalId', 'quantity', 'startDate', 'endDate', 'status', 'account' => ['id', 'name'], 'addonId'],
            'info' => ['total', 'unitPrice', 'finalUnitPrice', 'quantity', 'priceProtectionPeriodEndDate', 'protecetedSalesPrice']
        ];


        $fields = $this->addHeader($header);
        $str[] = $this->view->addString($fields);


        if(!isset($res['data']))
        {
            $this->generateQuery($res, $str);
            exit;
        }
        
        $workString = [];
        
        for($i = 0; $i < count($res['data']); $i++)
        {
            $ar_temp['id'] = $res['data'][$i]['id'];
            $ar_temp['productId'] = $res['data'][$i]['product']['id'];
            $ar_temp['productCode'] = $res['data'][$i]['product']['code'];
            $ar_temp['productName'] = $res['data'][$i]['product']['name'];
            $ar_temp['productTypeId'] = $res['data'][$i]['productType']['id'];
            $ar_temp['productTypeName'] = $res['data'][$i]['productType']['name'];
            $ar_temp['unit'] = $res['data'][$i]['unit'];
            $ar_temp['billingPeriodStart'] = date('Y-m-d', strtotime($res['data'][$i]['billingPeriodStart']));
            $ar_temp['billingPeriodEnd'] = date('Y-m-d', strtotime($res['data'][$i]['billingPeriodEnd']));

            
            //////////////////////////////////////////////////////////////
            // 
            // Если это продукт Azure
            //
            //////////////////////////////////////////////////////////////
            if($res['data'][$i]['product']['code'] == azureProductCode)
            {
                $ar = $ar_temp;
                
                $ar['costPrice'] = $ar['finalPrice'] =  $ar['costTotal'] = $ar['finalTotal'] = 0;
                
                $ar['quantity'] = 1;

                if(is_array($res['data'][$i]['usageRecords']))
                {
                    // Считаем общую сумму
                    foreach($res['data'][$i]['usageRecords'] as $usageRecordsItem)
                    {
                        $ar['costPrice'] = floatval($usageRecordsItem['costPrice']); // себестоимость
                        $ar['finalPrice'] = floatval($usageRecordsItem['finalPrice']); // продажа партнеру

                        $ar['costTotal'] += floatval($usageRecordsItem['quantity']) * floatval($usageRecordsItem['costPrice']); // - себестоимость
                        $ar['finalTotal'] += floatval($usageRecordsItem['quantity']) * floatval($usageRecordsItem['finalPrice']);//  - продажа партнеру
                    }
                }
                
                if(isset($res['data'][$i]['subscriptions'][0]))
                {
                    $ar = array_merge($ar, $this->getSubscriptionsData($res['data'][$i]['subscriptions'][0], $vars));
                }
                
//                echo '<pre>'.print_r($ar, true).'</pre>';
                // Артем попросил не показывать строки с нулевыми ценами
                //if($ar['costTotal'] > 0)
                    $str[] = $this->view->addString($ar, $fields);
            }
            
            //////////////////////////////////////////////////////////////
            // 
            // Если это не Azure
            //
            //////////////////////////////////////////////////////////////
            else
            {
                $ar_temp['costPrice'] = $res['data'][$i]['costPrice'];
                $ar_temp['finalPrice'] = $res['data'][$i]['finalPrice'];
                
                foreach($res['data'][$i]['subscriptions'] as $k => $z)
                {
                    
                    $ar_temp = array_merge($ar_temp, $this->getSubscriptionsData($z, $vars));
                    
                    $ar_temp['costTotal']  = floatval($ar_temp['subscriptionsQuantity']) * floatval($ar_temp['costPrice']); // !!!!!!!!!!!!!!!!!!!!!!!!
                    $ar_temp['finalTotal'] = floatval($ar_temp['subscriptionsQuantity']) * floatval($ar_temp['finalPrice']); // !!!!!!!!!!!!!!!!!!!!!!!!
   
                    if($res['data'][$i]['subscriptions'][0]['addonId'] != '00000000-0000-0000-0000-000000000000') // $res['data'][$i]['id']
                    {
                        $addon = $res['data'][$i]['subscriptions'][0]['addonId'];
                        
                        if(!isset($workString[$addon]))
                        {
                            $str[] = $this->view->addString($ar_temp, $fields);
                            
                            $workString[$addon] = &$str[count($str)-1];
                        }
                        else
                        {
                            $ar = &$workString[$addon];
                            
                            $ar['costTotal'] += $ar_temp['costTotal'];
                            $ar['finalTotal'] += $ar_temp['finalTotal']; 
                            $ar['subscriptionsQuantity'] += $ar_temp['subscriptionsQuantity']; 
                        }   
                    }
                    else
                    {
                        $str[] = $this->view->addString($ar_temp, $fields);
                    }                              

                }

            }
        }
        
        

        $this->generateQuery($res, $str);
    }
    
    
    
    
    // Данные о подписке которые есть в инойсе
    function getSubscriptionsData($subscription, &$vars)
    {
        $ar['subscriptionsName'] = $subscription['name'];
        $ar['subscriptionsAccountId'] = $subscription['account']['id'];
        $ar['subscriptionsAccountName'] = $subscription['account']['name'];
        $ar['subscriptionsQuantity'] = $subscription['quantity'];
        $ar['subscriptionsExternalId'] = $subscription['externalId'];
        $ar['subscriptionsId'] = $subscription['id'];
        $ar['subscriptionsStartDate'] = date('Y-m-d', strtotime($subscription['startDate']));
        $ar['subscriptionsEndDate'] = date('Y-m-d', strtotime($subscription['endDate']));
        $ar['subscriptionsStatus'] =  $subscription['status'];
        $ar['subscriptionsAddonId'] =  $subscription['addonId'];
        
        
        $ar = array_merge($ar, $this->getSubscriptionsPricingInfo($subscription['id'], $vars));
            
        return $ar;
    }
    
    
    
    // Информация о прайсе подписки
    function getSubscriptionsPricingInfo($id, &$vars)
    {
        
//        $subscription = new Subscriptions($this->vars);
//        $resInfo = $subscription->subscriptionsPricingInfoQuery($id, $vars);
//echo '/api/Subscriptions/'.$id.'/pricingInfo<br>';
        $this->interWorksOption['url'] = '/api/Subscriptions/'.$id.'/pricingInfo';
        $resInfo = $this->interworks->query($this->interWorksOption);
//echo '<pre>'.print_r($resInfo, true).'</pre>'; exit;
        $ar['infoTotal'] = @$resInfo['total'];
        $ar['infoUnitPrice'] = @$resInfo['unitPrice'];
        $ar['infoFinalUnitPrice'] = @$resInfo['finalUnitPrice'];
        $ar['infoQuantity'] = @$resInfo['quantity'];
        $ar['infoProtecetedSalesPrice'] = @$resInfo['priceProtection']['protectedSalesPrice'];
        
        $ar['infoPriceProtectionPeriodEndDate'] = '';
        if(isset($resInfo['priceProtection']['periodEndDate']))
            $ar['infoPriceProtectionPeriodEndDate'] = date('Y-m-d', strtotime($resInfo['priceProtection']['periodEndDate']));
        
        return $ar;
    }
    
    
    // Должно быть в классе Subscriptions
    // Как должно быть правильно:
    // http://api.interworks.muk.ua/api/Subscriptions/c26a274e-eeab-4a01-82d0-d4904222e841/characteristics
    
    // Как сейчас работает
    // http://api.interworks.muk.ua/api/invoices/c26a274e-eeab-4a01-82d0-d4904222e841/characteristics
    function getSubscriptionsCharacteristics($vars)
    {
//        echo '<pre>'.print_r($vars, true).'</pre>'; exit;
        $urlAr = explode('/', $vars['url']['redirect_url']);
        
        $this->interWorksOption['url'] = '/api/Subscriptions/'.$urlAr[3].'/characteristics';
        $resInfo = $this->interworks->query($this->interWorksOption);
        
        echo '<pre>'.print_r($resInfo, true).'</pre>'; exit;
    }
    
    
    // Не понятно где используется УДАЛИТЬ!!!!!!
    function getInvoiceByProduct($vars)
    {
        $get = $_GET;
        if(isset($get['html']))
            unset($get['html']);
                                                             
        $url = $vars['url']['redirect_url'].'?'; //http_build_query($_GET); 
        //$url = '/api/invoices?invoiceDate='.$_GET['createdDate']; 
        $this->interWorksOption['url'] = $url;
        
        $res = $this->interworks->query($this->interWorksOption);
        
        var_dump($res);
    }
    
    
    // Помечаем инвойс как оплаченый  НЕ НАДО ДЕЛАТЬ
    // /api/Invoices/{invoiceId}/markpaid
    function invoicePaid($vars)
    {
        $urlAr = explode('/', $vars['url']['redirect_url']);
        
        $this->interWorksOption['url'] = '/api/Invoices/'.$urlAr[3].'/markpaid'; // $vars['url']['redirect_url'];
        
        $this->interWorksOption['post'] = 0;
        $this->interWorksOption['httpGet'] = 0;
        $this->interWorksOption['put'] = 1;
        $this->interWorksOption['postField'] = http_build_query(['invoiceId' => $urlAr[3]]);
        
        $this->interWorksOption['url'] = $vars['url']['redirect_url'];
        
        
        
        $res = $this->interworks->query($this->interWorksOption);
        
        var_dump($res);
//        echo 1;
        // /api/Invoices/{invoiceId}/markpaid
        
//        return $ar;
    }
    
    
    
}