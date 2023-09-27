<?php
$host = '192.168.250.24';
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


/*
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



