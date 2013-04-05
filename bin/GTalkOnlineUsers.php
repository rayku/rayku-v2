<?php

require_once 'BotServiceProvider.class.php';

$gtalkEmails = array();
$gtalkUsersJSON = json_decode(BotServiceProvider::createFor("http://10.180.146.105:8892/onlines")->getContent());

foreach ($gtalkUsersJSON as $gtalkUserId => $status) {
	$parts = explode('/', $gtalkUserId);
	if (trim($parts[0]) != '') {
		$gtalkEmails[] = trim($parts[0]);
	}
}

if(empty($gtalkEmails)){
	return true;
}

$query = "
	UPDATE rayku_tutor 
	SET online_gtalk = '".date("Y-m-d H:i:s")."' 
	WHERE gtalk_email IN (".implode(',',$gtalkEmails).")
	LIMIT ".count($gtalkEmails);

$dsn = 'mysql:dbname=rayku_v2;host=localhost';
$user = 'root';
$password = 'abc123';

try {
	$dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}

$dbh->exec($query);