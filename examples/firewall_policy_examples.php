<?php

require('../vendor/autoload.php');

use src\oneandone\OneAndOne;

$token = getenv('ONEANDONE_TOKEN');

$client = new OneAndOne($token);

$server_appliance = $client->serverAppliance();
$params = array(
    'q' => 'ubuntu'
);
$res = $server_appliance->all($params);

foreach ($res as $appliance) {
    if ($appliance['type'] == "IMAGE") {
        break;
    }
}

# Create a server
$server = $client->server();

$hdd1 = [
    'size' => 120,
    'is_main' => True
];

$hdds = [$hdd1];

$my_server = [
    'name' => 'php Server',
    'description' => 'Example Desc',
    'server_type' => 'cloud',
    'hardware' => [
        'vcore' => 1,
        'cores_per_processor' => 1,
        'ram' => 1,
        'hdds' => $hdds
    ],
    'appliance_id' => $appliance['id']
];

$res = $server->create($my_server);
echo $server->waitFor();

# Retrieve the current specs for a server
$get_server = $server->get($res['id']);
echo json_encode($res, JSON_PRETTY_PRINT);

# Create a firewall policy
$firewall_policy = $client->firewallPolicy();

$rule1 = [
    'protocol' => 'TCP',
    'port' => '80',
    'action' => 'allow',
    'source' => '0.0.0.0'
];

$rules = [$rule1];

$args = [
    'name' => 'Example Firewall',
    'description' => 'Example Desc',
    'rules' => $rules
];

$fwPolicy = $firewall_policy->create($args);
echo json_encode($res, JSON_PRETTY_PRINT);

$firewall_policy->waitFor();

# Add IPs to a firewall policy
$ip_id = $get_server['ips'][0]['id'];

$ips = [$ip_id];

$res = $firewall_policy->addIps($ips, $fwPolicy['id']);
echo json_encode($res, JSON_PRETTY_PRINT);


# List all firewall policies on your account
$res = $firewall_policy->all();
echo json_encode($res, JSON_PRETTY_PRINT);

# Retrieve a firewall policy's current specs
$res = $firewall_policy->get($fwPolicy['id']);
echo json_encode($res, JSON_PRETTY_PRINT);

# List the IPs assigned to a firewall policy
$res = $firewall_policy->ips($fwPolicy['id']);
echo json_encode($res, JSON_PRETTY_PRINT);

# Retrieve information about an IP assigned to a firewall policy

$res = $firewall_policy->ip($ip_id, $fwPolicy['id']);
echo json_encode($res, JSON_PRETTY_PRINT);

# Add new rules to a firewall policy

$rule1 = [
    'protocol' => 'TCP',
    'port' => '90',
    'action' => 'allow',
    'source' => '0.0.0.0'
];

$rules = [$rule1];

$ruleRes = $firewall_policy->addRules($rules, $fwPolicy['id']);
echo json_encode($res, JSON_PRETTY_PRINT);

$firewall_policy->waitFor();

# List a firewall policy's rules
$res = $firewall_policy->rules($fwPolicy['id']);
echo json_encode($res, JSON_PRETTY_PRINT);

# Retrieve information about a firewall policy's rule
$rule_id = $ruleRes['rules'][0]['id'];

$res = $firewall_policy->rule($rule_id, $fwPolicy['id']);
echo json_encode($res, JSON_PRETTY_PRINT);

# Modify a firewall policy
$args = [
    'name' => 'php New Name',
    'description' => 'New Desc'
];

$res = $firewall_policy->modify($args, $fwPolicy['id']);
echo json_encode($res, JSON_PRETTY_PRINT);

# Remove a rule
$res = $firewall_policy->deleteRule($rule_id, $fwPolicy['id']);
echo json_encode($res, JSON_PRETTY_PRINT);
$firewall_policy->waitFor();

$server->waitFor();
$keep_ips = False;
# delete the server
$res = $server->delete($keep_ips, $get_server['id']);
echo json_encode($res, JSON_PRETTY_PRINT);
$server->waitRemoved();

# Delete a firewall policy
$res = $firewall_policy->delete($fwPolicy['id']);
echo json_encode($res, JSON_PRETTY_PRINT);

