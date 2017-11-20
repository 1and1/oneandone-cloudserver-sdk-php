<?php

require('../vendor/autoload.php');

use src\oneandone\OneAndOne;
$token = getenv('ONEANDONE_TOKEN');

$client = new OneAndOne($token);

//# List all fixed server options
$server = $client->server();

# Find a baremetal model
$baremetalModels = $server->listBaremetalModels();
echo json_encode($baremetalModels, JSON_PRETTY_PRINT);

foreach ($baremetalModels as &$bmModel) {
  if ($bmModel['name'] == 'BMC_L') {
    $baremetal_model = $bmModel;
  }
}

#Find a baremetal appliance image
$server_appliance = $client->serverAppliance();
$params = [
    'page' => null,
    'per_page' => null,
    'sort' => null,
    'q' => "baremetal",
    'fields' => null
];
$server_appliances = $server_appliance->all($params);
echo json_encode($server_appliances, JSON_PRETTY_PRINT);
$server_image = $server_appliances[0];

# Create a server
$baremetal_server = [
    'name' => 'Example Server',
    'description' => 'Example Desc',
    'server_type' => 'baremetal',
    'hardware' => [
        'baremetal_model_id' => $baremetal_model['id']
    ],
    'appliance_id' => $server_image['id']
];

$res = $server->create($baremetal_server);
echo json_encode($res, JSON_PRETTY_PRINT);

$server->waitFor();

# List all servers on your account
$servers_list = $server->all();
echo json_encode($servers_list, JSON_PRETTY_PRINT);

# Retrieve the current specs for a server
$get_server = $server->get($res['id']);
echo json_encode($get_server, JSON_PRETTY_PRINT);


# Modify a server
$specs = [
    'name' => 'New Name'
];

$updated_server = $server->modify($specs, $res['id']);
echo json_encode($updated_server, JSON_PRETTY_PRINT);

# Retrieve a server's current hardware configuration

$harware = $server->hardware($res['id']);
echo json_encode($harware, JSON_PRETTY_PRINT);

# List a server's hdds
$hdds = $server->hdds($res['id']);
echo json_encode($hdds, JSON_PRETTY_PRINT);

# Retrieve a server's hdd
$hdd = $server->hdd($hdds[0]['id'], $res['id']);
echo json_encode($hdd, JSON_PRETTY_PRINT);

# Retrieve information about a server's image
$server_img = $server->image($res['id']);
echo json_encode($server_img, JSON_PRETTY_PRINT);

# List a servers IPs
$servers_ips = $server->ips($res['id']);
echo json_encode($servers_ips, JSON_PRETTY_PRINT);

# Add an IP to a server
$type = 'IPV4';

$added_ip = $server->addIp($type, $res['id']);
echo json_encode($added_ip, JSON_PRETTY_PRINT);
$server->waitFor();

# Retrieve a server's IP
$ret_server_ip = $server->ip($added_ip['ips'][1]['id'], $res['id']);
echo json_encode($ret_server_ip, JSON_PRETTY_PRINT);

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
    'name' => 'PHP Firewall',
    'description' => 'PHP Desc',
    'rules' => $rules
];

$my_firewall = $firewall_policy->create($args);
echo json_encode($my_firewall, JSON_PRETTY_PRINT);
$firewall_policy->waitFor();
# Add a firewall to a server

$firewall = [
    'ip_id' => $added_ip['ips'][1]['id'],
    'firewall_id' => $my_firewall['id']
];

$addedFW = $server->addFirewall($firewall, $res['id']);
echo json_encode($addedFW, JSON_PRETTY_PRINT);

$firewall_policy->waitFor();

# Retrieve a server IP's firewall

$fwl_policy = $server->firewall($added_ip['ips'][1]['id'], $res['id']);
echo json_encode($fwl_policy, JSON_PRETTY_PRINT);

# Remove a server IP's firewall
$policy_removed = $server->removeFirewall($added_ip['ips'][1]['id'], $res['id']);
echo json_encode($policy_removed, JSON_PRETTY_PRINT);
$server->waitFor();

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

$my_loadbalancer = $load_balancer->create($args);
echo json_encode($my_loadbalancer, JSON_PRETTY_PRINT);

$load_balancer-> waitFor();


# Add a load balancer to a server's IP
$load_balancer_body = [
    'ip_id' => $added_ip['ips'][1]['id'],
    'load_balancer_id' => $my_loadbalancer['id']
];

$addLB = $server->addLoadBalancer($load_balancer_body, $res['id']);
echo json_encode($addLB, JSON_PRETTY_PRINT);
$load_balancer-> waitFor();
$server -> waitFor();

# List a server IP's load balancers
$server_lbs = $server->loadBalancers($added_ip['ips'][1]['id'], $res['id']);
echo json_encode($server_lbs, JSON_PRETTY_PRINT);

# Remove a load balancer from a server's IP
$load_balancer_body = [
    'ip_id' => $added_ip['ips'][1]['id'],
    'load_balancer_id' => $my_loadbalancer['id']
];

$removed_lb = $server->removeLoadBalancer($load_balancer_body,  $res['id']);
echo json_encode($removed_lb, JSON_PRETTY_PRINT);
$load_balancer-> waitFor();
$server -> waitFor();

# Retrieve a server's current status
$server_status = $server->status($res['id']);
echo json_encode($server_status, JSON_PRETTY_PRINT);


# Change a server's status
$action = [
    'action' => 'REBOOT',
    'method' => 'SOFTWARE'
];

$changed_status = $server->changeStatus($action, $res['id']);
echo json_encode($changed_status, JSON_PRETTY_PRINT);

#Delete firewall
$deleted_firewall =$firewall_policy->delete($my_firewall['id']);

# Delete a load balancer
$load_balancer = $client->loadBalancer();

$deleted_lb = $load_balancer->delete($my_loadbalancer['id']);

# Delete a server
$keep_ips = False;
$server->waitFor();
$delete_response = $server->delete($keep_ips, $res['id']);
echo json_encode($delete_response, JSON_PRETTY_PRINT);
