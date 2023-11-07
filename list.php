


<!DOCTYPE html>
<html>
<head>
    <title>Liste des Raspberry Pi</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
            width: 100%;
        }

        li {
            float: left;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover {
            background-color: #111;
        }

        body {
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            align-items: center;
        }

        h1 {
            background-color: lightblue;
            color: #000;
            padding: 10px;
            text-align: center;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }

        select {
            width: 100%;
            height: 100px;
        }
        select.gid{
            width: auto;
            height: auto;
        }

        li.dropdown {
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="configuration.php">
            <img class="logo-img" alt="Banniere" src="lycee.jpg">
        </a>
        <ul>
            <li><a href="list.php">Hôtes</a></li>
              
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Groupes</a>
                <div class="dropdown-content">
                  <a href="groupe.php">Lister groupes</a>
                  <a href="creationgroupe.php">Créer nouveau groupe</a>
                  
                </div>
            </li>
        </ul>
         
     </div>
    <h1>Liste des Raspberry Pi</h1>

    <label for="target_pis">Raspberry Pi cibles :</label>
    <select id="target_pis" name="target_pis[]" multiple>
        <?php
        require_once "controller_config_files.php";
        try {
            $conn = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $conn->query('SELECT * FROM pis');
            $rows = $stmt->fetchAll();

            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    echo '<option value="' . $row['ip'] . '">' . $row['name'] . ' - ' . $row['ip'] . '</option>';
                }
            } else {
                echo '<option disabled selected>OUPS pas de Raspberry disponible 😞</option>';
            }
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
        ?>
    </select>
    <?php
        require_once "controller_config_files.php";
        session_start();
        $db = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
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
          header("Location: list.php");
          exit();
        }
    ?>
    
    <div class="selected_group" style="display: none; width: auto; height: auto;">
        
        <form method="post" action="Update_table.php">
            <label for="group_id">Sélectionner un groupe :</label>
            <select class= "gid" name="group_id" id="groupid">
                <option value="">Sélectionner un groupe</option>
                <?php foreach ($groups as $group): ?>
                <option value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <input type="hidden" name="selected_pis" id="selected_pis" value="">
            <input type="hidden" name="existing_group" id="existing_group" value="">
            <input type="submit" value="Enregistrer">

        </form>
    </div>
    
    <br>
    <a href="gestionPis.php">Retour à l'ajout</a>

    <script>
    var existingGroup; // Déclarez existingGroup ici

    function addToGroup() {
        var targetPis = document.getElementById("target_pis");
        var selectedPis = Array.from(targetPis.selectedOptions).map(option => option.value);

        existingGroup = document.getElementById("existing_group").value; // Obtenez la valeur de l'élément HTML ici

        // Envoyer les données au serveur via une requête AJAX ou un formulaire
        alert("Ajout de ces Raspberry Pi (" + selectedPis.join(', ') + ") au groupe " + existingGroup);
    }

    document.getElementById("target_pis").addEventListener("change", function() {
        var selectedPis = document.getElementById("target_pis").selectedOptions;
        var selectedGroup = document.querySelector(".selected_group");

        selectedGroup.style.display = selectedPis.length > 0 ? "block" : "none";

    });


    document.getElementById("target_pis").addEventListener("change", function() {
            var selectedPis = Array.from(this.selectedOptions).map(option => option.value);
            document.getElementById("selected_pis").value = selectedPis.join(',');
        });

        document.getElementById("groupid").addEventListener("change", function() {
            document.getElementById("existing_group").value = this.value;
        });
</script>

</body>
</html>