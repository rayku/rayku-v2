<?php

require_once 'BotServiceProvider.class.php';

$expire_session = '-15 minutes';
$dsn = 'mysql:dbname=rayku_v2;host=db1.p.rayku.com';
$user = 'rayku_db';
$password = 'UthmCRtaum34qpGL';

$sql = "
	SELECT * 
	FROM rayku_v2.rayku_session s
	INNER JOIN rayku_v2.rayku_tutor_connect c ON c.session_id = s.id
	INNER JOIN rayku_v2.rayku_tutor t ON t.id = c.tutor_id
	WHERE s.end_time IS NULL
	AND s.selected_tutor_id IS NULL
	AND c.tutor_reply = 'pending'
	AND t.gtalk_email IS NOT NULL
	AND TIME_TO_SEC(TIMEDIFF(s.created_at, NOW())) > '-360'
	AND TIME_TO_SEC(TIMEDIFF(t.online_gtalk, NOW())) > '-360'
";

try {
	$dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
	return false;
}


foreach ($dbh->query($sql) as $row) {
	echo 'request sent to '.$row['gtalk_email'];
	$message = rawurlencode('A student has requested a tutoring session with you on www.rayku.com');
	var_dump(BotServiceProvider::createFor('http://10.180.146.105:8892/msg/'.$row['gtalk_email'].'/'.$message)->getContent());
	$update = "UPDATE rayku_v2.rayku_tutor_connect c SET tutor_reply = 'contacted gtalk' WHERE session_id = ".$row['session_id']." AND tutor_id = ".$row['tutor_id']." limit 1";
	$dbh->exec($update);
}

