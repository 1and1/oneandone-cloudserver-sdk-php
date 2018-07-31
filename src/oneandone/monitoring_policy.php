<?php

namespace src\oneandone;

use Requests;

class MonitoringPolicy {

    protected $api_token;
    protected $header;
    public $id;
    public $specs;
    const BASE_ENDPOINT = '/monitoring_policies';

    // Constructor
    public function __construct($token, $header) {

        $this->api_token = $token;
        $this->header = $header;

    }

    // Monitoring Policy methods
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
            'email' => null,
            'agent' => null,
            'thresholds' => null,
            'ports' => null,
            'processes' => null
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

        // Store MP ID and response body for later use
        $this->specs = $json;
        $this->id = $json['id'];

        return $json;

    }

    public function get($monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
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

    public function modify($args, $monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $args += [
            'name' => null,
            'description' => null,
            'email' => null,
            'thresholds' => null
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

    public function delete($monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
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

    public function ports($monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/ports";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function addPorts($ports, $monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
        }else{
            $uri = $this->id;
        }

        // Build POST body
        $body = [
            'ports' => $ports
        ];

        // Encode the POST body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/ports";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::post($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function port($port_id, $monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/ports/$port_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function modifyPort($args, $monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $body = [
            'ports' => [
                'protocol' => $args['protocol'],
                'port' => $args['port'],
                'alert_if' => $args['alert_if'],
                'email_notification' => $args['email_notification']
            ]
        ];

        // Encode the PUT body
        $data = json_encode($body);

        // Build URL
        $port_id = $args['port_id'];
        $extension = "/$uri/ports/$port_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::put($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function deletePort($port_id, $monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/ports/$port_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::delete($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function processes($monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/processes";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function addProcesses($processes, $monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
        }else{
            $uri = $this->id;
        }

        // Build POST body
        $body = [
            'processes' => $processes
        ];

        // Encode the POST body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/processes";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::post($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function process($process_id, $monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/processes/$process_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function modifyProcess($args, $monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $body = [
            'processes' => [
                'process' => $args['process'],
                'alert_if' => $args['alert_if'],
                'email_notification' => $args['email_notification']
            ]
        ];

        // Encode the PUT body
        $data = json_encode($body);

        // Build URL
        $process_id = $args['process_id'];
        $extension = "/$uri/processes/$process_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::put($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function deleteProcess($process_id, $monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/processes/$process_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::delete($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function servers($monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
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

    public function server($server_id, $monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
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

    public function removeServer($server_id, $monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
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

    public function addServers($servers, $monitoring_policy_id = null) {

        // Build URI
        if($monitoring_policy_id) {
            $uri = $monitoring_policy_id;
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

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function waitFor($timeout = 25, $interval = 5) {

        // Set counter for timeout
        $counter = 0;

        // Check initial status and save server state
        $initial_response = $this->get();
        $mp_state = $initial_response['state'];

        // Keep polling the server's state until good
        while(!in_array($mp_state, GOOD_STATES)) {

            // Wait $interval in seconds before polling again
            sleep($interval);

            // Check server state again
            $current_response = $this->get();
            $mp_state = $current_response['state'];

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