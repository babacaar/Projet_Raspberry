<!DOCTYPE html>
<html>
   <head>
        <title>ABSENCES</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="cours.css">
    </head>
    <body>
        <h1>Absences Titre h1</h1>  
        <?php
		    $servername = '172.17.5.200';
            $username = 'wpuser';
            $password = '22351414';
			$database = 'mm';
            
            //On établit la connexion
            $conn = mysqli_connect($servername,$username,$password,$database);
            //$conn = new mysqli($servername, $username, $password , $database);
			//On vérifie la connexion
            //if(!$conn){
            //    die('Erreur : ' .mysqli_connect_error());
            //}
            //echo 'Connexion réussie';
			
		// lancement de la requete
		$sql = 'SELECT nomAbsProf FROM Absence WHERE idAbsProf = "99"';

		// on lance la requête (mysql_query) et on impose un message d'erreur si la requête ne se passe pas bien (or die)
		$req = mysql_query($sql) or die('Impossible de se connecter : ' . mysql_error());

		// on recupere le resultat sous forme d'un tableau
		$data = mysql_fetch_array($req);

		// on libère l'espace mémoire alloué pour cette interrogation de la base
		mysql_free_result ($req);
		mysql_close ();
		?>
Le numéro de téléphone de LA GLOBULE est :<br />
<?php echo $data['nomAbsProf']; ?>
    </body>
</html>
