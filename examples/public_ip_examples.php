<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

$client = new OneAndOne('<API-TOKEN>');




# List all public IPs on your account
$public_ip = $client->publicIp();

$res = $public_ip->all();
echo json_encode($res, JSON_PRETTY_PRINT);



# Returns a public IP's current specs
$public_ip = $client->publicIp();

$res = $public_ip->get('<IP-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Create a public IP
$public_ip = $client->publicIp();

$res = $public_ip->create();
echo json_encode($res, JSON_PRETTY_PRINT);



# Modify a public IP
$public_ip = $client->publicIp();

$reverse_dns = 'example.com';

$res = $public_ip->modify($reverse_dns, '<IP-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Delete a public IP
$public_ip = $client->publicIp();

$res = $public_ip->delete('<IP-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);