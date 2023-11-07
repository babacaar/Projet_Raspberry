<?php
require_once "new1.php";

// Récupérer le nombre de lignes dans la table "groups"
$query = "SELECT COUNT(*) as group_count FROM groupes";
$stmt = $db->prepare($query);
$stmt->execute();
$groupCount = $stmt->fetchColumn();

// Récupérer les informations des groupes depuis la base de données
$query = "SELECT id, name FROM groupes";
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
  
  <form method="post" action="">
    
    <label for="selected_group">Sélectionner un groupe :</label>
    <select name="selected_group" id="selected_group">
      <option value="">Sélectionner un groupe</option>
      <?php foreach ($groups as $group): ?>
        <option value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
      <?php endforeach; ?>
    </select><br><br>

    <div id="group_details">
      <!-- Les informations du groupe sélectionné seront affichées ici -->
    </div>
  
    <input type="submit" value="Enregistrer">
  </form>

  <script>
    $(document).ready(function() {
      $('#selected_group').change(function() {
        var groupId = $(this).val();
        $.ajax({
          url: 'group_details.php',
          method: 'POST',
          data: { group_id: groupId },
          success: function(response) {
            $('#group_details').html(response);
          }
        });
      });
    });
  </script>
</body>
</html>
