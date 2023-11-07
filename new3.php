<?php
require_once "new1.php";
//require_once "new3.php";

session_start();

// Récupérer le nombre de lignes dans la table "raspberries"
$query = "SELECT COUNT(*) as raspberry_count FROM raspberries";
$stmt = $db->prepare($query);
$stmt->execute();
$raspberryCount = $stmt->fetchColumn();

// Récupérer tous les Raspberry depuis la table "raspberries"
$query = "SELECT id, hostname FROM raspberries";
$stmt = $db->prepare($query);
$stmt->execute();
$raspberries = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Récupérer tous les groupes depuis la table "groups"
$query = "SELECT id, name FROM groupes";
$stmt = $db->prepare($query);
$stmt->execute();
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Vérifier si les valeurs sont déjà présentes dans la session
if (!isset($_SESSION['raspberry_count'])) {
  // Si les valeurs ne sont pas présentes, les stocker dans la session
  $_SESSION['raspberry_count'] = $raspberryCount;
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupérer le Raspberry sélectionné
  $selectedRaspberryId = $_POST['selected_raspberry'];

  // Récupérer les nouvelles valeurs d'hostname, d'IP et de groupe
  $newHostname = $_POST['hostname'];
  $newIp = $_POST['ip'];
  if (isset($_POST['group_id']) && is_numeric($_POST['group_id'])){
     $newGroupId = intval($_POST['group_id']);
  }
 

  // Mettre à jour la base de données avec les nouvelles valeurs
  $query = "UPDATE raspberries SET hostname = :hostname, ip = :ip, group_id = :group_id WHERE id = :raspberry_id";
  $stmt = $db->prepare($query);
  $stmt->bindParam(':hostname', $newHostname);
  $stmt->bindParam(':ip', $newIp);
  $stmt->bindParam(':group_id', $newGroupId);
  $stmt->bindParam(':raspberry_id', $selectedRaspberryId);
  $stmt->execute();

  // Rediriger vers la page de configuration pour éviter la soumission du formulaire à nouveau en actualisant la page
  header("Location: new3.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Configurer Raspberry </title>
</head>
<body>
  <h1>Configurer Raspberry</h1>

  <form method="post" action="">
    <label for="selected_raspberry">Sélectionner un Raspberry :</label>
    <select name="selected_raspberry" id="selected_raspberry">
      <option value="">Sélectionner un Raspberry</option>
      <?php foreach ($raspberries as $raspberry): ?>
        <option value="<?php echo $raspberry['id']; ?>"><?php echo $raspberry['hostname']; ?></option>
      <?php endforeach; ?>
    </select><br><br>

    <label for="hostname">Hostname :</label>
    <input type="text" name="hostname" id="hostname"><br><br>

    <label for="ip">IP :</label>
    <input type="text" name="ip" id="ip"><br><br>

    
    <label for="group_id">Groupe :</label>
      <select name="group_id" id="groupid">
        <option value="">Sélectionner un un groupe</option>
        <?php foreach ($groups as $group): ?>
          <option value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
        <?php endforeach; ?>
      </select><br><br>

    <input type="submit" value="Enregistrer">
  </form>
</body>
</html>

-------------------------************************------------------------------------********************************---------------------------//////////////-------------------**************///////////////---------------*******************//////////-----------*******************----//-*-/*-*/


<?php
require_once "controller_config_files.php";
//session_start();

// Récupérer tous les groupes depuis la table "groups"
$query = "SELECT id, name FROM groupes";
$stmt = $db->prepare($query);
$stmt->execute();
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupérer le groupe sélectionné
  $selectedGroupId = $_POST['group_id'];

  // Mettre à jour la base de données avec le nouveau groupe sélectionné
  $query = "UPDATE pis SET group_id = :group_id";
  $stmt = $db->prepare($query);
  $stmt->bindParam(':group_id', $selectedGroupId);
  $stmt->execute();

  // Rediriger vers la page de configuration pour éviter la soumission du formulaire à nouveau en actualisant la page
  header("Location: list.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Configurer Raspberry</title>
  <style>
    ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: #333;
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

    body {
      font-family: Arial, sans-serif;
    }

    h1 {
      background-color: lightblue;
      color: #000;
      padding: 10px;
      text-align: center;
    }

    label {
      display: block;
      font-weight: bold;
      margin-top: 10px;
    }

    select {
      width:auto;
      height: auto;
    }

    li.dropdown {
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      text-align: left;
    }

    .dropdown-content a:hover {
      background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }
  </style>
</head>
<body>
  <ul>
    <li><a href="list.php">Hôtes</a></li>
    <li class="dropdown">
      <a href="javascript:void(0)" class="dropbtn">Groupes</a>
      <div class="dropdown-content">
        <a href="groupe.php">Lister groupes</a>
        <a href="creationgroupe.php">Créer nouveau groupe</a>
      </div>
    </li>
  </ul>
  <h1>Configurer Raspberry</h1>

    <form method="post" action="">
      <label for="group_id">Sélectionner un groupe :</label>
      <select name="group_id" id="groupid">
        <option value="">Sélectionner un groupe</option>
        <?php foreach ($groups as $group): ?>
          <option value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
        <?php endforeach; ?>
      </select><br><br>
      <input type="submit" value="Enregistrer">
    </form>

  <br>
  <a href="gestionPis.php">Retour à l'ajout</a>
</body>
</html>

