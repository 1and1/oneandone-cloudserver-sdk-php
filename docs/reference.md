# 1&amp;1 PHP SDK


# Table of Contents

- ["waitFor()"](#wait-for)
- [Class Attributes](#attributes)
- [Servers](#servers)
- [Images](#images)
- [Shared Storages](#shared-storages)
- [Firewall Policies](#firewall-policies)
- [Load Balancers](#load-balancers)
- [Public IPs](#public-ips)
- [Private Networks](#private-networks)
- [Monitoring Center](#monitoring-center)
- [Monitoring Policies](#monitoring-policies)
- [Logs](#logs)
- [Users](#users)
- [Usages](#usages)
- [Server Appliances](#server-appliances)
- [DVD's](#dvds)
- [Data Centers](#datacenters)
- [Pricing](#pricing)
- [Ping](#ping)
- [Ping Auth](#ping-auth)
- [VPN's](#vpn)
- [Roles](#roles)
- [Block Storages](#block-storages)



# <a name="wait-for"></a>"waitFor()"

Use the `waitFor()` method on any major class object to poll its resource until an `"ACTIVE"`, `"ENABLED"`, `"POWERED_ON"`, or `"POWERED_OFF"` state is returned.  This is necessary when chaining together multiple actions that take some time to deploy.  The `waitFor()` method is available on the `Server`, `Image`, `SharedStorage`, `Vpn`, `FirewallPolicy`, `LoadBalancer`, `PrivateNetwork`, and `MonitoringPolicy` classes.  It returns a string containing the execution duration.  See the example below:
```
<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

// Instantiate library with your API Token
$client = new OneAndOne('<API-TOKEN>');


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

echo "Creating server...\n";
$res = $server->create($my_server);
// Wait for Server to Deploy
echo $server->waitFor();



// Add a New IP to the Server
echo "Adding an IP to the server...\n";
$res = $server->addIp();
```
You may pass in an optional `timeout` value (in minutes) which stops the `waitFor()` method from polling after the given amount of time.  `timeout` is set to 25 minutes by default.  You may also set the `interval` value (in seconds).  The default value for `interval` varies by class.



# <a name="attributes"></a>Class Attributes

When creating a new resource (Server, Image, etc) the class object will automatically parse the returned JSON response and store its unique ID for later use.  This allows you to perform further actions on the resource without having to pass its unique identifier each time.  The ID is stored in the `id` attribute. 

In addition to the `id` attribute, you also have access to the following:
- `first_ip`: the initial IP address assigned to your new server.
- `first_password`: the initial password for connecting to your new server.
- `specs`: associative array containing all attributes parsed from JSON response.

If we extend our previous example, notice how we add a load balancer using the `first_ip` attribute:

```
<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

// Instantiate library with your API Token
$client = new OneAndOne('<API-TOKEN>');


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

echo "Creating server...\n";
$res = $server->create($my_server);
// Wait for Server to Deploy
echo $server->waitFor();



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



// Add the Load Balancer to the New IP
$add_lb = [
    'ip_id' => $server->first_ip['id'],
    'load_balancer_id' => $load_balancer->id
];

echo "Adding load balancer to the IP...\n";
$res = $server->addLoadBalancer($add_lb);
// Wait for load balancer to be added
echo $server->waitFor();
```



# <a name="servers"></a>Servers

Get started by instantiating a `Server` object:

```
$client = new OneAndOne('<API-TOKEN>');

$server = $client->server();
```


**List all servers:**

```
$res = $server->all();
```


**Returns a server's current configurations:**

```
$res = $server->get();

OR

$res = $server->get('<SERVER-ID>');
```


**List fixed server options:**

```
$res = $server->listFixed();
```


**Returns information about a fixed server option:**

```
$res = $server->getFixed('<FIXED-INSTANCE-ID>');
```


**Returns a server's current hardware configurations:**

```
$res = $server->hardware();

OR

$res = $server->hardware('<SERVER-ID>');
```


**List a server's HDDs:**

```
$res = $server->hdds();

OR

$res = $server->hdds('<SERVER-ID>');
```


**Returns information about a server's HDD:**

```
$res = $server->hdd('<HDD-ID>');

OR

$res = $server->hdd('<HDD-ID>', '<SERVER-ID>');
```


**Returns information about a server's image:**

```
$res = $server->image();

OR

$res = $server->image('<SERVER-ID>');
```


**List a server's IPs:**

```
$res = $server->ips();

OR

$res = $server->ips('<SERVER-ID>');
```


**Returns information about a server's IP:**

```
$res = $server->ip('<IP-ID>');

OR

$res = $server->ip('<IP-ID>', '<SERVER-ID>');
```


**Returns the firewall policy assigned to the server's IP:**

```
$res = $server->firewall('<IP-ID>');

OR

$res = $server->firewall('<IP-ID>', '<SERVER-ID>');
```


**List all load balancers assigned to the server's IP:**

```
$res = $server->loadBalancers('<IP-ID>');

OR

$res = $server->loadBalancers('<IP-ID>', '<SERVER-ID>');
```


**Returns a server's current state:**

```
$res = $server->status();

OR

$res = $server->status('<SERVER-ID>');
```


**Returns information about the DVD loaded into the virtual DVD unit of a server:**

```
$res = $server->dvd();

OR

$res = $server->dvd('<SERVER-ID>');
```


**List a server's private networks:**

```
$res = $server->privateNetworks();

OR

$res = $server->privateNetworks('<SERVER-ID>');
```


**Returns information about a server's private network:**

```
$private_network_id = '<PRIVATE-NETWORK-ID>';


$res = $server->privateNetwork($private_network_id);

OR

$res = $server->privateNetwork($private_network_id, '<SERVER-ID>');
```


**Returns information about a server's snapshot:**

```
$res = $server->snapshot();

OR

$res = $server->snapshot('<SERVER-ID>');
```


**Create a fixed server:**

*Note:* `appliance_id`, takes an `image_id` string
```
$my_server = [
    'name' => 'Example Server',
    'hardware' => [
        'fixed_instance_size_id' => '65929629F35BBFBA63022008F773F3EB'
    ],
    'appliance_id' => '6C902E5899CC6F7ED18595EBEB542EE1',
    'datacenter_id' => '5091F6D8CBFEF9C26ACE957C652D5D49'
];

$res = $server->create($my_server);
```


**Create a custom server:**

*Note:* A Hdd's `size` must be a multiple of `20`

*Note:* `appliance_id`, takes an `image_id` string
```
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
```


**Create a server with SSH Key access:**

*Note:* `appliance_id`, takes an `image_id` string
```
$pub_key = '<PUB-KEY>';

$my_server = [
    'name' => 'Example Server',
    'hardware' => [
        'fixed_instance_size_id' => '65929629F35BBFBA63022008F773F3EB'
    ],
    'appliance_id' => '6C902E5899CC6F7ED18595EBEB542EE1',
    'datacenter_id' => '5091F6D8CBFEF9C26ACE957C652D5D49',
    'rsa_key' => $pub_key
];

$res = $server->create($my_server);
```


**Create a server with SSH Key access and explicitly declare your datacenter:**

*Note:* `appliance_id`, takes an `image_id` string

*Note:* `appliance_id` location must match datacenter location (ex. DE and DE)
```
$pub_key = '<PUB-KEY>';
$datacenter = '<DC-ID>';

$my_server = [
    'name' => 'Example Server',
    'hardware' => [
        'fixed_instance_size_id' => '65929629F35BBFBA63022008F773F3EB'
    ],
    'appliance_id' => '6C902E5899CC6F7ED18595EBEB542EE1',
    'datacenter_id' => '5091F6D8CBFEF9C26ACE957C652D5D49',
    'rsa_key' => $pub_key,
    'datacenter_id' => $datacenter
];

$res = $server->create($my_server);
```


**Add new HDDs to a server:**

*Note:* A Hdd's `size` must be a multiple of `20`
```
$hdd1 = [
    'size' => 40,
    'is_main' => False
];

$hdds = [$hdd1];


$res = $server->addHdds($hdds);

OR

$res = $server->addHdds($hdds, '<SERVER-ID>');
```


**Add a new IP to the server:**

```
$res = $server->addIp();

OR

$type = 'IPV4';

$res = $server->addIp($type, '<SERVER-ID>');
```


**Add a new load balancer to the server's IP:**

```
$load_balancer = [
    'ip_id' => '<IP-ID>',
    'load_balancer_id' => '<LOAD-BALANCER-ID>'
];


$res = $server->addLoadBalancer($load_balancer);

OR

$res = $server->addLoadBalancer($load_balancer, '<SERVER-ID>');
```


**Assign a private network to the server:**

```
$private_network_id = '<PRIVATE-NETWORK-ID>';


$res = $server->addPrivateNetwork($private_network_id);

OR

$res = $server->addPrivateNetwork($private_network_id, '<SERVER-ID>');
```


**Create a server snapshot:**

```
$res = $server->createSnapshot();

OR

$res = $server->createSnapshot('<SERVER-ID>');
```


**Clone a server:**

```
$args = [
    'name' => 'Clone Server',
    'datacenter_id' => '<DC-ID>'
];


$res = $server->cloneServer($args);

OR

$res = $server->cloneServer($args, '<SERVER-ID>');
```


**Modify a server:**

```
$specs = [
    'name' => 'New Name'
];


$res = $server->modify($specs);

OR

$res = $server->modify($specs, '<SERVER-ID>');
```


**Modify a server's hardware configurations:**

*Note:* Cannot perform "hot" decreasing of server hardware values.  "Cold" decreasing is allowed.

```
$specs = [
    'ram' => 2
];


$res = $server->modifyHardware($specs);

OR

$res = $server->modifyHardware($specs, '<SERVER-ID>');
```


**Resize a server's HDD:**

*Note:* `size` must be a multiple of `20`

```
$resize = [
    'hdd_id' => '<HDD-ID>',
    'size' => 80
];


$res = $server->modifyHdd($resize);

OR

$res = $server->modifyHdd($resize, '<SERVER-ID>');
```


**Add a firewall policy to a server's IP:**

```
$firewall = [
    'ip_id' => '<IP-ID>',
    'firewall_id' => '<FIREWALL-ID>'
];


$res = $server->addFirewall($firewall);

OR

$res = $server->addFirewall($firewall, '<SERVER-ID>');
```


**Change a server's state:**

*Note:* `action` can be set to `POWER_OFF`, `POWER_ON`, `REBOOT`

*Note:* `method` can be set to `SOFTWARE` or `HARDWARE`

```
$action = [
    'action' => 'REBOOT',
    'method' => 'SOFTWARE'
];


$res = $server->changeStatus($action);

OR

$res = $server->changeStatus($action, '<SERVER-ID>');
```


**Load a DVD into the virtual DVD unit of a server:**

```
$dvd_id = '<DVD-ID>';


$res = $server->loadDvd($dvd_id);

OR

$res = $server->loadDvd($dvd_id, '<SERVER-ID>');
```


**Restore a snapshot into the server:**

```
$snapshot_id = '<SNAPSHOT-ID>';


$res = $server->restoreSnapshot($snapshot_id);

OR

$res = $server->restoreSnapshot($snapshot_id, '<SERVER-ID>');
```


**Install an image onto a server:**

```
$image = [
    'id' => '<IMAGE-ID>',
    'password' => 'serverpass'
];


$res = $server->installImage($image);

OR

$res = $server->installImage($image, '<SERVER-ID>');
```


**Delete a server:**

*Note:* Set `keep_ips` to `True` to keep server IPs after deleting a server. (`False` by default).  This parameter is only required if you are passing in a `<SERVER-ID>`.

```
$res = $server->delete();

OR

$keep_ips = False;

$res = $server->delete($keep_ips, '<SERVER-ID>');
```


**Remove a server's HDD:**

```
$hdd_id = '<HDD-ID>';

$res = $server->deleteHdd($hdd_id);

OR

$res = $server->deleteHdd($hdd_id, '<SERVER-ID>');
```


**Release a server's IP and optionally remove it:**

```
$args = [
    'ip_id' => '<IP-ID>'
];


$res = $server->releaseIp($args);

OR

$res = $server->releaseIp($args, '<SERVER-ID>');
```


**Remove a firewall policy from a server's IP:**

```
$ip_id = '<IP-ID>';


$res = $server->removeFirewall($ip_id);

OR

$res = $server->removeFirewall($ip_id, '<SERVER-ID>');
```


**Remove a load balancer from a server's IP:**

```
$load_balancer = [
    'ip_id' => '<IP-ID>',
    'load_balancer_id' => '<LOAD-BALANCER-ID>'
];


$res = $server->removeLoadBalancer($load_balancer);

OR

$res = $server->removeLoadBalancer($load_balancer, '<SERVER-ID>');
```


**Remove a server from a private network:**

```
$private_network_id = '<PRIVATE-NETWORK-ID>';


$res = $server->removePrivateNetwork($private_network_id);

OR

$res = $server->removePrivateNetwork($private_network_id, '<SERVER-ID>');
```


**Eject a DVD from the virtual DVD unit of a server:**

```
$res = $server->ejectDvd();

OR

$res = $server->ejectDvd('<SERVER-ID>');
```


**Delete a server's snapshot:**

```
$snapshot_id = '<SNAPSHOT-ID>';


$res = $server->deleteSnapshot($snapshot_id);

OR

$res = $server->deleteSnapshot($snapshot_id, '<SERVER-ID>');
```




# <a name="images"></a>Images

Get started by instantiating an `Image` object:

```
$client = new OneAndOne('<API-TOKEN>');

$image = $client->image();
```



**List all images:**

```
$res = $image->all();
```


**Retrieve a single image:**

```
$res = $image->get();

OR

$res = $image->get('<IMAGE-ID>');
```


**Create an image:**

*Note:* `frequency` can be set to `'ONCE', 'DAILY'`, or `'WEEKLY'`

*Note:* `num_images` must be an integer between `1` and `50`
```
$specs = [
    'server_id' => '<SERVER-ID>',
    'name' => 'Example Image',
    'description' => 'Example Desc'
    'frequency' => 'ONCE',
    'num_images' => 1
];

$res = $image->create($specs);
```


**Modify an image:**

*Note:* `frequency` can only be changed to `'ONCE'`
```
$specs = [
    'name' => 'New Name'
];

$res = $image->modify($specs);

OR

$res = $image->modify($specs, '<IMAGE-ID>');
```


**Delete an image:**

```
$res = $image->delete();

OR

$res = $image->delete('<IMAGE-ID>');
```




# <a name="shared-storages"></a>Shared Storages

Get started by instantiating a `SharedStorage` object:

```
$client = new OneAndOne('<API-TOKEN>');

$shared_storage = $client->sharedStorage();
```

**List all shared storages:**

```
$res = $shared_storage->all();
```


**Returns information about a shared storage:**

```
$res = $shared_storage->get();

OR

$res = $shared_storage->get('<SHARED-STORAGE-ID>');
```


**List a shared storage's servers:**

```
$res = $shared_storage->servers();

OR

$res = $shared_storage->servers('<SHARED-STORAGE-ID>');
```


**Returns information about a shared storage's server:**

```
$server_id = '<SERVER-ID>';


$res = $shared_storage->server($server_id);

OR

$res = $shared_storage->server($server_id, '<SHARED-STORAGE-ID>');
```


**List the credentials for accessing shared storages:**

```
$res = $shared_storage->access();
```


**Create a shared storage:**

*Note:* `size` must be a multiple of `50`

```
$args = [
    'name' => 'Test Storage',
    'description' => 'Test Desc',
    'size' => 200
];

$res = $shared_storage->create($args);
```


**Add servers to a shared storage:**

*Note:* `rights` can be set to either `'R'` or `'RW'`. (Read or Read/Write)
```
$server1 = [
    'id' => '<SERVER-ID>',
    'rights' => 'R'
];

$servers = [$server1];

$res = $shared_storage->addServers($servers);

OR

$res = $shared_storage->addServers($servers, '<SHARED-STORAGE-ID>');
```


**Modify a shared storage:**

*Note:* `size` must be a multiple of `50`

```
$args = [
    'name' => 'New Name',
    'description' => 'New Desc',
    'size' => 250
];

$res = $shared_storage->modify($args);

OR

$res = $shared_storage->modify($args, '<SHARED-STORAGE-ID>');
```


**Change the password for accessing shared storages:**

```
$res = $shared_storage->changePassword('newpass1');
```


**Delete a shared storage:**

```
$res = $shared_storage->delete();

OR

$res = $shared_storage->delete('<SHARED-STORAGE-ID>');
```


**Remove a server from a shared storage:**

```
$server_id = '<SERVER-ID>';

$res = $shared_storage->removeServer($server_id);

OR

$res = $shared_storage->removeServer($server_id, '<SHARED-STORAGE-ID>');
```




# <a name="firewall-policies"></a>Firewall Policies


Get started by instantiating a `Firewall` object:

```
$client = new OneAndOne('<API-TOKEN>');

$firewall_policy = $client->firewallPolicy();
```


**List all firewall policies:**

```
$res = $firewall_policy->all();
```


**Retrieve a firewall policy's current specs:**

```
$res = $firewall_policy->get();

OR

$res = $firewall_policy->get('<FIREWALL-ID>');
```


**List the IPs assigned to a firewall policy:**

```
$res = $firewall_policy->ips();

OR

$res = $firewall_policy->ips('<FIREWALL-ID>');
```


**Retrieve information about an IP assigned to a firewall policy:**

```
$ip_id = '<IP-ID>';

$res = $firewall_policy->ip($ip_id);

OR

$res = $firewall_policy->ip($ip_id, '<FIREWALL-ID>');
```


**List a firewall policy's rules:**

```
$res = $firewall_policy->rules();

OR

$res = $firewall_policy->rules('<FIREWALL-ID>');
```


**Retrieve information about a firewall policy's rule:**

```
$rule_id = '<RULE-ID>';

$res = $firewall_policy->rule($rule_id);

OR

$res = $firewall_policy->rule($rule_id, '<FIREWALL-ID>');
```


**Create a firewall policy:**

*Note:* `rules` must receive an array with at least one rule object.
```
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
```


**Add new rules to a firewall policy:**
```
$rule1 = [
    'protocol' => 'TCP',
    'port_from' => 90,
    'port_to' => 90,
    'source' => '0.0.0.0'
];

$rules = [$rule1];

$res = $firewall_policy->addRules($rules);

OR

$res = $firewall_policy->addRules($rules, '<FIREWALL-ID>');
```


**Add IPs to a firewall policy:**

```
$ip_id = '<IP-ID>';

$ips = [$ip_id];

$res = $firewall_policy->addIps($ips);

OR

$res = $firewall_policy->addIps($ips, '<FIREWALL-ID>');
```


**Modify a firewall policy:**

```
$args = [
    'name' => 'New Name',
    'description' => 'New Desc'
];

$res = $firewall_policy->modify($args);

OR

$res = $firewall_policy->modify($args, '<FIREWALL-ID>');
```


**Delete a firewall policy:**

```
$res = $firewall_policy->delete();

OR

$res = $firewall_policy->delete('<FIREWALL-ID>');
```


**Remove a rule from a firewall policy:**

```
$rule_id = '<RULE-ID>';

$res = $firewall_policy->deleteRule($rule_id);

OR

$res = $firewall_policy->deleteRule($rule_id, '<FIREWALL-ID>');
```


**Remove a firewall policy's IP:**

```
$ip_id = '<IP-ID>';

$res = $firewall_policy->removeIp($ip_id);

OR

$res = $firewall_policy->removeIp($ip_id, '<FIREWALL-ID>');
```




# <a name="load-balancers"></a>Load Balancers

Get started by instantiating a `LoadBalancer` object:

```
$client = new OneAndOne('<API-TOKEN>');

$load_balancer = $client->loadBalancer();
```


**List all load balancers:**

```
$res = $load_balancer->all();
```


**Returns the current specs of a load balancer:**

```
$res = $load_balancer->get();

OR

$res = $load_balancer->get('<LOAD-BALANCER-ID>');
```


**List the IP's assigned to a load balancer:**

```
$res = $load_balancer->ips();

OR

$res = $load_balancer->ips('<LOAD-BALANCER-ID>');
```


**Returns information about an IP assigned to the load balancer:**

```
$ip = '<IP-ID>';


$res = $load_balancer->ip($ip);

OR

$res = $load_balancer->ip($ip, '<LOAD-BALANCER-ID>');
```


**List all load balancer rules:**

```
$res = $load_balancer->rules();

OR

$res = $load_balancer->rules('<LOAD-BALANCER-ID>');
```


**Returns information about a load balancer's rule:**

```
$rule = '<RULE-ID>';


$res = $load_balancer->rule($rule);

OR

$res = $load_balancer->rule($rule, '<LOAD-BALANCER-ID>');
```


**Create a load balancer:**

*Note:* `health_check_test` can only be set to `'TCP'` at the moment

*Note:* `health_check_interval` can range from `5` to `300` seconds

*Note:* `persistence_time` is required if `persistence` is enabled, and can range from `30` to `1200` seconds

*Note:* `method` can be set to `'ROUND_ROBIN'` or `'LEAST_CONNECTIONS'`
```
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
```


**Add a load balancer to IP's:**
```
$ip = '<IP-ID>';

$ips = [$ip];


$res = $load_balancer->addIps($ips);

OR

$res = $load_balancer->addIps($ips, '<LOAD-BALANCER-ID>');
```


**Add new rules to a load balancer:**
```
$rule = [
    'protocol' => 'TCP',
    'port_balancer' => 99,
    'port_server' => 99,
    'source' => '0.0.0.0'
];

$rules = [$rule];


$res = $load_balancer->addRules($rules);

OR

$res = $load_balancer->addRules($rules, '<LOAD-BALANCER-ID>');
```


**Modify a load balancer:**

```
$args = [
    'name' => 'New Name'
];


$res = $load_balancer->modify($args);

OR

$res = $load_balancer->modify($args, '<LOAD-BALANCER-ID>');
```


**Delete a load balancer:**

```
$res = $load_balancer->delete();

OR

$res = $load_balancer->delete('<LOAD-BALANCER-ID>');
```


**Remove a load balancer from an IP:**

```
$ip = '<IP-ID>';


$res = $load_balancer->removeIp($ip);

OR

$res = $load_balancer->removeIp($ip, '<LOAD-BALANCER-ID>');
```


**Remove a load balancer's rule:**

```
$rule = '<RULE-ID>';


$res = $load_balancer->deleteRule($rule);

OR

$res = $load_balancer->deleteRule($rule, '<LOAD-BALANCER-ID>');
```




# <a name="public-ips"></a>Public IPs


Get started by instantiating a `PublicIP` object:

```
$client = new OneAndOne('<API-TOKEN>');

$public_ip = $client->publicIp();
```

**List all public IPs on your account:**

```
$res = $public_ip->all();
```


**Returns a public IP's current specs:**

```
$res = $public_ip->get();

OR

$res = $public_ip->get('<IP-ID>');
```


**Create a public IP:**

*Note:* `reverse_dns` is an optional parameter

```
$reverse_dns = 'example.com';

$res = $public_ip->create($reverse_dns);
```


**Modify a public IP:**

*Note:* If you call this method without a `reverse_dns` argument, it will remove the previous `reverse_dns` value

```
$reverse_dns = 'newexample.com';


$res = $public_ip->modify($reverse_dns);

OR

$res = $public_ip->modify($reverse_dns, '<IP-ID>');
```


**Delete a public IP:**

```
$res = $public_ip->delete();

OR

$res = $public_ip->delete('<IP-ID>');
```




# <a name="private-networks"></a>Private Networks


Get started by instantiating a `PrivateNetwork` object:

```
$client = new OneAndOne('<API-TOKEN>');

$private_network = $client->privateNetwork();
```

**List all private networks:**

```
$res = $private_network->all();
```


**Returns a private network's current specs:**

```
$res = $private_network->get();

OR

$res = $private_network->get('<PRIVATE-NETWORK-ID>');
```


**List a private network's servers:**

```
$res = $private_network->servers();

OR

$res = $private_network->servers('<PRIVATE-NETWORK-ID>');
```


**Returns information about a private network's server:**

```
$server_id = '<SERVER-ID>';


$res = $private_network->server($server_id);

OR

$res = $private_network->server($server_id, '<PRIVATE-NETWORK-ID>');
```


**Create a private network:**

*Note:* `name` is the only required parameter
```
$args = [
    'name' => 'Example PN',
    'network_address' => '192.168.1.0',
    'subnet_mask' => '255.255.255.0'
];

$res = $private_network->create($args);
```


**Add servers to a private network:**

*Note:* Servers cannot be added or removed from a private network if they currently have a snapshot.
```
$servers = ['<SERVER-ID>'];


$res = $private_network->addServers($servers);

OR

$res = $private_network->addServers($servers, '<PRIVATE-NETWORK-ID>');
```


**Modify a private network:**

```
$args = [
    'name' => 'New Name PN'
];


$res = $private_network->modify($args);

OR

$res = $private_network->modify($args, '<PRIVATE-NETWORK-ID>');
```


**Delete a private network:**

```
$res = $private_network->delete();

OR

$res = $private_network->delete('<PRIVATE-NETWORK-ID>');
```


**Remove a server from a private network:**

*Note:* Servers cannot be attached or removed from a private network if they currently have a snapshot.

*Note:* Servers cannot be removed from a private network when they are 'online'.

```
$server_id = '<SERVER-ID>';


$res = $private_network->removeServer($server_id);

OR

$res = $private_network->removeServer($server_id, '<PRIVATE-NETWORK-ID>');
```




# <a name="monitoring-center"></a>Monitoring Center


Get started by instantiating a `MonitoringCenter` object:

```
$client = new OneAndOne('<API-TOKEN>');

$monitoring_center = $client->monitoringCenter();
```

**List all usages and alerts of monitoring servers:**

```
$res = $monitoring_center->all();
```


**Retrieve the usages and alerts for a monitoring server:**

*Note:* `period` can be set to `'LAST_HOUR'`, `'LAST_24H'`, `'LAST_7D'`, `'LAST_30D'`, `'LAST_365D'`, or `'CUSTOM'`

*Note:* If `period` is set to `'CUSTOM'`, the `start_date` and `end_date` parameters are required.  They should be
set using the following date/time format: `2015-19-05T00:05:00Z`

```
$params = [
    'period' => 'LAST_24H'
];

$res = $monitoring_center->get('<SERVER-ID>', $params);
```




# <a name="monitoring-policies"></a>Monitoring Policies


Get started by instantiating a `MonitoringPolicy` object:

```
$client = new OneAndOne('<API-TOKEN>');

$monitoring_policy = $client->monitoringPolicy();
```

**List all monitoring policies:**

```
$res = $monitoring_policy->all();
```


**Returns a monitoring policy's current specs:**

```
$res = $monitoring_policy->get();

OR

$res = $monitoring_policy->get('<MONITORING-POLICY-ID>');
```


**List a monitoring policy's ports:**

```
$res = $monitoring_policy->ports();

OR

$res = $monitoring_policy->ports('<MONITORING-POLICY-ID>');
```


**Returns information about a monitoring policy's port:**

```
$port_id = '<PORT-ID>';


$res = $monitoring_policy->port($port_id);

OR

$res = $monitoring_policy->port($port_id, '<MONITORING-POLICY-ID>');
```


**List a monitoring policy's processes:**

```
$res = $monitoring_policy->processes();

OR

$res = $monitoring_policy->processes('<MONITORING-POLICY-ID>');
```


**Returns information about a monitoring policy's process:**

```
$process_id = '<PROCESS-ID>';


$res = $monitoring_policy->process($process_id);

OR

$res = $monitoring_policy->process($process_id, '<MONITORING-POLICY-ID>');
```


**List a monitoring policy's servers:**

```
$res = $monitoring_policy->servers();

OR

$res = $monitoring_policy->servers('<MONITORING-POLICY-ID>');
```


**Returns information about a monitoring policy's server:**

```
$server_id = '<SERVER-ID>';


$res = $monitoring_policy->server($server_id);

OR

$res = $monitoring_policy->server($server_id, '<MONITORING-POLICY-ID>');
```


**Create a monitoring policy:**

*Note:* `thresholds` must receive an object with the exact keys/values shown below.  Only the `value` and `alert` keys may be changed

*Note:* `ports` must receive an array with at least one object

*Note:* `processes` must receive an array with at least one object
```
// Set threshold values
$thresholds = [
    'cpu' => [
        'warning' => [
            'value' => 90,
            'alert' => False
        ],
        'critical' => [
            'value' => 95,
            'alert' => True
        ]
    ],
    'ram' => [
        'warning' => [
            'value' => 90,
            'alert' => False
        ],
        'critical' => [
            'value' => 95,
            'alert' => True
        ]
    ],
    'disk' => [
        'warning' => [
            'value' => 80,
            'alert' => False
        ],
        'critical' => [
            'value' => 90,
            'alert' => True
        ]
    ],
    'transfer' => [
        'warning' => [
            'value' => 1000,
            'alert' => False
        ],
        'critical' => [
            'value' => 2000,
            'alert' => True
        ]
    ],
    'internal_ping' => [
        'warning' => [
            'value' => 50,
            'alert' => False
        ],
        'critical' => [
            'value' => 100,
            'alert' => True
        ]
    ]
];

// Set processes
$process1 = [
    'process' => 'test',
    'alert_if' => 'NOT_RUNNING',
    'email_notification' => True
];

$processes = [$process1];

// Set ports
$port1 = [
    'protocol' => 'TCP',
    'port' => 22,
    'alert_if' => 'NOT_RESPONDING',
    'email_notification' => True
];

$ports = [$port1];

// Set Monitoring Policy Specs
$args = [
    'name' => 'Example MP',
    'email' => 'test@example.com',
    'agent' => True,
    'thresholds' => $thresholds,
    'ports' => $ports,
    'processes' => $processes
];

$res = $monitoring_policy->create($args);
```


**Add ports to a monitoring policy:**

```
$port2 = [
    'protocol' => 'TCP',
    'port' => 90,
    'alert_if' => 'RESPONDING',
    'email_notification' => False
];

$ports = [$port2];


$res = $monitoring_policy->addPorts($ports);

OR

$res = $monitoring_policy->addPorts($ports, '<MONITORING-POLICY-ID>');
```


**Add processes to a monitoring policy:**

```
$process2 = [
    'process' => 'logger',
    'alert_if' => 'NOT_RUNNING',
    'email_notification' => True
];

$processes = [$process2];


$res = $monitoring_policy->addProcesses($processes);

OR

$res = $monitoring_policy->addProcesses($processes, '<MONITORING-POLICY-ID>');
```


**Add servers to a monitoring policy:**

```
$server1 = '<SERVER-ID>';

$servers = [$server1];


$res = $monitoring_policy->addServers($servers);

OR

$res = $monitoring_policy->addServers($servers, '<MONITORING-POLICY-ID>');
```

**Modify a monitoring policy:**

*Note:* `thresholds` is not a required parameter, but it must receive a "thresholds object" exactly like the one in the `monitoring_policy->create()` method above, if you do choose to update.
```
$new_thresholds = [
    'cpu' => [
        'warning' => [
            'value' => 80,
            'alert' => False
        ],
        'critical' => [
            'value' => 95,
            'alert' => True
        ]
    ],
    'ram' => [
        'warning' => [
            'value' => 80,
            'alert' => False
        ],
        'critical' => [
            'value' => 95,
            'alert' => True
        ]
    ],
    'disk' => [
        'warning' => [
            'value' => 80,
            'alert' => False
        ],
        'critical' => [
            'value' => 90,
            'alert' => True
        ]
    ],
    'transfer' => [
        'warning' => [
            'value' => 1000,
            'alert' => False
        ],
        'critical' => [
            'value' => 2000,
            'alert' => True
        ]
    ],
    'internal_ping' => [
        'warning' => [
            'value' => 50,
            'alert' => False
        ],
        'critical' => [
            'value' => 100,
            'alert' => True
        ]
    ]
];

$args = [
    'name' => 'New Name',
    'email' => 'changed@example.com',
    'thresholds' => $new_thresholds
];


$res = $monitoring_policy->modify($args);

OR

$res = $monitoring_policy->modify($args, '<MONITORING-POLICY-ID>');
```


**Modify a monitoring policy's port:**

*Note:* Only `alert_if` and `email_notification` can be updated.  `protocol` and `port` are immutable.  You will still need to send in the entire "port object", as you would when creating a monitoring policy, or adding new ports to an existing monitoring policy
```
$port = [
    'port_id' => '<PORT-ID>',
    'protocol' => 'TCP',
    'port' => 90,
    'alert_if' => 'NOT_RESPONDING',
    'email_notification' => True
];


$res = $monitoring_policy->modifyPort($port);

OR

$res = $monitoring_policy->modifyPort($port, '<MONITORING-POLICY-ID>');
```


**Modify a monitoring policy's process:**

*Note:* Only `alert_if` and `email_notification` can be updated.  `process` is immutable.  You will still need to send in the entire "process object", as you would when creating a monitoring policy or adding new processes to an existing monitoring policy
```
$process = [
    'process_id' => '<PROCESS-ID>',
    'process' => 'test',
    'alert_if' => 'RUNNING',
    'email_notification' => False
];


$res = $monitoring_policy->modifyProcess($process);

OR

$res = $monitoring_policy->modifyProcess($process, '<MONITORING-POLICY-ID>');
```


**Delete a monitoring policy:**

```
$res = $monitoring_policy->delete();

OR

$res = $monitoring_policy->delete('<MONITORING-POLICY-ID>');
```


**Delete a monitoring policy's port:**

```
$port_id = '<PORT-ID>';


$res = $monitoring_policy->deletePort($port_id);

OR

$res = $monitoring_policy->deletePort($port_id, '<MONITORING-POLICY-ID>');
```


**Delete a monitoring policy's process:**

```
$process_id = '<PROCESS-ID>';


$res = $monitoring_policy->deleteProcess($process_id);

OR

$res = $monitoring_policy->deleteProcess($process_id, '<MONITORING-POLICY-ID>');
```


**Remove a monitoring policy's server:**

```
$server_id = '<SERVER-ID>';


$res = $monitoring_policy->removeServer($server_id);

OR

$res = $monitoring_policy->removeServer($server_id, '<MONITORING-POLICY-ID>');
```



# <a name="logs"></a>Logs


Get started by instantiating a `Log` object:

```
$client = new OneAndOne('<API-TOKEN>');

$log = $client->log();
```

**List all logs by time period:**

*Note:* `period` can be set to `'LAST_HOUR'`, `'LAST_24H'`, `'LAST_7D'`, `'LAST_30D'`, `'LAST_365D'`, or `'CUSTOM'`

*Note:* If `period` is set to `'CUSTOM'`, the `start_date` and `end_date` parameters are required.  They should be
set using the following date/time format: `2015-19-05T00:05:00Z`

```
$params = [
    'period' => 'LAST_24H'
];

$res = $log->all($params);
```


**Returns information about a log:**

```
$res = $log->get('<LOG-ID>');
```



# <a name="users"></a>Users


Get started by instantiating a `User` object:

```
$client = new OneAndOne('<API-TOKEN>');

$user = $client->user();
```

**List all users on your account:**

```
$res = $user->all();
```


**Return a user's current specs:**

```
$res = $user->get();

OR

$res = $user->get('<USER-ID>');
```


**Return a user's API access credentials:**

```
$res = $user->api();

OR

$res = $user->api('<USER-ID>');
```


**Return a user's API key:**

```
$res = $user->apiKey();

OR

$res = $user->apiKey('<USER-ID>');
```


**List the IP's from which a user can access the API:**

```
$res = $user->ips();

OR

$res = $user->ips('<USER-ID>');
```


**Create a user:**

```
$args = [
    'name' => 'phpTest',
    'password' => 'testpassword'
];

$res = $user->create($args);
```


**Add IP's from which a user can access the API:**

*Note:* `ips` must receive an array with at least one IP string
```
$ip1 = '1.2.3.4';

$ips = [$ip1];


$res = $user->addIps($ips);

OR

$res = $user->addIps($ips, '<USER-ID>');
```


**Modify a user:**

*Note:* `state` can be set to `ACTIVE` or `DISABLE`

```
$args = [
    'name' => 'newName',
    'description' => 'Example Desc'
];


$res = $user->modify($args);

OR

$res = $user->modify($args, '<USER-ID>');

```


**Enable or disable a user's API access:**

```
$active = True;


$res = $user->enableApi($active);

OR

$res = $user->enableApi($active, '<USER-ID>');
```


**Change a user's API key:**

```
$res = $user->changeKey();

OR

$res = $user->changeKey('<USER-ID>');
```


**Delete a user:**

```
$res = $user->delete();

OR

$res = $user->delete('<USER-ID>');
```


**Remove API access for an IP:**

```
$ip = '1.2.3.4';


$res = $user->removeIp($ip);

OR

$res = $user->removeIp($ip, '<USER-ID>');
```



# <a name="usages"></a>Usages


Get started by instantiating a `Usage` object:

```
$client = new OneAndOne('<API-TOKEN>');

$usage = $client->usage();
```

**List all usages by time period:**

*Note:* `period` can be set to `'LAST_HOUR'`, `'LAST_24H'`, `'LAST_7D'`, `'LAST_30D'`, `'LAST_365D'`, or `'CUSTOM'`

*Note:* If `period` is set to `'CUSTOM'`, the `start_date` and `end_date` parameters are required.  They should be
set using the following date/time format: `2015-19-05T00:05:00Z`

```
$params = [
    'period' => 'LAST_24H'
];

$res = $usage->all($params);
```



# <a name="server-appliances"></a>Server Appliances


Get started by instantiating a `ServerAppliance` object:

```
$client = new OneAndOne('<API-TOKEN>');

$server_appliance = $client->serverAppliance();
```

**List all appliances:**

```
$res = $server_appliance->all();
```


**Returns information about an appliance:**

```
$res = $server_appliance->get('<APPLIANCE-ID>');
```



# <a name="dvds"></a>DVD's


Get started by instantiating a `Dvd` object:

```
$client = new OneAndOne('<API-TOKEN>');

$dvd = $client->dvd();
```

**List all DVD's on your account:**

```
$res = $dvd->all();
```


**Returns information about a DVD:**

```
$res = $dvd->get('<DVD-ID>');
```



# <a name="datacenters"></a>Data Centers


Get started by instantiating a `Datacenter` object:

```
$client = new OneAndOne('<API-TOKEN>');

$datacenter = $client->datacenter();
```

**List all available data centers:**

```
$res = $datacenter->all();
```


**Returns information about a data center:**

```
$res = $datacenter->get('<DATACENTER-ID>');
```



# <a name="pricing"></a>Pricing


Get started by instantiating a `Pricing` object:

```
$client = new OneAndOne('<API-TOKEN>');

$pricing = $client->pricing();
```

**List pricing for all available resources in Cloud Panel:**

```
$res = $pricing->all();
```



# <a name="ping"></a>Ping


Get started by instantiating a `Ping` object:

```
$client = new OneAndOne('<API-TOKEN>');

$ping = $client->ping();
```

**Returns `"PONG"` if the API is running:**

```
$res = $ping->get();
```



# <a name="ping-auth"></a>Ping Auth


Get started by instantiating a `PingAuth` object:

```
$client = new OneAndOne('<API-TOKEN>');

$ping_auth = $client->pingAuth();
```

**Returns `"PONG"` if the API is running and your token is valid:**

```
$res = $ping_auth->get()
```



# <a name="vpn"></a>VPN's

Get started by instantiating a `Vpn` object:

```
$client = new OneAndOne('<API-TOKEN>');

$vpn = $client->vpn();
```



**List all VPN's:**

```
$res = $vpn->all();
```


**Retrieve a single VPN:**

```
$res = $vpn->get();

OR

$res = $vpn->get('<VPN-ID>');
```


**Create a VPN:**

```
$args = [
    'name' => 'Example VPN'
];

$res = $vpn->create($args);
```


**Modify a VPN:**

```
$args = [
    'name' => 'New Name'
];

$res = $vpn->modify($args);

OR

$res = $vpn->modify($args, '<VPN-ID>');
```


**Delete a VPN:**

```
$res = $vpn->delete();

OR

$res = $vpn->delete('<VPN-ID>');
```


**Download a VPN's config file:**

```
$res = $vpn->downloadConfig();

OR

$res = $vpn->downloadConfig('<VPN-ID>');
```



# <a name="roles"></a>Roles

Get started by instantiating an `Role` object:

```
$client = new OneAndOne('<API-TOKEN>');

$role = $client->role();
```



**List all available roles on your account:**

```
$res = $role->all();
```


**Retrieve a single role:**

```
$res = $role->get();

OR

$res = $role->get('<ROLE-ID>');
```


**Create a role:**

```
$name = 'Example Role';

$res = $role->create($name);
```


**Modify a role:**

```
$args = [
    'name' => 'New Name',
    'state' => 'ACTIVE'
];

$res = $role->modify($args);

OR

$res = $role->modify($args, '<ROLE-ID>');
```


**Delete a role:**

```
$res = $role->delete();

OR

$res = $role->delete('<ROLE-ID>');
```



**List a role's permissions:**

```
$res = $role->permissions();

OR

$res = $role->permissions('<ROLE-ID>');
```



**Modify a role's permissions:**

```
$server_perms = [
  'show' => True,
  'create' => True,
  'delete' => False
];

$args = [
    'servers' => $server_perms
];

$res = $role->modifyPermissions($args);

OR

$res = $role->modifyPermissions($args, '<ROLE-ID>');
```



**List the users assigned to a role:**

```
$res = $role->users();

OR

$res = $role->users('<ROLE-ID>');
```



**Assign new users to a role:**

```
$users = ['<USER1-ID>', '<USER2-ID>']

$res = $role->addUsers($users);

OR

$res = $role->addUsers($users, '<ROLE-ID>');
```



**Returns information about a user assigned to a role:**

```
$res = $role->user('<USER-ID>');

OR

$res = $role->user('<USER-ID>', '<ROLE-ID>');
```



**Unassign a user from a role:**

```
$res = $role->removeUser('<USER-ID>');

OR

$res = $role->removeUser('<USER-ID>', '<ROLE-ID>');
```



**Clone a role:**

```
$name = 'Role Clone'

$res = $role->clone($name);

OR

$res = $role->clone($name, '<ROLE-ID>');
```




# <a name="block-storages"></a>Block Storages

Get started by instantiating a `BlockStorage` object:

```
$client = new OneAndOne('<API-TOKEN>');

$block_storage = $client->blockStorage();
```

**List all block storages:**

```
$res = $block_storage->all();
```


**Returns information about a block storage:**

```
$res = $block_storage->get();

OR

$res = $block_storage->get('<BLOCK-STORAGE-ID>');
```


**Create a block storage:**

*Note:* `size` must be a multiple of `10`

```
$args = [
    'name' => 'Test Block Storage',
    'description' => 'Test Desc',
    'size' => 40,
    'datacenter_id' => '<DATACENTER-ID>'
];

$res = $block_storage->create($args);
```


**Attach block storage to a server:**

```
$res = $block_storage->attachBlockStorage('<SERVER-ID>');

OR

$res = $block_storage->attachBlockStorage('<SERVER-ID>', '<BLOCK-STORAGE-ID>');
```


**Modify a block storage:**

```
$args = [
    'name' => 'New Name',
    'description' => 'New Desc',
];

$res = $block_storage->modify($args);

OR

$res = $block_storage->modify($args, '<BLOCK-STORAGE-ID>');
```


**Delete a block storage:**

```
$res = $block_storage->delete();

OR

$res = $block_storage->delete('<BLOCK-STORAGE-ID>');
```


**Detach storage from a server:**

```
$res = $block_storage->detachBlockStorage();

OR

$res = $block_storage->detachBlockStorage('<BLOCK-STORAGE-ID>');
```