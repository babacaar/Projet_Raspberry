<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Météo Angers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        #weather-container {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .forecast-item {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .forecast-item img {
            width: 50px;
            height: 50px;
        }
    </style>
</head>
<body>

<div id="weather-container">
    <h1>Météo Angers</h1>
    <div id="current-weather"></div>
    <div id="hourly-forecast"></div>
</div>

<script>
    const apiKey = '9eaac629dc966dca48b4890bc510f5ce';
    const city = 'Angers';
    const apiUrl = `https://api.openweathermap.org/data/2.5/onecall?q=${city}&appid=${apiKey}&units=metric`;

    async function getWeather() {
        try {
            const response = await fetch(apiUrl);
            const data = await response.json();

            if (data.cod === '401') {
                console.error('Unauthorized: Please check your OpenWeatherMap API key.');
                return;
            }

            const currentWeather = document.getElementById('current-weather');
            if (data.current) {
                currentWeather.innerHTML = `
                    <p>Température actuelle: ${data.current.temp} °C</p>
                    <p>Humidité: ${data.current.humidity} %</p>
                    <p>Conditions: ${data.current.weather[0].description}</p>
                `;
            } else {
                console.error('Current weather data not available.');
            }

            const hourlyForecast = document.getElementById('hourly-forecast');
            hourlyForecast.innerHTML = "";

            if (data.hourly) {
                const hourlyData = data.hourly.slice(0, 6);
                hourlyData.forEach(hour => {
                    const timestamp = new Date(hour.dt * 1000);
                    const hours = timestamp.getHours();
                    const iconCode = hour.weather[0].icon;
                    const iconUrl = `http://openweathermap.org/img/w/${iconCode}.png`;

                    hourlyForecast.innerHTML += `
                        <div class="forecast-item">
                            <p>${hours}:00</p>
                            <img src="${iconUrl}" alt="${hour.weather[0].description}">
                            <p>${hour.temp} °C</p>
                        </div>
                    `;
                });
            } else {
                console.error('Hourly forecast data not available.');
            }
        } catch (error) {
            console.error('Error fetching weather data:', error);
        }
    }

    getWeather();
</script>

</body>
</html>
