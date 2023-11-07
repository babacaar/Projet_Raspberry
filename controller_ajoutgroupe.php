<?php
require_once "controller_config_files.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];

    $pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db, $dbuser, $dbpasswd);
    
    // Créer une table avec le nom de la variable $name
    $createTableStmt = $pdo->prepare("CREATE TABLE IF NOT EXISTS `$name` (id INT AUTO_INCREMENT PRIMARY KEY, namerasp VARCHAR(255), iprasp VARCHAR(255), portssh INT(11), username VARCHAR(255), mdp VARCHAR(255))");
    
    if ($createTableStmt->execute()) {
        echo "Table `$name` créée avec succès!";

require_once "controller_config_files.php";

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];

    try {
        $pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db, $dbuser, $dbpasswd);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM groupes WHERE name = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Le nom du groupe existe déjà. Veuillez en choisir un autre.";
        } else {
            $insertStmt = $pdo->prepare("INSERT INTO groupes (name, description) VALUES (:name, :description)");
            $insertStmt->bindParam(':name', $name);
            $insertStmt->bindParam(':description', $description);

            if ($insertStmt->execute()) {
                header("Location: confirmation.php");
                exit();
            } else {
                echo "Erreur d'insertion dans la base de données.";
            }
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
}
    } else {
        echo "Erreur lors de la création de la table `$name` : " . $createTableStmt->errorInfo()[2];
    }
    
    exit();
}
?>

