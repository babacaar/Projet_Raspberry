// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupérer les nouvelles valeurs des Raspberry Pi et des groupes
  $newRaspberryCount = $_POST['raspberry_count'];
  $newGroupCount = $_POST['group_count'];

  // Mettre à jour la table "raspberries"
  $query = "UPDATE conf_raspberry SET raspberry_count = :raspberry_count, group_count = :group_count WHERE id = 1";
  $stmt = $db->prepare($query);
  $stmt->bindParam(':raspberry_count', $newRaspberryCount);
  $stmt->bindParam(':group_count', $newGroupCount);
  $stmt->execute();

  // Mettre à jour les valeurs dans la session
  $_SESSION['raspberry_count'] = $newRaspberryCount;
  $_SESSION['group_count'] = $newGroupCount;

  // Insérer les nouvelles lignes dans la table "raspberries" si nécessaire
  $currentRaspberryCount = $_SESSION['raspberry_count'];
  $query = "SELECT COUNT(*) FROM raspberries";
  $stmt = $db->prepare($query);
  $stmt->execute();
  $existingRaspberryCount = $stmt->fetchColumn();

  if ($currentRaspberryCount > $existingRaspberryCount) {
    $raspberryToAdd = $currentRaspberryCount - $existingRaspberryCount;

    for ($i = 0; $i < $raspberryToAdd; $i++) {
      $query = "INSERT INTO raspberries (hostname, ip, group_id) VALUES (:hostname, :ip, :group_id)";
      $stmt = $db->prepare($query);
      $stmt->bindValue(':hostname', '');
      $stmt->bindValue(':ip', '');
      $stmt->bindValue(':group_id', 0);
      $stmt->execute();
    }
  }

  // Rediriger vers la page de configuration pour éviter la soumission du formulaire à nouveau en actualisant la page
  header("Location: new2.php");
  exit();
}
