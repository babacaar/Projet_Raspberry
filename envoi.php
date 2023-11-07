<?php
ini_set('display_errors', 1);

require_once "controller_config_files.php";

// Récupération des liens
$pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db, $dbuser, $dbpasswd);
$stmt0 = $pdo->prepare("SELECT * FROM `configuration` ORDER BY Conf_id DESC LIMIT 1");
$stmt0->execute();
$res0 = $stmt0->fetchAll();
$link = "";
$id = 0;

foreach ($res0 as $row0) {
    $link = $row0['Conf_sites'];
    $id = $row0['Conf_id'];
}


    $static=
        "#!/bin/bash\n

            xset s noblank\n
            xset s off\n
            xset -dpms\n
            unclutter -idle 1 -root &\n

            #/usr/bin/chromium-browser --kiosk --noerrdialogs http://10.49.11.214/captures/capturemm.png http://10.49.11.214/captures/capturemm.png http://10.49.11.214/captures/capturemm.png https://lpjw.fr/ecrans/menu.jpg &\n
            /usr/bin/chromium-browser --kiosk --noerrdialogs $link &\n

        while true; do\n
           xdotool keydown ctrl+Next; xdotool keyup ctrl+Next;\n
           xdotool keydown ctrl+r; xdotool keyup ctrl+r;\n
           sleep 15\n
        done\n";


    $file = $dir.$name.".sh";
    $fichier = fopen($file,'w');
    fwrite($fichier,$static);
    fclose($fichier);

// Liste des adresses IP des Raspberry Pi
$raspberryPiIPs = [];

$selectedGroups = isset($_POST["groupIDs"]) ? $_POST["groupIDs"] : [];
var_dump($selectedGroups);
try {
    // Établir une connexion à la base de données
    $pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db, $dbuser, $dbpasswd);

    // Boucle sur chaque groupe sélectionné
    foreach ($selectedGroups as $groupId) {
        // Récupérez les adresses IP des Raspberry Pi pour ce groupe depuis la base de données
        $query = "SELECT ip FROM pis WHERE group_id = :group_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":group_id", $groupId, PDO::PARAM_INT);
            if ($stmt->execute()) {
        $raspberryPiIPs = array_merge($raspberryPiIPs, $stmt->fetchAll(PDO::FETCH_COLUMN));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Erreur lors de l'exécution de la requête SQL : " . print_r($stmt->errorInfo(), true);
    }
        var_dump($raspberryPiIPs);

        // Boucle sur chaque Raspberry Pi du groupe
        foreach ($raspberryPiIPs as $raspberryPiIP) {
            // Tentative de connexion au serveur FTP
            echo "Tentative de connexion au serveur FTP $raspberryPiIP\n";
            $identifiant_Srv = ftp_connect($raspberryPiIP) or die("could not connect to $raspberryPiIP");

            if (@ftp_login($identifiant_Srv, $row['username'], $row['password'])) {
                echo "Connecté en tant que" .$row['username'].@"$raspberryPiIP\n";
                echo "<br>";
            } else {
                echo "Connexion impossible en tant que ".$row['username']."\n";
                echo "<br>";
            }

            // Transfert du fichier
            $remote_file = $name;
            ftp_put($identifiant_Srv, $remote_file, $file, FTP_ASCII);
            ftp_close($identifiant_Srv);

            // Exécution du script
            $connection = ssh2_connect($raspberryPiIP, $port);
            ssh2_auth_password($connection, $row['username'], $row['password']); 
            $stream = ssh2_exec($connection, '/home/pi/test.sh');
            stream_set_blocking($stream, true);
            $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
            $stream_out = stream_get_contents($stream_out);
            echo trim($stream_out);

            ssh2_disconnect($connection);
            unset($connection);
        }
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}









    











/*// Fonction pour transférer un fichier via FTP
                function transferFileViaFTP($server, $Username, $Password, $file, $remoteFile) {
                    $connection = ftp_connect($Server);
                    if ($connection) {
                        if (ftp_login($connection, $Username, $Password)) {
                            echo "Connecté en tant que $Username@$Server via FTP\n";
                            ftp_put($connection, $remoteFile, $file, FTP_ASCII);
                            echo "Fichier transféré via FTP avec succès\n";
                            ftp_close($connection);
                        } else {
                            echo "Connexion FTP échouée en tant que $Username\n";
                        }
                    } else {
                        echo "Connexion au serveur FTP échouée\n";
                    }
                }

                // Fonction pour exécuter un script via SSH
                function executeScriptViaSSH($Server, $Port, $Username, $Password, $remoteScript) {
                    $connection = ssh2_connect($Server, $Port);
                    if (ssh2_auth_password($connection, $Username, $Password)) {
                        echo "Connecté en tant que $Username@$Server via SSH\n";
                        $stream = ssh2_exec($connection, $remoteScript);
                        stream_set_blocking($stream, true);
                        $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
                        $stream_out = stream_get_contents($stream_out);
                        echo trim($stream_out);
                        ssh2_disconnect($connection);
                    } else {
                        echo "Connexion SSH échouée en tant que $Username\n";
                    }
                }

        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $Server = $row['ip'];
                $Username = $row['username'];
                $Password = $row['password'];
                $Port = '22';

                // Générez le contenu du script pour chaque Raspberry Pi
                $static = "#!/bin/bash\n";
                $static .= "xset s noblank\n";
                $static .= "xset s off\n";
                $static .= "xset -dpms\n";
                $static .= "unclutter -idle 1 -root &\n";
                $static .= "/usr/bin/chromium-browser --kiosk --noerrdialogs $link &\n";
                $static .= "while true; do\n";
                $static .= "xdotool keydown ctrl+Next; xdotool keyup ctrl+Next;\n";
                $static .= "xdotool keydown ctrl+r; xdotool keyup ctrl+r;\n";
                $static .= "sleep 15\n";
                $static .= "done\n";

                // Chemin du fichier sur le serveur local
                //$dir = "/path/to/directory/"; // Mettez le chemin du répertoire où vous souhaitez enregistrer les fichiers
                //$name = "script";
                $file = $dir . $name . ".sh";
                $remoteFile = $name;

                // Enregistrez le fichier en local
                $fichier = fopen($file, 'w');
                fwrite($fichier, $static);
                fclose($fichier);

                $remoteScript = "/home/pi/test.sh"; // Assurez-vous que le chemin du script est correct sur le Raspberry Pi

                

                foreach ($raspberryIPs as $ip) {
                $remoteScript = '/home/pi/test.sh';
                
                // Transférer le fichier via FTP
                transferFileViaFTP($Server, $Username, $Password, $file, $remoteFile);
                
                // Exécuter le script via SSH
                executeScriptViaSSH($Server, $Port, $Username, $Password, $remoteScript);
            }
            }
        }
    }

    echo "Opération de Pousser fichier réussie.";
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}*/

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