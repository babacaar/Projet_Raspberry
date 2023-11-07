<html>
  <head>
    <title>Formulaire en PHP/MySQL</title>
	<link rel="stylesheet" href="style.css" />
  </head>
  <body>
<?php
// Database settings
	$db="Affichage";
	$dbhost="172.17.5.202";
	$dbport=3306;
	$dbuser="root";
	$dbpasswd="22351414";
 
$pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
//$pdo->exec("SET CHARACTER SET utf8");
?>
	<form method="post" action="controller_update.php">
     Tache : <br />
	 <label for="TDL_id" name="TDL_id"></label>
	<select id="TDL_id" name="TDL_id">
		<option value="Merci de choisir" selected>Merci de choisir</option>
			<?php
				$stmt0 = $pdo->prepare("	SELECT * 
						FROM `ToDoList`
						WHERE TDL_Tache_Achieve='NON'
						");
				$stmt0->bindParam(1,$id);
				$stmt0->execute();
				$res0 = $stmt0->fetchall();
                foreach($res0 as $row0)
                {
					$TDL_id = $row0['TDL_id'];
                    echo '<option value="'.$TDL_id.'">'.$TDL_id.'</option>';
             
                }
            ?>
	</select><br />
	
	 
	 Tache éffectué : <br />
	<label for="TDL_Tache_Achieve" name="TDL_Tache_Achieve"></label>
	<select id="TDL_Tache_Achieve" name="TDL_Tache_Achieve">
		<option value="Merci de choisir" selected>Merci de choisir</option>
		<option value="OUI">OUI</option>
		<option value="NON">NON</option>
	</select><br />
	<input type="submit" value="Submit" /><br />
	<input type="button" onclick="window.location.href = 'http://172.17.5.202/menu.php';" value="Menu" /><br />
    </form>
   </body>
</html>