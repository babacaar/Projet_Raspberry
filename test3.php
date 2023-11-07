<?php
$host = '192.168.250.24';
$port = 22;
$username = 'pi';
$password = '22351414';

$connection = ssh2_connect($host, $port);
ssh2_auth_password($connection, $username, $password);
$stream = ssh2_exec($connection, '/home/pi/test.sh');
stream_set_blocking($stream, true);
$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$stream_out = stream_get_contents($stream_out);

echo trim($stream_out);

ssh2_disconnect($connection);
unset($connection);
?>