<?
class Unittest
{
    function __construct()
    {
        
    }
    
    function getData()
    {
        if(isset($_GET['method']))
        {
            $method = $_GET['method'];
            unset($_GET['method']);
            header('Content-Type: application/json');
            echo json_encode($this->$method($_GET));
        }
        else
        {
            require_once $_SERVER['DOCUMENT_ROOT'].'application/views/unit.php';    
        }
        
        
//        $GLOBALS['url'];

//        $status = $this->invoice_invoiceCode(['invoiceCode' => '002725', 'html' => '&html=1']);
//        $status = $this->invoice_invoiceCode(['invoiceCode' => '002725']);
        
//        var_dump($status);
    }
    
    
    function invoice_invoiceCode($vars = ['invoiceCode' => '002725', 'html' => '1'] )
    {
        $str = sprintf('http://api.interworks.muk.ua/api/invoices/?invoiceCode=%s&html=%s',  $vars['invoiceCode'], $vars['html']);
        
        $message = ['class' => 'Invoice', 'method' => 'invoiceCode'];
        
        return $this->getDataObject($str, $message, $vars, __FUNCTION__);
        
        /*
        $textServer = $this->getCurlData($str);
        
        $file = $_SERVER['DOCUMENT_ROOT'].'application/models/unittest/'.__FUNCTION__.'_'.implode('_', $vars).'txt';
        
        if($textFile = @file_get_contents($file))
        {
           return array_merge($message, ['status' => (md5($textFile) !=  md5($textServer) ? false : true)]);
        }
        else
        {
            file_put_contents($file, $textServer);
            return array_merge($message, ['status' => 'new']);
        }
        */
    }
    
    
    function invoice_getInvoiceByDate($vars = ['invoiceDate' => '2017-12-28', 'sort' => 'invoiceDate', 'order' => 'desc', 'html' => 1])
    {
        $str = 'http://api.interworks.muk.ua/api/invoices?'.http_build_query($vars);
        
        $message = ['class' => 'Invoice', 'method' => 'getInvoiceByDate'];
        
        return $this->getDataObject($str, $message, $vars, __FUNCTION__);
    }


    function subscriptions_subscriptionsGetExternalID($vars = ['subscriptionsId' => 'b231c268-bca9-496c-b333-cb659e7a9a1a', 'html' => 1])
    {
        $str = 'http://api.interworks.muk.ua/api/Subscriptions/'.$vars['subscriptionsId'].'/attributes/get-externalId?html='.$vars['html'];
        
        $message = ['class' => 'Subscriptions', 'method' => 'subscriptionsGetExternalID'];
        
        return $this->getDataObject($str, $message, $vars, __FUNCTION__);
    }  
    
    
    function subscriptions_subscriptionsPricingInfo($vars = ['subscriptionsId' => 'b4f771f6-c197-4ca5-89ac-b1bf6a8154ce'])
    {
        $str = 'http://api.interworks.muk.ua/api/Subscriptions/'.$vars['subscriptionsId'].'/pricingInfo';
        
        $message = ['class' => 'Subscriptions', 'method' => 'subscriptionsPricingInfo'];
        
        return $this->getDataObject($str, $message, $vars, __FUNCTION__);
    }
    
    
    
    
    
    
    
    
    function getDataObject($uri, $message, $vars, $function)
    {
        $textServer = $this->getCurlData($uri);
        
        $file = $_SERVER['DOCUMENT_ROOT'].'application/models/unittest/'.$function.'_'.implode('_', $vars).'.txt';
        
        if($textFile = @file_get_contents($file))
        {
           return array_merge($message, ['status' => (md5($textFile) !=  md5($textServer) ? false : true)]);
        }
        else
        {
            file_put_contents($file, $textServer);
            return array_merge($message, ['status' => 'new']);
        }
    }
    
    
    function getCurlData($url)
    {
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL,$url); // set url to post to 
        curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable 
        curl_setopt($ch, CURLOPT_TIMEOUT, 20); // times out after 4s 
        curl_setopt($ch, CURLOPT_USERAGENT, 'UnitTest Opera/9.80 (Windows NT 5.1; U; ru) Presto/2.7.62 Version/11.01');
        $result = curl_exec($ch); // run the whole process 
        curl_close($ch);   
        return $result;
    }
}