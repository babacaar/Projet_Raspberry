<?php
require_once "controller_config_files.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données soumises
    $selectedPis = isset($_POST['selected_pis']) ? $_POST['selected_pis'] : '';
    $existingGroup = isset($_POST['existing_group']) ? $_POST['existing_group'] : '';

    // Validation des données (vous devrez peut-être effectuer une validation plus approfondie ici)

    // Mettre à jour la base de données avec les Raspberry Pi sélectionnés
    try {
        $conn = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db, $dbuser, $dbpasswd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vous devrez diviser la chaîne $selectedPis en un tableau pour traiter chaque Raspberry Pi
        $selectedPisArray = explode(',', $selectedPis);

        // Transformez le tableau en une chaîne de caractères avec des marqueurs de position
        $selectedPisPlaceholders = implode(', ', array_fill(0, count($selectedPisArray), '?'));

        // Préparez la requête en utilisant des marqueurs de position pour les Raspberry Pi
        $query = "UPDATE pis SET group_id = ? WHERE ip IN ($selectedPisPlaceholders)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $existingGroup, PDO::PARAM_INT);

        // Liez chaque valeur du tableau individuellement
        foreach ($selectedPisArray as $index => $selectedPi) {
            $stmt->bindValue(($index + 2), $selectedPi, PDO::PARAM_STR);
        }

        if ($stmt->execute()) {
           // Mise à jour réussie, maintenant mettez à jour la colonne "membre" dans la table "groupes".
            $updateGroupMemberCountQuery = "UPDATE groupes g
                                           SET g.membres = (SELECT COUNT(p.ip) FROM pis p WHERE p.group_id = g.id)";
            $conn->exec($updateGroupMemberCountQuery);
        } else {
            echo "Erreur lors de la mise à jour de la base de données : " . implode(", ", $stmt->errorInfo());
        }

    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
} else {
    echo "Accès non autorisé.";
}
header("Location: list.php");
exit;
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
        <br>
        <br>
        <br>
        <a href="http://localhost/list.php" class="precedent">&laquo; Précédent</a>
    </body>
    </html>