<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];
    error_log("API action: $action"); // Debugging message

    switch ($action) {
        case 'getWeatherAndTime':
            // Obtener la hora actual
            $time = date('Y-m-d H:i:s');
            error_log("Current time: $time"); // Debugging message

            // Obtener el clima desde una API externa (por ejemplo, OpenWeatherMap)
            $apiKey = 'TU_API_KEY_DE_OPENWEATHERMAP';
            $city = 'TU_CIUDAD';
            $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";

            // Manejo de errores para la solicitud externa
            $weatherResponse = @file_get_contents($url);
            if ($weatherResponse === FALSE) {
                error_log("Error fetching weather data from API.");
                header('Content-Type: application/json');
                echo json_encode(['error' => 'No se pudo obtener el clima.']);
                exit();
            }

            $weatherData = json_decode($weatherResponse, true);
            error_log("Weather data: " . print_r($weatherData, true)); // Debugging message

            if (isset($weatherData['main'])) {
                $temperature = $weatherData['main']['temp'];
                $weather = $weatherData['weather'][0]['description'];

                header('Content-Type: application/json');
                echo json_encode([
                    'time' => $time,
                    'temperature' => $temperature,
                    'weather' => $weather
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'No se pudo obtener el clima.']);
            }
            break;
        
        default:
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Acción no válida.']);
            break;
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Método no permitido.']);
}
?>
