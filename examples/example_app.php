<?php

require(dirname(__DIR__).'/vendor/autoload.php');

use src\oneandone\OneAndOne;

$client = new OneAndOne('<API-TOKEN>');



// Create Load Balancer
$load_balancer = $client->loadBalancer();

$rule1 = [
    'protocol' => 'TCP',
    'port_balancer' => 80,
    'port_server' => 80,
    'source' => '0.0.0.0'
];

$rules = [$rule1];

$args = [
    'name' => 'Example LB',
    'health_check_test' => 'TCP',
    'health_check_interval' => 40,
    'persistence' => True,
    'persistence_time' => 1200,
    'method' => 'ROUND_ROBIN',
    'rules' => $rules
];

echo "Creating load balancer...\n";
$res = $load_balancer->create($args);
// Wait for Load Balancer to Deploy
$load_balancer->waitFor();



// Create Firewall Policy
$firewall_policy = $client->firewallPolicy();

$rule1 = [
    'protocol' => 'TCP',
    'port_from' => 80,
    'port_to' => 80,
    'source' => '0.0.0.0'
];

$rules = [$rule1];

$args = [
    'name' => 'Example Firewall',
    'description' => 'Example Desc',
    'rules' => $rules
];

echo "\nCreating firewall policy...\n";
$res = $firewall_policy->create($args);
// Wait for Firewall to Deploy
$firewall_policy->waitFor();



// Create Server
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

echo "\nCreating server...\n";
$res = $server->create($my_server);
// Wait for Server to Deploy
$server->waitFor();



// Add a New IP to the Server
echo "\nAdding an IP to the server...\n";
$res = $server->addIp();
$new_ip = $res['ips'][1]['id'];



// Add the Load Balancer to the New IP
$add_lb = [
    'ip_id' => $new_ip,
    'load_balancer_id' => $load_balancer->id
];

echo "\nAdding load balancer to the IP...\n";
$res = $server->addLoadBalancer($add_lb);
// Wait for load balancer to be added
$server->waitFor();



// Add the Firewall Policy to the New IP
$add_firewall = [
    'ip_id' => $new_ip,
    'firewall_id' => $firewall_policy->id
];

echo "\nAdding firewall policy to the IP...\n";
$res = $server->addFirewall($add_firewall);
// Wait for firewall policy to be added
$server->waitFor();



// Cleanup
echo "\nEverything looks good!\n";
echo "\nLet's clean up the mess we just made.\n";

echo "\nDeleting server...\n";
$res = $server->delete();
echo "Success!\n";

echo "\nDeleting load balancer...\n";
$res = $load_balancer->delete();
echo "Success!\n";

echo "\nDeleting firewall policy...\n";
$res = $firewall_policy->delete();
echo "Success!\n";