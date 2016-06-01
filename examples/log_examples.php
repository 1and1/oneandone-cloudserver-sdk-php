<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

$client = new OneAndOne('<API-TOKEN>');




# List all logs by time period
$log = $client->log();

$params = [
    'period' => 'LAST_24H'
];

$res = $log->all($params);
echo json_encode($res, JSON_PRETTY_PRINT);


# Returns information about a log
$log = $client->log();

$res = $log->get('<LOG-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);