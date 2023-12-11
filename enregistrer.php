<?php
// Connexion à la base de données
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "affichage";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Vérifier la connexion
if (!$conn) {
    die("Échec de la connexion à la base de données : " . mysqli_connect_error());
}

// Récupérer les données du formulaire
$nb_raspberry = $_POST['nb_raspberry'];
$nb_groupes = $_POST['nb_groupes'];

// Insérer les données dans la base de données
for ($i = 1; $i <= $nb_raspberry; $i++) {
    $hostname = $_POST['hostname_' . $i];
    $ip = $_POST['ip_' . $i];

    $query = "INSERT INTO raspberry (hostname, ip) VALUES ('$hostname', '$ip')";

    if (mysqli_query($conn, $query)) {
        echo "Raspberry Pi " . $i . " enregistré avec succès.<br>";
    } else {
        echo "Erreur lors de l'enregistrement du Raspberry Pi " . $i . ": " . mysqli_error($conn) . "<br>";
    }
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>
