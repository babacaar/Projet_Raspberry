
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Gestion des groupes</title>
    <style>
        .logo-img{
           display: block;
           margin: 0 auto;
           margin-bottom: 5px;
        }
        ul.navbar {
          list-style-type: none;
          margin: 0;
          padding: 0;
          overflow: hidden;
          background-color: #333;
          

        }

        li.floaters{
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
        h1 {
            background-color: lightblue;
            color: #000;
            padding: 10px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            cursor: pointer;
        }

        th:hover {
            background-color: #ddd;
        }
        tr:nth-child(even) {
          background-color: #dddddd;
        }

        .filter-input {
            width: 100%;
            padding: 5px;
        }
        li.dropdown {
          display: inline-block;
        }

        .dropdown-content {
          display: none;
          position: absolute;
          background-color: #f9f9f9;
          min-width: 160px;
          box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
          z-index: 1;
        }

        .dropdown-content a {
          color: black;
          padding: 12px 16px;
          text-decoration: none;
          display: block;
          text-align: left;
        }

        .dropdown-content a:hover {background-color: #f1f1f1;}

        .dropdown:hover .dropdown-content {
          display: block;
        }
        .text-center{
            text-align: center;
        }
        .pi-details-container {
            background-color: lightblue;
            
            /* Ajoutez d'autres styles personnalisés ici */
        }
        #pi-details {
            margin-top: 20px;
            background-color: lightblue;
            text-align: center;
            font-size: 24px;
        }

        #push-file-button {
            float: right;
        }


    </style>
