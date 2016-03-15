<?php

namespace src\oneandone;

use Requests;

class SharedStorage {

    protected $api_token;
    protected $header;
    public $id;
    public $specs;
    const BASE_ENDPOINT = '/shared_storages';

    // Constructor
    public function __construct($token, $header) {

        $this->api_token = $token;
        $this->header = $header;

    }

    // Shared Storage methods
    public function list($params = []) {

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
            'size' => null
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

        // Store shared storage ID and response body for later use
        $this->specs = $json;
        $this->id = $json['id'];

        return $json;

    }

    public function get($shared_storage_id = null) {

        // Build URI
        if($shared_storage_id) {
            $uri = $shared_storage_id;
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

    public function modify($args, $shared_storage_id = null) {

        // Build URI
        if($shared_storage_id) {
            $uri = $shared_storage_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $args += [
            'name' => null,
            'description' => null,
            'size' => null
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

    public function delete($shared_storage_id = null) {

        // Build URI
        if($shared_storage_id) {
            $uri = $shared_storage_id;
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

    public function servers($shared_storage_id = null) {

        // Build URI
        if($shared_storage_id) {
            $uri = $shared_storage_id;
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

    public function server($server_id, $shared_storage_id = null) {

        // Build URI
        if($shared_storage_id) {
            $uri = $shared_storage_id;
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

    public function removeServer($server_id, $shared_storage_id = null) {

        // Build URI
        if($shared_storage_id) {
            $uri = $shared_storage_id;
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

    public function AddServers($servers, $shared_storage_id = null) {

        // Build URI
        if($shared_storage_id) {
            $uri = $shared_storage_id;
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

    public function access() {

        // Build URL
        $extension = '/access';
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function changePassword($password) {

        // Build URL
        $extension = '/access';
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Build PUT body
        $body = [
            'password' => $password
        ];

        // Encode the PUT body
        $data = json_encode($body);

        // Perform Request
        $response = Requests::put($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function waitFor() {

        // Check initial status and save shared storage state
        $initial_response = $this->get();
        $storage_state = $initial_response['state'];

        // Keep polling the storage's state until good
        while(!in_array($storage_state, GOOD_STATES)) {

            // Wait 5 seconds before polling again
            sleep(5);

            // Check storage state again
            $current_response = $this->get();
            $storage_state = $current_response['state'];

            // Inform user when state is good
            if(in_array($storage_state, GOOD_STATES)) {

                echo "\nSuccess!\n";
                echo "Shared Storage state: $storage_state \n";

            }

        }

    }

}