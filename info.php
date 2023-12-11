<!------------HEADER------------>
<?php
$pageTitle = "Formulaire d'Information"; // Titre de la page
$dropDownMenu = true;
include "modules/header.php";
?>

<!------------BODY------------>

<body>
    <div class="info page">
        <section class="page-content">
            <form method="post" action="controllers/controller_infos.php">
                <h1>Informations</h1>

                <hr />

                <label for="titre">Titre <span class="required">*</span></label>
                <input type="text" id="titre" name="titre" required>

                <label for="infos">Information à saisir <span class="required">*</span></label>
                <textarea id="infos" name="infos"></textarea>

                <label for="duration">Durée <span class="required">*</span></label>
                <input type="text" id="duration" name="duration" placeholder="hh:mm:ss"
                    pattern="^([0-1]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$" required oninput="formatDuration(this)">
                <small>Format : hh:mm:ss</small>

                <div class="form-group">
                    <label for="groupid">Sélectionner un groupe <span class="required">*</span></label>
                    <select class="form-control selectpicker" name="group_id[]" id="groupid" multiple
                        data-live-search="true" title="Aucun groupe sélectionné">
                        <?php
                        require_once "controllers/controller_config_files.php";
                        $pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db, $dbuser, $dbpasswd);

                        // Récupérer tous les groupes depuis la table "groupes"
                        $query = "SELECT id, name FROM groupes";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Générer les options de la liste déroulante
                        foreach ($groups as $group) {
                            echo '<option value="' . $group['id'] . '">' . $group['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <input type="hidden" name="selected_pis" id="selected_pis" value="">
                <input type="hidden" name="existing_group" id="existing_group" value="">

                <button tabindex="0" type="submit" class="submit-btn"><i class="fa-solid fa-floppy-disk"></i>
                    Sauvegarder</button>
            </form>

        </section>
    </div>
</body>

<script>
    function formatDuration(input) {
        let inputValue = input.value.replace(/\D/g, ''); // Supprimez tous les caractères non numériques
        let formattedValue = '';

        if (inputValue.length > 2) {
            formattedValue += inputValue.substring(0, 2) + ':';
            inputValue = inputValue.substring(2);
        }

        if (inputValue.length > 2) {
            formattedValue += inputValue.substring(0, 2) + ':';
            inputValue = inputValue.substring(2);
        }

        formattedValue += inputValue; // Ajoutez le reste de la saisie

        input.value = formattedValue.substring(0, 8); // Limitez la longueur à 8 caractères (hh:mm:ss)
    }
</script>

<!------------FOOTER------------>
<?php include "modules/footer.php"; ?>