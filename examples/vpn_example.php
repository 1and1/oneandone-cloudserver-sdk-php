<?php
/**
 * Created by PhpStorm.
 * vpn: Ali
 * Date: 11/16/2017
 * Time: 6:21 PM
 */
$token = getenv('ONEANDONE_TOKEN');
require('../vendor/autoload.php');

use src\oneandone\OneAndOne;

$client = new OneAndOne($token);
$vpn = $client->vpn();

# List all vpns on your account
$res = $vpn->all();
echo json_encode($res, JSON_PRETTY_PRINT);



# Create a new vpn
$args = [
    'name' => 'phpTest',
    'description' => 'phpTest'
];

$res = $vpn->create($args);
$vpn->waitFor();
echo json_encode($res, JSON_PRETTY_PRINT);



# Return a vpn's current specs
$vpn = $client->vpn();

$res = $vpn->get($res['id']);
echo json_encode($res, JSON_PRETTY_PRINT);

# download config file
$config = $vpn->downloadConfig($res['id'],"C:\\vpnconfig");
echo json_encode($res, JSON_PRETTY_PRINT);

# Modify a vpn account
$args = [
    'name' => 'newName',
    'description' => 'Example Desc'
];

$updated = $vpn->modify($args, $res['id']);
echo json_encode($res, JSON_PRETTY_PRINT);



# Delete a vpn
$res = $vpn->delete($res['id']);
echo json_encode($res, JSON_PRETTY_PRINT);