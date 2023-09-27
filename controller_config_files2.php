<?php 
 	require_once "controller_config_files.php";

	// NAME servira de nom au fichier texte crée
		$name = "Myfiles";


		//EMPLACEMENT DU DOSSIER 

	$dossier = "Etat";
	$boolean = "VRAI";          //Permet de checker l'état des raspberry
	if(!file_exists($dossier)) //vérification de l'existence du dossier
	{
    
    if(mkdir($dossier))  // Tentative de création du répertoire
    {
        echo "Répertoire crée avec succès.";
    } 
    else {
        echo "ERREUR : Le répertoire n'a pas pu être créé.";
    } 
	}
	else {
    echo "Le répertoire existe déjà.";
	}

	echo "<br>";
		$xFiles = glob("Etat/*"); //PARCOURIR LES FICHIERS DU DOSSIER
		if(count($xFiles) > 0){
            // Boucle dans le tableau récupéré
            foreach($xFiles as $file){
                if(is_file("$file")){
                    // Affichage du nom du fichier uniquement
                   file_put_contents($file, $boolean) . "<br>";
                }
            }
    }
		//RECUPERATION A PARTIR DE LA BASE DE DONNEE DE LA DERNIERE DATE DE PUSH

    $pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
	$stmt1 = $pdo->prepare("SELECT * 
						FROM `Configuration`
						ORDER BY Conf_id DESC
                        LIMIT 1
						");
	$stmt1->bindParam(1,$id);
	$stmt1->execute();
	$res1 = $stmt1->fetchall();
	foreach ( $res1 as $row1 )
	{
		$link = $row1['Conf_sites'];
		$id = $row1['Conf_id'];
		$dateLastModif = $row1['Conf_date'];
		//$dateLastModifPush = $row1['Push_date'];
	}
		echo "Le dernier push a été fait le " .$dateLastModif." ! <br>";

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