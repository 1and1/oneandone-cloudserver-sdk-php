<?php

use OneAndOne;

$client = new OneAndOne('<API-TOKEN>');




# List all shared storages on your account
$shared_storage = $client->sharedStorage();

$res = $shared_storage->all();
echo json_encode($res, JSON_PRETTY_PRINT);



# Create a shared storage
$shared_storage = $client->sharedStorage();

$args = [
    'name' => 'Test Storage',
    'description' => 'Test Desc',
    'size' => 200
];

$res = $shared_storage->create($args);
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve a shared storage's current specs
$shared_storage = $client->sharedStorage();

$res = $shared_storage->get('<SHARED-STORAGE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Modify a shared storage
$shared_storage = $client->sharedStorage();

$args = [
    'name' => 'New Name',
    'description' => 'New Desc'
];

$res = $shared_storage->modify($args, '<SHARED-STORAGE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Delete a shared storage
$shared_storage = $client->sharedStorage();

$res = $shared_storage->delete('<SHARED-STORAGE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# List a shared storage's servers
$shared_storage = $client->sharedStorage();

$res = $shared_storage->servers('<SHARED-STORAGE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve information about a shared storage's server
$shared_storage = $client->sharedStorage();

$server_id = '<SERVER-ID>'

$res = $shared_storage->server($server_id, '<SHARED-STORAGE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Remove a server from a shared storage
$shared_storage = $client->sharedStorage();

$server_id = '<SERVER-ID>'

$res = $shared_storage->removeServer($server_id, '<SHARED-STORAGE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Add servers to a shared storage
$shared_storage = $client->sharedStorage();

$server1 = [
    'id' => '<SERVER-ID>',
    'rights' => 'R'
];

$servers = [$server1];

$res = $shared_storage->addServers($servers, '<SHARED-STORAGE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve the credentials for accessing shared storages
$shared_storage = $client->sharedStorage();

$res = $shared_storage->access();
echo json_encode($res, JSON_PRETTY_PRINT);



# Change the password for accessing shared storages
$shared_storage = $client->sharedStorage();

$res = $shared_storage->changePassword('newpass1');
echo json_encode($res, JSON_PRETTY_PRINT);