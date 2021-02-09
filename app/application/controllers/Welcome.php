<?

class Welcome extends MyController
{
    function __construct($vars)
    {
        parent::__construct($vars);
        
    }
    
    
    function index()
    {
        require_once($_SERVER['DOCUMENT_ROOT'].'/public/index.html');
        exit;
    }
}
