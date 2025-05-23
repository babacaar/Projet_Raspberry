

<?php 
	
	require_once "controller_config_files.php";
	
		//RECUPERATION DES LIENS
    $pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
	$stmt0 = $pdo->prepare("SELECT * 
						FROM `Configuration`
						ORDER BY Conf_id DESC
                        LIMIT 1
						");
	$stmt0->bindParam(1,$id);
	$stmt0->execute();
	$res0 = $stmt0->fetchall();
	foreach ( $res0 as $row0 )
	{
		$link = $row0['Conf_sites'];
		$id = $row0['Conf_id'];
		//$dateLastModif = $row0['Conf_date'];
	}

		
		
		//GENERATION DU FICHIER

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
		   sleep 50\n
		done\n";
		
	$pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
	$stmt1 = $pdo->prepare("SELECT * 
						FROM `Configuration`
						ORDER BY Conf_id DESC
                        LIMIT 1
						");
	$stmt1->bindParam(1,$id);
	$stmt1->execute();
	$res1 = $stmt1->fetchall();
	foreach ( $res1 as $row1 )
	{
		$link = $row1['Conf_sites'];
		$id = $row1['Conf_id'];
		$dateLastModif = $row1['Conf_date'];
		//$dateLastModifGener = $row1['Generation_date'];
	}
		echo "La dernière génération est faite le " .$dateLastModif." ! <br>";


		// ENREGISTREMENT DU FICHIER .sh EN LOCAL
	$file = $dir.$name.".sh";
	
	$fichier = fopen($file,'w');
	fwrite($fichier,$static);
	fclose($fichier);


		//CHARGEMENT DU FICHIER DANS UN SERVEUR FTP PAR EXEMPLE
//CONNEXION EN FTP ET TRANSFERT DU FICHIER DANS LE RASPBERRY
	$identifiant_Srv = ftp_connect($ftp_kioskbsif_server) or die("could not connect to $ftp_kioskbsif_server");

	if (@ftp_login($identifiant_Srv, $ftp_kioskbsif_username, $ftp_kioskbsif_password)) 
		{ 
			echo "Connecté en tant que $ftp_kioskbsif_username@$ftp_kioskbsif_server\n";
			//die("Impossible de se connecter au serveur.");
			echo "<br>";
		}
		 else 
		 {
		 	echo "Connexion impossible en tant que $ftp_kioskbsif_username\n";
		 	echo "<br>";
		 }

		$remote_file = $name;
		ftp_put($identifiant_Srv, $remote_file,$file, FTP_ASCII);
		ftp_close($identifiant_Srv);
//FIN DU TRANSFERT DU FICHIER ET DECONNEXION



//CONNEXION EN SSH AU RASPBERRY ET AFFICHAGE DES LIENS CONTENUS DANS LE FICHER TRANSFERE PAR FTP 
		$connection = ssh2_connect($ssh_kioskbsif_server, $ssh_kioskbsif_port);
		ssh2_auth_password($connection, $ssh_kioskbsif_username, $ssh_kioskbsif_password);
		$stream = ssh2_exec($connection, '/home/pi/test.sh');
		stream_set_blocking($stream, true);
		$stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
		$stream_out = stream_get_contents($stream_out);
		echo trim($stream_out);

	ssh2_disconnect($connection);
	unset($connection);
//DECONNEXION AU SRV RASP
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