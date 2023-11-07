<html>
<body>
<?php
require_once "new1.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $groupId = $_POST['group_id'];

  // Récupérer les informations du groupe depuis la base de données
  $query = "SELECT id, name FROM groups WHERE id = :group_id";
  $stmt = $db->prepare($query);
  $stmt->bindParam(':group_id', $groupId);
  $stmt->execute();
  $group = $stmt->fetch(PDO::FETCH_ASSOC);

  // Récupérer les informations des Raspberry Pi du groupe depuis la base de données
  $query = "SELECT id, hostname FROM raspberries WHERE group_id = :group_id";
  $stmt = $db->prepare($query);
  $stmt->bindParam(':group_id', $groupId);
  $stmt->execute();
  $raspberries = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Afficher les informations du groupe et les options de Raspberry Pi associées
  ?>
  <h2>Groupe <?php echo $group['name']; ?></h2>
  <label for="group_name">Nom:</label>
  <input type="text" name="group_name" id="group_name" value="<?php echo $group['name']; ?>">
  <br><br>
  <label for="group_raspberries">Liste des Raspberry Pi actuels dans le groupe</label>
  <br><br>
  <select name="group_raspberries[]" id="group_raspberries" multiple>
    <?php foreach ($raspberries as $raspberry): ?>
      <option value="<?php echo $raspberry['id']; ?>"><?php echo $raspberry['hostname']; ?></option>
    <?php endforeach; ?>
  </select>
<?php
}
?>
</body>
</html>
