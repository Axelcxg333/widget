<?php

header("Content-Type: application/json");

$apiKey = "AIzaSyCnjaC0QyOoLhS8v5vVAXfihq2SWEjFBN0";
$query = $_POST['search'] ?? '';

if (!$query) {
    echo json_encode(["error" => "No se proporcionó un término de búsqueda."]);
    exit;
}

$url = "https://places.googleapis.com/v1/places:autocomplete?key={$apiKey}";

$data = json_encode([
    "input" => $query,
    "regionCode" => "PE" 
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: application/json",
    "X-Goog-FieldMask: suggestions.placePrediction.placeId,suggestions.placePrediction.text.text"
]);

$response = curl_exec($ch);
curl_close($ch);

$resultados = json_decode($response, true);

$sugerencias = [];
if (isset($resultados['suggestions'])) {
    foreach ($resultados['suggestions'] as $sugerencia) {
        $place = $sugerencia['placePrediction'];
        $sugerencias[] = [
            'place_id' => $place['placeId'],
            'nombre' => $place['text']['text']
        ];
    }
}

echo json_encode(['sugerencias' => $sugerencias]);
exit;

?>
