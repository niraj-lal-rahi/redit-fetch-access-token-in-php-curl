<?php
public function redit(){

	$str = rand();
	$result = md5($str);
	$url = "https://www.reddit.com/api/v1/authorize?";
	$auth_url = $url."client_id=".self::REDIT_CLIENT_ID."&response_type=code&state=$result&redirect_uri=".self::REDIT_REDIRECT_URL."&duration=permanent&scope=".self::REDIT_SCOPE_STRING;

	echo  "<a href='".$auth_url."'>Login with Redit</a>";
	exit;

}

public function reditCallback(){
	$url ='https://ssl.reddit.com/api/v1/access_token';

	// post variables
	$fields = array (
		'grant_type' => 'authorization_code',
		'code' => $_GET['code'],
		'redirect_uri' => self::REDIT_REDIRECT_URL
	);

	$userAgent = 'sometext:APPNAME v0.1 by USERNAME';
	$field_string = http_build_query($fields);
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . base64_encode(self::REDIT_CLIENT_ID . ':' . self::REDIT_SECRET_ID) ));
	curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl,CURLOPT_USERAGENT, $userAgent);
	curl_setopt($curl,CURLOPT_POST, 1);
	curl_setopt($curl,CURLOPT_POSTFIELDS, $field_string);

	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	$response = json_decode($response, true);
	dd($response); // access_token should be here
	exit;
}
