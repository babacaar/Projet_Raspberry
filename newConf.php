<!DOCTYPE html>
<html>
<head>
    <title>Formulaire Raspberry Pi</title>
</head>
<body>
    <?php
    // Connexion à la base de données
    $dbhost = "localhost";
    $dbport = 3306;
    $dbname = "affichage";
    $dbuser = "root";
    $dbpasswd = "root";

    $conn = new mysqli($dbhost, $dbuser, $dbpasswd, $dbname);
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données: " . $conn->connect_error);
    }

    // Traitement du formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des valeurs du formulaire
        $nombreRaspberry = $_POST["nombre_raspberry"];
        $nombreGroupes = $_POST["nombre_groupes"];

        // Vérification et enregistrement des données
        if ($nombreRaspberry > 0 && $nombreGroupes > 0) {
            // Préparation de la requête SQL pour insérer les informations
            $stmt = $conn->prepare("INSERT INTO raspberries (hostname, ip, group_id) VALUES (?, ?, ?)");
            if ($stmt === false) {
                die("Erreur de préparation de la requête : " . $conn->error);
            }
            
            // Boucle pour traiter chaque Raspberry Pi
            //for ($i = 1; $i <= $nombreRaspberry; $i++) {
               // $hostname = $_POST["hostname$i"];
               // $ip = $_POST["ip$i"];
               // $groupe = $_POST["groupe$i"];

            for ($i = 1; $i <= $nombreRaspberry; $i++) {
    $hostname = isset($_POST["hostname$i"]) ? $_POST["hostname$i"] : "";
    $ip = isset($_POST["ip$i"]) ? $_POST["ip$i"] : "";
    $groupe = isset($_POST["groupe$i"]) ? $_POST["groupe$i"] : "";

    // Maintenant, vous pouvez utiliser $hostname, $ip et $groupe en toute sécurité

    
                
                // Exécution de la requête d'insertion
                if (!$stmt->bind_param("sss", $hostname, $ip, $groupe) || !$stmt->execute()) {
                    echo "Erreur lors de l'insertion des données pour la Raspberry Pi $i : " . $stmt->error;
                }
            }
            
            echo "Données enregistrées avec succès !";
        } else {
            echo "Veuillez saisir des valeurs valides pour le nombre de Raspberry Pi et le nombre de groupes.";
        }
        
        //$stmt->close();
    }
    
    // Fermer la connexion à la base de données
    $conn->close();
    ?>

    <h2>Formulaire Raspberry Pi</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nombre_raspberry">Nombre de Raspberry Pi :</label>
        <input type="number" name="nombre_raspberry" id="nombre_raspberry" required><br><br>

        <label for="nombre_groupes">Nombre de groupes de Raspberry Pi :</label>
        <input type="number" name="nombre_groupes" id="nombre_groupes" required><br><br>

        <?php
        // Génération des champs pour chaque Raspberry Pi
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $nombreRaspberry > 0 && $nombreGroupes > 0) {
            for ($i = 1; $i <= $nombreRaspberry; $i++) {
                echo "<h3>Raspberry Pi $i</h3>";
                echo "<label for='hostname$i'>Hostname :</label>";
                echo "<input type='text' name='hostname$i' id='hostname$i' required><br><br>";
                echo "<label for='ip$i'>IP :</label>";
                echo "<input type='text' name='ip$i' id='ip$i' required><br><br>";
                echo "<label for='groupe$i'>Groupe :</label>";
                echo "<input type='text' name='groupe$i' id='groupe$i' required><br><br>";
            }
        }
        ?>

        <input type="submit" value="Enregistrer">
    </form>
</body>
</html>
