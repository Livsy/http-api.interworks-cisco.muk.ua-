<?
    class InterWorks
    {

        public $conf = [];

        function __construct($conf)
        {
            $this->conf = $conf;

            //            session_destroy();
            //            session_start();
        }
        
        
        // Получаем Токен (Авторизация)
        function getToken()
        {
            $output = $this->getData([
                'url'           => hostProtocol.host.'/oauth/token',
                'header'        => 1,
                'httpHeader'    => [
                    'Content-Type: application/x-www-form-urlencoded', 
                    'Authorization: Basic ' .base64_encode($this->conf['clientKey'].':'.$this->conf['clientSecret']),
                    'Host:'.$this->conf['host'],
                    'X-Api-Version: 2.2'],
                'post'          => 1,
                'postField'     => http_build_query([
                    'grant_type' => $this->conf['grant_type'],
                    'username'  => $this->conf['username'],
                    'password'  => $this->conf['password']
                ]),
                'httpGet' => 0,
                'getfields'     => [],
            ]);

            $output = explode("\n", $output);

            if(!isset($output[10]))
            {
                echo '{"err":{"msg":"Нет подключения к interworks"; "text":"Возможно отдел Microsoft зашел под нашей учетной записью"}}';
                $this->setLog('Can\'t connect');
                $_SESSION['token'] = false;
                exit;
            }

            $vars = json_decode($output[10]);
//			var_dump($output); exit;
            return (!isset($vars->access_token)) ? false : $_SESSION['token'] = $vars->access_token; 
        }
        

        // Перез запросом я уже вызывают getToken поэтому здесь подключение избыточно!!!!!!!!!!!!!!!!!!!!!
        function query($options)
        {

            $options['url'] =  hostProtocol.host.$options['url'];

            $output = $this->getData($options);
            
            if(!isset($output[0]) || $output[0] == 'HTTP/1.1 500 Internal Server Error')
            {
                $this->setLog('Token is old.');
                return false;
            }

            $vars =  json_decode($output, true);

            return $vars;
        }




        // Отправка запроса по CURL
        function getData($data)
        {
            $ch = curl_init($data['url']);
            curl_setopt($ch, CURLOPT_URL, $data['url']);  

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_HEADER, $data['header']); 
            curl_setopt($ch, CURLINFO_HEADER_OUT, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $data['httpHeader']); 

            if(isset($data['post']) && $data['post'] == 1)
                curl_setopt($ch, CURLOPT_POST, $data['post']);



            //    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
            //    curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);         
            if($data['httpGet'] <> 1)
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data['postField']);
            else
                curl_setopt($ch, CURLOPT_HTTPGET, $data['httpGet']);

            curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14");
            curl_setopt($ch, CURLINFO_OS_ERRNO, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 240); // таймаут соединения
            curl_setopt($ch, CURLOPT_TIMEOUT, 240);        // таймаут ответа
            curl_setopt($ch, CURLOPT_MAXREDIRS, 20);       // останавливаться после 10-ого
            curl_setopt($ch, CURLOPT_HTTP_VERSION, 'HTTP/1.1');

            $output = curl_exec($ch);


            if(curl_errno($ch))
                $this->setLog('Request Error:' . curl_error($ch));

            $info = curl_getinfo($ch); 

            //            echo '<br>Info header<br>';
            //            echo '<pre>'.print_r($info, true).'</pre>';

            curl_close($ch);

            return $output; 
        }


        function setLog($str)
        {
//            file_put_contents(__DIR__.'/InterWorks_'.date('Y.m.d').'.txt', date('H:i:s').' '.$str."\n");
        }
    }