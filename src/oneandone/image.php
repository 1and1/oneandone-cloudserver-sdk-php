<?php

namespace src\oneandone;

use Requests;

class Image {

    protected $api_token;
    protected $header;
    public $id;
    public $specs;
    const BASE_ENDPOINT = '/images';

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

    public function create($args) {

        // Build POST body
        $args += [
            'server_id' => null,
            'name' => null,
            'description' => null,
            'frequency' => null,
            'num_images' => null
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

    public function get($image_id = null) {

        // Build URI
        if($image_id) {
            $uri = $image_id;
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

    public function modify($args, $image_id = null) {

        // Build URI
        if($image_id) {
            $uri = $image_id;
        }else{
            $uri = $this->id;
        }

        // Build PUT body
        $args += [
            'name' => null,
            'description' => null,
            'frequency' => null
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


    public function delete($image_id = null) {

        // Build URI
        if($image_id) {
            $uri = $image_id;
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


    public function waitFor() {

        // Check initial status and save image state
        $initial_response = $this->get();
        $image_state = $initial_response['state'];

        // Keep polling the image's state until good
        while(!in_array($image_state, GOOD_STATES)) {

            // Wait 30 seconds before polling again
            sleep(30);

            // Check image state again
            $current_response = $this->get();
            $image_state = $current_response['state'];

            // Inform user when state is good
            if(in_array($image_state, GOOD_STATES)) {

                echo "\nSuccess!\n";
                echo "Image state: $image_state \n";

            }

        }

    }

}