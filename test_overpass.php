<?php

$lat = 2.32164;
$lng = 99.05728;
$radius = 20000;

$query = "
[out:json][timeout:30];
(
  node[\"amenity\"~\"^(restaurant|cafe|fast_food|food_court|bar)$\"](around:{$radius},{$lat},{$lng});
  way[\"amenity\"~\"^(restaurant|cafe|fast_food|food_court)$\"](around:{$radius},{$lat},{$lng});
);
out center 150;
";

$url = 'https://overpass-api.de/api/interpreter';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'data=' . urlencode($query));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: " . $httpCode . PHP_EOL;

$data = json_decode($response, true);
if (isset($data['elements'])) {
    echo "Found " . count($data['elements']) . " elements." . PHP_EOL;
    foreach ($data['elements'] as $el) {
        $name = $el['tags']['name'] ?? $el['tags']['name:en'] ?? 'Unnamed';
        $cuisine = $el['tags']['cuisine'] ?? 'None';
        $amenity = $el['tags']['amenity'] ?? 'None';
        echo "- Name: " . $name . " | Cuisine: " . $cuisine . " | Amenity: " . $amenity . PHP_EOL;
    }
} else {
    echo "Error response: " . $response . PHP_EOL;
}
