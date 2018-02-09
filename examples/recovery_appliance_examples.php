<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

$client = new OneAndOne('<API-TOKEN>');




# List all server appliances on your account
$recovery_appliance = $client->recoveryAppliance();

$res = $recovery_appliance->all();
echo json_encode($res, JSON_PRETTY_PRINT);


# Returns information about an appliance
$recovery_appliance = $client->recoveryAppliance();

$res = $recovery_appliance->get('<APPLIANCE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);