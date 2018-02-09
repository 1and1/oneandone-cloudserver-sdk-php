<?php

namespace src\oneandone;

use Requests;

class Vpn {

    protected $api_token;
    protected $header;
    public $id;
    public $specs;
    const BASE_ENDPOINT = '/vpns';

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
            'name' => null,
            'description' => null,
            'datacenter_id' => null
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

    public function get($vpn_id = null) {

        // Build URI
        if($vpn_id) {
            $uri = $vpn_id;
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

    public function modify($args, $vpn_id = null) {

        // Build URI
        if($vpn_id) {
            $uri = $vpn_id;
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


    public function delete($vpn_id = null) {

        // Build URI
        if($vpn_id) {
            $uri = $vpn_id;
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


    public function downloadConfig($vpn_id = null, $filepath) {

        // Build URI
        if($vpn_id) {
            $uri = $vpn_id;
        }else{
            $uri = $this->id;
        }

        // Build URL
        $extension = "/$uri/configuration_file";
        $url = Utilities::buildURL(self::BASE_ENDPOINT, $extension);

        // Perform Request
        $response = Requests::get($url, $this->header);

        // Check response status
        Utilities::checkResponse($response->body, $response->status_code);
        
        //write output to zip file
        $this->base64_to_file(json_decode($response->body, true)['config_zip_file'],$filepath .= ".zip");

        // Decode the response and return
        return json_decode($response->body, true);

    }
  
    function base64_to_file($base64_string, $output_file) {
        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' );
        
        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );
        
        $decoded_string=base64_decode( $data[ 0 ] );
        
        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, $decoded_string );
        
        // clean up the file resource
        fclose( $ifp );
        
        return $output_file;
    }


    public function waitFor($timeout = 25, $interval = 15) {

        // Set counter for timeout
        $counter = 0;

        // Check initial status and save server state
        $initial_response = $this->get();
        $vpn_state = $initial_response['state'];

        // Keep polling the server's state until good
        while(!in_array($vpn_state, GOOD_STATES)) {

            // Wait 60 seconds before polling again
            sleep($interval);

            // Check server state again
            $current_response = $this->get();
            $vpn_state = $current_response['state'];

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