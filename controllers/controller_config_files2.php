<!------------HEADER------------>
<?php
$pageTitle = "Configuration"; // Titre de la page
$dropDownMenu = true;
include "../modules/header.php";
?>

<!------------BODY------------>

<body>
	<div class="controller page">
		<section class="page-content">

			<?php
			//PARAMETRES DATABASE
			$db = "Affichage";
			$dbhost = "localhost";
			$dbport = 3306;
			$dbuser = "root";
			$dbpasswd = "root";

			//Parametres FTP LPJW
			$ftp_server = "localhost";
			$ftp_username = "ftp_Lpjw";
			$ftp_password = "Passer1234#";

			// NAME servira de nom au fichier texte crée
			$name = "Myfiles";

			// EMPLACEMENT DU DOSSIER 
			$dossier = "Etat";
			$boolean = "VRAI";
			if (!file_exists($dossier)) //vérification de l'existence du dossier
			{
				if (mkdir($dossier))  // Tentative de création du répertoire
				{
					$msg = "Répertoire créé avec succès.";
					include "../modules/success.php";
				} else {
					$msg = "Erreur : Le répertoire n'a pas pu être créé.";
					include "../modules/error.php";
					die();
				}
			} else {
				$msg = "Le répertoire existe déjà.";
				include "../modules/error.php";
				die();
			}

			echo "<br>";
			$xFiles = glob("Etat/*"); //PARCOURIR LES FICHIERS DU DOSSIER
			if (count($xFiles) > 0) {
				// Boucle dans le tableau récupéré
				foreach ($xFiles as $file) {
					if (is_file("$file")) {
						// Affichage du nom du fichier uniquement
						file_put_contents($file, $boolean) . "<br>";
					}
				}
			}

			$pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db . '', $dbuser, $dbpasswd);
			$stmt1 = $pdo->prepare("SELECT * 
						FROM `Configuration`
						ORDER BY Conf_id DESC
                        LIMIT 1
						");
			$stmt1->bindParam(1, $id);
			$stmt1->execute();
			$res1 = $stmt1->fetchall();
			foreach ($res1 as $row1) {
				$link = $row1['Conf_sites'];
				$id = $row1['Conf_id'];
				$dateLastModif = $row1['Conf_date'];
			}
			echo "<p class='debug-msg'>Le dernier push a été fait le " . $dateLastModif . " !</p>";
			?>


		</section>
	</div>
</body>


<!------------FOOTER------------>
<?php include "../modules/footer.php"; ?>