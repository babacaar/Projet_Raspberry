<?php
  // Vérifie qu'il provient d'un formulaire
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
   require_once "controller_config_files.php";

	
	
	$Conf_sites = $_POST["Conf_sites0"]; 
 	date_default_timezone_set('Europe/Paris');
    	$Conf_date = date('y-m-d à H:i:s');
    	echo $Conf_date;
    	echo "<br/>";	

    if (empty($Conf_sites)){
      die("Merci de remplir le champ");
    }
//OUVERTURE D'UNE NOUVELLE CONNEXION AU SERVEUR MYSQL

	$pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);

	//PREPARATION DE LA REQUETE D'INSERTION SQL
 
 $statement = $pdo->prepare("INSERT INTO configuration (Conf_sites, Conf_date) VALUES(:Conf_sites, NOW())");

	//Associer les valeurs et exécuter la requête d'insertion
    $statement->bindParam(':Conf_sites', $Conf_sites, PDO::PARAM_STR);

	if($statement->execute()){
		echo 'Le lien suivant :" '. $Conf_sites . ' " a bien été ajouté!<br>';
	}
	else{
		echo "La configuration a échoué ! <br>";
	}
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
		<a href="http://172.17.5.202/configuration.php" class="precedent">&laquo; Précédent</a>
	</body>
	</html>
