<?

Class View
{
    function __construct()
    {
        
    }
    
    
    // Добавление строки в вывод данных (CSV, HTML)
    function dataSort(&$ar, $fields = [])
    {
        $temp = [];
        
        // Сортируем данные по индексам массива $fields
        if(count($fields) > 0)
        {
            foreach($fields as $item)
            {         
                $temp[$item] = (isset($ar[$item]) ? $ar[$item] : '');
            }
        }
        else
        {
            $temp = $ar;
        }
        
        return $temp;
    }
}