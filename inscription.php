<!-- inscription.php -->
<!DOCTYPE html>
<html>
<head>
  <title>Inscription au tournoi</title>
  <style>
    
    body {
      background: url('https://osticket.lpjw.net/scp/logo.php?backdrop') no-repeat center center fixed;
      background-size: cover;
    }
    
    h1 {
      text-align: center;
      color: #333; /* Couleur du titre */
    }
    
    h2 {
      text-align: center;
      color: #555; /* Couleur des sous-titres */
      margin-bottom: 10px; /* Marge en bas pour séparer les sous-titres des champs */
    }
    
    .container {
      max-width: 500px; /* Largeur maximale du formulaire */
      margin: 0 auto; /* Centrer le formulaire horizontalement */
      padding: 20px; /* Espacement interne du conteneur */
      background-color: rgba(255, 255, 255, 0.8); /* Couleur de fond du conteneur */
      border-radius: 5px; /* Arrondir les coins du conteneur */
    }
    
    label {
      display: block;
      margin-bottom: 5px; /* Espacement entre les libellés */
      color: #777; /* Couleur des libellés */
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
</head>
<body>
  
  <div class="container">
    <h1>Inscription au tournoi</h1>
    <form method="post" action="traitementTournoi.php">
      <label for="team_name">Nom de l'équipe :</label>
      <input type="text" name="team_name" id="team_name" required><br>

      <label for="tournament_Type">Type de tournoi :</label>
      <input type="text" name="tournament_Type" id="tournament_Type" required><br>
      
      <h2>Membres de l'équipe :</h2>
      
      <label for="member_1_name">Nom :</label>
      <input type="text" name="member_1_name" id="member_1_name" required><br>
      
      <label for="member_1_firstname">Prénom :</label>
      <input type="text" name="member_1_firstname" id="member_1_firstname" required><br>
      
      <label for="member_1_class">Classe :</label>
      <input type="text" name="member_1_class" id="member_1_class" required><br>
      
      <!-- Répétez les champs ci-dessus pour chaque membre de l'équipe -->
      
      <input type="submit" value="Inscrire">
    </form>
  </div>
</body>
</html>
