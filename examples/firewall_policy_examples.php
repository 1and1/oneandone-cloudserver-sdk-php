<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

$client = new OneAndOne('<API-TOKEN>');




# List all firewall policies on your account
$firewall_policy = $client->firewallPolicy();

$res = $firewall_policy->all();
echo json_encode($res, JSON_PRETTY_PRINT);



# Create a firewall policy
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

$res = $firewall_policy->create($args);
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve a firewall policy's current specs
$firewall_policy = $client->firewallPolicy();

$res = $firewall_policy->get('<FIREWALL-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Modify a firewall policy
$firewall_policy = $client->firewallPolicy();

$args = [
    'name' => 'New Name',
    'description' => 'New Desc'
];

$res = $firewall_policy->modify($args, '<FIREWALL-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Delete a firewall policy
$firewall_policy = $client->firewallPolicy();

$res = $firewall_policy->delete('<FIREWALL-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# List the IPs assigned to a firewall policy
$firewall_policy = $client->firewallPolicy();

$res = $firewall_policy->ips('<FIREWALL-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve information about an IP assigned to a firewall policy
$firewall_policy = $client->firewallPolicy();

$ip_id = '<IP-ID>';

$res = $firewall_policy->ip($ip_id, '<FIREWALL-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Remove a firewall policy's IP
$firewall_policy = $client->firewallPolicy();

$ip_id = '<IP-ID>';

$res = $firewall_policy->removeIp($ip_id, '<FIREWALL-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Add IPs to a firewall policy
$firewall_policy = $client->firewallPolicy();

$ip_id = '<IP-ID>';

$ips = [$ip_id];

$res = $firewall_policy->addIps($ips, '<FIREWALL-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# List a firewall policy's rules
$firewall_policy = $client->firewallPolicy();

$res = $firewall_policy->rules('<FIREWALL-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve information about a firewall policy's rule
$firewall_policy = $client->firewallPolicy();

$rule_id = '<RULE-ID>';

$res = $firewall_policy->rule($rule_id, '<FIREWALL-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Add new rules to a firewall policy
$firewall_policy = $client->firewallPolicy();

$rule1 = [
    'protocol' => 'TCP',
    'port_from' => 90,
    'port_to' => 90,
    'source' => '0.0.0.0'
];

$rules = [$rule1];

$res = $firewall_policy->addRules($rules, '<FIREWALL-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Remove a rule
$firewall_policy = $client->firewallPolicy();

$rule_id = '<RULE-ID>';

$res = $firewall_policy->deleteRule($rule_id, '<FIREWALL-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);