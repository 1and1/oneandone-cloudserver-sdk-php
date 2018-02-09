# 1&amp;1 PHP SDK

The 1&amp;1 PHP SDK is a library used for interacting with the 1&amp;1 platform over the REST API.

This guide will show you how to programmatically use the 1&amp;1 library to perform common management tasks also available through the 1&amp;1 Control Panel. For more information on the 1&amp;1 PHP SDK see the [1&1 Community Portal](https://www.1and1.com/cloud-community/).

## Table of Contents

- [Overview](#overview)
- [Getting Started](#getting-started)
  * [Installation](#installation)
  * [Authentication](#authentication)
- [Operations](#operations)
  - [Using the Module](#using-the-module)
  - [Creating a Server](#creating-a-server)
  - [Creating a Server with SSH Key Access](#creating-a-server-with-ssh-key-access)
  - [Creating a Firewall Policy](#creating-a-firewall-policy)
  - [Creating a Load Balancer](#creating-a-load-balancer)
  - [Creating a Monitoring Policy](#creating-a-monitoring-policy)
  - [Creating a Block Storage](#creating-a-block-storage)
  - [Creating an SSH Key](#creating-an-ssh-key)
  - [Updating Server Cores, Memory, and Disk](#updating-server-cores-memory-and-disk)
  - [Listing Servers, Images, Shared Storages, and More](#listing-servers-images-shared-storages-and-more )
- [Example App](#example-app)


## Overview

The PHP Client Library wraps the latest version of the 1&amp;1 REST API. All API operations are performed over SSL and authenticated using your 1&amp;1 API Token. The API can be accessed within an instance running in 1&amp;1 or directly over the Internet from any application that can send an HTTPS request and receive an HTTPS response.

For more information on the 1&1 Cloud Server SDK for PHP, visit the [Community Portal](https://www.1and1.com/cloud-community/).


## Getting Started

Before you begin you will need to have signed-up for a 1&amp;1 account. The credentials you setup during sign-up will be used to authenticate against the API.


### Installation

You can install the latest stable version using <a href='https://getcomposer.org/'>Composer</a>.  If you don't already have Composer installed, follow their installation instructions <a href='https://getcomposer.org/doc/00-intro.md'>here</a>.  Once you have Composer installed, add the snippet below to your `composer.json` file, and then run `composer install` (if you installed Composer globally), or `php composer.phar install` (if you installed locally) from your terminal.  This will create a `vendor` directory in your repo, and now allows you to use the 1and1 PHP SDK.

```json
{
    "require": {
        "1and1/1and1-sdk-php": ">=1.0.0"
    }
}
```

You will need to "autoload" the SDK by requiring Composer's autoload file at the top of your PHP script, like so:
```php
<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;
```

**Note:** An issue has been discoverd on Linux operating systems that prevents the SDK class from being autoloaded.  After completing all of the steps above, you will need to run `composer dumpautoload -o` (global install), or `php composer.phar dumpautoload -o` (local install) from inside the directory that you originally ran `composer install`.  Your file structure should look something like this:
```
/repo-root
  - composer.json
  - composer.lock
  - composer.phar (if you installed composer locally)
  - create_server.php
  - /vendor
```
After executing the `dumpautoload` command, you should then be able to run your `create_server.php` script.


### Authentication

Connecting to 1&amp;1 is handled by first setting up your authentication.  Start your application by initializing the module with your API token.

```php
<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

$client = new OneAndOne('<API-TOKEN>');
```
You can now use `$client` to perform all future operations, as seen in the examples below.


## Operations

### Using the Module

Official 1&amp;1 REST API Documentation: <a href='https://cloudpanel-api.1and1.com/documentation/1and1/v1/en/documentation.html' target='_blank'>https://cloudpanel-api.1and1.com/documentation/1and1/v1/en/documentation.html</a>

The following examples are meant to give you a general overview of some of the things you can do with the 1&amp;1 PHP SDK.  For a detailed list of all methods and functionality, please visit the <a href='docs/reference.md'>reference.md</a> file.




### Creating a Cloud Server

```php
<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

// Instantiate library with your API Token
$client = new OneAndOne('<API-TOKEN>');


// Instantiate Server Object
$server = $client->server();

// Create HDD's
$hdd1 = [
    'size' => 120,
    'is_main' => True
];

$hdds = [$hdd1];

// Create Server
$my_server = [
    'name' => 'Example Server',
    'description' => 'Example Desc',
    'server_type' => 'cloud',
    'hardware' => [
        'vcore' => 1,
        'cores_per_processor' => 1,
        'ram' => 1,
        'hdds' => $hdds
    ],
    'appliance_id' => '<IMAGE-ID>'
];

// Perform Request
$res = $server->create($my_server);
echo json_encode($res, JSON_PRETTY_PRINT);
```

### Creating a Baremetal Server

```php
<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

// Instantiate library with your API Token
$client = new OneAndOne('<API-TOKEN>');


// Instantiate Server Object
$server = $client->server();

// Create HDD's
$hdd1 = [
    'size' => 120,
    'is_main' => True
];

$hdds = [$hdd1];

// Create Server
$my_server = [
    'name' => 'Example Server',
    'description' => 'Example Desc',
    'server_type' => 'baremetal',
    'hardware' => [
       'baremetal_model_id' =>'<BAREMETAL-MODEL-ID>'
    ],
    'appliance_id' => '<IMAGE-ID>'
];

// Perform Request
$res = $server->create($my_server);
echo json_encode($res, JSON_PRETTY_PRINT);
```


### Creating a Server with SSH Key Access

```php
<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

// Instantiate library with your API Token
$client = new OneAndOne('<API-TOKEN>');


// Instantiate Server Object
$server = $client->server();

// Create HDD's
$hdd1 = [
    'size' => 120,
    'is_main' => True
];

$hdds = [$hdd1];

// Assign your public key to a variable
$pub_key = '<PUB-KEY>';

// Create Server
$my_server = [
    'name' => 'Example Server',
    'description' => 'Example Desc',
    'hardware' => [
        'vcore' => 1,
        'cores_per_processor' => 1,
        'ram' => 1,
        'hdds' => $hdds
    ],
    'appliance_id' => '<IMAGE-ID>',
    'rsa_key' => $pub_key
];

// Perform Request
$res = $server->create($my_server);
echo json_encode($res, JSON_PRETTY_PRINT);
```
**Note:** You may then SSH into your server by executing the following command in terminal 

`ssh –i <path_to_private_key_file> root@SERVER_IP`


### Creating a Firewall Policy

```php
<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

// Instantiate library with your API Token
$client = new OneAndOne('<API-TOKEN>');


// Instantiate Firewall Object
$firewall_policy = $client->firewallPolicy();

// Create Rules
$rule1 = [
    'protocol' => 'TCP',
    'port_from' => 80,
    'port_to' => 80,
    'source' => '0.0.0.0'
];

$rules = [$rule1];

// Create Firewall
$args = [
    'name' => 'Example Firewall',
    'description' => 'Example Desc',
    'rules' => $rules
];

// Perform Request
$res = $firewall_policy->create($args);
echo json_encode($res, JSON_PRETTY_PRINT);
```


### Creating a Load Balancer

```php
<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

// Instantiate library with your API Token
$client = new OneAndOne('<API-TOKEN>');


// Instantiate Load Balancer Object
$load_balancer = $client->loadBalancer();

// Create Rules
$rule1 = [
    'protocol' => 'TCP',
    'port_balancer' => 80,
    'port_server' => 80,
    'source' => '0.0.0.0'
];

$rules = [$rule1];

// Create Load Balancer
$args = [
    'name' => 'Example LB',
    'health_check_test' => 'TCP',
    'health_check_interval' => 40,
    'persistence' => True,
    'persistence_time' => 1200,
    'method' => 'ROUND_ROBIN',
    'rules' => $rules
];

// Perform Request
$res = $load_balancer->create($args);
echo json_encode($res, JSON_PRETTY_PRINT);
```


### Creating a Monitoring Policy

```php
<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

// Instantiate library with your API Token
$client = new OneAndOne('<API-TOKEN>');


// Instantiate Monitoring Policy Object
$monitoring_policy = $client->monitoringPolicy();

// Create Threshold Values
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

// Create Processes
$process1 = [
    'process' => 'test',
    'alert_if' => 'NOT_RUNNING',
    'email_notification' => True
];

$processes = [$process1];

// Create Ports
$port1 = [
    'protocol' => 'TCP',
    'port' => 22,
    'alert_if' => 'NOT_RESPONDING',
    'email_notification' => True
];

$ports = [$port1];

// Create Monitoring Policy
$args = [
    'name' => 'Example MP',
    'email' => 'test@example.com',
    'agent' => True,
    'thresholds' => $thresholds,
    'ports' => $ports,
    'processes' => $processes
];

// Perform Request
$res = $monitoring_policy->create($args);
echo json_encode($res, JSON_PRETTY_PRINT);
```

Then, add a server or two:
```php
$server1 = '<SERVER-ID>';

$servers = [$server1];

$res = $monitoring_policy->addServers($servers);
echo json_encode($res, JSON_PRETTY_PRINT);
```


### Creating a Block Storage

```php
<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

// Instantiate library with your API Token
$client = new OneAndOne('<API-TOKEN>');


// Instantiate Block Storage Object
$block_storage = $client->blockStorage();

// Create Block Storage
$args = [
    'name' => 'My new block storage',
    'description' => 'My block storage description',
    'size' => 40,
    'server' => '<SERVER-ID>',
    'datacenter_id' => '<DATACENTER-ID>'
];

// Perform Request
$res = $block_storage->create($args);
echo json_encode($res, JSON_PRETTY_PRINT);
```


### Creating an SSH Key

```php
<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

// Instantiate library with your API Token
$client = new OneAndOne('<API-TOKEN>');


// Instantiate SshKey Object
$ssh_key = $client->sshKey();

// Create SSH Key
$args = [
    'name' => 'Test SSH Key',
    'description' => 'Test description',
    'public_key' => '<PUBLIC-KEY>'
];

// Perform Request
$res = $ssh_key->create($args);
echo json_encode($res, JSON_PRETTY_PRINT);
```


### Updating Server Cores, Memory, and Disk

1&amp;1 allows users to dynamically update cores, memory, and disk independently of each other. This removes the restriction of needing to upgrade to the next size up to receive an increase in memory. You can now simply increase the instances memory keeping your costs in-line with your resource needs.

The following code illustrates how you can update cores and memory:
```php
<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

// Instantiate library with your API Token
$client = new OneAndOne('<API-TOKEN>');


// Instantiate Server Object
$server = $client->server();

$specs = [
    'vcore' => 2,
    'ram' => 6
];

$res = $server->modifyHardware($specs, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);
```

This is how you would update a server disk's size:
```php
<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

// Instantiate library with your API Token
$client = new OneAndOne('<API-TOKEN>');


// Instantiate Server Object
$server = $client->server();

// Create HDD Resize
$resize = [
    'hdd_id' => '<HDD-ID>',
    'size' => 140
];

$res = $server->modifyHdd($resize, '<SERVER-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);
```


### Listing Servers, Images, Shared Storages, and More

Generating a list of resources is fairly straight forward.  Every class in the library comes equipped with an `all` method.  You may pass optional query parameters to help filter your results.  By default, these parameters are all set to `null`.

**Here are the parameters available to you:**

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-`page` (integer): Allows to the use of pagination. Indicate which page to start on.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-`per_page` (integer): Number of items per page.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-`sort` (string): `sort => 'name'` retrieves a list of elements sorted alphabetically. `sort => 'creation_date'` retrieves a list of elements sorted by their creation date in descending order.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-`q` (string): `q` is for query.  Use this parameter to return only the items that match your search query.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-`fields` (string): Returns only the parameters requested. (i.e. fields => 'id, name, description, hardware.ram')


**Here are a few examples of how you would list resources:**
```php
<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

// Instantiate library with your API Token
$client = new OneAndOne('<API-TOKEN>');


// List All Servers On Your Account
$server = $client->server();

$res = $server->all();
echo json_encode($res, JSON_PRETTY_PRINT);


// List All Servers Whose Name Contains "My"
$server = $client->server();

$params = [
    'q' => 'My'
];

$res = $server->all($params);
echo json_encode($res, JSON_PRETTY_PRINT);


# List all images on your account
$image = $client->image();

$res = $image->all();
echo json_encode($res, JSON_PRETTY_PRINT);


# List all block storages on your account
$block_storage = $client->blockStorage();

$res = $block_storage->all();
echo json_encode($res, JSON_PRETTY_PRINT);


# List all ssh keys on your account
$ssh_key = $client->sshKey();

$res = $ssh_key->all();
echo json_encode($res, JSON_PRETTY_PRINT);
```



## Example App

This simple app creates a load balancer, firewall policy, and server.  It then adds the load balancer and firewall policy to the server's initial IP address.  You can access a server's initial IP by using the `first_ip` attribute on the Server class object, as seen in the example below.

The source code for the Example App can be found <a href='examples/example_app.php'>here</a>.
```php
<?php

require(dirname(__DIR__).'/vendor/autoload.php');

use src\oneandone\OneAndOne;

// Instantiate library with your API Token
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
    'server_type' => 'cloud',
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



// Create Block Storage
$block_storage = $client->blockStorage();

$my_block_storage = [
    'name' => 'My new block storage',
    'description' => 'My block storage description',
    'size' => 40,
    'server' => $server->id,
    'datacenter_id' => $server->specs['datacenter_id']
];

echo "\nCreating block storage...\n";
$res = $block_storage->create($my_block_storage);
// Wait for Block Storage to be ready
echo $block_storage->waitFor();



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

echo "\nDeleting block storage...\n";
$block_storage->delete();
echo "Success!\n";

echo "\nDeleting server...\n";
$server->delete();
echo "Success!\n";

echo "\nDeleting load balancer...\n";
$load_balancer->delete();
echo "Success!\n";

echo "\nDeleting firewall policy...\n";
$firewall_policy->delete();
echo "Success!\n";
```
