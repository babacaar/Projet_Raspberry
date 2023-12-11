<!------------HEADER------------>
<?php
session_start();
$pageTitle = "Liste des Rasperrys Pi"; // Titre de la page
$dropDownMenu = true;
include "modules/header.php";
?>

<!------------BODY------------>

<body>
    <div class="list page">

        <?php include "modules/list_menu.php"; ?>

        <section class="page-content">
            <h1>Liste des Hôtes</h1>
            <hr>

            <label for="target_pis">Hôtes cibles</label>
            <select id="target_pis" name="target_pis[]" multiple>
                <?php
                require_once "controllers/controller_config_files.php";
                try {
                    $conn = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db . '', $dbuser, $dbpasswd);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $conn->query('SELECT * FROM pis');
                    $rows = $stmt->fetchAll();

                    if (count($rows) > 0) {
                        foreach ($rows as $row) {
                            echo '<option value="' . $row['ip'] . '">' . $row['name'] . ' - ' . $row['ip'] . '</option>';
                        }
                    } else {
                        echo '<option disabled selected>Pas d\'hôte disponible...</option>';
                    }
                } catch (PDOException $e) {
                    echo "Erreur de connexion à la base de données : " . $e->getMessage();
                }
                ?>
            </select>

            <?php
            require_once "controllers/controller_config_files.php";
            
            $db = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db . '', $dbuser, $dbpasswd);
            // Récupérer tous les groupes depuis la table "groups"
            $query = "SELECT id, name FROM groupes";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Traitement du formulaire
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Récupérer le groupe sélectionné
                $selectedGroupId = $_POST['group_id'];

                // Mettre à jour la base de données avec le nouveau groupe sélectionné
                $query = "UPDATE pis SET group_id = :group_id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':group_id', $selectedGroupId);
                $stmt->execute();

                // Rediriger vers la page de configuration pour éviter la soumission du formulaire à nouveau en actualisant la page
                // header("Location: list.php");

                die();
            }
            ?>

            <div class="selected-group">

                <form method="post" action="update_table.php">

                    <label for="group_id">Sélectionner un groupe</label>
                    <select class="gid" name="group_id" id="groupid">
                        <option value="">Sélectionner un groupe</option>
                        <?php foreach ($groups as $group): ?>
                            <option value="<?php echo $group['id']; ?>">
                                <?php echo $group['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <input type="hidden" name="selected_pis" id="selected_pis" value="">
                    <input type="hidden" name="existing_group" id="existing_group" value="">
                    <button tabindex="0" type="submit" class="submit-btn">Ajouter</button>

                </form>
            </div>

        </section>
    </div>

    <script>
        var existingGroup; // Déclarez existingGroup ici

        function addToGroup() {
            var targetPis = document.getElementById("target_pis");
            var selectedPis = Array.from(targetPis.selectedOptions).map(option => option.value);

            existingGroup = document.getElementById("existing_group").value; // Obtenez la valeur de l'élément HTML ici

            // Envoyer les données au serveur via une requête AJAX ou un formulaire
            alert("Ajout de ces Hôtes (" + selectedPis.join(', ') + ") au groupe " + existingGroup);
        }

        document.getElementById("target_pis").addEventListener("change", function () {
            var selectedPis = document.getElementById("target_pis").selectedOptions;
            var selectedGroup = document.querySelector(".selected-group");

            selectedGroup.style.display = selectedPis.length > 0 ? "block" : "none";

        });


        document.getElementById("target_pis").addEventListener("change", function () {
            var selectedPis = Array.from(this.selectedOptions).map(option => option.value);
            document.getElementById("selected_pis").value = selectedPis.join(',');
        });

        document.getElementById("groupid").addEventListener("change", function () {
            document.getElementById("existing_group").value = this.value;
        });
    </script>

    <!------------FOOTER------------>
    <?php include "modules/footer.php"; ?>