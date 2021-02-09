<?

class Cisco extends MyController 
{
    function __construct($vars)
    {
        parent::__construct($vars);
        
    }
	
	
	function index($vars)
	{

		$data['url'] = 'https://cloudsso.cisco.com/as/token.oauth2';
		
		$data['post'] = 1;
		$data['header'] = 0;	
		$data['httpHeader'] = array(
			'content-type: ' => 'application/json',
			'cache-control: ' => 'no-cache',
			
		);
		$data['httpGet'] = 0;
		
		
		$post = [
			
			'client_id' 		=> 'xxet8rmrn9nvkvcnftb4y7vx',
			'client_secret' 	=> 'QJ87R2JWM5akXXr3PS6uZfFZ',
//			'client_id' 		=> '7hxupapy5mn9ybzf69s9w3un',
//			'client_secret' 	=> 'q7DDqBRfQjP9e8cYK4ZUjV3y',
			'scope'				=> 'edit',
			'grant_type' 		=> 'client_credentials',
//			'username' 			=> 'vitaliy.obukhov@muk.ua',
//			'password' 			=> 'Test1234$'
		];
		
		$data['postField'] = http_build_query($post);

		
		$res = $this->getData($data);
		
		var_dump($res);
//		var_dump(json_decode($res));
		$resJson = json_decode($res);
		
		
		
		

			
		
		
		
		

	echo '<br><br><br><br><br><br>';	
	
	
	
	
	
		
		
		
		$data['url'] = 'https://api.cisco.com/helloInteractive';
		
		$data['post'] = 0;
		$data['header'] = 0;
		$data['httpHeader'] = array(
//			'content-type: ' => 'application/json',
			'cache-control: ' => 'no-cache',
			'authorization: ' => $resJson->token_type.' '.$resJson->access_token,
		);
		
		$data['httpGet'] = '1';
		
		$res2 = $this->getData($data);
		
		var_dump($res2);
		
		var_dump(json_decode($res2));
		
//		$resJson = json_decode($res);

		
		
		
		
		
		
		
		

	echo '<br><br><br><br><br><br>';	
	
	
	
	
	
/*	
		if(!isset($resJson->token_type) || !isset($resJson->access_token))
		{
			echo 'my No Autorized!!!<br>';
			exit;
		}

//		$resJson = new Object;
//		$resJson->token_type	= 'Bearer';
//		$resJson->access_token 	= 'aNGCHKcKLUSoRuAtl9ImcF0NLTRc';
//		https://cloudsso.cisco.com/as/authorization.oauth2?response_type=code&client_id=g2mv5gp6jsbsht9fsaquxff8
		$data['url'] = 'https://api-test.cisco.com/ccw/subscriptionmanagement/api/v1.0/sub/subscriptionList';
		$data['post'] = 1;
		$data['header'] = 1;
		$data['httpHeader'] = array(
//			'content-type' => 'application/json',
			'cache-control' => 'no-cache',
			'authorization' => $resJson->token_type.' '.$resJson->access_token,
			'accept' => 'application/json',
//			'client_id' => 'b0bc8e5615034eebaf734332f32814d3',
//			'client_secret' => '60CCF8BCDC184B6Fa33Bf56E3b78F4C9Hide',
//			'username' => 'vitaliy.obukhov@muk.ua',
//			'password' => 'Test1234$'
		);
		
//		$data['cookie'] = 'PF=W3KnyEaaJLnLuDgyyeULyU;Path=/;Secure;HttpOnly;SameSite=None';

var_dump($data['httpHeader']);
		
		$data['httpGet'] = 0;
		
		
		$post = [
			'pageLimit' => 100,
			'startDate' => '2020-01-07T18:58:01Z',
			'endDate' => '2020-12-07T18:58:01Z',
//			'username' => 'vitaliy.obukhov@muk.ua',
//			'password' => 'Test1234$',
//			'authorization' => $resJson->token_type.' '.$resJson->access_token,
		];
		
		$data['postField'] = http_build_query($post);
//		var_dump($data['httpHeader']); exit;
		
		$res = $this->getData($data);
		
		var_dump($res);
//		var_dump(json_decode($res));
		
		
//		$data
*/
		
	}
	
	
	function setLog($str)
	{}
	
	function getData($data)
	{
		
		$ch = curl_init($data['url']);
		curl_setopt($ch, CURLOPT_URL, $data['url']);  

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_HEADER, $data['header']); 
		curl_setopt($ch, CURLINFO_HEADER_OUT, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $data['httpHeader']); 

		if(isset($data['post']) && $data['post'] == 1)
			curl_setopt($ch, CURLOPT_POST, $data['post']);

		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);

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
		
		
		
		
		if(isset($data['cookie']))
			curl_setopt($ch, CURLOPT_COOKIE, $data['cookie']);

		$output = curl_exec($ch);
		
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		var_dump($status);

		if(curl_errno($ch))
			$this->setLog('Request Error:' . curl_error($ch));

		$info = curl_getinfo($ch); 

		//            echo '<br>Info header<br>';
		//            echo '<pre>'.print_r($info, true).'</pre>';

		curl_close($ch);

		return $output; 
	}
}