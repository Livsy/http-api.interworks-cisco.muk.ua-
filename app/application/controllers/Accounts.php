<?

class Accounts extends MyController 
{
    function __construct($vars)
    {
        parent::__construct($vars);
        
    }
    
    
    // Get Account Balance
    // http://api.interworks.muk.ua/api/accounts/2792/balance
    function accountBalance($vars)
    {
        
        $this->interWorksOption['url'] = $vars['url']['redirect_url'];//'?'.http_build_query($_GET);;

        // Отправляем запрос в interWorks
        $res = $this->interworks->query($this->interWorksOption);
        
        
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


        $str[] = $this->view->addString($header);

        if(!isset($res['Type']) && count($res) > 0)
        {
            for($i = 0; $i < count($res); $i++)
            {
                // Создаем массив для строки и в пример берем заголовки
                foreach($header as $item)
                {
                    $ar[$item] = $this->trimEx((isset($res[$i][$item]) ? $res[$i][$item] : (isset($res[$item]) ? $res[$item] : '!!!Error!!!')));
                }

                $str[] = $this->view->addString($ar);

                if(isset($res[$item])) break;
            }
        }

        $this->generateQuery($res, $str);
    }
    
    
    
    
    // http://api.interworks.muk.ua/api/accounts/2792
    function accountsInfo($vars)
    {
        
        $this->interWorksOption['url'] = $vars['url']['redirect_url'];//'?'.http_build_query($_GET);;
        
        // Отправляем запрос в interWorks
        $res = $this->interworks->query($this->interWorksOption);

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

        $str[] = $this->view->addString($header);

        if(isset($res[0]))
        {
            for($i = 0; $i < count($res); $i++)
            {
                // Создаем массив для строки и в пример берем заголовки
                $ar = [];
                foreach($header as $item)
                {
                    $ar[$item] = $this->trimEx($res[$i][$item]);
                }

                $str[] = addString($ar);


            }
        }
        else
        {
            foreach($header as $item)
            {
                $ar[$item] = $this->trimEx($res[$item]);
            }

            $str[] = $this->view->addString($ar);
        }

        $this->generateQuery($res, $str);

    }
}