











<?php
require_once "controller_config_files.php";
  // Vérifie qu'il provient d'un formulaire
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database settings
	/*$db="affichage";
	$dbhost="10.49.11.117";
	$dbport=3306;
	$dbuser="root";
	$dbpasswd="root";
*/
	
	
		$Conf_sites = $_POST["Conf_sites0"]; 
    date_default_timezone_set('Europe/Paris');
    $Conf_date = date('y-m-d à H:i:s');
    echo $Conf_date;
    echo "<br/>";	
		//$Conf_date  = $_POST["Conf_date0"];

    if (empty($Conf_sites)){
      die("Merci de remplir le champ");
    }
//Ouvrir une nouvelle connexion au serveur MySQL
		$pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);

if (!$pdo) {
    die("Erreur de connexion à la base de données");
}


	//préparer la requête d'insertion SQL
    //$statement = $pdo->prepare("INSERT INTO ToDoList (TDL_Name_Tache, TDL_Priority, TDL_Date_Jalon) VALUES(:TDL_Name_Tache, :TDL_Priority,:TDL_Date_Jalon)"); 
 $statement = $pdo->prepare ("INSERT INTO configuration (Conf_sites, Conf_date) VALUES(:Conf_sites, NOW())");
	//Associer les valeurs et exécuter la requête d'insertion
    $statement->bindParam(':Conf_sites', $Conf_sites, PDO::PARAM_STR);
		//$statement->bindParam(':Conf_date', $Conf_date, PDO::PARAM_STR);	
	
	if(!$statement->execute()){
    echo "Erreur MySQL : " . $statement->errorInfo()[2];
}

	
    if($statement->execute()) {
        echo 'Le lien suivant : "'. $Conf_sites . '" a bien été ajouté!<br>';
    } else {
        echo "La configuration a échoué !<br>";
    }

	//print "La tache est la suivante : " . $TDL_Name_Tache . " elle a une prioritée : ". $TDL_Priority . " A faire pour le : " . $TDL_Date_Jalon ;

    //print "La tache est la suivante : " . $Tache . " elle a une prioritée : ". $ComboPrio . " A faire pour le : " . $DateJalon;
	  }
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<style>
				a {
  				text-decoration: none;
  				display: inline-block;
  				padding: 8px 16px;
  				margin-top: 10px;
				}


					.precedent {
  				background-color: #04AA6D;
  				color: black;
					}
		</style>
			
	</head>
	<body>
		<a href="http://localhost/configuration.php" class="precedent">&laquo; Précédent</a>
	</body>
	</html>