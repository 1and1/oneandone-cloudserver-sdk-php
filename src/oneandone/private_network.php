<?php

namespace src\oneandone;

use Requests;

class PrivateNetwork {

    protected $api_token;
    protected $header;
    public $id;
    public $specs;
    const BASE_ENDPOINT = '/private_networks';

    // Constructor
    public function __construct($token, $header) {

        $this->api_token = $token;
        $this->header = $header;

    }

    // Public IP methods
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
            'network_address' => null,
            'subnet_mask' => null
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

        // Store private network ID and response body for later use
        $this->specs = $json;
        $this->id = $json['id'];

        return $json;

    }

    public function get($private_network_id = null) {

        // Build URI
        if($private_network_id) {
            $uri = $private_network_id;
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

    public function modify($args, $private_network_id = null) {

        // Build URI
        if($private_network_id) {
            $uri = $private_network_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $args += [
            'name' => null,
            'description' => null,
            'network_address' => null,
            'subnet_mask' => null
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

        // Decode the response
        return json_decode($response->body, true);

    }

    public function delete($private_network_id = null) {

        // Build URI
        if($private_network_id) {
            $uri = $private_network_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::delete($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function servers($private_network_id = null) {

        // Build URI
        if($private_network_id) {
            $uri = $private_network_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/servers";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function server($server_id, $private_network_id = null) {

        // Build URI
        if($private_network_id) {
            $uri = $private_network_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/servers/$server_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function removeServer($server_id, $private_network_id = null) {

        // Build URI
        if($private_network_id) {
            $uri = $private_network_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/servers/$server_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::delete($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function addServers($servers, $private_network_id = null) {

        // Build URI
        if($private_network_id) {
            $uri = $private_network_id;
        }else{
            $uri = $this->id;
        }

        // Build POST body
        $body = [
            'servers' => $servers
        ];

        // Encode the POST body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/servers";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::post($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response
        return json_decode($response->body, true);

    }

    public function waitFor() {

        // Check initial status and save private network state
        $initial_response = $this->get();
        $private_network_state = $initial_response['state'];

        // Keep polling the private network's state until good
        while(!in_array($private_network_state, GOOD_STATES)) {

            // Wait 5 second before polling again
            sleep(5);

            // Check private network state again
            $current_response = $this->get();
            $private_network_state = $current_response['state'];

            // Inform user when state is good
            if(in_array($private_network_state, GOOD_STATES)) {

                echo "\nSuccess!\n";
                echo "Private Network state: $private_network_state \n";

            }

        }

    }


}