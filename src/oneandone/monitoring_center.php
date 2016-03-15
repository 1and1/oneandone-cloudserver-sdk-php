<?php

namespace src\oneandone;

use Requests;

class MonitoringCenter {

    protected $api_token;
    protected $header;
    public $id;
    public $specs;
    const BASE_ENDPOINT = '/monitoring_center';

    // Constructor
    public function __construct($token, $header) {

        $this->api_token = $token;
        $this->header = $header;

    }

    // Monitoring Center methods
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

    public function get($server_id, $params = []) {

        // Build query parameter object
        $params += [
            'period' => null,
            'start_date' => null,
            'end_date' => null
        ];

        // Build endpoint
        $uri = $server_id;

        // Build URL
        $extension = "/$uri";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension, $params);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);

        // Decode the response and return
        return json_decode($response->body, true);

    }


}