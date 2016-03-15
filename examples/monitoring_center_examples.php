<?php

use OneAndOne;

$client = new OneAndOne('<API-TOKEN>');




# List all usages and alerts of monitoring servers
$monitoring_center = $client->monitoringCenter();

$res = $monitoring_center->list();
echo json_encode($res, JSON_PRETTY_PRINT);


# Returns the usage of the resources for the specified time range
$monitoring_center = $client->monitoringCenter();

$params = [
    'period' => 'LAST_24H'
];

$res = $monitoring_center->get('<SERVER-ID>', $params);
echo json_encode($res, JSON_PRETTY_PRINT);