<?php

namespace src\oneandone;

use Requests;

class FirewallPolicy {

    protected $api_token;
    protected $header;
    public $id;
    public $specs;
    const BASE_ENDPOINT = '/firewall_policies';

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
            'rules' => null
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

        // Store firewall ID and response body for later use
        $this->specs = $json;
        $this->id = $json['id'];

        return $json;

    }

    public function get($firewall_id = null) {

        // Build URI
        if($firewall_id) {
            $uri = $firewall_id;
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

    public function modify($args, $firewall_id = null) {

        // Build URI
        if($firewall_id) {
            $uri = $firewall_id;
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

    public function delete($firewall_id = null) {

        // Build URI
        if($firewall_id) {
            $uri = $firewall_id;
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

    public function ips($firewall_id = null) {

        // Build URI
        if($firewall_id) {
            $uri = $firewall_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/server_ips";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function ip($ip_id, $firewall_id = null) {

        // Build URI
        if($firewall_id) {
            $uri = $firewall_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/server_ips/$ip_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function removeIp($ip_id, $firewall_id = null) {

        // Build URI
        if($firewall_id) {
            $uri = $firewall_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/server_ips/$ip_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::delete($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function addIps($ips, $firewall_id = null) {

        // Build URI
        if($firewall_id) {
            $uri = $firewall_id;
        }else{
            $uri = $this->id;
        }

        // Build POST body
        $body = [
            'server_ips' => $ips
        ];

        // Encode the POST body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/server_ips";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::post($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function rules($firewall_id = null) {

        // Build URI
        if($firewall_id) {
            $uri = $firewall_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/rules";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function rule($rule_id, $firewall_id = null) {

        // Build URI
        if($firewall_id) {
            $uri = $firewall_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/rules/$rule_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function deleteRule($rule_id, $firewall_id = null) {

        // Build URI
        if($firewall_id) {
            $uri = $firewall_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/rules/$rule_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::delete($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function addRules($rules, $firewall_id = null) {

        // Build URI
        if($firewall_id) {
            $uri = $firewall_id;
        }else{
            $uri = $this->id;
        }

        // Build POST body
        $body = [
            'rules' => $rules
        ];

        // Encode the POST body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/rules";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::post($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function waitFor($timeout = 25, $interval = 5) {

        // Set counter for timeout
        $counter = 0;

        // Check initial status and save server state
        $initial_response = $this->get();
        $firewall_state = $initial_response['state'];

        // Keep polling the server's state until good
        while(!in_array($firewall_state, GOOD_STATES)) {

            // Wait 60 seconds before polling again
            sleep($interval);

            // Check server state again
            $current_response = $this->get();
            $firewall_state = $current_response['state'];

            // Iterate counter and check for timeout
            $counter++;
            if($counter == $timeout) {
                echo "The operation timed out after $timeout minutes.\n";
                break;
            }

        }

        return "duration => $counter";

    }

}