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
            require_once "./controller_config_files.php";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = $_POST["name"];
                $description = $_POST["description"];

                $pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db, $dbuser, $dbpasswd);

                if (isset($_POST['add'])) {
                    $name = $_POST['name'];
                    $description = $_POST['description'];

                    try {
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt = $pdo->prepare("SELECT * FROM groupes WHERE name = :name");
                        $stmt->bindParam(':name', $name);
                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {
                            $msg = "Le nom du groupe existe déjà. Veuillez en choisir un autre.";
                            include "../modules/error.php";
                        } else {
                            $insertStmt = $pdo->prepare("INSERT INTO groupes (name, description) VALUES (:name, :description)");
                            $insertStmt->bindParam(':name', $name);
                            $insertStmt->bindParam(':description', $description);

                            if ($insertStmt->execute()) {
                                $msg = "Le groupe a bien été ajouté.";
                                include "../modules/success.php";
                            } else {
                                $msg = "Erreur d'insertion dans la base de données.";
                                include "../modules/error.php";
                            }
                        }
                    } catch (PDOException $e) {
                        echo "<p class='debug-msg'>Erreur de connexion à la base de données : </p>" . $e->getMessage();
                    }
                }

                exit();
            }
            ?>

        </section>
    </div>
</body>


<!------------FOOTER------------>
<?php include "../modules/footer.php"; ?>