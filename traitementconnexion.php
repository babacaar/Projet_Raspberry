<?php
require_once "controllers/controller_config_files.php";

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère les données du formulaire
    $nom_utilisateur = $_POST['username'];
    $mot_de_passe = $_POST['password'];

    try {
        // Connexion à la base de données
        $pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db, $dbuser, $dbpasswd);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prépare une requête pour récupérer le mot de passe haché de l'utilisateur
        $query = "SELECT id, mot_de_passe FROM Utilisateurs WHERE nom_utilisateur = ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $nom_utilisateur, PDO::PARAM_STR);

        // Exécute la requête
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifie s'il y a une correspondance d'utilisateur
        if ($row) {
            $mot_de_passe_hache = $row['mot_de_passe'];

            // Vérifie si le mot de passe est correct
            if (password_verify($mot_de_passe, $mot_de_passe_hache)) {
                // Mot de passe correct, authentification réussie
                session_start();
                $_SESSION['id_utilisateur'] = $row['id'];
var_dump($_SESSION);
                // Mettre à jour la date de dernière connexion
                $updateQuery = "UPDATE Utilisateurs SET date_derniere_connexion = NOW() WHERE id = ?";
                $updateStmt = $pdo->prepare($updateQuery);
                $updateStmt->bindParam(1, $row['id'], PDO::PARAM_INT);
                $updateStmt->execute();

                header("Location: menu.php");
                exit();
            } else {
                // Mot de passe incorrect
                echo "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } else {
            // Utilisateur non trouvé
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } catch(PDOException $e) {
        // Gérer les erreurs de base de données
        echo "Erreur de base de données : " . $e->getMessage();
    } finally {
        // Ferme la connexion à la base de données
        $pdo = null;
    }
}
?>
