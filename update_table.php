<!------------HEADER------------>
<?php
$pageTitle = "Modifier Table"; // Titre de la page
$dropDownMenu = true;
include "modules/header.php";
?>

<!------------BODY------------>

<body>
    <div class="page">
        <section class="page-content">

            <?php
            require_once "controllers/controller_config_files.php";

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
                        $msg = "Erreur lors de la mise à jour de la base de données : " . implode(", ", $stmt->errorInfo());
                        include "./modules/error.php";
                    }

                } catch (PDOException $e) {
                    $msg = "Erreur de connexion à la base de données : " . $e->getMessage();
                    include "./modules/error.php";
                }
            } else {
                $msg = "Accès non autorisé.";
                include "./modules/error.php";
            }

            $msg = "L'hôte a bien été ajouté au groupe " . $existingGroup . ".";
            include "./modules/success.php";

            ?>

            <!-- <a tabindex="0" href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="back-btn"><i
            class="fa-solid fa-arrow-right-from-bracket fa-rotate-180"></i>Retour</a> -->

        </section>
    </div>

</body>


<!------------FOOTER------------>
<?php include "modules/footer.php"; ?>