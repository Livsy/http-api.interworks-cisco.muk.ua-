
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Starter Template for Bootstrap</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    

    <div class="container">

      <div class="starter-template">
        <h1>Unit Test</h1>
        <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>
      </div>

    </div><!-- /.container -->
    
    <div class="container myString">
    
    </div>
    
    
    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    
    <script>
        $( document ).ready(function() {
            var data = {
                0:{
                    'method': 'invoice_invoiceCode',
                    'vars':{
                        'invoiceCode': '002725',
                        'html': '1'
                    }
                },
                1:{
                    'method': 'invoice_invoiceCode',
                    'vars':{
                        'invoiceCode': '002725',
                        'html': '0'
                    }
                },
                2:{
                    'method': 'invoice_getInvoiceByDate',
                    'vars':{
                        'invoiceDate': '2017-12-28',
                        'sort': 'invoiceDate',
                        'order': 'desc',
                        'html': '1'
                    }
                },                
                3:{
                    'method': 'invoice_getInvoiceByDate',
                    'vars':{
                        'invoiceDate': '2017-12-28',
                        'sort': 'invoiceDate',
                        'order': 'desc',
                        'html': '0'
                    }
                },
                4:{
                    'method': 'subscriptions_subscriptionsGetExternalID',
                    'vars':{
                        'subscriptionsId': 'b231c268-bca9-496c-b333-cb659e7a9a1a',
                        'html': '1'
                    }
                },
                5:{
                    'method': 'subscriptions_subscriptionsGetExternalID',
                    'vars':{
                        'subscriptionsId': 'b231c268-bca9-496c-b333-cb659e7a9a1a',
                        'html': '0'
                    }
                },

                6:{
                    'method': 'subscriptions_subscriptionsPricingInfo',
                    'vars':{
                        'subscriptionsId': 'b4f771f6-c197-4ca5-89ac-b1bf6a8154ce',
                        'html': '1'
                    }
                },
                7:{
                    'method': 'subscriptions_subscriptionsPricingInfo',
                    'vars':{
                        'subscriptionsId': 'b4f771f6-c197-4ca5-89ac-b1bf6a8154ce',
                        'html': '0'
                    }
                },
                
            }
            
            
            $.each(data, function(index, value) {
                
                var vars = '';
                $.each(value.vars, function(index, value) {
                    vars += '&'+index+'='+value;
                });
                
                
                $.ajax({
                    url: "http://api.interworks.muk.ua/unittest", 
                    data: 'method='+value.method+vars,
                    async: false,
                    success: function(result){
                        $(".myString").append('<div>'+value.method+'</div><div>'+vars+'</div><div>'+result.status+'</div><hr>');
                    }
                });
                
            });
        });
    
        
    </script>
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"  </script>
    
    
  </body>
</html>
