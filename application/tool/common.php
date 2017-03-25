<?php 

function getMajorText() {
	$str = curl('http://jiaowu.sicau.edu.cn/web/web/web/profession.htm');

	if (empty($str))
		return false;
	$str = strip_tags($str,"<tr><td>");
	$str = preg_replace('/<([a-z]+)\s+[^>]*>/is', '<$1>', $str);
	$str = str_replace( [" ","\n","\n\r","	","\r"],'',$str);
	$str = str_replace( ["</td>","</tr>"], '', $str);
	
	return $str;
}



function curl($destURL = '', $paramArr = array() ,$flag = 'GET',$fromurl='http://baidu.com'){
    $curl = curl_init();
    $paramStr = '';
      if( !empty($paramArr) ){
        foreach ($paramArr as $key => $value) {
            $paramStr .= $key.'='.$value.'&'; 
        }
    }
    if($flag == 'POST'){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $paramStr);
    }else{
        $destURL = $paramArr ? $destURL."?".$paramStr : $destURL;
    }
    // 构造IP
    $header = array( 
        'CLIENT-IP:127.0.0.1', 
        'X-FORWARDED-FOR:127.0.0.1', 
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_URL, $destURL);
    curl_setopt($curl, CURLOPT_REFERER, $fromurl);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    $user_agent = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0";
    curl_setopt ($curl, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);  
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
    $str = curl_exec($curl);  
    curl_close($curl);
	return iconv('GB2312', 'UTF-8',urldecode($str) ); 
}