<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
	    margin : 0;
            padding :0;
            position : relative;
        }
        body::before {
            content: "";
            background: url('bg.JPG') center center fixed;
            background-size: cover;
            position: fixed;
            width: 100%;
            height: 100%;
            filter: blur(3px); /* Ajuste la valeur de flou selon tes besoins */
            z-index: -1;
        }
        .container {
            background-color:lightblue; /* Opacité pour rendre le conteneur plus lisible */
            padding: 45px;
            margin-top: 50px;
            border-radius: 10px;
        }
    </style>
    <title>Formulaire d'information</title>
</head>
<body>

<div class="container">
    <h2>Formulaire d'Information</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="titre">TITRE</label>
            <input type="text" class="form-control" id="titre" name="titre" required>
        </div>
        <div class="form-group">
            <label for="infos">Information à saisir</label>
            <textarea class="form-control" id="infos" name="infos" ></textarea>
        </div>

	<div class="form-group">
    	    <label for="displayDateTime">Date et heure d'affichage :</label>
            <input type="datetime-local" class="form-control" id="displayDateTime" name="displayDateTime" required>
	</div>

	<div class="form-group">
	  <label for="duration">Durée (hh:mm:ss) :</label>
    	  <input type="text" class="form-control" id="duration" name="duration" pattern="^([0-1]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$" required>
          <small>Format : hh:mm:ss</small>
	</div>
	<div class="form-group">
	<label for="groupid">Sélectionner un groupe :</label>
            <select class= "form-control" name="group_id[]" id="groupid" multiple>
		<?php
            require_once "controller_config_files.php";
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
                <--!option value="">Sélectionner un groupe</option-->
            </select><br><br>
	</div>
           <input type="hidden" name="selected_pis" id="selected_pis" value="">
           <input type="hidden" name="existing_group" id="existing_group" value="">
        <button type="submit" class="btn btn-primary">Partager</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script>$(document).ready(function(){
	$('#groupid').selectpicker();
	});
</script>
</body>
</html>


    <?php
	require_once "controller_config_files.php";
    // Traitement des données du formulaire après la soumission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db, $dbuser, $dbpasswd);

        // Récupérer les données du formulaire
        //$info = $_POST['infos'];
        //$description = $_POST['description'];
	$titre = isset($_POST['titre']) ? $_POST['titre'] : '';
	$info = isset($_POST['infos']) ? $_POST['infos'] : '';
	$duration = isset($_POST['duration']) ? $_POST['duration'] : '00:00:00';

	// Séparer les heures, minutes et secondes
    	list($hours, $minutes, $seconds) = explode(':', $duration);

	// Convertir la durée en secondes
    	$durationInSeconds = $hours * 3600 + $minutes * 60 + $seconds;
        // Préparer la requête SQL pour l'insertion
	$insertStmt = $pdo->prepare("INSERT INTO Informations (titre, infos, duration_seconds) VALUES (:titre, :infos,:durationSeconds)");
        $insertStmt->bindParam(':titre', $titre);
        $insertStmt->bindParam(':infos', $info);
	$insertStmt->bindParam(':durationSeconds', $durationInSeconds);

        // Exécuter la requête
	if ($insertStmt->execute()) {
        	echo "<p class='text-success'>Informations insérées avec succès!</p>";

        	// Récupérer les données pour afficher sur une nouvelle page
        	$stmt1 = $pdo->prepare("SELECT infos, duration_seconds FROM `Informations`");
        	$stmt1->execute();
        	$res1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        	$news = $res1['infos'];
		$durationInSeconds = $res1['duration_seconds'];
       	} else {
        echo "Error: " . $insertStmt->errorInfo()[2];
    	}
    }
    $stmt0 = $pdo->prepare("SELECT * FROM `configuration` ORDER BY Conf_id DESC LIMIT 1");
$stmt0->execute();
$res0 = $stmt0->fetch(PDO::FETCH_ASSOC); // Utilisez fetch pour obtenir une seule ligne
$link = $res0['Conf_sites'];
$id = $res0['Conf_id'];
$port = '22';
$news = "http://172.17.5.202/displayInfo.php";

$stmt2 = $pdo->prepare ("SELECT Conf_id, Conf_date, Conf_sites, LENGTH(Conf_sites) - LENGTH(REPLACE(Conf_sites, ' ', '')) +2 AS nombre_de_liens FROM `configuration` ORDER BY Conf_id DESC LIMIT 1");
$stmt2->execute();
$res2 = $stmt2->fetch(PDO::FETCH_ASSOC);
$nombre_iterations = $res2['nombre_de_liens'];
var_dump($nombre_iterations);
$compteur= '$compteur';
var_dump($compteur);
$static = <<<BASH
#!/bin/bash
#Compteur d'itérations
compteur=0;

