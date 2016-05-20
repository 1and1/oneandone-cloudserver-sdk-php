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
echo $load_balancer->waitFor();



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
echo $firewall_policy->waitFor();



// Create Server
$server = $client->server();

$my_server = [
    'name' => 'Example App Server',
    'hardware' => [
        'fixed_instance_size_id' => '65929629F35BBFBA63022008F773F3EB'
    ],
    'appliance_id' => '6C902E5899CC6F7ED18595EBEB542EE1',
    'datacenter_id' => '5091F6D8CBFEF9C26ACE957C652D5D49'
];

echo "\nCreating server...\n";
$res = $server->create($my_server);
// Wait for Server to Deploy
echo $server->waitFor();



// Add the Load Balancer to the New IP
$add_lb = [
    'ip_id' => $server->first_ip['id'],
    'load_balancer_id' => $load_balancer->id
];

echo "\nAdding load balancer to the IP...\n";
$res = $server->addLoadBalancer($add_lb);
// Wait for load balancer to be added
echo $server->waitFor();



// Add the Firewall Policy to the New IP
$add_firewall = [
    'ip_id' => $server->first_ip['id'],
    'firewall_id' => $firewall_policy->id
];

echo "\nAdding firewall policy to the IP...\n";
$res = $server->addFirewall($add_firewall);
// Wait for firewall policy to be added
echo $server->waitFor();



// Cleanup
echo "\nEverything looks good!\n";
echo "\nLet's clean up the mess we just made.\n";

echo "\nDeleting server...\n";
$server->delete();
echo "Success!\n";

echo "\nDeleting load balancer...\n";
$load_balancer->delete();
echo "Success!\n";

echo "\nDeleting firewall policy...\n";
$firewall_policy->delete();
echo "Success!\n";