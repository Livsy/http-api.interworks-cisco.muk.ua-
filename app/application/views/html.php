<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <style>
            table{
                border-collapse: collapse; 
            }
            td{
                border: 1px solid #ccc; 
                padding: 5px;
            }
            tr:hover 
            {
                background: #f8f7f7;
            }
            td:hover 
            {
                background: #d9f5f7;
                box-shadow: 0 0 10px rgba(0,0,0,0.5);
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">

            <div class="col-12 col-md-12 col-xl-12 py-md-12 pl-md-12 bd-content">

                <table class="table">
                    <?
//                        echo '<pre>'.print_r($queryStr, true),'</pre>';
                        
                        foreach($queryStr as $item)
                        {
                            echo  '<tr><td>'.implode('</td><td>', $item).'</td></tr>'.excelRows;
                        }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>