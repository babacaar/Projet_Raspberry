<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Raspberry Pi</title>
    <style>
        ul {
          list-style-type: none;
          margin: 0;
          padding: 0;
          overflow: hidden;
          background-color: #333;
          width: 100%;

        }

        li {
          float: left;
        }

        li a {
          display: block;
          color: white;
          text-align: center;
          padding: 14px 16px;
          text-decoration: none;
        }

        li a:hover {
          background-color: #111;
        }
        /* Style de l'image */
    .logo-img {
      width: 298px;
      height: 127px;
      border-radius: 8px;
      margin-left: 20px;
      /*display: inline-block;
      vertical-align: middle;*/
    }
        /* Styles CSS pour l'apparence de la page */
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            background-color: lightblue;
            color: #000;
            padding: 10px;
            text-align: center;
        }
        form {
            margin: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }
        select {
            width: 100%;
            height: 100px;
        }
        .container {
            display: flex;
            align-items: center;
        }
        li.dropdown {
          display: inline-block;
        }

        .dropdown-content {
          display: none;
          position: absolute;
          background-color: #f9f9f9;
          min-width: 160px;
          box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
          z-index: 1;
        }

        .dropdown-content a {
          color: black;
          padding: 12px 16px;
          text-decoration: none;
          display: block;
          text-align: left;
        }

        .dropdown-content a:hover {background-color: #f1f1f1;}

        .dropdown:hover .dropdown-content {
          display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="configuration.php">
            <img class="logo-img" alt="Banniere" src="lycee.jpg">
        </a>
        <ul>
		<li class="dropdown">
    		<a href="javascript:void(0)" class="dropbtn">Hôtes</a>
    		<div class="dropdown-content">
      			<a href="list.php">Liste des hôtes</a>
      			<a href="gestionPis.php">Ajouter un hôte</a>
   		</div>
  		</li>
		<li><a href="creationgroupe.php">Groupes</a></li>
        </ul>

     </div>
    <h1>Gestion des Raspberry Pi</h1>
    <form method="post" action="">
        <label for="name">Nom du Raspberry Pi :</label>
        <input type="text" id="name" name="name"><br>

        <label for="ip">Adresse IP :</label>
        <input type="text" id="ip" name="ip"><br>

        <label for="username">Nom d'utilisateur SSH :</label>
        <input type="text" id="username" name="username"><br>

        <label for="password">Mot de passe SSH :</label>
        <input type="password" id="password" name="password">

        
<br><br>
        <input type="submit" name="submit" value="Valider">
    </form>
    <br>
    
    <label for="target_pis">Raspberry Pi cibles :</label>
        <select id="target_pis" name="target_pis[]" multiple>
            <?php
            require_once "controller_config_files.php";
            try {
                $conn = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $stmt = $conn->query('SELECT * FROM pis');
                $rows = $stmt->fetchAll();

                if (count($rows) > 0) {
                    foreach ($rows as $row) {
                        echo '<option value="' . $row['ip'] . '">' . $row['name'] . ' - ' . $row['ip'] . '</option>';
                    }
                } else {
                    // Aucun Raspberry Pi configuré, afficher un message d'erreur
                    echo '<option disabled selected>OUPS pas de Raspberry disponible 😞</option>';
                }
            } catch (PDOException $e) {
                echo "Erreur de connexion à la base de données : " . $e->getMessage();
            }
            ?>
        </select><br>
        <a href="list.php">Liste des Raspberry Pi</a>
    <?php
    require_once "controller_config_files.php";
    if (isset($_POST['submit'])) {
        try {
            // Connexion à la base de données
            $conn = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Récupération des données du formulaire
            $name = $_POST['name'];
            $ip = $_POST['ip'];
            $username = $_POST['username'];
            $password = $_POST['password'];
           // $target_pis = implode(',', $_POST['target_pis']); // Si vous souhaitez stocker les IP sous forme de chaîne

            // Requête d'insertion dans la table
            $stmt = $conn->prepare("INSERT INTO pis (name, ip, username, password) VALUES (:name, :ip, :username, :password)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':ip', $ip);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            //$stmt->bindParam(':target_pis', $target_pis);

            // Exécution de la requête
            $stmt->execute();

            echo "Données insérées avec succès dans la base de données.";
        } catch (PDOException $e) {
            echo "Erreur d'insertion dans la base de données : " . $e->getMessage();
        }
    }
    ?>
</body>
</html>
