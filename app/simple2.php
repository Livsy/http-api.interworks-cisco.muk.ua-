<?
	// DATA
	$data = [
		'url' => 'https://bss.eu.interworks.cloud/api/Subscriptions',
		'header' => 0,
		'httpHeader' => [
			'Authorization: Bearer ga9QB1phUdESX99NatldekSBPf_hu06yo3_Q-wqY3Ky3mqjZ0p5nHO2S5eEwfhOdIdK4E0lq_mtmXopVyJmuPq9TUzwmkmkv-_sc1ss595doKngJztLpMp_oJHb-sdWNbsfASr2_LVnwj4MiMVlkNSM5Gxyv1xJodhiAp0JO157i1sy-Dv1P2gUx0yzbbXhbJ7ZQltPq5_XLuaT851z5APgKZZVK1tvP-E3L3ig3ii1iKbsr8FUMoxYpsua4-5m2TI0EX7h902c08phnlQsMxDOGUjoTEEdI4Ts7dRbAls3YwN_ZBQ1DvNHwQFoDCL2ieUYuIplnCk6jFwy1KC1OW3w0cxJ-fYoyihtbGri75Tr_levKGaaFGipFb8q56V-TYwdueniYWJCV4r1hOJAEPcEAFqvUz1jMlAyslHy4BSLS0J0-3Z2BuKZ8hMXOP_mZuFVpKC65WLiJ949atBEUkvKQ80KMsKjAZB4lw1-fE-fQhvSOjbK1k0zLoSTN8DT_4mXX4VLFrSXQxbEBD9uJNQ',
			'X-Api-Version: 2.1'
		],

		'httpGet' => 1,
		'getfields' => 'accountId=2827'
	];
	// END DATA
	
	

	// CURL
	$ch = curl_init($data['url']);
	curl_setopt($ch, CURLOPT_URL, $data['url']);  

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_HEADER, $data['header']); 
	curl_setopt($ch, CURLINFO_HEADER_OUT, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $data['httpHeader']); 

	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);

	if($data['httpGet'] <> 1)
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data['postField']);
	else
		curl_setopt($ch, CURLOPT_HTTPGET, $data['httpGet']);

	curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14");
	curl_setopt($ch, CURLINFO_OS_ERRNO, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 240); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 240);        
	curl_setopt($ch, CURLOPT_MAXREDIRS, 20);       
	curl_setopt($ch, CURLOPT_HTTP_VERSION, 'HTTP/1.1');

	$output = curl_exec($ch);

	if(curl_errno($ch))
		$this->setLog('Request Error:' . curl_error($ch));

	$info = curl_getinfo($ch); 

	curl_close($ch);
	// END CURL
	
	
	

	// OUTPUT
	echo '<pre>'.print_r(json_decode($output), true).'</pre>';

	
/*
stdClass Object
(
    [message] => The requested resource does not support http method 'GET'.
)
*/