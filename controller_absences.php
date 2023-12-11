<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Formulaire PHP Profs et Personnels</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <?php 
        require_once "controller_config_files.php";
        print('Nous sommes le '.gmdate('d-m-Y').'...');
        ?>
        <h1 class="mb-4">Bonjour,</h1>
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Absence ajoutée avec succès !</h4>
            <p>
                Vous venez d'ajouter l'absence de <?php echo $_POST['nom'] . ' ' . $_POST['prenom'] ?> du <?php echo $_POST['debut_absence'] ?> au <?php echo $_POST['fin_absence'] ?> pour le motif <?php echo $_POST['motif'] ?>.
            </p>
        </div>

        <?php
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $motif = $_POST['motif'];
        $commentaire = $_POST['commentaire'];
        $debutabs = $_POST['debut_absence'];
        $finabs = $_POST['fin_absence'];

        try {
            $pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
            $stmt = $pdo->prepare("INSERT INTO absence (nom, prenom, motif, commentaire, debut_absence, fin_absence) VALUES (:nom, :prenom, :motif, :commentaire, :debut_absence, :fin_absence)");
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':motif', $motif);
            $stmt->bindParam(':commentaire', $commentaire);
            $stmt->bindParam(':debut_absence', $debutabs);
            $stmt->bindParam(':fin_absence', $finabs);
            $stmt->execute();
echo "Insertion réussie !";
} catch (PDOException $e) {
    echo "Erreur d'insertion : " . $e->getMessage();
    die();
}
        $pdo = null;
        ?>

        <a class="btn btn-primary" href="gestionAbsence.php">Retour</a>
    </div>
</body>
</html>
