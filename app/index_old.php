<?

/////////////////////////////////////////////
///     Рабочая версия                    ///      
/////////////////////////////////////////////

	$i = 0;
    $str = [];
    $num = [];
    createExcel($res, $num, 0, $str, 'parentID');    
    
    $excel = '';
    foreach($str as $item)
    {
        $excel .= $item.'+++++'.excelRows;
    }
    echo $excel;
    
    /*
    *   $res - Массив
    *   $num - 
    *   $level - Уровень (глубина массива)
    *   $str - массив строк по глубине
    */
    function createExcel($res, &$num, $level, &$str, $columnName)
    {

        if(!isset($str[$columnName]))
            $str[$columnName] = '';
        
        // Счетчик уровня. 1 начинается в первой колонке строки
        if(!isset($num[$columnName]))
            $num[$columnName] = 0;
        
        $num2 = $num;
        
        
        $i = 0;
        foreach($res as $k1 => $z)
        {
            if(!is_array($z))
                return false;
                
            $i1 = 1;
            foreach($z as $k1 => $z1)
            {
                // --- Заголовок таблицы --- 
                if($i == 0 && $i1 == 1 && strlen($str[$columnName]) == 0)
                {
                    // Родительские таблицы
                    foreach($num2 as $kNum => $zNum)
                        $str[$columnName] .= 'e-'.$kNum.excelCols;
                    
                    // Поля таблицы
                    $str[$columnName] .= implode(excelCols, array_keys($z)).excelRows; 
                }
                
                // Если значение массив // Надо проверить может ли быть заголовок без значений, потому, что после заголовка может быть массив!!!!!!!!!!!!!!!
                if(is_array($z1))
                {
                    createExcel($z1, $num, $level+1, $str, $k1);
//                    $num2[$k1] = $num[$k1];
                }
                
                // Иначе генериуем строку
                else
                {
                    // Строка начинается с ID excel
                    if($i1 == 1)
                    {
                        $id = ++$num[$columnName];
                        
                        // Подмассивы
                        if($level > 0)
                        {
                            $str[$columnName] .= $num2['parentID'].excelCols.$id.excelCols;
                        } 
                        // $level = 0, главная таблица
                        else
                        {
                            $str[$columnName] .= ($id).excelCols;
                        }
                    }
                    
                    
                    $myStr = '';
                    for($i = 0; $i < strlen($z1); $i++)
                    {
                        if(array_search(ord($z1{$i}), [60,98,114,62,10,13]) === false)
                            $myStr .= $z1{$i};
                    }
                    
                    $str[$columnName] .= $myStr.excelCols; 
                }
                
                $i1++;
            }
            $str[$columnName] .= excelRows; 
            
            
            $i++;
        }
            
    }
    
    
    
    // Логирование
    $link = mysqli_connect($mysql['host'], $mysql['user'], $mysql['pass'], $mysql['database']);
    
    $sql = 'INSERT INTO api_log SET 
        link="'.($_SERVER['REDIRECT_URL'].'?'.http_build_query($_GET)).'", 
        post = "'.http_build_query($_POST).'", 
        result_json="'.addslashes(print_r($res, true)).'", 
        result_excel="'.addslashes($excel).'", 
        user_agent = "'.$_SERVER['HTTP_USER_AGENT'].'",
        ip = "'.$_SERVER['REMOTE_ADDR'].'"';
    
    mysqli_query($link, $sql);
    
    mysqli_close($link);
    
    

exit;