<!DOCTYPE html>
<html>
<head>
  <title>Configuration des écrans</title>
  <link rel="stylesheet" href="style.css" />
  <style>

.settings-button {
  background-color: lightblue;
  color: black;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
  border-radius: 15px;
  box-shadow: 0 9px #999;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.settings-container {
  display: none;
  position: absolute;
  right: 0;
  background-color: none;
  min-width: 160px;
  z-index: 1;
}

.settings-container a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.settings-container a:hover {background-color: none;}

.dropdown:hover .settings-container {
  display: block;
}

.dropdown:hover .settings-button {
  background-color: darkorange;
}

.settings-button-in-container {
      padding: 5px;
      font-size: 9px;
      text-align: center;
      cursor: pointer;
      outline: none;
      color: #000;
      background-color: lightblue;
      border: none;
      border-radius: 8px;
      margin-top: 10px;
      text-decoration: none;
    }


		/* Style du conteneur pour centrer le formulaire */
    .center-container {
     	text-align: center;
      margin: 0px auto; /* Ajustez la marge pour centrer verticalement */
     	padding: 20px; /* Espacement interne du conteneur */
     	max-width: 800px; /* Largeur maximale du formulaire */
    }

    /* Style du formulaire */
    .form-container {
      display: inline-block;
      text-align: left; /* Pour aligner le texte du formulaire à gauche */
      padding: 20px; /* Espace autour du formulaire */
      background-color: white; /* Couleur de fond du formulaire */
      border-radius: 8px;
      width: 60%; /* Largeur du conteneur (ajouté à 80%) */
      vertical-align: top; 

    }

        /* Style de l'image */
    .logo-img {
      width: 298px;
      height: 127px;
      border-radius: 8px;
      margin-left: 20px;
      display: inline-block;
      vertical-align: middle;
    }
</style>
</head>
<body>
<!-- Bouton Paramètres -->
<div class="dropdown" style="display: inline-block; vertical-align: middle; margin-right: 20px; float:right; margin-top: 20px;">
  <button class="settings-button" onclick="toggleSettings()">☰</button>

  <!-- Conteneur des boutons paramètres -->
  <div class="settings-container" id="settings-container">
    <!-- Boutons paramètres ici -->
    <a href="http://172.17.5.202/Menu.php" class="settings-button-in-container">Menu</a>
    <a href="http://172.17.5.202/rebootRasp.php" class="settings-button-in-container">Redémarrer Raspberry</a>
    <a href="http://localhost/gestionPis.php" class="settings-button-in-container">Gérer Raspberry</a>
  </div>
</div>
  
  <!-- Le reste de votre code HTML et PHP... -->
  <img class="logo-img" alt="Banniere" src="lycee.jpg"> 
  <div class="center-container"> <!-- Conteneur pour centrer le formulaire -->
  	<div class="form-container"> <!-- Conteneur du formulaire -->
  		<h2>Mes Liens</h2>
  		<form method="post" action="controller_config.php">
		   
		    <input type="text" name="Conf_sites0" placeholder="Veuillez séparer vos liens par des espaces. (http://exemples.fr  http://examples.us) " size="50"/>
		    <br />

		    <!-- ==============Bouton Submit -->
		    <div>
		      <input class="button" style= "padding: 5px 15px;
		        font-size: 14px;
		        text-align: center;
		        cursor: pointer;
		        outline: none;
		        color: #000;
		        background-color: lightblue;
		        border: none;
		        border-radius: 5px;
		        box-shadow: 0 9px #999;
		        float: right;
		        margin-top: 8px;
		        margin-right: -250px;
		        text-decoration: none;" type="submit" value="Submit" />
		    </div>
		    <!-- ==============Bouton Submit -->

		  </form>
		</div>
	</div>

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
<div class="elementConf">
     
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
  
  </div>
  


  <!-- JavaScript pour gérer l'affichage des boutons paramètres -->
  <script>
  	// Récupérer l'élément déclencheur et le conteneur
const settingsButton = document.getElementById("settings-button");
const settingsContainer = document.getElementById("settings-container");
    function toggleSettings() {
      var settingsContainer = document.querySelector('.settings-container');
      if (settingsContainer.style.display === 'none' || settingsContainer.style.display === '') {
        settingsContainer.style.display = 'block'; // Afficher les boutons paramètres
      } else {
        settingsContainer.style.display = 'none'; // Masquer les boutons paramètres
      }
    }
  </script>
</body>
</html>
