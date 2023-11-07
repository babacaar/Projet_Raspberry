<!DOCTYPE html>
<html>
<head>
  <title>Menu</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      background-image: url("https://osticket.lpjw.net/osticket/scp/logo.php?backdrop");
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      margin: 0; /* Supprime la marge par défaut */
      padding: 0; /* Supprime le rembourrage par défaut */
    }

    .container {
    	margin-top: 7%;
    	margin-left: 36%;
      max-width: 500px; /* Ajustez la largeur du conteneur selon vos besoins */
     /* margin: 0 auto; /* Centre le conteneur horizontalement */
      padding: 20px; /* Ajoute du rembourrage à l'intérieur du conteneur */
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 5px;
      position: relative; /* Position relative ajoutée */
    }

    /* Style partagé pour les boutons */
    .button {
      margin-top: 20px; /* Ajoute une marge pour séparer les boutons verticalement */
      padding: 16px 30px;
      background: #337ab7;
      cursor: pointer;
      outline: none;
      box-shadow: 0 9px #999;
      border-radius: 19px;
      justify-content: center;
      align-items: center;
      display: inline-flex;
      color: #FFFEFE;
      font-size: 30px;
      font-family: Taviraj;
      font-weight: 400;
      line-height: 25px;
      word-wrap: break-word;
    }


    .button:active {
      background-color: #EB2E94; /* Nouvelle couleur d'arrière-plan lorsqu'il est enfoncé */
      transform: translateY(4px); /* Effet de déplacement vers le bas lorsqu'il est enfoncé */
    }

    /* Style partagé pour les descriptions */
    .description {
      margin-top: 10px; /* Ajoute une marge pour séparer les descriptions verticalement */
      position: relative;
      width: 100%;
      color: black;
      font-size: 15px;
      font-family: Taviraj;
      font-weight: 800;
      line-height: 25px;
      word-wrap: break-word;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Bouton Configuration -->
    <div class="button button1">CONFIGURATION</div>
    <div class="description">Le bouton configuration permet d’accéder au formulaire d’envoi de fichier pour les Raspberry.</div>

    <!-- Bouton Vue -->
    <div class="button button2">VUE</div>
    <div class="description">Le bouton VUE permet d’afficher les tâches qui doivent être effectuées en précisant l’ordre de priorité.</div>

    <!-- Bouton Création -->
    <div class="button button3">CRÉATION</div>
    <div class="description">Le bouton CREATION permet de créer des tâches.</div>

    <!-- Bouton Update avec lien cliquable -->
    <div class="button button4" onclick="window.location.href = 'http://172.17.5.202/update_tache.php';">UPDATE</div>
    <div class="description">Le bouton UPDATE permet de mettre à jour une tâche en changeant son statut.</div>
  </div>
</body>
</html>
