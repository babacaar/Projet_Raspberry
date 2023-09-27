<html>
  <head>
    <title>Configuration des écrans </title>
	<link rel="stylesheet" href="style.css" />
  </head>
  <body>
  	<img style="width:50%; height: 18%; display: block; margin-left: auto; margin-right: auto;  max-width:1000px" alt="Banniere" src="logo.png"> 
     <form method="post" action="controller_config.php">

     	Mes Liens <br />
	 <input type="text" name="Conf_sites0" placeholder="Veuillez séparer vos liens par des espaces. (http://exemples.fr  http://examples.us) " size="30"/>
	 <br />

 

<!-- ==============Bouton Submit -->
	<div>
		<input class="button" style= "padding: 15px 25px;
			  font-size: 24px;
			  text-align: center;
			  cursor: pointer;
			  outline: none;
			  color: #000;
			  background-color: lightblue;
			  border: none;
			  border-radius: 15px;
			  box-shadow: 0 9px #999;
			  float: left;
			  margin-top: 8px;
			  margin-right: 50px;
			  text-decoration: none;" type="submit" value="Submit" />
	</div>
<!-- ==============Bouton Submit -->

<!-- ==============Bouton Menu-->
	<div>
		<input class="button" style="padding: 15px 25px;
			  font-size: 24px;
			  text-align: center;
			  cursor: pointer;
			  outline: none;
			  color: #000;
			  background-color: lightblue;
			  border: none;
			  border-radius: 15px;
			  box-shadow: 0 9px #999;
			  float:left;
			  margin-right: 100px;
			  margin-top: 8px;
			  text-decoration: none;" type="button" onclick="window.location.href = 'http://172.17.5.202/Menu.php';" value="Menu" />
	</div>
<!-- ==============Bouton Menu-->

<!-- ==============Bouton Pousser fichiers-->
		<style>
			a {
			  padding: 15px 25px;
			  font-size: 24px;
			  text-align: center;
			  cursor: pointer;
			  outline: none;
			  color: #000;
			  background-color: lightblue;
			  border: none;
			  border-radius: 15px;
			  box-shadow: 0 9px #999;
			  float: right;
			  margin-left: 10px;
			  margin-top: 8px;
			  text-decoration: none;
			}

			.button:hover {background-color: orangered;}

			.button:active {
			  background-color: orangered;
			  box-shadow: 0 5px #666;
			  transform: translateY(4px);
			}
		</style>
		<a href="http://172.17.5.202/conf_generer_files.php" class="button" >Pousser fichiers</a>
<!-- ==============Bouton Pousser fichiers-->		


<!-- ==============Bouton Reboot Raspberry-->
		<style>
			.btn {
			  padding: 15px 25px;
			  font-size: 24px;
			  text-align: center;
			  cursor: pointer;
			  outline: none;
			  color: #000;
			  background-color: lightblue;
			  border: none;
			  border-radius: 15px;
			  box-shadow: 0 9px #999;
			  float: right;
			  margin-top: 8px;
			  text-decoration: none;
			  margin-right: 50px;
			}

			.btn:hover {background-color: orangered;}

			.btn:active {
			  background-color: orangered;
			  box-shadow: 0 5px #666;
			  transform: translateY(4px);
			}
		</style>
		<a href="http://172.17.5.202/rebootRasp.php" class="btn" >Reboot Raspberry</a>
<!-- ==============Bouton Reboot Raspberry-->
  	 </form> <br />


  	
<?php 
		require_once "controller_config_files.php";
				$pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
	$stmt1 = $pdo->prepare("SELECT * 
						FROM `configuration`
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
	}
?>
		
  	 

	
	<elementConf> 
		
	<?php 
	
	echo "<p class='fichier'>Contenus Fichiers KIOSK</p><br>";
	require_once "controller_config_files.php";
	
    $pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
	$stmt0 = $pdo->prepare("SELECT * 
						FROM `configuration`
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
		$dateLastModif = $row0['Conf_date'];
		date_default_timezone_set('Europe/Paris');
    $Conf_date = date('j-M-Y à H:i:s');
		echo "<br>"."<p class='Normal'>" . $Conf_date . "\n" . $link . "</p><br>";
	}
?>


  	 
		</elementConf>
		
	</body>
</html>
