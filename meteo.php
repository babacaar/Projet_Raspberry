<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Météo Angers</title>
</head>
<!------------HEADER------------>
<?php
$pageTitle = "Météo Angers"; // Titre de la page
$dropDownMenu = true;
include "modules/header.php";
?>

<body>
    <div class="group page">
        <section class="page-content">
            <h1>Météo en temps réel - Angers</h1>
            <div id="weather-container">
                <p id="temperature"></p>
                <p id="description"></p>
            </div>

            <script>
                // Remplacez 'YOUR_API_KEY' par votre clé API OpenWeatherMap
                const apiKey = '98a865ef245d5cb3a6abb6891e0d5ecd';
                const city = 'Angers';
                const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric&lang=fr`;

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        // Vérifie si les données ont été correctement récupérées
                        if (data && data.main && data.main.temp && data.weather && data.weather[0].description) {
                            const temperature = data.main.temp;
                            const description = data.weather[0].description;

                            document.getElementById('temperature').innerText = `Température : ${temperature} °C`;
                            document.getElementById('description').innerText = `Description : ${description}`;
                        } else {
                            console.error('Données météo invalides ou manquantes');
                        }
                    })
                    .catch(error => console.error('Erreur lors de la récupération des données météo', error));
            </script>
        </section>
    </div>

</body>
</html>
<!------------FOOTER------------>
<?php include "modules/footer.php"; ?>
