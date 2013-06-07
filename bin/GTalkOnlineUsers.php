<?php

require_once 'BotServiceProvider.class.php';

$dsn = 'mysql:dbname=rayku_v2;host=db1.p.rayku.com';
$user = 'rayku_db';
$password = 'UthmCRtaum34qpGL';

$gtalkEmails = array();
$gtalkUsersJSON = json_decode(BotServiceProvider::createFor("http://10.180.146.105:8892/onlines")->getContent());

foreach ($gtalkUsersJSON as $gtalkUserId => $status) {
	$parts = explode('/', $gtalkUserId);
	if(strpos($parts[1],'gmail') !== false || strpos($parts[1],'Talk') !== false){
		if (trim($parts[0]) != '') {
			$gtalkEmails[] = trim($parts[0]);
		}
	}
}

if(empty($gtalkEmails)){
	return true;
}

$sql = "
	UPDATE rayku_tutor 
	SET online_gtalk = NOW() 
	WHERE gtalk_email IN ('".implode('\',\'',$gtalkEmails)."')
	LIMIT ".count($gtalkEmails);

echo 'found '.count($gtalkEmails).' online';
try {
	$dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
	return false;
}

echo $sql;
$dbh->exec($sql);
