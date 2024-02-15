<?php
$pageTitle = "Création de Tâche"; // Titre de la page
$dropDownMenu = true;
include "../modules/header.php";
?>

<body>
	<div class="page">
		<section class="page-content">

			<?php
			$msg = "";

			try {
				// Vérifie qu'il provient d'un formulaire
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					// Database settings
					$db = "Affichage";
					$dbhost = "localhost";
					$dbport = 3306;
					$dbuser = "root";
					$dbpasswd = "root";

					$TDL_Name_Tache = $_POST["TDL_Name_Tache"];
					$TDL_Priority = $_POST["TDL_Priority"];
					$TDL_Date_Jalon = $_POST["TDL_Date_Jalon"];

					if (!isset($TDL_Name_Tache)) {
						throw new Exception("Merci de renseigner le nom de la Tâche");
					}

					//Ouvrir une nouvelle connexion au serveur MySQL
					$pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db . '', $dbuser, $dbpasswd);

					//préparer la requête d'insertion SQL
					//$statement = $pdo->prepare("INSERT INTO ToDoList (TDL_Name_Tache, TDL_Priority, TDL_Date_Jalon) VALUES(:TDL_Name_Tache, :TDL_Priority, :TDL_Date_Jalon)"); 
					$statement = $pdo->prepare("INSERT INTO ToDoList (TDL_Name_Tache, TDL_Priority, TDL_Date_Jalon) VALUES(:TDL_Name_Tache, :TDL_Priority, :TDL_Date_Jalon)");

					//Associer les valeurs et exécuter la requête d'insertion
					$statement->bindParam(':TDL_Name_Tache', $TDL_Name_Tache, PDO::PARAM_STR);
					$statement->bindParam(':TDL_Priority', $TDL_Priority, PDO::PARAM_STR);
					$statement->bindParam(':TDL_Date_Jalon', $TDL_Date_Jalon, PDO::PARAM_STR);

					if ($statement->execute()) {
						$msg .= "La tâche : " . $TDL_Name_Tache . " a bien été créée <br>";
						include "../modules/success.php";
					} else {
						throw new Exception("Échec de création de la tache.");
					}
				}
			} catch (PDOException $e) {
				$msg .= "Erreur de base de données : " . $e->getMessage();
				include "../modules/error.php";
			} catch (Exception $e) {
				$msg .= $e->getMessage();
				include "../modules/error.php";
			}
			?>

		</section>
	</div>
</body>

<!------------FOOTER------------>
<?php include "../modules/footer.php"; ?>