<?php
require_once "new1.php";
session_start();

// Récupérer le nombre de lignes dans la table "raspberries"
$query = "SELECT COUNT(*) as raspberry_count FROM raspberries";
$stmt = $db->prepare($query);
$stmt->execute();
$raspberryCount = $stmt->fetchColumn();

// Récupérer le nombre de lignes dans la table "groups"
$query = "SELECT COUNT(*) as group_count FROM groupes";
$stmt = $db->prepare($query);
$stmt->execute();
$groupCount = $stmt->fetchColumn();

// Vérifier si les valeurs sont déjà présentes dans la session
if (!isset($_SESSION['raspberry_count']) || !isset($_SESSION['group_count'])) {
  // Si les valeurs ne sont pas présentes, les stocker dans la session
  $_SESSION['raspberry_count'] = $raspberryCount;
  $_SESSION['group_count'] = $groupCount;
}

// Récupérer les valeurs à partir de la session ou utiliser une valeur par défaut
$raspberryCount = isset($_SESSION['raspberry_count']) ? $_SESSION['raspberry_count'] : 0;
$groupCount = isset($_SESSION['group_count']) ? $_SESSION['group_count'] : 0;

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupérer les nouvelles valeurs des Raspberry Pi et des groupes
  $newRaspberryCount = intval($_POST['raspberry_count']);
  $newGroupCount = intval($_POST['group_count']);

  // Mettre à jour la base de données avec les nouvelles valeurs
  $query = "UPDATE conf_raspberry SET raspberry_count = :raspberry_count, group_count = :group_count WHERE id = 1";
  $stmt = $db->prepare($query);
  $stmt->bindParam(':raspberry_count', $newRaspberryCount);
  $stmt->bindParam(':group_count', $newGroupCount);
  $stmt->execute();

  // Mettre à jour les valeurs dans la session
  $_SESSION['raspberry_count'] = $newRaspberryCount;
  $_SESSION['group_count'] = $newGroupCount;

  // Rediriger vers la page de configuration pour éviter la soumission du formulaire à nouveau en actualisant la page
  header("Location: new2.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
  <title>Configuration globale</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('https://osticket.lpjw.net/osticket/scp/logo.php?backdrop') no-repeat center center fixed;
      background-size: cover;
    
    
    }

    h1 {
      text-align: center;
      color: #333; /* Couleur du titre */
    }
    .container {
      max-width: 500px; /* Largeur maximale du formulaire */
      margin: 0 auto; /* Centrer le formulaire horizontalement */
      padding: 20px; /* Espacement interne du conteneur */
      background-color: rgba(255, 255, 255, 0.8); /* Couleur de fond du conteneur */
      border-radius: 5px; /* Arrondir les coins du conteneur */
    }

    form {
      margin-top: 20px;
    }

    label {
      display: block;
      margin-bottom: 5px; /* Espacement entre les libellés */
      color: #777; /* Couleur des libellés */
    }

    input[type="number"] {
      width: 50px;
    }

    button {
      padding: 5px 10px;
      font-size: 14px;
    }
    input[type="text"] {
      width: 100%; /* Largeur maximale des champs de texte */
      padding: 8px; /* Espacement interne des champs de texte */
      margin-bottom: 10px; /* Espacement entre les champs de texte */
    }

    input[type="submit"] {
      width: 100%; /* Largeur maximale du bouton de soumission */
      padding: 10px; /* Espacement interne du bouton de soumission */
      background-color: #337ab7; /* Couleur de fond du bouton de soumission */
      color: #fff; /* Couleur du texte du bouton de soumission */
      border: none; /* Supprimer les bordures du bouton de soumission */
      cursor: pointer;
    }
    
    input[type="submit"]:hover {
      background-color: #23527c; /* Couleur de fond du bouton de soumission au survol */
    }
  </style>
  <script>
    $(document).ready(function() {
      // Ajouter un champ Raspberry Pi
      $("#addRaspberry").click(function() {
        var currentCount = parseInt($("#raspberry_count").val());
        var newCount = currentCount + 1;
        $("#raspberry_count").val(newCount);
      });

      // Ajouter un champ groupe
      $("#addGroup").click(function() {
        var currentCount = parseInt($("#group_count").val());
        var newCount = currentCount + 1;
        $("#group_count").val(newCount);
      });
    });
    $(document).ready(function() {
  // Décrémenter le nombre de Raspberry Pi
  $("#removeRaspberry").click(function() {
    // Obtenir la valeur actuelle du nombre de Raspberry Pi
    var raspberryCount = parseInt($("#raspberry_count").val());

    // Décrémenter la valeur
    raspberryCount--;

    // Mettre à jour la valeur du champ de saisie
    $("#raspberry_count").val(raspberryCount);
  });

  // Décrémenter le nombre de groupes
  $("#removeGroup").click(function() {
    // Obtenir la valeur actuelle du nombre de groupes
    var groupCount = parseInt($("#group_count").val());

    // Décrémenter la valeur
    groupCount--;

    // Mettre à jour la valeur du champ de saisie
    $("#group_count").val(groupCount);
  });
});

  </script>
</head>
<body>
  <form class="container border border-primary p-3 mt-5" method="post" action="">
  <h1 class="text-center">Configuration globale</h1>
  <div class="row mb-3">
    <div class="col-md-6">
      <label for="raspberry_count" class="form-label">Nombre de Raspberry Pi à configurer:</label>
      <input type="number" class="form-control" name="raspberry_count" id="raspberry_count" value="<?php echo $raspberryCount; ?>">
      <button class="btn btn-primary" type="button" id="addRaspberry">+</button>
      <button class="btn btn-danger" type="button" id="removeRaspberry">-</button>
    </div>
    <div class="col-md-6">
      <label for="group_count" class="form-label">Nombre de groupes:</label>
      <input type="number" class="form-control" name="group_count" id="group_count" value="<?php echo $groupCount; ?>">
      <button class="btn btn-primary" type="button" id="addGroup">+</button>
      <button class="btn btn-danger" type="button" id="removeGroup">-</button>
    </div>
  </div>
  <button class="btn btn-primary" type="submit">Enregistrer</button>
</form>

</body>
</html>
