<?php

/**
 * Posts child measurements to the locally hosted WHO Anthro API.
 * Keep the API key in your MOMS configuration, never in a view or browser.
 */
function calculateChildGrowthZScores(array $records): array
{
    $endpoint = 'http://127.0.0.1:8000/v1/zscores';
    $apiKey = getenv('MOMS_ANTHRO_API_KEY');

    $curl = curl_init($endpoint);
    curl_setopt_array($curl, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_HTTPHEADER => array_filter([
            'Content-Type: application/json',
            $apiKey ? 'X-API-Key: ' . $apiKey : null,
        ]),
        CURLOPT_POSTFIELDS => json_encode(['records' => $records], JSON_THROW_ON_ERROR),
    ]);

    $responseBody = curl_exec($curl);
    $httpStatus = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    $curlError = curl_error($curl);
    curl_close($curl);

    if ($responseBody === false) {
        throw new RuntimeException('WHO Anthro API connection failed: ' . $curlError);
    }

    $response = json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);
    if ($httpStatus >= 400 || empty($response['ok'])) {
        throw new RuntimeException($response['error']['message'] ?? 'WHO Anthro API request failed.');
    }

    return $response;
}

// Example: calculate age in exact days using your child and measurement dates.
$zScoreResponse = calculateChildGrowthZScores([
    [
        'id' => 'child-127',
        'sex' => 'Female',
        'age_days' => 730,
        'weight_kg' => 10.8,
        'length_height_cm' => 84.5,
        'measurement_position' => 'H',
        'head_circumference_cm' => 47.2,
    ],
]);

$growth = $zScoreResponse['results'][0];
// $growth['measurements']['zlen'], $growth['measurements']['zwei'], etc.
