<?


	
	class Functions
	{
		////////////////////////////////////////////
		//
		// 		Ошибка 404
		//
		////////////////////////////////////////////
		function error_page($code, $status, $message)
		{
			header("HTTP/1.0 $code $status");
			header("HTTP/1.1 $code $status");
			header("Status: $code $status");
			die($message);
		}
		
		
		////////////////////////////////////////////
		//
		// 		Поиск глобальных переменных
		//
		////////////////////////////////////////////
		function settings($var)
		{
			return isset($GLOBALS[$var]) ? $GLOBALS[$var] : '';
		}
		
        
        
        
        function addToLog($mysql, $str, $res)
        {
            
            // Логирование
            $link = mysqli_connect($mysql['host'], $mysql['user'], $mysql['pass'], $mysql['database']);
            
            $sql = 'INSERT INTO api_log SET 
                link="'.($_SERVER['REDIRECT_URL'].'?'.http_build_query($_GET)).'", 
                post = "'.http_build_query($_POST).'", 
                result_json="'.addslashes(json_encode($res)).'", 
                result_excel="'.addslashes(print_r($res, true)).'", 
                user_agent = "'.$_SERVER['HTTP_USER_AGENT'].'",
                ip = "'.$_SERVER['REMOTE_ADDR'].'"';
            
            mysqli_query($link, $sql);
            
            mysqli_close($link);
        }
		
        
        
        
        
        
        
        
		
		//
        // Генерирование вывода данных на клиент
        //
        function generateQuery(&$res, &$queryStr)
        {
            if(isset($_GET['html']) && $_GET['html'] == 1)
            {
                require_once($_SERVER['DOCUMENT_ROOT'].'/application/views/html.php');
            }
            else
            {
                require_once($_SERVER['DOCUMENT_ROOT'].'/application/views/xml.php');
            }
            
            $this->addToLog($this->settings('mysql'), $queryStr, $res);    
            
            exit;
        }

                
        
        
        
		

		
		
		// Валидация полей от interworks
		function trimEx($str)
		{
			$myStr = '';
			for($i = 0; $i < mb_strlen($str); $i++)
			{
				$char = mb_substr($str, $i, 1);
				if(array_search(ord($char), [60,62,10,13]) === false) // 98, 114,
					$myStr .= $char;
			}

			return $myStr;
		}
		
		
		
        
        // Пробразовываем многомерный массив в одномерный (для заголовков)
        function addHeader(&$ar, $prefix = '')
        {
            $titleAr = [];
            foreach($ar as $k => $item)
            {
                if(is_array($item))
                {
                    $substring = $this->addHeader($item, (strlen($prefix) ? $prefix.ucfirst($k) : $k));
                    $titleAr = array_merge($titleAr, $substring);
                }
                else
                {
                    $titleAr[] = (strlen($prefix) > 0 ? $prefix.ucfirst($item) : $item);
                }
            }
            
            return $titleAr;
        }
		
		
		
	}

