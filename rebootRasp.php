<?php
ini_set('display_errors', 1);

require_once "controller_config_files.php";

// Établir une connexion à la base de données
$pdo = new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db, $dbuser, $dbpasswd);

// Liste des adresses IP des Raspberry Pi
$raspberryPiIPs = [];
$port = '22';
$selectedGroups = isset($_POST["groupIDs"]) ? $_POST["groupIDs"] : [];
var_dump($selectedGroups);

try {
    // Boucle sur chaque groupe sélectionné
    foreach ($selectedGroups as $groupId) {
        // Récupérez les adresses IP, username et password des Raspberry Pi pour ce groupe depuis la base de données
        $query = "SELECT ip, username, password FROM pis WHERE group_id = :group_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":group_id", $groupId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $raspberryPiIPs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Boucle sur chaque Raspberry Pi du groupe
            foreach ($raspberryPiIPs as $raspberryPiInfo) {
                $ip = $raspberryPiInfo['ip'];
                $username = $raspberryPiInfo['username'];
                $password = $raspberryPiInfo['password'];

                // Établissez une connexion SSH
                $connection = ssh2_connect($ip, $port);
                if (ssh2_auth_password($connection, $username, $password)) {
                    $stream = ssh2_exec($connection, '/home/pi/reboot.sh');
                    stream_set_blocking($stream, true);
                    $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
                    $stream_out = stream_get_contents($stream_out);
                    echo "Script de redémarrage exécuté sur $ip :\n";
                    echo trim($stream_out) . "\n\n";
                    ssh2_disconnect($connection);
                } else {
                    echo "Impossible de se connecter à $ip avec le nom d'utilisateur $username.\n";
                }
            }
        } else {
            echo "Erreur lors de l'exécution de la requête SQL : " . print_r($stmt->errorInfo(), true);
        }
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}






/*$host = '192.168.250.24';
$port = 22;
$username = 'pi';
$password = '22351414';

$connection = ssh2_connect($host, $port);
ssh2_auth_password($connection, $username, $password);
$stream = ssh2_exec($connection, '/home/pi/reboot.sh');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$stream_out = stream_get_contents($stream_out);

echo trim($stream_out);

ssh2_disconnect($connection);
unset($connection);



$host = '192.168.250.24';
$port = 22;
$username = 'pi';
$password = '22351414';

$connection = ssh2_connect($host, $port);
if (!$connection) {
    die('La connexion SSH a échoué');
}

if (!ssh2_auth_password($connection, $username, $password)) {
    die('L'authentification SSH a échoué');
}

$stream = ssh2_exec($connection, '/home/pi/reboot.sh');
if (!$stream) {
    die('L'exécution du script SSH a échoué');
}

stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
if (!$stream_out) {
    die('La récupération du flux SSH a échoué');
}

$stream_out = stream_get_contents($stream_out);

echo trim($stream_out);

ssh2_disconnect($connection);
unset($connection);
*/
?>



