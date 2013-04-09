<?php

require_once 'BotServiceProvider.class.php';

$expire_session = '-15 minutes';
$dsn = 'mysql:dbname=rayku_v2;host=db1.p.rayku.com';
$user = 'rayku_db';
$password = 'UthmCRtaum34qpGL';

$sql = "
	SELECT * 
	FROM rayku_v2.rayku_session s
	INNER JOIN rayku_v2.rayku_tutor_connect c ON c.session_id = c.id
	INNER JOIN rayku_v2.rayku_tutor t ON t.id = c.tutor_id
	WHERE s.end_time IS NULL
	AND s.selected_tutor_id IS NULL
	AND c.tutor_reply = 'pending'
	AND t.gtalk_email IS NOT NULL
	AND s.created_at > '".date('Y-m-d H:i:s', strtotime($expire_session))."'
	AND t.online_gtalk > '".date('Y-m-d H:i:s', strtotime($expire_session))."'
";

echo $sql;

try {
	$dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
	return false;
}


foreach ($dbh->query($sql) as $row) {
	$message = 'A student has requested a tutoring session with you on http://www.rayku.com';
	BotServiceProvider::createFor('http://10.180.146.105:8892/msg/'.$row['gtalk_email'].'/'.$message)->getContent();
	$update = "UPDATE rayku_v2.rayku_tutor_connect c SET tutor_reply = 'contacted gtalk' WHERE c.id = ".$row['c.id']." limit 1";
	$dbh->exec($update);
}

