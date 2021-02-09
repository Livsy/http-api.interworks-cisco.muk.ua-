<?
    class Routes extends Functions
    {
        var $redirect_url;


        var $url = [];    // Массив со списком разрешенных адресов
		
		var $class;
        
        var $method;
        
        var $urlArr = [];
		


        // --- Новое решение ---
        function __construct()
        {
            $this->redirect_url = $this->get_redirect_url();

            $this->url = $this->settings('url');
                        
            if(!$url_level_1 = $this->get_url_level_1())
            {

                if(!strlen($this->redirect_url))
                    $url_level_1 = 'welcome';
                else
                    $this->error_page(404, 'Not Found', 'Сопоставление адресной строки методом обработки не найдены');
            }
//  var_dump($url_level_1); exit;                      
            $url_level_2_list = array_merge(explode('/', $this->redirect_url), array_keys($_GET));
                
            $url_level_2 = array_values(array_intersect(array_keys($this->url[$url_level_1]), $url_level_2_list));
//var_dump($this->url[$url_level_1]); exit;                      
//var_dump($url_level_2_list); exit;
            $classStr = ucfirst(str_replace('/api/', '', $url_level_1));
            
            if(!count($url_level_2))
            {
                $url_level_1 = 'welcome';
                $methodName = $url_level_2[0] = 'index';
            }
      
            if(count($url_level_2) == 0 || !isset($url_level_2[0]))
            {
                $this->error_page(404, 'Not Found', 'Не найден метод обработки');
            }
            else
            {
                $methodName = $this->url[$url_level_1][$url_level_2[0]];
            }

            
            $this->class = $classStr;
            $this->method = $methodName;
            
            $this->urlArr = ['url' => [
                'level1' => $url_level_1, 
                'level2' => $url_level_2[0], 
                'redirect_url' => $this->redirect_url
            ]];
        } // End __construct()
        
        
        
        function getData()
        {
            return ['class' => $this->class, 'method' => $this->method, 'url' => $this->urlArr];
        }


        //
        // Получаем redirect_url
        //
        function get_redirect_url()
        {
            $this->redirect_url = !isset($_SERVER['REDIRECT_URL']) || empty($_SERVER['REDIRECT_URL']) ? '' : $_SERVER['REDIRECT_URL'];

            // Приводим REDIRECT_URL к общему виду (без слеша в конце)
            return rtrim($this->redirect_url, '/');
        }


        //
        // Поиск существования индекса в массве url первого уровня
        //
        function get_url_level_1()
        {
            $url = false;

            foreach($this->url as $k => $z)
            {
                if(mb_strpos($this->redirect_url, $k) !== false)
                    $url = $k;
            }

            return $url;
        }






    } // End class getEvent