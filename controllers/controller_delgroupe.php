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
            // Inclure le fichier de configuration de la base de données
            require_once "./controller_config_files.php";

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['groupIDs']) && is_array($_POST['groupIDs'])) {
                // Établir la connexion à la base de données
                $pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db, $dbuser, $dbpasswd);
                // Supprimer les groupes sélectionnés de la base de données
                $groupIDs = $_POST['groupIDs'];
                $placeholders = implode(',', array_fill(0, count($groupIDs), '?'));

                $sql = "DELETE FROM groupes WHERE id IN ($placeholders)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($groupIDs);

                // Récupérer les groupes restants après la suppression
                $query = "SELECT id, name, membres FROM groupes";
                $stmt = $pdo->query($query);
                $remainingGroups = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Réorganiser les ID de manière continue
                $newID = 1;
                foreach ($remainingGroups as $group) {
                    // Mettre à jour l'ID du groupe dans la base de données
                    $updateQuery = "UPDATE groupes SET id = ? WHERE id = ?";
                    $updateStmt = $pdo->prepare($updateQuery);
                    $updateStmt->execute([$newID, $group['id']]);
                    $newID++;
                }

                $msg = "Le groupe a bien été supprimé.";
                include "../modules/success.php";
            }
            ?>

        </section>
    </div>
</body>


<!------------FOOTER------------>
<?php include "../modules/footer.php"; ?>