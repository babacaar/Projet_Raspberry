<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Chargement de Vidéo</title>
</head>
<body>
    <h1>Chargement de Vidéo</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="video">Sélectionnez une vidéo :</label>
        <input type="file" name="video" id="video" accept="video/*">
        <br>
        <input type="submit" value="Charger la Vidéo" name="submit">
    </form>
</body>
</html>
