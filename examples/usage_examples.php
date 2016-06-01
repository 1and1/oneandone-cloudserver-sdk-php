<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

$client = new OneAndOne('<API-TOKEN>');




# List all usages by time period
$usage = $client->usage();

$params = [
    'period' => 'LAST_24H'
];

$res = $usage->all($params);
echo json_encode($res, JSON_PRETTY_PRINT);