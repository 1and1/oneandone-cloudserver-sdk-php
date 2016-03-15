<?php

namespace src\oneandone;

use Requests;

class User {

    protected $api_token;
    protected $header;
    public $id;
    public $specs;
    const BASE_ENDPOINT = '/users';

    // Constructor
    public function __construct($token, $header) {

        $this->api_token = $token;
        $this->header = $header;

    }

    // User methods
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
            'password' => null,
            'email' => null,
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

        // Decode the response and return
        $json = json_decode($response->body, true);

        // Store user ID and response body for later use
        $this->specs = $json;
        $this->id = $json['id'];

        return $json;

    }

    public function get($user_id = null) {

        // Build URI
        if($user_id) {
            $uri = $user_id;
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

    public function modify($args, $user_id = null) {

        // Build URI
        if($user_id) {
            $uri = $user_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $args += [
            'description' => null,
            'email' => null,
            'password' => null,
            'state' => null
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

    public function delete($user_id = null) {

        // Build URI
        if($user_id) {
            $uri = $user_id;
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

    public function api($user_id = null) {

        // Build URI
        if($user_id) {
            $uri = $user_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/api";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function enableApi($active, $user_id = null) {

        // Build URI
        if($user_id) {
            $uri = $user_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $body = [
            'active' => $active
        ];

        // Encode the PUT body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/api";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::put($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function apiKey($user_id = null) {

        // Build URI
        if($user_id) {
            $uri = $user_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/api/key";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function changeKey($user_id = null) {

        // Build URI
        if($user_id) {
            $uri = $user_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $body = [];

        // Encode the PUT body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/api/key";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::put($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function ips($user_id = null) {

        // Build URI
        if($user_id) {
            $uri = $user_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/api/ips";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function addIps($ips, $user_id = null) {

        // Build URI
        if($user_id) {
            $uri = $user_id;
        }else{
            $uri = $this->id;
        }

        // Build POST body
        $body = [
            'ips' => $ips
        ];

        // Encode the POST body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/api/ips";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::post($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }

    public function removeIp($ip, $user_id = null) {

        // Build URI
        if($user_id) {
            $uri = $user_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/api/ips/$ip";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::delete($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }


}