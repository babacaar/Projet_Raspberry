<?php
// on se connecte à notre base
$base = mysql_connect ('172.17.5.200', 'root', 'q32hXjJcjnczQlU6lzNE');
mysql_select_db ('mm', $base) ;
?>
<html>
<head>
<title>Absence</title>
</head>
<body>
<?php
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