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


        echo $str;

        $this->saveLog(['Method' => 'validateSettingFieldsURL', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);
        exit;
    }


    // Get Service Definitions URL
    function getServiceDefinitionsURL()
    {
        header('Content-Type: application/json');

        echo $str =  <<<EOT
{
    "ProductTypes": [
 {
     "ID": "myservice",
     "Name": "Example Service",
     "Description": "The definition of an example service",
     "AllowMultipleSubscriptions": true,
     "AutoExecuteAddonCancelRequest": false,
     "AutoExecuteSubscriptionCancelRequest": false,
     "AutoExecuteSubscriptionDowngradeRequest": false,
     "QuantityLimit": 0,
     "QuantityLimitLocked": false,
     "Scope": "Both",
     "PortalURL": "https://portal.vendor.com"
     "Restrictions": null,
     "ExtraParameters": null,
     "AttributeList": [
           {
               "Usage": "ProductCharacteristic",
             "Kind": "Numeric",
             "ID": "valueNumeric",
             "SortOrder": 1,
             "Name": "Numeric value",
             "Description": "Type a numeric value to define service attribute",
             "UsageSpecified": true,
             "KindSpecified": true,
             "IsRequired": true,
             "IsSyncLocked": 0,
             "LinkedToQuantity": false,
             "AllowUnlimited": false,
             "PredefinedValues": [],
             "ExtraParameters": null,
             "SliderMin": 0,
             "SliderMax": 0,
             "SliderStep": 0
          },
          {
              "Usage": "OrderCharacteristic",
             "Kind": "PredefinedChooseOne",
             "ID": "valueList",
             "SortOrder": 2,
             "Name": "List value",
             "Description": "Select a value from the list to define service attribute",
             "UsageSpecified": true,
             "KindSpecified": true,
             "IsRequired": true,
             "IsSyncLocked": 0,
             "LinkedToQuantity": false,
             "AllowUnlimited": false,
             "PredefinedValues": [
                       {
                           "ID": "1",
                           "Code": "1",
                           "Name": "Value 1",
                           "IsDefault": false,
                           "ResourceId": 0
                       },
                       {
                           "ID": "2",
                           "Code": "2",
                           "Name": "Value 2",
                           "IsDefault": false,
                           "ResourceId": 0
                       },
                       {
                           "ID": "3",
                           "Code": "3",
                           "Name": "Value 3",
                           "IsDefault": false,
                           "ResourceId": 0
                       },
                       {
                           "ID": "4",
                           "Code": "4",
                           "Name": "Value 4",
                           "IsDefault": false,
                           "ResourceId": 0
                       }
                 ],
             "ExtraParameters": null,
             "SliderMin": 0,
             "SliderMax": 0,
             "SliderStep": 0
 },
 {
     "Usage": "ProductCharacteristic",
             "Kind": "Boolean",
             "ID": "valueCheckbox",
             "SortOrder": 3,
             "Name": "Bool value",
             "Description": "Check to define service attribute",
             "UsageSpecified": true,
             "KindSpecified": true,
             "IsRequired": true,
             "IsSyncLocked": 0,
             "LinkedToQuantity": false,
             "AllowUnlimited": false,
             "PredefinedValues": [],
             "ExtraParameters": null,
             "SliderMin": 0,
             "SliderMax": 0,
             "SliderStep": 0
 },
 {
     "Usage": "ProductCharacteristic",
             "Kind": "PredefinedChooseMany",
             "ID": "valueCheckboxes",
             "SortOrder": 4,
             "Name": "Multiple checkboxes value",
             "Description": "Select multiple values from the list to define service attribute",
             "UsageSpecified": true,
             "KindSpecified": true,
             "IsRequired": true,
             "IsSyncLocked": 0,
             "LinkedToQuantity": false,
             "AllowUnlimited": false,
             "PredefinedValues": [
                     {
                         "ID": "1",
                        "Code": "1",
                        "Name": "Value 1",
                        "IsDefault": false,
                        "ResourceId": 0
                     },
                     {
                         "ID": "2",
                        "Code": "2",
                        "Name": "Value 2",
                        "IsDefault": false,
                        "ResourceId": 0
                     },
                     {
                         "ID": "3",
                        "Code": "3",
                        "Name": "Value 3",
                        "IsDefault": false,
                        "ResourceId": 0
                     },
                     {
                         "ID": "4",
                        "Code": "4",
                        "Name": "Value 4",
                        "IsDefault": false,
                        "ResourceId": 0
                     }
               ],
               "ExtraParameters": null,
               "SliderMin": 0,
               "SliderMax": 0,
               "SliderStep": 0
 }
 ]
 }
 ]
}
EOT;
        $this->saveLog(['Method' => 'getServiceDefinitionsURL', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);

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

        echo $str =  <<<EOT
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
        $this->saveLog(['Method' => 'accountSynchronizeURL', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);

        exit;
    }

    // Account Delete URL
    function accountDeleteURL()
    {
        header('Content-Type: application/json');


        echo $str =  <<<EOT
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
        $this->saveLog(['Method' => 'accountDeleteURL', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);

        exit;
    }

    // Account Exists URL
    function accountExistsURL()
    {
        header('Content-Type: application/json');

        echo $str = <<<EOT
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

        $this->saveLog(['Method' => 'accountExistsURL', 'send' => $str, 'sendHeaders' => print_r(headers_list(), true)]);
        exit;
    }




    // Subscription Create URL
    function subscriptionCreateURL()
    {

    }

    // Subscription Update URL
    function subscriptionUpdateURL()
    {

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


}
