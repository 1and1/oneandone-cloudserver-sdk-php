<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

$client = new OneAndOne('<API-TOKEN>');




# List all DVD's on your account
$dvd = $client->dvd();

$res = $dvd->all();
echo json_encode($res, JSON_PRETTY_PRINT);


# Returns information about a DVD
$dvd = $client->dvd();

$res = $dvd->get('<DVD-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);