<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

$client = new OneAndOne('<API-TOKEN>');




# List all load balancers on your account
$load_balancer = $client->loadBalancer();

$res = $load_balancer->all();
echo json_encode($res, JSON_PRETTY_PRINT);



# Create a load balancer
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

$res = $load_balancer->create($args);
echo json_encode($res, JSON_PRETTY_PRINT);



# Return information about a load balancer
$load_balancer = $client->loadBalancer();

$res = $load_balancer->get('<LOAD-BALANCER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Modify a load balancer
$load_balancer = $client->loadBalancer();

$args = [
    'name' => 'New Name'
];

$res = $load_balancer->modify($args, '<LOAD-BALANCER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Delete a load balancer
$load_balancer = $client->loadBalancer();

$res = $load_balancer->delete('<LOAD-BALANCER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# List the IP's assigned to a load balancer
$load_balancer = $client->loadBalancer();

$res = $load_balancer->ips('<LOAD-BALANCER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Returns information about an IP assigned to the load balancer
$load_balancer = $client->loadBalancer();

$ip = '<IP-ID>';

$res = $load_balancer->ip($ip, '<LOAD-BALANCER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Remove a load balancer from an IP
$load_balancer = $client->loadBalancer();

$ip = '<IP-ID>';

$res = $load_balancer->removeIp($ip, '<LOAD-BALANCER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Add a load balancer to IP's
$load_balancer = $client->loadBalancer();

$ip = '<IP-ID>';

$ips = [$ip];

$res = $load_balancer->addIps($ips, '<LOAD-BALANCER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# List a load balancer's rules
$load_balancer = $client->loadBalancer();

$res = $load_balancer->rules('<LOAD-BALANCER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Returns information about a load balancer's rule
$load_balancer = $client->loadBalancer();

$rule = '<RULE-ID>';

$res = $load_balancer->rule($rule, '<LOAD-BALANCER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Add new rules to a load balancer
$load_balancer = $client->loadBalancer();

$rule = [
    'protocol' => 'TCP',
    'port_balancer' => 99,
    'port_server' => 99,
    'source' => '0.0.0.0'
];

$rules = [$rule];

$res = $load_balancer->addRules($rules, '<LOAD-BALANCER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Remove a load balancer's rule
$load_balancer = $client->loadBalancer();

$rule = '<RULE-ID>';

$res = $load_balancer->deleteRule($rule, '<LOAD-BALANCER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);