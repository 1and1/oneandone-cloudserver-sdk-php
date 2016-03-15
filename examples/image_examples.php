<?php

use OneAndOne;

$client = new OneAndOne('<API-TOKEN>');




# List all images on your account
$image = $client->image();

$res = $image->list();
echo json_encode($res, JSON_PRETTY_PRINT);



# Create a new image
$image = $client->image();

$specs = [
    'server_id' => '<SERVER-ID>',
    'name' => 'Example Image',
    'description' => 'Example Desc',
    'frequency' => 'ONCE',
    'num_images' => 1
];

$res = $image->create($specs);
echo json_encode($res, JSON_PRETTY_PRINT);



# Retrieve the current specs for an image
$image = $client->image();

$res = $image->get('<IMAGE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Modify an image
$image = $client->image();

$specs = [
    'name' => 'New Name'
];

$res = $image->modify($specs, '<IMAGE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Delete the new image
$image = $client->image();

$res = $image->delete('<IMAGE-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);
