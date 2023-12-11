<!------------HEADER------------>
<?php
$pageTitle = "Configuration des écrans"; // Titre de la page
$dropDownMenu = true;
include "modules/header.php";
?>

<!------------BODY------------>

<body>
    <div class="page">
        <section class="page-content">
            <form method="post" action="controllers/controller_config.php">
                <h1>Configurer l'Affichage</h1>
                <hr />

                <label for="Conf_sites0">Ajouter des Liens</label>
                <input type="text" name="Conf_sites0"
                    placeholder="Veuillez séparer vos liens par des espaces. (http://exemples.fr  http://examples.us) "
                    size="50" />

                <button tabindex="0" type="submit" class="submit-btn"><i class="fa-solid fa-floppy-disk"></i> Sauvegarder</button>
            </form>
        </section>

        <?php
        require_once "controllers/controller_config_files.php";
        $pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db . '', $dbuser, $dbpasswd);
        $stmt1 = $pdo->prepare("SELECT * FROM `configuration` ORDER BY Conf_id DESC LIMIT 1");
        $stmt1->bindParam(1, $id);
        $stmt1->execute();
        $res1 = $stmt1->fetchall();
        foreach ($res1 as $row1) {
            $link = $row1['Conf_sites'];
            $id = $row1['Conf_id'];
            $dateLastModif = $row1['Conf_date'];
        }
        ?>

        <section class="page-content">
            <h2>Derniers liens ajoutés</h2>
            <hr>

            <div class="links">
                <?php
                require_once "controllers/controller_config_files.php";
                $pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db . '', $dbuser, $dbpasswd);
                $stmt0 = $pdo->prepare("SELECT * FROM `configuration` ORDER BY Conf_id DESC LIMIT 1");
                $stmt0->bindParam(1, $id);
                $stmt0->execute();
                $res0 = $stmt0->fetchall();
                foreach ($res0 as $row0) {
                    $link = $row0['Conf_sites'];
                    $id = $row0['Conf_id'];
                    $dateLastModif = $row0['Conf_date'];
                    date_default_timezone_set('Europe/Paris');
                    $Conf_date = date('j-M-Y à H:i:s');
                    echo "<p class='date'>" . $Conf_date . "</p>" . "<p class='link'>" . $link . "</p>";
                }
                ?>
            </div>
        </section>
    </div>
</body>

<!------------FOOTER------------>
<?php include "modules/footer.php"; ?>