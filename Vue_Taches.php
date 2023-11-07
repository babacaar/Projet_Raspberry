<html>
	<head>
		<meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
	<title>Taches</title>
</head>
<body>
<?php
// Database settings
	$db="Affichage";
	$dbhost="172.17.5.202";
	$dbport=3306;
	$dbuser="root";
	$dbpasswd="22351414";
 
$pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
//$pdo->exec("SET CHARACTER SET utf8");
?>

<?php
   function dateDiff($date1, $date2)  //days find function
        { 
            $diff = strtotime($date2) - strtotime($date1); 
            return abs(round($diff / 86400)); 
        } 
?>

<elementHG>
<div class="scroll_V_B">
<?php 
$stmt0 = $pdo->prepare("	SELECT * 
						FROM `ToDoList`
						WHERE TDL_Tache_Achieve='NON'
						ORDER BY TDL_Priority='Basse',TDL_Priority='Moyenne',TDL_Priority='Haute'
						LIMIT 15
						");
$stmt0->bindParam(1,$id);
$stmt0->execute();

$stmt1 = $pdo->prepare("	SELECT * 
						FROM `ToDoList`
						WHERE TDL_Tache_Achieve='NON'
						ORDER BY TDL_Priority='Basse',TDL_Priority='Moyenne',TDL_Priority='Haute'
						");
$stmt1->bindParam(1,$id);
$stmt1->execute();

$res0 = $stmt0->fetchall();
foreach ( $res0 as $row0 ) {
	$date = $row0['TDL_Date_Jalon']; // defini la date
	date_default_timezone_set('Europe/Paris');
	$aujourdhui = date('d-m-Y');
	$timestamp = strtotime($date);
	$newdate = date('d-m-Y', $timestamp);
	$nbr_jours =  dateDiff($newdate, $aujourdhui);
	$tmstp1 = strtotime($newdate);
	$tmstp2 = strtotime($aujourdhui);
	
	
	//$nb=$stmt->rowCount();	
	
	if($nbr_jours<=3){
		echo "<p class='Critique_R'>Id" . $row0['TDL_id'] . "\n : \n" . $row0['TDL_Name_Tache'] . "\n | pour le \n" . $newdate . "\n | \n" . $nbr_jours . "\n Jours restants \n</p><br>";
	}	
	if($nbr_jours>=4 && $nbr_jours<=7){
		echo "<p class='Critique_O'>Id" . $row0['TDL_id'] . "\n : \n" . $row0['TDL_Name_Tache'] . "\n | pour le \n"  . $newdate . "\n | \n" . $nbr_jours . "\n Jours restants \n</p><br>";
	}
	if($nbr_jours>=8 && $tmstp1 > $tmstp2) {
		echo "<p class='Critique_N'>Id" . $row0['TDL_id'] . "\n : \n" . $row0['TDL_Name_Tache'] . "\n | pour le \n"  . $newdate . "\n | \n" . $nbr_jours . "\n Jours restants \n</p><br>";
	}
	if($tmstp1 < $tmstp2){
		echo "<p class='Critique_DD'>Id" . $row0['TDL_id'] . "\n : \n" . $row0['TDL_Name_Tache'] . "\n | pour le \n" . $newdate . "\n | En retard de \n" . $nbr_jours . "\n Jours \n</p><br>";
	}
	
	//echo "\n";
	//echo "doit être réalisée avant le " . $row['TDL_Date_Jalon'];
	//echo "\n";
	//echo "<br>";
}

$res1 = $stmt1->fetchall();
foreach ( $res1 as $row1 ) {
	$nb0=$stmt1->rowCount();
}

?>
</div>


</elementHG>
<elementBG>
<?php
echo "<br>"."<p class='Normal'>" . $nb0 . "\n" . "Taches en cours</p><br>";
?>
</elementBG>
<elementBD>
<?php 
$stmt2 = $pdo->prepare("	SELECT * 
						FROM `ost_ticket`
						INNER JOIN `ost_ticket__cdata` ON ost_ticket.ticket_id = ost_ticket__cdata.ticket_id
						WHERE status_id=1
						AND dept_id=1
						ORDER BY created DESC
						LIMIT 15
						");
$stmt2->bindParam(1,$id);
$stmt2->execute();

$stmt3 = $pdo->prepare("	SELECT * 
						FROM `ost_ticket`
						INNER JOIN `ost_ticket__cdata` ON ost_ticket.ticket_id = ost_ticket__cdata.ticket_id
						WHERE status_id=1
						AND dept_id=1
						ORDER BY created DESC
						");
$stmt3->bindParam(1,$id);
$stmt3->execute();

$res2 = $stmt2->fetchall();
foreach ( $res2 as $row2 ) {
	$nb1=$stmt2->rowCount();
    echo $row2['created'];
	echo "\n";
	echo "|";
	echo "\n";
	echo $row2['subject'];
	//echo "\n";
	echo "<br>";
}

$res3 = $stmt3->fetchall();
foreach ( $res3 as $row3 ) {
	$nb1=$stmt3->rowCount();
}
?>

<?php
echo "<br>";
echo $nb1;
echo "\n";
echo "Tickets Ouverts";
?>
</elementBD>
<elementHD>

</elementHD>
<?php
$pdo = null;
?>
</body>
</html>