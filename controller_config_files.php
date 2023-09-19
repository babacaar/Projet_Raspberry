<?php 
	//ACCESS DATABASE BDDEA
 	$db="Affichage";
	$dbhost="172.17.5.202";
	$dbport=3306;
	$dbuser="kiosk";
	$dbpasswd="22351414";

	//Acces RASP Kioskbsif	
		//SSH
		$ssh_kioskbsif_server= "192.168.250.24";
		$ssh_kioskbsif_username = "pi";
		$ssh_kioskbsif_password = "22351414";
		$ssh_kioskbsif_port = "22";

		//FTP				
		$ftp_kioskbsif_server = "192.168.250.24";
		$ftp_kioskbsif_username = "pi";
		$ftp_kioskbsif_password = "22351414";


	// NAME servira de nom au fichier texte crée
	$name = "Myfiles";


		//EMPLACEMENT DU FICHIER DANS LE RASP

	$dir = "/var/www/monsite.fr/Affichage_";


		//CREATION DU FICHIER DANS LE RASP
	$fichier = fopen($name, 'c+b');
	
?>