<?php

use OneAndOne;

$client = new OneAndOne('<API-TOKEN>');




# List all servers on your account
$server = $client->server();

$res = $server->list();
echo json_encode($res, JSON_PRETTY_PRINT);



# Create a server
$server = $client->server();

$hdd1 = [
    'size' => 120,
    'is_main' => True
];

$hdds = [$hdd1];

$my_server = [
    'name' => 'Example Server',
    'description' => 'Example Desc',
    'hardware' => [
        'vcore' => 1,
        'cores_per_processor' => 1,
        'ram' => 1,
        'hdds' => $hdds
    ],
    'appliance_id' => '<IMAGE-ID>'
];

$res = $server->create($my_server);
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve the current specs for a server
$server = $client->server();

$res = $server->get('<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Modify a server
$server = $client->server();

$specs = [
    'name' => 'New Name'
];

$res = $server->modify($specs, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Delete a server
$server = $client->server();

$keep_ips = False;

$res = $server->delete($keep_ips, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# List all fixed server options
$server = $client->server();

$res = $server->listFixed();
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve information about a fixed server option
$server = $client->server();

$res = $server->getFixed('<FIXED-INSTANCE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve a server's current hardware configuration
$server = $client->server();

$res = $server->hardware('<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Modify a server's hardware configurations
$server = $client->server();

$specs = [
    'ram' => 2
];

$res = $server->modifyHardware($specs, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# List a server's hdds
$server = $client->server();

$res = $server->hdds('<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Add hdds to a server
$server = $client->server();

$hdd1 = [
    'size' => 40,
    'is_main' => False
];

$hdds = [$hdd1];

$res = $server->addHdds($hdds, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve a server's hdd
$server = $client->server();

$res = $server->hdd('<HDD-ID>', '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Modify a server's hdd
$server = $client->server();

$resize = [
    'hdd_id' => '<HDD-ID>',
    'size' => 80
];

$res = $server->modifyHdd($resize, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Delete a server's hdd
$server = $client->server();

$res = $server->deleteHdd('<HDD-ID>', '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve information about a server's image
$server = $client->server();

$res = $server->image('<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Install an image onto a server
$server = $client->server();

$image = [
    'id' => '<IMAGE-ID>',
    'password' => 'serverpass'
];

$res = $server->installImage($image, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# List a servers IPs
$server = $client->server();

$res = $server->ips('<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Add an IP to a server
$server = $client->server();

$type = 'IPV4';

$res = $server->addIp($type, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve a server's IP
$server = $client->server();

$res = $server->ip('<IP-ID>', '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Release a server's IP
$server = $client->server();

$args = [
    'ip_id' => '<IP-ID>',
    'keep_ip' => true
];

$res = $server->releaseIp($args, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve a server IP's firewall
$server = $client->server();

$res = $server->firewall('<IP-ID>', '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Remove a server IP's firewall
$server = $client->server();

$res = $server->removeFirewall('<IP-ID>', '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Add a firewall to a server
$server = $client->server();

$firewall = [
    'ip_id' => '<IP-ID>',
    'firewall_id' => '<FIREWALL-ID>'
];

$res = $server->addFirewall($firewall, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# List a server IP's load balancers
$server = $client->server();

$res = $server->loadBalancers('<IP-ID>', '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Add a load balancer to a server's IP
$server = $client->server();

$load_balancer = [
    'ip_id' => '<IP-ID>',
    'load_balancer_id' => '<LOAD-BALANCER-ID>'
];

$res = $server->addLoadBalancer($load_balancer, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Remove a load balancer from a server's IP
$server = $client->server();

$load_balancer = [
    'ip_id' => '<IP-ID>',
    'load_balancer_id' => '<LOAD-BALANCER-ID>'
];

$res = $server->removeLoadBalancer($load_balancer, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve a server's current status
$server = $client->server();

$res = $server->status('<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Change a server's status
$server = $client->server();

$action = [
    'action' => 'REBOOT',
    'method' => 'SOFTWARE'
];

$res = $server->changeStatus($action, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve a server's DVD
$server = $client->server();

$res = $server->dvd('<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Eject a server's DVD
$server = $client->server();

$res = $server->ejectDvd('<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Load a DVD into a server
$server = $client->server();

$dvd_id = '<DVD-ID>';

$res = $server->loadDvd($dvd_id, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# List a server's private networks
$server = $client->server();

$res = $server->privateNetworks('<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve information about a server's private network
$server = $client->server();

$private_network_id = '<PRIVATE-NETWORK-ID>';

$res = $server->privateNetwork($private_network_id, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Remove a server from a private network
$server = $client->server();

$private_network_id = '<PRIVATE-NETWORK-ID>';

$res = $server->removePrivateNetwork($private_network_id, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Add a server to a private network
$server = $client->server();

$private_network_id = '<PRIVATE-NETWORK-ID>';

$res = $server->addPrivateNetwork($private_network_id, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Create a server snapshot
$server = $client->server();

$res = $server->createSnapshot('<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve a server's snapshot
$server = $client->server();

$res = $server->snapshot('<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Restore a server's snapshot
$server = $client->server();

$snapshot_id = '<SNAPSHOT-ID>';

$res = $server->restoreSnapshot($snapshot_id, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Delete a server's snapshot
$server = $client->server();

$snapshot_id = '<SNAPSHOT-ID>';

$res = $server->deleteSnapshot($snapshot_id, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Clone a server
$server = $client->server();

$name = 'Clone Server';

$res = $server->clone($name, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);