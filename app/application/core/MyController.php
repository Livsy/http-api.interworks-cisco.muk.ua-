<?

class MyController extends Functions
{
    
    var $interworks;
    
    var $interWorksOption;
    
    var $token;
    
    var $view;
    
    function __construct(&$vars)
    {
        $this->interworks = new InterWorks($this->settings('confInterworks'));
        
        $this->token = $this->interworks->getToken();
//var_dump($this->token); exit;
        // Значения пакета по умолчанию для отправки в interWorks
        $this->interWorksOption = [
            'url'           => '', 
            'header'        => 0,
            'httpHeader'    => [
                'X-Api-Version: 2.2',
                'Authorization: Bearer '.($_SESSION['token'] ?? '') //$this->token,
            ],
            'post'          => 0,
            'postField'     => '',
            'httpGet'       => 1,             
            'getfields'     => []
        ];
        
        if(isset($vars['view']))
            $this->view = new $vars['view'];
    }
}