<?php
require_once "new1.php";
$raspberryCount = 0; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupérer les données du formulaire
  $raspberryCount = $_POST['raspberry_count'];

  // Traiter chaque Raspberry Pi
  for ($i = 1; $i <= $raspberryCount; $i++) {
    $raspberryId = $_POST['raspberry_' . $i];
    $hostname = $_POST['hostname_' . $i];
    $ip = $_POST['ip_' . $i];
    $groupId = $_POST['group_' . $i];

    // Mettre à jour les valeurs dans la base de données pour le Raspberry Pi spécifié
    $query = "UPDATE raspberries SET hostname = :hostname, ip = :ip, group_id = :group_id WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':hostname', $hostname);
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':group_id', $groupId);
    $stmt->bindParam(':id', $raspberryId);
    $stmt->execute();
  }

  // Rediriger vers une autre page après l'enregistrement
  header("Location: new3.php");
  exit();
}
?>



<?php for ($i = 1; $i <= $raspberryCount; $i++): ?>
      <h2>Raspberry<?php echo $i; ?></h2>
      <label for="hostname_<?php echo $i; ?>">Hostname:</label>
      <input type="text" name="hostname_<?php echo $i; ?>" id="hostname_<?php echo $i; ?>"><br>
  
      <label for="ip_<?php echo $i; ?>">IP:</label>
      <input type="text" name="ip_<?php echo $i; ?>" id="ip_<?php echo $i; ?>"><br>
  
      <label for="group_<?php echo $i; ?>">Groupe:</label>
      <select name="group_<?php echo $i; ?>" id="group_<?php echo $i; ?>">
        <option value="">Sélectionner un groupe</option>
        <?php foreach ($groups as $group): ?>
          <option value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
        <?php endforeach; ?>
      </select><br><br>
    <?php endfor; ?>