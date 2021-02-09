<?
	// DATA
	$data = [
		'url' => 'https://bss.eu.interworks.cloud/api/Subscriptions/b231c268-bca9-496c-b333-cb659e7a9a1a/attributes',
		'header' => 0,
		'httpHeader' => [
			0 => 'Authorization: Bearer s3Pnz-DXcg9RcbBK8hRxfplax8kkxM0fgox63MYli9Fx4zrfWBRo2ja-ryJfc4TrJ2eLgz60gX8pGbqp1Vk98bh5sCUBA3tB1hJU6dSnmlzto1yoni-3ZS4MwMUzJt_Fm811VG1z3P3kHGbA620p1Crv3SzESkruYOURDwcB1NxjwTEOUL0NvtCMBPf4OdViw2d8UQ5Qkk22s4TmF1-47b7Rzx1iqQ0_HKV0Ej3njCKODxA836diax_PC8uodwFEX0WzSS-g4MVFPqwr_cJc5P8Z2BPZb4aNO4zh4pWVT0cv8_yAGAKWeftSx7kbszwvh640ElTjx-gpnY0t5AvUzyCb9IuiUri_It6LzqCjM19Cxjj7ZUDSRgxznBYtkot7ikaKiLO14ydVctD0Pcj1LL2cUL_0kk2ZIJPQXEN6vS0fww4GGAEwMHEAZXjJfwrRhC9fVW99qAHqmNj5V0q3k93zLZhZSydMo409TJMJVAc1-nA6Cfz8P9CBZT_zkYtLIR-9lYN9VqtQTg4anUAQIg'
		],
		'httpGet' => 1,
		'getfields' => ''
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
    [attributes] => Array
        (
            [0] => stdClass Object
                (
                    [id] => 4C617CFA-B53A-4277-ABE1-5AD48FE9C387
                    [externalId] => MicrosoftCloudServicesMSAzure
                    [name] => MS Azure Plans
                    [value] => Microsoft Azure (Enterprise)
                    [valueExternal] => MicrosoftCloudServicesMSAzure_/fbf178a5-144e-46d1-aa81-612c2d3f97f4/Offers/MS-AZR-0145P
                    [code] => /fbf178a5-144e-46d1-aa81-612c2d3f97f4/Offers/MS-AZR-0145P
                )

        )

)
*/