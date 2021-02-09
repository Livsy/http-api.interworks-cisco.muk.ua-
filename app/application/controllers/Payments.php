<?
class Payments extends MyController
{
    var $vars;
    
    
    function __construct($vars)
    {
        parent::__construct($vars);
        
        $this->vars = $vars;
        
    }
    
    // Добавление оплаты
    // /api/Payments/add
    // http://test.api.interworks.muk.ua/api/payments/add?invoiceId=12F0B6C0-AF04-4875-AC26-8295B3C75FEA&amount=100&paymentMethod=Net%2030&transactionFee=0&paymentDate=2017-11-02&dueDate=2017-11-17&accountId=3337&responsibleUser=901
    /*
        accountId=2690
        invoiceId = ???
        paymentMethod=Net%2015
        paymentDate=2017-11-02
        dueDate=2017-11-17
        amount=100
        transactionFee=100
        chequeNo
        chequePayTo
        chequeBank
        transactionId=1C31BAD5-2CC1-4056-94D2-3B92A3D3B99C
        responsibleUser
        comments
        
        
        
        
        
    */
    
    function addPayment($vars)
    {
        $post = $_GET;
        
        $post['paymentDate'] = str_replace('-', '/', $post['paymentDate']);
        $post['dueDate'] = str_replace('-', '/', $post['dueDate']);
/*        
        $post = [
            'accountId'     => 3337,
            'invoiceId'     => '12F0B6C0-AF04-4875-AC26-8295B3C75FEA',
            'paymentMethod' => 'Net 30',
            'paymentDate'   => '2019/01/31',
            'dueDate'       => '2019/01/31',
            'amount'        => 100,
            'transactionFee'=> 0,
            'chequeNo'      => '',
            'chequePayTo'   => '',
            'chequeBank'    => '',
            'transactionId' => '',
            'responsibleUser'=> 901,
            'comments'      => 'pay by Api'
        ];
*/

        $postDefault = [
            'accountId'     => '',
            'invoiceId'     => '',
            'paymentMethod' => '',
            'paymentDate'   => '',
            'dueDate'       => '',
            'amount'        => '',
            'transactionFee'=> 0,
            'chequeNo'      => '',
            'chequePayTo'   => '',
            'chequeBank'    => '',
            'transactionId' => '',
            'responsibleUser'=> '',
            'comments'      => 'pay by Api'
        ];
        
        $post = array_merge($postDefault, $post);
        


//        echo '<pre>'.print_r($post, true).'</pre>';
        
/*
        $post = [
          "accountId" =>        (isset($_GET['accountId']) ? $_GET['accountId'] : ''),
//          "invoiceId": "string",
          
          "paymentMethod" =>    (isset($_GET['paymentMethod']) ? $_GET['paymentMethod'] : ''),
          "paymentDate" =>      (isset($_GET['paymentDate']) ? $_GET['paymentDate'] : ''),
          "dueDate" =>          (isset($_GET['dueDate']) ? $_GET['dueDate'] : ''),
          "amount" =>           (isset($_GET['amount']) ? $_GET['amount'] : ''),
          "transactionFee" =>   (isset($_GET['transactionFee']) ? $_GET['transactionFee'] : ''),
//          "chequeNo": "string",
//          "chequePayTo": "string",
//          "chequeBank": "string",
          "transactionId" =>    (isset($_GET['transactionId']) ? $_GET['transactionId'] : ''),
//          "responsibleUser": "string",
          "comments" => "Pay by API"
        ];
*/
        
        $this->interWorksOption['url'] = '/api/Payments/add'; // $vars['url']['redirect_url'];
        
        $this->interWorksOption['post'] = 1;
        $this->interWorksOption['httpGet'] = 0;
        $this->interWorksOption['postField'] = http_build_query($post);
        
        $res = $this->interworks->query($this->interWorksOption);
//        var_dump($res);
        echo $res != 'The payment was added sucessfully' ? 'Оплата отклонена' : 'Ok';

    }
}