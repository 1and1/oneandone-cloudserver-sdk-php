<?php

require(__DIR__.'/vendor/autoload.php');

use src\oneandone\OneAndOne;

$client = new OneAndOne('<API-TOKEN>');

$block_storage = $client->blockStorage();



# Create a block storage
$args = [
    'name' => 'My new block storage',
    'description' => 'My block storage description',
    'size' => 40,
    'datacenter_id' => '<DATACENTER-ID>'
];

$res = $block_storage->create($args);
echo json_encode($res, JSON_PRETTY_PRINT);



# List all block storages on your account
$res = $block_storage->all();
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve a block storage's current specs
$res = $block_storage->get('<BLOCK-STORAGE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Modify a block storage
$args = [
    'name' => 'New Name',
    'description' => 'New Desc'
];

$res = $block_storage->modify($args, '<BLOCK-STORAGE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Attach block storage to a server
$res = $block_storage->attachBlockStorage('<SERVER-ID>', '<BLOCK-STORAGE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Detach block storage from a server
$res = $block_storage->detachBlockStorage('<BLOCK-STORAGE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Delete a block storage
$res = $block_storage->delete('<BLOCK-STORAGE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);