<?php 
	require_once "controller_config_files.php";


	// NAME servira de nom au fichier texte créé (le nom du fichier aura le préfixe "SITE_" suivi de l'ID)
	$name = "nomFichier";


		//EMPLACEMENT DU FICHIER
$fichier = "\\10.49.11.146\UwAmp\www";

		//RECUPERATION DES LIENS
    $pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
	$stmt0 = $pdo->prepare("SELECT * 
						FROM `Configuration`
						ORDER BY Conf_id DESC
                        LIMIT 1
						");
	$stmt0->bindParam(1,$id);
	$stmt0->execute();
	$res0 = $stmt0->fetchall();
	foreach ( $res0 as $row0 )
	{
		$link = $row0['Conf_sites'];
		$id = $row0['Conf_id'];
	}

		
		
		//GENERATION DU FICHIER

	$stmt0=
		"# INFORMATIONS\n"
		."nomFichier=$link\n"
		."type=txt\n";


		// ENREGISTREMENT DU FICHIER EN LOCAL
	$file = $fichier."/SITE_".$link.".txt";
	$fp=fopen($file,'w');
	fwrite($fp,$stmt0);
	fclose($fp);
	
    
?>












<?php 
	/*$db="ost";
	$dbhost="172.17.5.200";
	$dbport=3306;
	$dbuser="wpuser";
	$dbpasswd="22351414";
	
    $pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
	$stmt0 = $pdo->prepare("SELECT * 
						FROM `Configuration`
						ORDER BY Conf_id DESC
                        LIMIT 1
						");
	$stmt0->bindParam(1,$id);
	$stmt0->execute();
	$res0 = $stmt0->fetchall();
	foreach ( $res0 as $row0 )
	{
		$link = $row0['Conf_sites'];
		$id = $row0['Conf_id'];
		echo "<br>"."<p class='Normal'>" . $id . "\n" . $link . "</p><br>";
	}
	/*	$pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
  // set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT * FROM `Configuration`" ;
  // use exec() because no results are returned
  $pdo->exec($sql);
  $last_id = var_dump($pdo->lastInsertId());
  echo "New record created successfully. Last inserted ID is: " . $last_id;
/*catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}*/
//$pdo = null;











/*
$pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
	$stmt0 = $pdo->prepare("SELECT * 
						FROM `Configuration`
						ORDER BY Conf_id DESC
						");
	$stmt0->bindParam(1,$id);
	$stmt0->execute();
	$res0 = $stmt0->fetchall();
	foreach ( $res0 as $row0 ) {
	$link = $row0['Conf_sites'];
	$id = $row0['Conf_id'];
	echo "<br>"."<p class='Normal'>" . $id . "\n" . $link . "</p><br>";
}
*/
?>