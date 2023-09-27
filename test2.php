<html>
<head>
<title>ECRANS</title>
</head>
<body>
<?php
// Database settings
$db="ost";
$dbhost="172.17.5.200";
$dbport=3306;
$dbuser="wpuser";
$dbpasswd="22351414";
 
$pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
$pdo->exec("SET CHARACTER SET utf8");
?>

<?php 
$stmt = $pdo->prepare("	SELECT * 
						FROM `ost_ticket`
						INNER JOIN `ost_ticket__cdata` ON ost_ticket.ticket_id = ost_ticket__cdata.ticket_id
						WHERE status_id=1
						AND dept_id=1
						ORDER BY created DESC
						");
$stmt->bindParam(1,$id);
$stmt->execute();


$res = $stmt->fetchall();
foreach ( $res as $row ) {
	$nb=$stmt->rowCount();
    echo $row['created'];
	echo "\n";
	echo "|";
	echo "\n";
	echo $row['subject'];
	//echo "\n";
	echo "<br>";
}
?>

<?php
echo "<br>";
echo $nb;
echo "\n";
echo "Tickets Ouverts";
?>

<?php
$pdo = null;
?>
</body>
</html>