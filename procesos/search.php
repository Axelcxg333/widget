<?php

header("Content-Type: application/json");

$apiKey = "AIzaSyCnjaC0QyOoLhS8v5vVAXfihq2SWEjFBN0";

if (!isset($_POST['place_id'])) {
    echo json_encode(["error" => "Parámetro de búsqueda no válido."]);
    exit;
}

$placeId = $_POST['place_id'];
$url = "https://places.googleapis.com/v1/places/$placeId?key={$apiKey}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "X-Goog-FieldMask: displayName,formattedAddress,rating,photos,userRatingCount,reviews.authorAttribution,reviews.rating,reviews.text,reviews.relativePublishTimeDescription",
    "Accept-Language: es"
]);

$response = curl_exec($ch);
curl_close($ch);

$resultado = json_decode($response, true);

if (isset($resultado['error'])) {
    echo json_encode(["error" => $resultado['error']['message']]);
    exit;
}

$placeData = [
    "nombre" => $resultado['displayName']['text'] ?? 'Sin nombre',
    "direccion" => $resultado['formattedAddress'] ?? 'Sin dirección',
    "rating" => $resultado['rating'] ?? 0,
    "rating_count" => $resultado['userRatingCount'] ?? 0,
    "imagenes" => [],
    "reseñas" => []
];

if (isset($resultado['photos'])) {
    foreach ($resultado['photos'] as $photo) {
        if (isset($photo['name'])) {
            $placeData["imagenes"][] = "https://places.googleapis.com/v1/{$photo['name']}/media?maxWidthPx=400&key={$apiKey}";
        }
    }
}

if (isset($resultado['reviews'])) {
    foreach ($resultado['reviews'] as $review) {
        $imagenesReseña = [];
        if (isset($review['photos'])) {
            foreach ($review['photos'] as $photo) {
                if (isset($photo['name'])) {
                    $imagenesReseña[] = "https://places.googleapis.com/v1/{$photo['name']}/media?maxWidthPx=400&key={$apiKey}";
                }
            }
        }

        $placeData["reseñas"][] = [
            "autor" => $review['authorAttribution']['displayName'] ?? "Usuario desconocido",
            "foto_autor" => $review['authorAttribution']['photoUri'] ?? "https://via.placeholder.com/50",
            "texto" => $review['text']['text'] ?? "",
            "rating" => $review['rating'] ?? 0,
            "fecha" => isset($review['relativePublishTimeDescription']) ? $review['relativePublishTimeDescription'] : "Fecha desconocida",
            "imagenes" => $imagenesReseña
        ];
    }
}

echo json_encode($placeData);
exit;
