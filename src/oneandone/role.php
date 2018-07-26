<?php

namespace src\oneandone;

use Requests;

class Role {

    protected $api_token;
    protected $header;
    public $id;
    public $specs;
    const BASE_ENDPOINT = '/roles';

    // Constructor
    public function __construct($token, $header) {

        $this->api_token = $token;
        $this->header = $header;

    }

    // Image methods
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

    public function create($name) {

        // Build POST body
        $args = [
            'name' => $name
        ];

        // Encode the POST body
        $data = json_encode($args);

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

    public function get($role_id = null) {

        // Build URI
        if($role_id) {
            $uri = $role_id;
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

    public function modify($args, $role_id = null) {

        // Build URI
        if($role_id) {
            $uri = $role_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $args += [
            'name' => null,
            'description' => null,
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


    public function delete($role_id = null) {

        // Build URI
        if($role_id) {
            $uri = $role_id;
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


    public function permissions($role_id = null) {

        // Build URI
        if($role_id) {
            $uri = $role_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/permissions";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }


    public function modifyPermissions($args, $role_id = null) {

        // Build URI
        if($role_id) {
            $uri = $role_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $args += [
            'servers' => null,
            'images' => null,
            'sharedstorages' => null,
            'firewalls' => null,
            'loadbalancers' => null,
            'ips' => null,
            'privatenetwork' => null,
            'vpn' => null,
            'monitoringcenter' => null,
            'monitoringpolicies' => null,
            'backups' => null,
            'logs' => null,
            'users' => null,
            'roles' => null,
            'usages' => null,
            'interactiveinvoice' => null
        ];

        // Clean out null values from PUT body
        $body = Utilities::cleanArray($args);

        // Encode the PUT body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/permissions";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::put($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }


    public function users($role_id = null) {

        // Build URI
        if($role_id) {
            $uri = $role_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/users";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }


    public function addUsers($users, $role_id = null) {

        // Build URI
        if($role_id) {
            $uri = $role_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $body = [
            'users' => $users
        ];

        // Encode the PUT body
        $data = json_encode($body);

        // Build URL
        $extension = "/$uri/users";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::post($url, $this->header, $data);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }


    public function user($user_id, $role_id = null) {

        // Build URI
        if($role_id) {
            $uri = $role_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/users/$user_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }


    public function removeUser($user_id, $role_id = null) {

        // Build URI
        if($role_id) {
            $uri = $role_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/users/$user_id";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::delete($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }


    public function cloneRole($name, $role_id = null) {

        // Build URI
        if($role_id) {
            $uri = $role_id;
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


}