#Fonction pour lancer Chromium
lancer_chromium() {
    xset s noblank
    xset s off
    xset -dpms
    unclutter -idle 1 -root &
 /usr/bin/chromium-browser --kiosk --noerrdialogs $news $link &
}

fermer_onglets_chromium() {
    xdotool search --onlyvisible --class "chromium-browser" windowfocus key ctrl+shift+w
    wmctrl -k off
}

#Lancer Chromium au début
lancer_chromium

while true; do
    xdotool keydown ctrl+Next
    xdotool keyup ctrl+Next

    xdotool keydown ctrl+r
    xdotool keyup ctrl+r

    sleep 15

    #Incrémente le compteur d'itérations
    ((compteur++))

    #Vérifie si le nombre d'itérations spécifié est atteint
    if [ "$compteur" -eq "$nombre_iterations" ]; then
        #Arrêtez le processus Chromium
        #arreter_chromium
        fermer_onglets_chromium

        #Lancement de la vidéo avec VLC
        mpv --fs /home/pi/Videos/Gestes.mp4
        #sleep 10
        #Attendez que VLC se termine avant de réinitialiser le compteur


        #Relancer Chromium après que VLC ait terminé
        lancer_chromium

        #Réinitialisez le compteur
        compteur=0
    fi

done\n
BASH;

$file = $dir . $name . ".sh";
var_dump($file);
// Liste des adresses IP des Raspberry Pi
$raspberryPiIPs = [];

$selectedGroups = isset($_POST["groupIDs"]) ? $_POST["groupIDs"] : [];
var_dump($selectedGroups);

try {
    // Établir une connexion à la base de données
    $pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db, $dbuser, $dbpasswd);

    // Boucle sur chaque groupe sélectionné
    foreach ($selectedGroups as $groupId) {
        // Récupérez les adresses IP, username et password des Raspberry Pi pour ce groupe depuis la base de données
        $query = "SELECT ip, username, password FROM pis WHERE group_id = :group_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":group_id", $groupId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Utilisez fetchAll pour obtenir toutes les lignes de résultats
            $raspberryPiIPs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Boucle sur chaque Raspberry Pi du groupe
            foreach ($raspberryPiIPs as $raspberryPiInfo) {
                $ip = $raspberryPiInfo['ip'];
                $username = $raspberryPiInfo['username'];
                $password = $raspberryPiInfo['password'];

                $fichier = fopen($file, 'w');
                fwrite($fichier, $static);
                fclose($fichier);

                // Tentative de connexion au serveur FTP
                echo "Tentative de connexion au serveur FTP $ip\n";
                $identifiant_Srv = ftp_connect($ip) or die("could not connect to $ip");

                if (@ftp_login($identifiant_Srv, $username, $password)) {
                    echo "Connecté en tant que $username@$ip\n";
                    echo "<br>";
                } else {
                    echo "Connexion impossible en tant que $username\n";
                    echo "<br>";
                }
var_dump($username);

                // Transfert du fichier
                $remote_file = $name;
                ftp_put($identifiant_Srv, $remote_file, $file, FTP_ASCII);
                ftp_close($identifiant_Srv);

                // Exécution du script
                $connection = ssh2_connect($ip, $port);
                ssh2_auth_password($connection, $username, $password);
                //ssh2_scp_send($connection, "/var/www/monsite.fr/displayInfo.php", "/home/pi/displayInfo.php", 0755);
                //scp /var/www/monsite.fr/displayInfo.php $username@$ip:/home/pi/
                $stream = ssh2_exec($connection, "/home/pi/test.sh");
                stream_set_blocking($stream, true);
                $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
                $stream_out = stream_get_contents($stream_out);
                echo trim($stream_out);
                var_dump($username);
                ssh2_disconnect($connection);
                unset($connection);
            }
        } else {
            echo "Erreur lors de l'exécution de la requête SQL : " . print_r($stmt->errorInfo(), true);
        }
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
  ?>


<!DOCTYPE html>
<html>
<head>
    <style>
        a {
            text-decoration: none;
            display: inline-block;
            padding: 8px 16px;
            margin-top: 10px;
        }

        .precedent {
            background-color: #04AA6D;
            color: black;
        }
    </style>
</head>
<body>
    <br>
    <br>
    <br>
    <a href="http://172.17.5.202/configuration.php" class="precedent">&laquo; Précédent</a>
</body>
</html>
