<?
class ViewXml extends View implements ViewConfig
{
    function addString(&$ar, $fields = [])
    {
        $temp = $this->dataSort($ar, $fields);
        
//        if(is_array($temp))
//        {
//            $str = implode(excelCols, $temp).excelRows;
//        }
        
        return $temp;
    }
}