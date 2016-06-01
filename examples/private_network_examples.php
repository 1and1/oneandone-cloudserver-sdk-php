<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

$client = new OneAndOne('<API-TOKEN>');




# List all private networks on your account
$private_network = $client->privateNetwork();

$res = $private_network->all();
echo json_encode($res, JSON_PRETTY_PRINT);



# Create a private network
$private_network = $client->privateNetwork();

$args = [
    'name' => 'Example PN',
    'network_address' => '192.168.1.0',
    'subnet_mask' => '255.255.255.0'
];

$res = $private_network->create($args);
echo json_encode($res, JSON_PRETTY_PRINT);



# Returns a private network's current specs
$private_network = $client->privateNetwork();

$res = $private_network->get('<PRIVATE-NETWORK-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Modify a private network
$private_network = $client->privateNetwork();

$args = [
    'name' => 'New Name PN'
];

$res = $private_network->modify($args, '<PRIVATE-NETWORK-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Delete a private network
$private_network = $client->privateNetwork();

$res = $private_network->delete('<PRIVATE-NETWORK-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# List a private network's servers
$private_network = $client->privateNetwork();

$res = $private_network->servers('<PRIVATE-NETWORK-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Returns information about a private network's server
$private_network = $client->privateNetwork();

$server_id = '<SERVER-ID>';

$res = $private_network->server($server_id, '<PRIVATE-NETWORK-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Remove a private network's server
$private_network = $client->privateNetwork();

$server_id = '<SERVER-ID>';

$res = $private_network->removeServer($server_id, '<PRIVATE-NETWORK-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Add servers to a private network
$private_network = $client->privateNetwork();

$servers = ['<SERVER-ID>'];

$res = $private_network->addServers($servers, '<PRIVATE-NETWORK-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);