</head>
<body>
        <a href="configuration.php">
            <img class="logo-img" alt="Banniere" src="lycee.jpg">
        </a>
    <ul class= "navbar">
              
        <li class="floaters"><a href="list.php">Hôtes</a></li>
              
        
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">Groupes</a>
            <div class="dropdown-content">
              <a href="groupe.php">Lister groupes</a>
              <a href="creationgroupe.php">Créer nouveau groupe</a>
              
            </div>
        </li>
    </ul>                                                             
    <h1>Liste des groupes</h1>
    <input type="text" id="myInput" class="filter-input" placeholder="Rechercher..."><br>
    <br>

        <!-- Code HTML pour le checkbox -->
    <div class="text-center">
        <div class="checkbox">
            <label for="hostMeShow">
                <input type="checkbox" name="hostMeShow" id="hostMeShow">
                Check here to see what hosts can be added
            </label>
        </div>
    </div>

    <label for="target_pis">Raspberry Pi Sans Groupe :</label>
    <select id="target_pis" name="target_pis[]" multiple>
    <?php
    require_once "controller_config_files.php";
    try {
        $conn = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db . '', $dbuser, $dbpasswd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->query('SELECT * FROM pis');
        $rows = $stmt->fetchAll();

        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $group_id = $row['group_id'];
                $data_group_id = ($group_id === null) ? 'null' : $group_id;
                echo '<option data-group_id="' . $data_group_id . '" value="' . $row['ip'] . '">' . $row['name'] . ' - ' . $row['ip'] . '</option>';
            }
        } else {
            echo '<option disabled selected>OUPS pas de Raspberry disponible 😞</option>';
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
    ?>
</select>
<br>
    <form method="post" action="" id="action-form">
        <table id="myTable">
            <thead>
                <tr>
                    <th></th> <!-- Colonne pour la case à cocher -->
                    <th onclick="sortTable(0)">ID</th>
                    <th onclick="sortTable(1)">Nom</th>
                    <th onclick="sortTable(2)">Membres</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Inclure le fichier de configuration de la base de données
                    require_once "controller_config_files.php";

                    try {
                        // Établir la connexion à la base de données
                        $pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db, $dbuser, $dbpasswd);
                        
                        // Préparer et exécuter une requête SQL pour récupérer les données des groupes
                        $query = "SELECT groupes.id, groupes.name, COUNT(pis.ip) AS membres 
                                    FROM groupes 
                                    LEFT JOIN pis ON groupes.id = pis.group_id 
                                    GROUP BY groupes.id, groupes.name";

                        $stmt = $pdo->query($query);

                        if ($stmt) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<tr>';
                                echo '<td><input type="checkbox" name="groupIDs[]" value="' . htmlspecialchars($row['id']) . '"></td>';
                                echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                                echo '<td><a href="javascript:void(0);" onclick="showGroupPis(' . htmlspecialchars($row['id']) . ')">' . htmlspecialchars($row['name']) . '</a></td>';

                                echo '<td>' . htmlspecialchars($row['membres']) . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo "Erreur lors de l'exécution de la requête : " . $pdo->errorInfo()[2];
                        }
                    } catch (PDOException $e) {
                        echo "Erreur de connexion à la base de données : " . $e->getMessage();
                    }

                ?>
            </tbody>
        </table>
        <button type="button" id="delete-button">Supprimer sélectionnés</button>
        <button type="button" id="push-file-button">Pousser fichiers</button>



    </form>
    <div  class= "pi-details-container" id="pi-details">
        <!-- Les détails des Raspberry Pi du groupe seront affichés ici. -->
    </div>

    <script>
        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("myTable");
            switching = true;
            dir = "asc"; 

            while (switching) {
                switching = false;
                rows = table.rows;

                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;

                    x = rows[i].getElementsByTagName("td")[n];
                    y = rows[i + 1].getElementsByTagName("td")[n];

                    if (dir === "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir === "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }

                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount === 0 && dir === "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }

        // Fonction de filtrage
        document.getElementById("myInput").addEventListener("keyup", function () {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";

                for (j = 0; j < tr[i].getElementsByTagName("td").length; j++) {
                    td = tr[i].getElementsByTagName("td")[j];

                    if (td) { 
                        txtValue = td.textContent || td.innerText;

                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        });

    function filterPis() {
        var checkbox = document.getElementById("hostMeShow");
        var label = document.querySelector("label[for='target_pis']");
        var select = document.getElementById("target_pis");
        var options = select.getElementsByTagName('option');

        if (checkbox.checked) {
            label.style.display = "block";
            select.style.display = "block";
        } else {
            label.style.display = "none";
            select.style.display = "none";
        }

        for (var i = 0; i < options.length; i++) {
            if (checkbox.checked) {
                if (options[i].getAttribute('data-group_id') === 'null') {
                    options[i].style.display = 'block';
                } else {
                    options[i].style.display = 'none';
                }
            } else {
                options[i].style.display = 'block';
            }
        }
    }

    document.getElementById("hostMeShow").addEventListener("change", filterPis);

    filterPis(); // Appel initial pour configurer l'état initial

        
    function showGroupPis(groupId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_pis.php?group_id=' + groupId, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var piDetails = JSON.parse(xhr.responseText);
                var detailsDiv = document.getElementById('pi-details');
                detailsDiv.innerHTML = ''; // Effacez le contenu précédent

                if (piDetails.length > 0) {
                    var ul = document.createElement('ul');
                    for (var i = 0; i < piDetails.length; i++) {
                        var li = document.createElement('li');
                        li.textContent = piDetails[i].name + ' - ' + piDetails[i].ip;
                        ul.appendChild(li);
                    }

                    // Créez un div conteneur pour les détails et ajoutez-lui la classe personnalisée
                    var detailsContainer = document.createElement('div');
                    detailsContainer.className = 'pi-details-container';
                    detailsContainer.appendChild(ul);

                    detailsDiv.appendChild(detailsContainer);
                } else {
                    detailsDiv.textContent = 'Aucun Raspberry Pi dans ce groupe.';
                }
            }
        };
        xhr.send();
    }
   // Détection de la case à cocher et redirection en fonction de l'action choisie
    document.getElementById("delete-button").addEventListener("click", function () {
        // Obtenez tous les éléments cochés
        var checkboxes = document.querySelectorAll("input[name='groupIDs[]']:checked");
        
        if (checkboxes.length > 0) {
            // S'il y a des éléments cochés, redirigez vers controller_delgroupe.php
            document.getElementById("action-form").action = "controller_delgroupe.php";
            document.getElementById("action-form").submit();
        } else {
            alert("Veuillez sélectionner au moins un groupe à supprimer.");
        }
    });

    document.getElementById("push-file-button").addEventListener("click", function () {
        // Obtenez tous les éléments cochés
        var checkboxes = document.querySelectorAll("input[name='groupIDs[]']:checked");
        //var checkboxes = document.querySelectorAll("input[name='selected_groups[]']:checked");

        if (checkboxes.length > 0) {
            // S'il y a des éléments cochés, redirigez vers envoi.php
            document.getElementById("action-form").action = "envoi.php";
            document.getElementById("action-form").submit();
        } else {
            alert("Veuillez sélectionner au moins un groupe pour pousser des fichiers.");
        }
    });  
    </script>
</body>
</html>
