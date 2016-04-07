<?php

namespace src\oneandone;

use Requests;

class Server {

    protected $api_token;
    protected $header;
    public $id;
    public $specs;
    const BASE_ENDPOINT = '/servers';

    // Constructor
    public function __construct($token, $header) {

        $this->api_token = $token;
        $this->header = $header;

    }

    // Server methods
    public function all($params = []) {

        // Build query parameter object
        $params += [
            'page' => null,
            'per_page' => null,
            'sort' => null,
            'q' => null,
            'fields' => null
        ];

        // Build URL
        $url = Utilities::buildURL(self::BASE_ENDPOINT, null, $params);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function create($args) {

        // Build POST body
        $args += [
            'name' => null,
            'description' => null,
            'hardware' => [
                'fixed_instance_size_id' => null,
                'vcore' => null,
                'cores_per_processor' => null,
                'ram' => null,
                'hdds' => null
            ],
            'appliance_id' => null,
            'password' => null,
            'power_on' => null,
            'firewall_policy_id' => null,
            'ip_id' => null,
            'load_balancer_id' => null,
            'monitoring_policy_id' => null
        ];

        // Clean out null values from POST body
        $body = Utilities::cleanArray($args);

        // Encode the POST body
        $data = json_encode($body);

        // Build URL
        $url = Utilities::buildURL(self::BASE_ENDPOINT);

        // Perform Request
        $response = Requests::post($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response
        $json = json_decode($response->body, true);

        // Store image ID and response body for later use
        $this->specs = $json;
        $this->id = $json['id'];

        return $json;

    }

    public function get($server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function modify($args, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $args += [
            'name' => null,
            'description' => null
        ];

        // Clean out null values from PUT body
        $body = Utilities::cleanArray($args);

        // Encode the PUT body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::put($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function delete($keep_ips = False, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build query parameter object
        $params = [
            'keep_ips' => $keep_ips
        ];

        // Build URL
        $extension = "/$uri";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension, $params);

        // Perform Request
        $response = Requests::delete($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function listFixed() {

        // Build URL
        $extension = '/fixed_instance_sizes';
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function getFixed($fixed_instance_id) {

        // Build URI
        $uri = $fixed_instance_id;

        // Build URL
        $extension = "/fixed_instance_sizes/$uri";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function hardware($server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/hardware";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function modifyHardware($args, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $args += [
            'fixed_instance_size_id' => null,
            'vcore' => null,
            'cores_per_processor' => null,
            'ram' => null
        ];

        // Clean out null values from PUT body
        $body = Utilities::cleanArray($args);

        // Encode the PUT body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/hardware";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::put($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function hdds($server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/hardware/hdds";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function addHdds($hdds, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build POST body
        $body = [
            'hdds' => $hdds
        ];

        // Encode the POST body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/hardware/hdds";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::post($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }
    
    public function hdd($hdd_id, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/hardware/hdds/$hdd_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function modifyHdd($args, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $body = [
            'size' => $args['size']
        ];

        // Encode the PUT body
        $data = json_encode($body);

        // Build URL
        $hdd_id = $args['hdd_id'];
        $extension = "/$uri/hardware/hdds/$hdd_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::put($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function deleteHdd($hdd_id, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/hardware/hdds/$hdd_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::delete($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function image($server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/image";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function installImage($args, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $args += [
            'id' => null,
            'password' => null,
            'firewall_policy' => [
                'id' => null
            ]
        ];

        // Clean out null values from PUT body
        $body = Utilities::cleanArray($args);

        // Encode the PUT body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/image";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::put($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function ips($server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/ips";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function addIp($type = 'IPV4', $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build POST body
        $body = [
            'type' => $type
        ];

        // Encode the POST body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/ips";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::post($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function ip($ip_id = null, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/ips/$ip_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function releaseIp($args, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build argument object
        $args += [
            'ip_id' => null,
            'keep_ip' => False
        ];

        // Build URL
        $params = [
            'keep_ip' => $args['keep_ip']
        ];
        $ip_id = $args['ip_id'];
        $extension = "/$uri/ips/$ip_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension, $params);

        // Perform Request
        $response = Requests::delete($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function firewall($ip_id = null, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/ips/$ip_id/firewall_policy";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function removeFirewall($ip_id = null, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/ips/$ip_id/firewall_policy";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::delete($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function addFirewall($args, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $body = [
            'id' => $args['firewall_id']
        ];

        // Encode the PUT body
        $data = json_encode($body);

        // Build URL
        $ip_id = $args['ip_id'];
        $extension = "/$uri/ips/$ip_id/firewall_policy";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::put($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function loadBalancers($ip_id = null, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/ips/$ip_id/load_balancers";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function removeLoadBalancer($args, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $ip_id = $args['ip_id'];
        $load_balancer_id = $args['load_balancer_id'];
        $extension = "/$uri/ips/$ip_id/load_balancers/$load_balancer_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::delete($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function addLoadBalancer($args, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build POST body
        $body = [
            'load_balancer_id' => $args['load_balancer_id']
        ];

        // Encode the POST body
        $data = json_encode($body);

        // Build URL
        $ip_id = $args['ip_id'];
        $extension = "/$uri/ips/$ip_id/load_balancers";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::post($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function status($server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/status";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function changeStatus($args, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $args += [
            'action' => null,
            'method' => null
        ];

        // Encode the PUT body
        $data = json_encode($args);

        // Build URL
        $extension = "/$uri/status/action";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::put($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function dvd($server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/dvd";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function ejectDvd($server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/dvd";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::delete($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function loadDvd($dvd_id, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $body = [
            'id' => $dvd_id
        ];

        // Encode the PUT body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/dvd";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::put($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function privateNetworks($server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/private_networks";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function privateNetwork($private_network_id, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/private_networks/$private_network_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function removePrivateNetwork($private_network_id, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/private_networks/$private_network_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::delete($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function addPrivateNetwork($private_network_id, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build POST body
        $body = [
            'id' => $private_network_id
        ];

        // Encode the POST body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/private_networks";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::post($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function createSnapshot($server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build POST body
        $body = '';
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/snapshots";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::post($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function snapshot($server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/snapshots";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function restoreSnapshot($snapshot_id, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $body = '';
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/snapshots/$snapshot_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::put($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function deleteSnapshot($snapshot_id, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/snapshots/$snapshot_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::delete($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function cloneServer($name, $server_id = null) {

        // Build URI
        if($server_id) {
            $uri = $server_id;
        }else{
            $uri = $this->id;
        }

        // Build POST body
        $body = [
            'name' => $name
        ];

        // Encode the POST body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/clone";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::post($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function waitFor($timeout = 25) {

        // Set counter for timeout
        $counter = 0;

        // Check initial status and save server state
        $initial_response = $this->get();
        $server_state = $initial_response['status']['state'];

        // Keep polling the server's state until good
        while(!in_array($server_state, GOOD_STATES)) {

            // Wait 60 seconds before polling again
            sleep(60);

            // Check server state again
            $current_response = $this->get();
            $server_state = $current_response['status']['state'];

            // Inform user when state is good
            if(in_array($server_state, GOOD_STATES)) {

                echo "\nSuccess!\n";
                echo "Server state: $server_state \n";

            }

            // Iterate counter and check for timeout
            $counter++;
            if($counter == $timeout) {
                echo "The operation timed out after $timeout minutes.\n";
                break;
            }

        }

    }

}