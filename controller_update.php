<?php
  // Vérifie qu'il provient d'un formulaire
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database settings
	$db="Affichage";
	$dbhost="172.17.5.202";
	$dbport=3306;
	$dbuser="root";
	$dbpasswd="22351414";
	
	$TDL_id = $_POST["TDL_id"]; 
    $TDL_Tache_Achieve = $_POST["TDL_Tache_Achieve"];
    //$TDL_Date_Jalon  = $_POST["TDL_Date_Jalon"];
	//$TDL_Priority = "rien";
	
    //if (($TDL_id = "0") or ($TDL_Tache_Achieve = "Merci de choisir")){
    //  echo 'Tache N° " '. $TDL_id . ' " modifiée. Tache achevée : '. $TDL_Tache_Achieve . ' <br>';
	//  die("Merci de renseigner le N° de la Tache et d'indiquer si elle est achevée ou pas.");
	//}
    
	//Ouvrir une nouvelle connexion au serveur MySQL
	$pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
	//préparer la requête d'insertion SQL
    //$statement = $pdo->prepare("INSERT INTO ToDoList (TDL_Name_Tache, TDL_Priority, TDL_Date_Jalon) VALUES(:TDL_Name_Tache, :TDL_Priority, :TDL_Date_Jalon)"); 
    $statement = $pdo->prepare("UPDATE ToDoList SET TDL_Tache_Achieve=:TDL_Tache_Achieve WHERE TDL_id=:TDL_id");
	//Associer les valeurs et exécuter la requête d'insertion
    $statement->bindParam(':TDL_id', $TDL_id, PDO::PARAM_STR);
	$statement->bindParam(':TDL_Tache_Achieve', $TDL_Tache_Achieve, PDO::PARAM_STR);
	//$statement->bindParam(':TDL_Date_Jalon', $TDL_Date_Jalon, PDO::PARAM_STR);	
	
	if($statement->execute()){
		echo 'Tache N° '. $TDL_id . ' modifiée. Tache achevée : '. $TDL_Tache_Achieve . ' <br>';
	}else{
		echo "Échec de modification de la tache ! <br>";
		echo 'Tache N° '. $TDL_id . ' Tache achevée : '. $TDL_Tache_Achieve . ' <br>';
	}
    //print "La tache est la suivante : " . $TDL_Name_Tache . " elle a une prioritée : ". $TDL_Priority . " A faire pour le : " . $TDL_Date_Jalon ;

    //print "La tache est la suivante : " . $Tache . " elle a une prioritée : ". $ComboPrio . " A faire pour le : " . $DateJalon;
  }
?>