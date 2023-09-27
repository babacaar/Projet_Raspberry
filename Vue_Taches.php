<html>
	<head>
		<meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
	<title>Taches</title>
</head>
<body>
<?php
require_once "controller_config_files.php";
 
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
						FROM `todolist`
						WHERE TDL_Tache_Achieve='NON'
						ORDER BY TDL_Priority='Basse',TDL_Priority='Moyenne',TDL_Priority='Haute'
						LIMIT 30
						");
$stmt0->bindParam(1,$id);
$stmt0->execute();

$stmt1 = $pdo->prepare("	SELECT * 
						FROM `todolist`
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
	if($nbr_jours<=0){
		echo "<p class='Critique_RS'>Id" . $row0['TDL_id'] . "\n : \n" . $row0['TDL_Name_Tache'] . "\n | pour le \n" . $newdate . "\n | \n" . $nbr_jours . "\n Jours restants \n</p><br>";
	}		
	if($nbr_jours>0 && $nbr_jours<=3){
		echo "<p class='Critique_R'>Id" . $row0['TDL_id'] . "\n : \n" . $row0['TDL_Name_Tache'] . "\n | pour le \n" . $newdate . "\n | \n" . $nbr_jours . "\n Jours restants \n</p><br>";
	}	
	if($nbr_jours>=4 && $nbr_jours<=7){
		echo "<p class='Critique_O'>Id" . $row0['TDL_id'] . "\n : \n" . $row0['TDL_Name_Tache'] . "\n | pour le \n"  . $newdate . "\n | \n" . $nbr_jours . "\n Jours restants \n</p><br>";
	}
	if($nbr_jours>=8 && $tmstp1 > $tmstp2) {
		echo "<p class='Critique_N'>Id" . $row0['TDL_id'] . "\n : \n" . $row0['TDL_Name_Tache'] . "\n | pour le \n"  . $newdate . "\n | \n" . $nbr_jours . "\n Jours restants \n</p><br>";
	}
	if($tmstp1 < $tmstp2){
		echo "<p class='Critique_RS'>Id" . $row0['TDL_id'] . "\n : \n" . $row0['TDL_Name_Tache'] . "\n | pour le \n" . $newdate . "\n | En retard de \n" . $nbr_jours . "\n Jours \n</p><br>";
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
<?php
$pdo = null;
?>
</body>
</html>
