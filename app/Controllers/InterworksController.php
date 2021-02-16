<?php namespace App\Controllers;


class InterworksController extends BaseController
{
    function saveLog($data = [])
    {
        $str = "\nStart -----------------\n";

        $str .= "Date: ".date('Y-m-d H:i:s')."\n";

        $str .= 'Headers:'."\n";
        $str .= print_r(apache_request_headers(), true);
        $str .= '$_GET:'."\n";
        $str .= print_r($_GET, true);
        $str .= '$_POST:'."\n";
        $str .= print_r($_POST, true);


        foreach($data as $key => $value)
        {
            $str .= $key.': '.$value."\n";
        }



        $str .= "\nEnd    -----------------\n";

        file_put_contents(__DIR__.'/test.txt', $str, FILE_APPEND);
    }


    function oauth()
    {

        // state='.$_GET['state'].'&code='.$_GET['code']);

        $url = [];
        if(isset($_GET['state']))
        {
            $url[] = 'state='.$_GET['state'];
        }

        if(isset($_GET['code']))
        {
            $url[] = 'code='.$_GET['code'];
        }
//echo 'Ok';
//        echo '{"access_token":"Rii6CFxOqxzhvWb7Mnu97SQx7sSk","token_type":"Bearer","expires_in":3599}';
//    exit;

        $token = openssl_random_pseudo_bytes(16);

//Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);
        /*
        $str = "\n-----------------\nDate: ".date('Y-m-d H:i:s');
        $str = '$_GET:'."\n";
        $str = print_r($_GET, true);
        $str = '$_POST:'."\n";
        $str .= print_r($_POST, true);
        $str = 'Headers:'."\n";
        $str .= print_r(apache_request_headers(), true);
        file_put_contents(__DIR__.'/test.txt', $str, FILE_APPEND);
        */
        $this->saveLog(['Method' => 'oauth', '$token' => $token]);

        if(isset($_GET['redirect_uri']))
        {
            //header('Location: '.$_GET['redirect_uri'].'?'.http_build_query($url));
            header('Location: '.$_GET['redirect_uri'].'?'.'response_type='.$_GET['response_type'].'&state='.$_GET['state'].'&code='.$token);
        }
        else
        {
            echo '{"access_token":"'.$token.'","token_type":"Bearer","expires_in":3599}';
        }
        exit;
    }



    function token()
    {
        header('Content-Type: application/json');

        $this->saveLog(['Method' => 'token']);

        echo '{"access_token":"Rii6CFxOqxzhvWb7Mnu97SQx7sSk","token_type":"Bearer","expires_in":3599}';

        exit;
    }







