<?php
  // Vérifie qu'il provient d'un formulaire
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "controller_config_files.php";
	
	$TDL_Name_Tache = $_POST["TDL_Name_Tache"]; 
    $TDL_Priority = $_POST["TDL_Priority"];
    $TDL_Date_Jalon  = $_POST["TDL_Date_Jalon"];
	//$TDL_Priority = "rien";
	
    if (!isset($TDL_Name_Tache)){
      die("Merci de renseigner le nom de la Tache");
    }
    
	//Ouvrir une nouvelle connexion au serveur MySQL
	$pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
	//préparer la requête d'insertion SQL
    //$statement = $pdo->prepare("INSERT INTO ToDoList (TDL_Name_Tache, TDL_Priority, TDL_Date_Jalon) VALUES(:TDL_Name_Tache, :TDL_Priority, :TDL_Date_Jalon)"); 
    $statement = $pdo->prepare("INSERT INTO ToDoList (TDL_Name_Tache, TDL_Priority, TDL_Date_Jalon) VALUES(:TDL_Name_Tache, :TDL_Priority, :TDL_Date_Jalon)");
	//Associer les valeurs et exécuter la requête d'insertion
    $statement->bindParam(':TDL_Name_Tache', $TDL_Name_Tache, PDO::PARAM_STR);
	$statement->bindParam(':TDL_Priority', $TDL_Priority, PDO::PARAM_STR);
	$statement->bindParam(':TDL_Date_Jalon', $TDL_Date_Jalon, PDO::PARAM_STR);	
	
	if($statement->execute()){
		echo 'Tache : " '. $TDL_Name_Tache . ' " crée ! <br>';
	}else{
		echo "Échec de création de la tache ! <br>";
	}
    //print "La tache est la suivante : " . $TDL_Name_Tache . " elle a une prioritée : ". $TDL_Priority . " A faire pour le : " . $TDL_Date_Jalon ;

    //print "La tache est la suivante : " . $Tache . " elle a une prioritée : ". $ComboPrio . " A faire pour le : " . $DateJalon;
  }
?>