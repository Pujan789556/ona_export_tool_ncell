<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: text/plain');

$authString1 = $_POST['auth1'];
$authString2 = $_POST['auth2'];

if (!($authString1 && $authString2)) {
	echo "false";
	exit();
}

if (preg_match("/\W/", $authString1, $c)) {
	echo "false";
	exit();
}

$validAuth1 = exec("./authgen1.sh $authString1");
$validAuth2 = exec("./authgen2.sh $validAuth1");

$surveyor_id = exec("./getSurveyorId.sh $validAuth1");

$authString2Calc = exec("echo $authString2 | openssl enc -base64 -d | openssl enc -aes-256-cbc -k $validAuth2 -d");

$clientAddr = $_SERVER['REMOTE_ADDR'];

if ($authString1 == $validAuth1 && $authString2Calc == $validAuth2) {
	if (preg_match("/\d+\.\d+\.\d+\.\d+/", $clientAddr, $result)) {
		$secret_word  = exec("date")+rand();
		$cookieString = $authString1.'-'.md5($validAuth1.$secret_word);
		//setcookie('session', $cookieString);
		//setcookie('surveyor_id', $surveyor_id);

		$logfile = fopen('authlog.log', 'a');
		file_put_contents($clientAddr.'.addr', $cookieString);
		fwrite($logfile, date("Y-m-d h:i:s/a T")."\t".$authString1."\t".$clientAddr."\n");
		fclose($logfile);
		echo '{"authorized":true,"session":{"surveyor_id":"'.$surveyor_id.'","key":"'.$cookieString.'"}}';
	} else {
		echo "false";
	}
} else {
	echo "false";
}
?>