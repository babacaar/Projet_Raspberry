<?php
//ACCESS DATABASE BDDEA
$db = "affichage";
$dbhost = "172.17.5.202";
$dbport = 3306;
$dbuser = "root";
$dbpasswd = "Koxo@361428";

/*/Acces RASP Kioskbsif	
	   //SSH
	   $ssh_kioskbsif_server= "192.168.250.24";
	   $ssh_kioskbsif_username = "pi";
	   $ssh_kioskbsif_password = "22351414";
	   $ssh_kioskbsif_port = "22";

	   //FTP				
	   $ftp_kioskbsif_server = "192.168.250.24";
	   $ftp_kioskbsif_username = "pi";
	   $ftp_kioskbsif_password = "22351414";

*/
// NAME servira de nom au fichier texte crée
$name = "Myfiles";
$nom = "MyfilesInfo";

//EMPLACEMENT DU FICHIER DANS LE RASP

$dir = "/var/www/monsite.fr/scripts/Affichage_";


//CREATION DU FICHIER DANS LE RASP
$fichier1 = fopen($name, 'c+b');

?>
