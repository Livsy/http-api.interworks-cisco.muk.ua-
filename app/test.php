<?

$option['test'] = 1;


new simple();


class simple
{
	var $gl;
	
	function __construct()
	{
		$this->gl = &$GLOBALS;
		
		var_dump($this->gl['option']);
		
		function settings($name)
		{
			return isset($this->gl[$name]) ? $this->gl[$name] : '';
		}
	}
}