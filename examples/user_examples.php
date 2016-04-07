<?php

use OneAndOne;

$client = new OneAndOne('<API-TOKEN>');




# List all users on your account
$user = $client->user();

$res = $user->all();
echo json_encode($res, JSON_PRETTY_PRINT);



# Create a new user
$user = $client->user();

$args = [
    'name' => 'phpTest',
    'password' => 'testpassword'
];

$res = $user->create($args);
echo json_encode($res, JSON_PRETTY_PRINT);



# Return a user's current specs
$user = $client->user();

$res = $user->get('<USER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Modify a user account
$user = $client->user();

$args = [
    'name' => 'newName',
    'description' => 'Example Desc'
];

$res = $user->modify($args, '<USER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Delete a user
$user = $client->user();

$res = $user->delete('<USER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Return a user's API access credentials
$user = $client->user();

$res = $user->api('<USER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Enable or disable a user's API access
$user = $client->user();

$active = True;

$res = $user->enableApi($active, '<USER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Return a user's API key
$user = $client->user();

$res = $user->apiKey('<USER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Change a user's API key
$user = $client->user();

$res = $user->changeKey('<USER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# List the IP's from which a user can access the API
$user = $client->user();

$res = $user->ips('<USER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Add IP's from which a user can access the API
$user = $client->user();

$ip1 = '1.2.3.4';

$ips = [$ip1];

$res = $user->addIps($ips, '<USER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Remove API access for an IP
$user = $client->user();

$ip = '1.2.3.4';

$res = $user->removeIp($ip, '<USER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);