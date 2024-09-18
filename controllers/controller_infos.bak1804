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
            $msg = "";

                // Inclure le fichier de configuration de la base de données
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
                    $insertStmt = $pdo->prepare("INSERT INTO Informations (titre, infos, duration_seconds) VALUES (:titre, :infos, :durationSeconds)");
                    $insertStmt->bindParam(':titre', $titre);
                    $insertStmt->bindParam(':infos', $info);
                    $insertStmt->bindParam(':durationSeconds', $durationInSeconds);
                    // Exécuter la requête
                    if ($insertStmt->execute()) {

                        // Récupérer les données pour afficher sur une nouvelle page
                        $stmt1 = $pdo->prepare("SELECT infos, duration_seconds FROM `Informations`");
                        $stmt1->execute();
                        $res1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                        $news = $res1['infos'];
                        $durationIseconds = $res1['duration_seconds'];

                        // Ajouter un message supplémentaire pour indiquer que l'insertion a réussi
                        $msg .= "Informations insérées avec succès !<br>";
                    } else {
                        $msg .= "Error: " . $insertStmt->errorInfo()[2] . "<br>";
                    }
                }

                $stmt0 = $pdo->prepare("SELECT * FROM `configuration` ORDER BY Conf_id DESC LIMIT 1");
                $stmt0->execute();
                $res0 = $stmt0->fetch(PDO::FETCH_ASSOC);
                $link = $res0['Conf_sites'];
                $id = $res0['Conf_id'];
                $port = '22';
                $news = $siteUrl . "/display_info.php";

                $stmt2 = $pdo->prepare("SELECT Conf_id, Conf_date, Conf_sites, LENGTH(Conf_sites) - LENGTH(REPLACE(Conf_sites, ' ', '')) +2 AS nombre_de_liens FROM `configuration` ORDER BY Conf_id DESC LIMIT 1");
                $stmt2->execute();
                $res2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                $nombre_iterations = $res2['nombre_de_liens'];

                $compteur = '$compteur'; // Réinitialisation du compteur

                $static = <<<BASH
    #!/bin/bash
    # Compteur d'itérations
    compteur=0;
    duree=$durationInSeconds;
    # Fonction pour lancer Chromium
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

    #Fonction pour arrêter Chromium
    arreter_chromium() {
    killall chromium-browser
    #Ajoutez ici dutres commandes pour nettoyer l'environnement si nécessaire
    }

    # Lancer Chromium au début
    lancer_chromium

    while true; do
        xdotool keydown ctrl+Next
        xdotool keyup ctrl+Next

        xdotool keydown ctrl+r
        xdotool keyup ctrl+r

        sleep 15

BASH;

                $file = $dir . $nom . ".sh";

                // Liste des adresses IP des Raspberry Pi
                $raspberryPiIPs = [];

                $selectedGroups = isset($_POST["group_id"]) ? $_POST["group_id"] : [];

                try {

                // Établir une connexion à la base de données
                $pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db, $dbuser, $dbpasswd);

                // Boucle sur chaque groupe sélectionné
                foreach ($selectedGroups as $groupId) {
                    // Récupérez les adresses IP, le nom d'utilisateur et le mot de passe des Raspberry Pi pour ce groupe depuis la base de données
                    $query = "SELECT name, ip, username, password, video_acceptance FROM pis WHERE group_id = :group_id";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(":group_id", $groupId, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        // Utilisez fetchAll pour obtenir toutes les lignes de résultats
                        $raspberryPiIPs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Vérifier si le groupe est vide
                        if (empty($raspberryPiIPs)) {
                            throw new Exception("Aucun hôte trouvé pour le groupe sélectionné.");
                        }

                        // Boucle sur chaque Raspberry Pi du groupe
                        foreach ($raspberryPiIPs as $raspberryPiInfo) {
                            $ip = $raspberryPiInfo['ip'];
                            $username = $raspberryPiInfo['username'];
                            $password = $raspberryPiInfo['password'];
                            $video_acceptance = $raspberryPiInfo['video_acceptance'];
                            $name = $raspberryPiInfo['name'];

                            $fichier = @fopen($file, 'w');
                            if ($fichier === false) {
                                throw new Exception("Erreur lors de l'ouverture du fichier.");
                            }
                            fwrite($fichier, $static);
                            if ($video_acceptance == 1) {
                                fwrite($fichier, <<<BASH
   #Incrémente le compteur d'itérations
    ((compteur++))

    #Vérifie si le nombre d'itérations spécifié est atteint
    if [ "$compteur" -eq "$nombre_iterations" ]; then
        #Arrêtez le processus Chromium
        #arreter_chromium
        fermer_onglets_chromium

        #Lancement de la vidéo avec VLC
        mpv --fs /home/pi/Videos/video.mp4
        sleep 10
        #Attendez que VLC se termine avant de réinitialiser le compteur
        #Relancer Chromium après que VLC ait terminé
        lancer_chromium

        #Réinitialisez le compteur
        compteur=0
    fi
done\n

BASH
);
        } else {
                fwrite($fichier, <<<BASH
                #Aucune vidéo à lancer car video_acceptance n'est pas égal à 1
                #Relancer Chromium et réinitialiser le compteur
BASH
);
                            }


                            fclose($fichier);


                            // Tentative de connexion au serveur FTP
                            // echo "Tentative de connexion au serveur FTP $ip<br>";
                            $identifiant_Srv = ftp_connect($ip) or die("could not connect to $ip");

                            if (@ftp_login($identifiant_Srv, $username, $password)) {
                                $msg = "Connecté en tant que $name";
                                include "../modules/success.php";
                            } else {
                                throw new Exception("Connexion impossible en tant que $name");
                            }

                            // Transfert du fichier
                            $remote_file = $nom;
                            ftp_put($identifiant_Srv, $remote_file, $file, FTP_ASCII);
                            ftp_close($identifiant_Srv);

                            // Exécution du script
                            $connection = ssh2_connect($ip, $port);
                            ssh2_auth_password($connection, $username, $password);
			    $ssh_command = "/home/pi/time.sh $durationInSeconds";
                            echo "Commande SSH : $ssh_command <br>";

			    $stream = ssh2_exec($connection, $ssh_command);

//                            $stream = ssh2_exec($connection, "/home/pi/time.sh $durationInSeconds");
                            stream_set_blocking($stream, true);
                            $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
                            $stream_out = stream_get_contents($stream_out);

                            if ($stream_out === false) {
                                throw new Exception("Erreur lors de l'exécution du script sur $ip");
                            }

                            echo trim($stream_out);
                            ssh2_disconnect($connection);
                            unset($connection);

                            $msg = "Toutes les opérations ont été effectuées avec succès !";
                            var_dump($durationInSeconds);
			    include "../modules/success.php";
                        }
                    } else {
                        $msg = "Erreur lors de l'exécution de la requête SQL : " . print_r($stmt->errorInfo(), true);
                        include "../modules/error.php";
                    }
                }
            } catch (PDOException $e) {
                $msg .= "Erreur de connexion à la base de données : " . $e->getMessage();
                include "../modules/error.php";
            } catch (Exception $e) {
                $msg .= $e->getMessage();
                include "../modules/error.php";
            }


            ?>

        </section>
    </div>
</body>

<!------------FOOTER------------>
<?php include "../modules/footer.php"; ?>
