<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use yidas\googleMaps\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/../../');
$dotenv->load();
$dotenv->required('GOOGLE_MAPS_API_KEY')->notEmpty();

function geocodeAddress($address) {
    $gmaps = new Client(['key' => $_ENV['GOOGLE_MAPS_API_KEY']]);

    $geocode = $gmaps->geocode($address)[0];

    if (!isset($geocode['status'])) {
        $location = $geocode['geometry']['location'];
        return $location;
    }

    throw new Exception('geocoding failed');
}