    // Get Setting Fields URL
    // http://api.interworks-cisco.muk.ua/interworks/get_setting_fields_url
    function getSettingFieldsUrl()
    {
        header('Content-Type: application/json');

        echo $str = <<<EOT
{
    "Fields": [
        {
            "ID": "username",
            "Definition": {
                "ID": "username",
                "SortOrder": 0,
                "Name": "User Name",
                "Kind": "Text",
                "Type": "Text",
                "MaxLength": 20,
                "IsRequired": true
            }
        },
        {
            "ID": "password",
            "Definition": {
                "ID": "password",
                "SortOrder": 0,
                "Name": "Password",
                "Kind": "Text",
                "Type": "Text",
                "MaxLength": 20,
                "IsRequired": true
            }
        }
        
    ]
}
EOT;
        $this->saveLog(['Method' => 'getSettingFieldsUrl', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);

exit;


    }



    // Validate Setting Fields URL
    function validateSettingFieldsURL()
    {
        header('Content-type: application/json; charset=utf-8');
        header('Cache-Control: no-cache');

        $str = '[]';
/*
        $str = '{
    "Fields": [
        {
            "ID": "username",
            "Value": "test"
        },
        {
            "ID": "password",
            "Value": "test"
        }
    ]
}';
*/

        echo $str;

        $this->saveLog(['Method' => 'validateSettingFieldsURL', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);
        exit;
    }


    function CiscoProduct1()
    {
        header('Content-Type: application/json');
        echo '[]';
        exit;
    }


    // Get Service Definitions URL
    function getServiceDefinitionsURL()
    {
        header('Content-Type: application/json');

        // Нумерованная документация взята с документации:
        // https://interworkscloud.atlassian.net/wiki/spaces/ICPD/pages/4662870/Defining+your+Product+Types
        // Ссылка:  interworks.cloud_GetServicesDefinition_Questionairre.docx
        // https://interworkscloud.atlassian.net/wiki/download/attachments/4662870/interworks.cloud_GetServicesDefinition_Questionairre.docx?version=1&modificationDate=1551288048087&cacheVersion=1&api=v2


        $ProductTypes = [

            "ID" => "myservice",
            "Name" => "Example Service",
            "Description" => "The definition of an example service",

            // Documentation
            // Если true, то, когда клиент совершает новую покупку продукта, на который у него уже есть активная
            // подписка, система создаст новую подписку с новым количеством заказа вместо добавления нового количества к
            // существующей подписке.
            //
            // Предлагается ли услуга в нескольких редакциях или нет?
            "AllowMultipleSubscriptions" => false,

            // Documentation
            // Раздел определяет, будут ли события отмены для услуг типа продукта завершаться автоматически или они
            // потребуют действий со стороны BSS. Для некоторых автоматически инициализируемых продуктов безопаснее
            // пометить их как ЛОЖЬ, чтобы избежать ошибок клиентов.
            //
            // 9. Есть ли дополнительная услуга, которая предлагается в качестве дополнительной опции к базовой услуге?
            //
            // Автоматическое выполнение запроса на отмену дополнения
            "AutoExecuteAddonCancelRequest" => false,

            // 7. Если у клиента уже есть услуга и он хочет добавить рабочие места, обновляет ли действие увеличения
            // существующая подписка клиента на дополнительное количество или создается новая подписка с количеством новых мест?
            // 11. Разрешено ли конечному пользователю / торговому посреднику напрямую отменить (деинициализировать)
            // Подписку / Актив или вам необходимо контролировать отмену / деинициализацию внутри компании?
            // Автоматическое выполнение запроса на отмену подписки
            "AutoExecuteSubscriptionCancelRequest" => false,

            // Автоматическое выполнение запроса на понижение версии подписки
            "AutoExecuteSubscriptionDowngradeRequest" => false,

            // Documentation
            // Здесь вы можете определить ограничение на количество, которое может быть выбрано для заказа. Например.
            // у вас есть услуга, которая продается по пакету пользователей. В этом случае вы определяете, что он может
            // быть продан с ограничением заказа пакета 1, и каждый пакет содержит X пользователей.
            //
            // Ограничение количества
            "QuantityLimit" => 0,

            // Documentation
            // Если он неактивен, менеджер по продукту может изменить ограничение количества в заказе.
            //
            // 8. Есть ли ограничение на количество заказа, или клиент может приобрести неограниченное (условное) количество услуги?
            //
            // Ограничение количества заблокировано
            "QuantityLimitLocked" => false,

            // Documentation
            // Определяет, кто может покупать продукты из этого типа продукта. Есть три варианта: продукты могут быть
            // приобретены торговым посредником, продукты могут быть приобретены конечным потребителем или и то, и другое.
            //
            // Объем (Both - оба)
            "Scope" => "Both",


            "PortalURL" => "http =>//api.interworks-cisco.muk.ua/interworks/CiscoProduct1",

            // Documentation
            // необязательный
            //
            // Ограничения
            "Restrictions" => null,

            // Documentation
            // необязательный
            //
            // Дополнительные параметры
            // 4. Будет ли услуга предоставлена в виде плана или платформа для обеспечения требует, чтобы вы устанавливали значения для каждой характеристики продукта?
            "ExtraParameters" => null,

            // Список атрибутов
            // 5. В случае, если платформа обеспечения требует установки значений для каждой характеристики продукта, определите характеристики продукта услуги. Пример =>
            // 6.	The characteristics of your products should be defined from the product manager or you need the end Customer's input?
            "AttributeList" => []

    ];
//        echo  json_encode($ProductTypes); exit;

        echo $str =
'{
    "ProductTypes": 
    [
        '.json_encode($ProductTypes).'       
    ]
}';

//        echo $str = '[]';
            $this->saveLog(['Method' => 'getServiceDefinitionsURL', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);

        exit;
    }



    // Subscription Update
    function subscriptionUpdate()
    {
        header('Content-Type: application/json');

        echo $str =  <<<EOT
{
 "AccountExtraInfo": null,
 "Code": 0,
 "Message": "",
 "Result": "2103213618" 
}
EOT;

        //$this->saveLog(['Method' => 'accountGetSyncOptions', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);

        exit;
    }

    function subscriptionActivate()
    {
        header('Content-Type: application/json');

        echo $str =  <<<EOT
{
"AccountExtraInfo": null,
"Code": 0,
"Message": "",
"Result": "2103213618"
}
EOT;

    //$this->saveLog(['Method' => 'accountGetSyncOptions', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);

        exit;
    }


    // Subscription Suspend
    // https://interworkscloud.atlassian.net/wiki/spaces/ICPD/pages/4663901/Service+Management+API+Reference#ServiceManagementAPIReference-SubscriptionSuspend
    function subscriptionSuspend()
    {
        header('Content-Type: application/json');

        echo $str =  <<<EOT
{
 "AccountExtraInfo": null,
 "Code": 0,
 "Message": "",
 "Result": "2103213618" 
}
EOT;

        //$this->saveLog(['Method' => 'accountGetSyncOptions', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);

        exit;
    }






    // Account Get Synchronization Options URL
    // http://api.interworks-cisco.muk.ua/interworks/account_get_sync_options
    function accountGetSyncOptions()
    {
        header('Content-Type: application/json');

        echo $str =  <<<EOT
{
     "Fields": [
	 {
         "ID": "username",
		 "Definition": {
         "ID": "username",
			 "SortOrder": 0,
			 "Name": "Username",
			 "Description": "",
			 "Kind": "SimpleValue",
			 "DataType": "Text",
			 "IsRequired": true,
			 "PredefinedValues": []
		 }
	 }
 ]
}
EOT;
        $this->saveLog(['Method' => 'accountGetSyncOptions', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);

        exit;
    }


    // Account Synchronize URL
    function accountSynchronizeURL()
    {
        header('Content-Type: application/json');
/*
        echo $str =  <<<EOT
{
"ErrorCode": 0,
"ErrorMessage": "This Account id Don't see",
"Result": ""
}
EOT;
*/
        echo $str = '{"Result": "Ok"}';

        $this->saveLog(['Method' => 'accountSynchronizeURL', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);

        exit;
    }




    // Account Delete URL
    function accountDeleteURL()
    {
        header('Content-Type: application/json');

/*
        echo $str =  <<<EOT
{
"ErrorCode": 0,
"ErrorMessage": "",
"Result": ""
}
EOT;
*/
        echo $str =  '{"Result": "Ok"}';

        $this->saveLog(['Method' => 'accountDeleteURL', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);

        exit;
    }




    // Account Exists URL
    function accountExistsURL()
    {
        header('Content-Type: application/json');


/*
        echo $str = <<<EOT
{
"ErrorCode": 0,
"ErrorMessage": "",
"Result": ""
}
EOT;
*/
        echo $str =  '{"Result": "Ok"}';

        $this->saveLog(['Method' => 'accountExistsURL', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);

        exit;
    }




    // Subscription Create URL
    function subscriptionCreateURL()
    {
        header('Content-Type: application/json');

        echo $str =  <<<EOT
{
 "AccountExtraInfo": null,
 "Code": 1,
 "Message": "Ok",
 "Result": "2103213618" 
}
EOT;



        $this->saveLog(['Method' => 'subscriptionCreateURL', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);

        exit;
    }











    function customerPost()
    {
// Нечто похожее на данные
// https://interworkscloud.atlassian.net/wiki/spaces/ICPD/pages/95191554/Accounts+orderby
// https://interworkscloud.atlassian.net/wiki/spaces/ICPD/pages/4663901/Service+Management+API+Reference#ServiceManagementAPIReference-AccountGetSyncOptions


        header('Content-Type: application/json, utf-8');

        $this->saveLog(['Method' => 'customerPost']);
/*
        $str = print_r($_GET, true);
        $str .= print_r($_POST, true);
        $str .= print_r(apache_request_headers(), true);
        file_put_contents(__DIR__.'/test.txt', $str, FILE_APPEND);
*/
/*
        echo <<<EOT
{
    "GivenName":"test"
}

EOT;
        exit;

*/

        echo <<<EOT
{
    "Id":"32345",
    "SyncToken":"",
    "MetaData": {
        "CreateTime": "2020-01-09",
        "LastUpdatedTime": "2021-01-01"
    },
    "GivenName":"",
    "DisplayName":"",
    "PrimaryPhone":{"FreeFormNumber":"1234567890"},
    "Fax":{"FreeFormNumber":""},
    "PrimaryEmailAddr":{"Address":""},
    "WebAddr":{"URI":"https://test.ru"},
    "Taxable":"true",
    "TaxExemptionReasonId":"",
    "BillAddr":{
        "Line1":"", 
        "Line2":"", 
        "City":"", 
        "Country":"Ukraine", 
        "PostalCode":"", 
        "CountrySubDivisionCode":""},
    "CurrencyRef":{"value":"", "name":""},
    "Sparse":""
}

EOT;
        exit;

/*
echo <<<EOT
{
  "SyncToken": "",
  "Id": "",
  "GivenName": "",
  "PrimaryPhone": {
            "FreeFormNumber": ""
  },
   "WebAddr": {
            "URI": ""
  },
 "MetaData": {
            "CreateTime": "",
    "LastUpdatedTime": ""
  },
  "sparse": true
}
EOT;
        exit;
*/
        echo <<<EOT
{
  "GivenName": "",
  "PrimaryPhone": {
            "FreeFormNumber": ""
  },
  "PrimaryEmailAddr": {
            "Address": ""
  },
  "WebAddr": {
            "URI": ""
  },
  "MetaData": {
          "CreateTime": "",
      "LastUpdatedTime": ""
  }
}
EOT;
exit;
/*

{
	 "ID": "13",
	 "ExternalID": "",
	 "ResellerID": null,
	 "ResellerExternalID": null,
	 "Name": "My Reseller",
	 "Code": "ress",
	 "Phone": "",
	 "Fax": "",
	 "WebSite": "",
	 "Email": "my@r.com",
	 "Description": "",
	 "ExtraDetails": {},
	 "SyncOptions": {
		 "username": "test"
	 },
	 "ContactDetails": {
		 "ID": "16",
		 "FirstName": "Stelios",
		 "LastName": "Reseller",
		 "Phone": "",
		 "Fax": "",
		 "Email": "my@r.com"
	 }
}
EOT;
*/
/*
echo '{
    "Id":"",
    "SyncToken":"",
    "DisplayName":"",
    "PrimaryPhone":{"FreeFormNumber": ""},
    "PrimaryEmailAddr":{"Address": ""},
}';
*/
    }

    // Addon Create
    // https://interworkscloud.atlassian.net/wiki/spaces/ICPD/pages/4663901/Service+Management+API+Reference#ServiceManagementAPIReference-AddonCreate
    function addonCreate()
    {
        header('Content-Type: application/json');

        echo $str =  <<<EOT
{
 "Code": 0,
 "Message": "",
 "Result": "2103213618" 
}
EOT;

//        $this->saveLog(['Method' => 'subscriptionCreateURL', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);

        exit;
    }



    // Addon Update
    // https://interworkscloud.atlassian.net/wiki/spaces/ICPD/pages/4663901/Service+Management+API+Reference#ServiceManagementAPIReference-AddonUpdate
    function addonUpdate()
    {
        header('Content-Type: application/json');

        echo $str =  <<<EOT
{
 "Code": 0,
 "Message": "",
 "Result": "2103213618" 
}
EOT;

//        $this->saveLog(['Method' => 'subscriptionCreateURL', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);

        exit;
    }

    // Addon Delete / Addon Cancel URL
    // https://interworkscloud.atlassian.net/wiki/spaces/ICPD/pages/4663901/Service+Management+API+Reference#ServiceManagementAPIReference-AddonDelete
    function addonDelete()
    {
        header('Content-Type: application/json');

        echo '[]'; exit;

        echo $str =  <<<EOT
{
 "Code": 0,
 "Message": "",
 "Result": "2103213618" 
}
EOT;

//        $this->saveLog(['Method' => 'subscriptionCreateURL', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);

        exit;
    }

}
