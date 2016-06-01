<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

$client = new OneAndOne('<API-TOKEN>');




# List all server appliances on your account
$server_appliance = $client->serverAppliance();

$res = $server_appliance->all();
echo json_encode($res, JSON_PRETTY_PRINT);


# Returns information about an appliance
$server_appliance = $client->serverAppliance();

$res = $server_appliance->get('<APPLIANCE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);