<!------------HEADER------------>
<?php
$pageTitle = "Mise à Jour"; // Titre de la page
$dropDownMenu = true;
include "../modules/header.php";
?>

<!------------BODY------------>

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

					if (isset($_POST["TDL_id"]) && isset($_POST["TDL_Tache_Achieve"])) {
						$TDL_id = $_POST["TDL_id"];
						$TDL_Tache_Achieve = $_POST["TDL_Tache_Achieve"];
					} else {
						throw new Exception("Veuillez choisir une tâche valide.");
					}

					//Ouvrir une nouvelle connexion au serveur MySQL
					$pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db . '', $dbuser, $dbpasswd);

					//préparer la requête d'insertion SQL
					$statement = $pdo->prepare("UPDATE ToDoList SET TDL_Tache_Achieve=:TDL_Tache_Achieve WHERE TDL_id=:TDL_id");

					//Associer les valeurs et exécuter la requête d'insertion
					$statement->bindParam(':TDL_id', $TDL_id, PDO::PARAM_STR);
					$statement->bindParam(':TDL_Tache_Achieve', $TDL_Tache_Achieve, PDO::PARAM_STR);

					if ($statement->execute()) {
						$msg .= "Tache N° " . $TDL_id . " modifiée. Tache achevée : " . $TDL_Tache_Achieve . "<br>";
						include "../modules/success.php";
					} else {
						throw new Exception("Échec de modification de la tache !");
					}
				}
			} catch (PDOException $e) {
				$msg .= "Erreur de connexion à la base de données" . $e->getMessage();
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