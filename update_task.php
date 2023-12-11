<!------------HEADER------------>
<?php
$pageTitle = "Formulaire en PHP/MySQL"; // Titre de la page
$dropDownMenu = true;
include "modules/header.php";
?>

<!------------BODY------------>

<body>
    <?php
    // Database settings
    $db = "Affichage";
    $dbhost = "localhost";
    $dbport = 3306;
    $dbuser = "root";
    $dbpasswd = "root";

    $pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db . '', $dbuser, $dbpasswd);
    //$pdo->exec("SET CHARACTER SET utf8");
    ?>

    <div class="update-task page">

        <section class="page-content">
            <form method="post" action="controllers/controller_update.php">
                <h2>Modifier une Tâche</h2>
                <hr />

                <label for="TDL_id" name="TDL_id">Tâche</label>
                <select id="TDL_id" name="TDL_id">
                    <option value="Merci de choisir" selected>Merci de choisir</option>

                    <?php
                    $stmt0 = $pdo->prepare("SELECT * FROM `ToDoList` WHERE TDL_Tache_Achieve='NON' ");
                    $stmt0->bindParam(1, $id);
                    $stmt0->execute();
                    $res0 = $stmt0->fetchall();
                    foreach ($res0 as $row0) {
                        $TDL_id = $row0['TDL_id'];
                        echo '<option value="' . $TDL_id . '">' . $TDL_id . '</option>';
                    }
                    ?>
                </select>

                <label for="TDL_Tache_Achieve" name="TDL_Tache_Achieve">Tâche effectuée :</label>
                <select id="TDL_Tache_Achieve" name="TDL_Tache_Achieve">
                    <option value="Merci de choisir" selected>Merci de choisir</option>
                    <option value="OUI">OUI</option>
                    <option value="NON">NON</option>
                </select>

                <button tabindex="0" type="submit" class="submit-btn">Sauvegarder</button>
            </form>
        </section>
    </div>
</body>

<!------------FOOTER------------>
<?php include "modules/footer.php"; ?>