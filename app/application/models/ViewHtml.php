<?

class ViewHtml extends View implements ViewConfig
{
    
    function addString(&$ar, $fields = [])
    {
        $temp = $this->dataSort($ar, $fields);
//echo '<pre>'.print_r($temp, true).'</pre>';
//        $str =  '<tr><td>'.implode('</td><td>', $temp).'</td></tr>'.excelRows;
        
        return $temp;
    }   
}