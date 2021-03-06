<?php

namespace src\oneandone;

use Requests;

class Datacenter {

    protected $api_token;
    protected $header;
    public $id;
    public $specs;
    const BASE_ENDPOINT = '/datacenters';

    // Constructor
    public function __construct($token, $header) {

        $this->api_token = $token;
        $this->header = $header;

    }

    // Dvd methods
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

    public function get($datacenter_id = null) {

        // Build endpoint
        $uri = $datacenter_id;

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


}