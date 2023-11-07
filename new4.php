<?php

require_once "new1.php";



// Récupérer le nombre de Raspberry Pi et le nombre de groupes depuis la base de données
$query = "SELECT raspberry_count, group_count FROM conf_raspberry WHERE id = 1";
$stmt = $db->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$raspberryCount = $result['raspberry_count'];
$groupCount = $result['group_count'];

// Récupérer les informations des Raspberry Pi depuis la base de données
$query = "SELECT id, hostname, ip, group_id FROM raspberries";
$stmt = $db->prepare($query);
$stmt->execute();
$raspberries = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les informations des groupes depuis la base de données
$query = "SELECT id, name FROM groups";
$stmt = $db->prepare($query);
$stmt->execute();
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Configuration des Groupes</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <h1>Configuration des Groupes</h1>
  
  <form method="post" action="save.php">
    
  
    <?php for ($i = 1; $i <= $groupCount; $i++): ?>
      <h2>Groupe <?php echo $i; ?></h2>
      <label for="group_name_<?php echo $i; ?>">Nom:</label>
      <input type="text" name="group_name_<?php echo $i; ?>" id="group_name_<?php echo $i; ?>">
      <br><br>

    <label for="selected_raspberry">Sélectionner un Raspberry :</label>
    <select name="selected_raspberry" id="selected_raspberry">
      <option value="">Sélectionner un Raspberry</option>
      <?php foreach ($raspberries as $raspberry): ?>
        <option value="<?php echo $raspberry['id']; ?>"><?php echo $raspberry['hostname']; ?></option>
      <?php endforeach; ?>
    </select><br><br>  
    
   <label for="group_raspberries_<?php echo $i; ?>">Liste des raspberry actuelle dans le groupe</label>
   <br><br>
      <select name="group_raspberries_<?php echo $i; ?>[]" id="group_raspberries_<?php echo $i; ?>" multiple>
        <?php foreach ($raspberries as $raspberry): ?>
          <option value="<?php echo $raspberry['id']; ?>"><?php echo $raspberry['hostname']; ?></option>
        <?php endforeach; ?>
      </select><br><br>
    <?php endfor; ?>
  
    <input type="submit" value="Enregistrer">
  </form>
</body>
</html>

