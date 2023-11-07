<?php
include 'configTournoi.php';

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database settings
    $db = "tournois_db";
    $dbhost = "localhost";
    $dbport = 3306;
    $dbuser = "root";
    $dbpasswd = "root";

    // Récupérer le type de tournoi à partir du formulaire
    $tournamentType = $_POST["tournament_Type"];
    $team_name = $_POST["team_name"];
    $member_1_name = $_POST["member_1_name"];
    $member_1_firstname = $_POST["member_1_firstname"];
    $member_1_class = $_POST["member_1_class"];

    try {
        // Connexion à la base de données
        $pdo = new PDO("mysql:host=$dbhost;port=$dbport;dbname=$db", $dbuser, $dbpasswd);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer la requête d'insertion SQL
        $statement = $pdo->prepare("INSERT INTO teams (tournament_Type, team_name, member_1_name, member_1_firstname, member_1_class) VALUES(:tournament_Type, :team_name, :member_1_name, :member_1_firstname, :member_1_class)");

        // Associer les valeurs et exécuter la requête d'insertion
        $statement->bindParam(':tournament_Type', $tournamentType, PDO::PARAM_STR);
        $statement->bindParam(':team_name', $team_name, PDO::PARAM_STR);
        $statement->bindParam(':member_1_name', $member_1_name, PDO::PARAM_STR);
        $statement->bindParam(':member_1_firstname', $member_1_firstname, PDO::PARAM_STR);
        $statement->bindParam(':member_1_class', $member_1_class, PDO::PARAM_STR);

        if ($statement->execute()) {
            echo 'Inscription réussie au tournoi!<br>';

            // Vérifier si le type de tournoi est valide
            if (isset($config[$tournamentType])) {
                // Vérifier les limites d'inscription pour le tournoi
                if ($tournamentType == "developpe_couche") {
                    // Pour la compétition de développé couché (inscription individuelle)
                    $maxPlayers = $config[$tournamentType]["max_players"];
                    // Vérifier si le nombre maximal de joueurs est atteint
                    if (checkPlayerLimit($maxPlayers)) {
                        // Afficher un message d'inscription réussie
                        echo "Inscription réussie à la compétition de développé couché !";
                        // Enregistrer les données dans une base de données ou un fichier
                    } else {
                        // Afficher un message indiquant que les inscriptions sont fermées
                        echo "Les inscriptions à la compétition de développé couché sont fermées.";
                    }
                } else {
                    // Pour les autres tournois (inscription par équipe)
                    $maxTeams = $config[$tournamentType]["max_teams"];
                    $maxPlayersPerTeam = $config[$tournamentType]["max_players_per_team"];
                    // Vérifier si le nombre maximal d'équipes est atteint
                    if (checkTeamLimit($tournamentType, $maxTeams)) {
                        // Vérifier si le nombre maximal de joueurs par équipe est atteint
                        if (checkPlayerLimit($maxTeams * $maxPlayersPerTeam)) {
                            // Afficher un message d'inscription réussie
                            echo "Inscription réussie au tournoi de $tournamentType !";
                            // Enregistrer les données dans une base de données ou un fichier
                        } else {
                            // Afficher un message indiquant que les inscriptions sont fermées
                            echo "Les inscriptions au tournoi de $tournamentType sont fermées car le nombre maximal de joueurs est atteint.";
                        }
                    } else {
                        // Afficher un message indiquant que les inscriptions sont fermées
                        echo "Les inscriptions au tournoi de $tournamentType sont fermées car le nombre maximal d'équipes est atteint.";
                    }
                }
            } else {
                // Afficher un message d'erreur pour un type de tournoi invalide
                echo "Type de tournoi invalide.";
            }
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
} else {
    echo "La configuration a échoué ! <br>";
}

// Fonction de vérification du nombre maximal de joueurs
function checkPlayerLimit($maxPlayers) {
    // Code de vérification du nombre de joueurs inscrits (en utilisant une base de données ou un fichier)
    // Retourne true si le nombre maximal de joueurs n'est pas atteint, sinon false
    return true; // Modifier cette fonction selon votre méthode de stockage des inscriptions
}

// Fonction de vérification du nombre maximal d'équipes
function checkTeamLimit($tournamentType, $maxTeams) {
    // Code de vérification du nombre d'équipes inscrites (en utilisant une base de données ou un fichier)
    // Retourne true si le nombre maximal d'équipes n'est pas atteint, sinon false
    return true; // Modifier cette fonction selon votre méthode de stockage des inscriptions
}
?>
